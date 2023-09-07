<?php
include_once dirname(__FILE__) . '/../model/DatabaseConnection.php';
class storeController
{
    private $pdo;

    public function __construct()
    {
        $databaseConfig = new DatabaseConnection('localhost', 'mecab', 'irbba', 'hello!iRBbA');
        $this->pdo = $databaseConfig->connect();
    }

    // login
    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM users WHERE users_email = ? LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return 'not_found';
            }

            // Verify the password
            if (password_verify($password, $user['users_password'])) {
                // Password is correct, log the user in Fetch user's email and user id
                $userEmail = $user['users_email'];
                $userId = $user['user_id'];
                $userRole = $user['users_role'];
                $contact = "";

                // Check if user has a contact
                $hasDetails = $this->getUserContact($userId, $contact);

                // Start the session
                session_start();

                if ($hasDetails) {
                    if (($userRole != 'Customer') && ($userRole != 'Admin')) {
                        // Get user's store details
                        $query = "SELECT * FROM users_store WHERE users_id = ?";
                        $stmt = $this->pdo->prepare($query);
                        $stmt->execute([$user['user_id']]);
                        $userStore = $stmt->fetch(PDO::FETCH_ASSOC);
                        $store = $userStore['store_id'];

                        $isVerified = $this->isUserStoreVerified($userId, $store);
                        if ($isVerified) {
                            // Store the variables in session variables
                            $_SESSION['userEmail'] = $userEmail;
                            $_SESSION['userId'] = $userId;
                            $_SESSION['role'] = $userRole;
                            $_SESSION['isVerified'] = true;
                            $_SESSION['loggedIn'] = true;

                            return 'verified';
                        } else {
                            $_SESSION['userEmail'] = $userEmail;
                            $_SESSION['userId'] = $userId;
                            $_SESSION['role'] = $userRole;
                            $_SESSION['loggedIn'] = true;

                            return 'not_verified';
                        }
                    } else { // for customers and admins
                        $_SESSION['userEmail'] = $userEmail;
                        $_SESSION['userId'] = $userId;
                        $_SESSION['role'] = $userRole;
                        $_SESSION['loggedIn'] = true;

                        return $_SESSION['role'];
                    }
                } else {
                    $_SESSION['userEmail'] = $userEmail;
                    $_SESSION['userId'] = $userId;
                    $_SESSION['role'] = $userRole;
                    $_SESSION['loggedIn'] = true;

                    return 'no_details';
                }
            } else {
                return 'incorrect_password';
            }
        } catch (PDOException $e) {
            echo "Login failed: " . $e->getMessage();
            return 'error';
        }
    }

    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- ADD ----------------RECORDS--------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    // Add new store
    public function addStore($store_id, $storeName, $storeType, $storeEmail, $storeContact, $gpsAddress, $streetName, $storeTown, $storeLocation)
    {
        // Check if store with the same name or email or contact already exists
        if ($this->isStoreExists($storeName, $storeEmail, $storeContact)) {
            return 'exists';
        }

        // Add store if store does not exist
        try {
            $query = "INSERT INTO stores (store_id, store_name, store_type, store_email, store_contact, gps_address, street_name, store_town, store_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$store_id, $storeName, $storeType, $storeEmail, $storeContact, $gpsAddress, $streetName, $storeTown, $storeLocation]);
            return 'success';
        } catch (PDOException $e) {
            echo "Store registration failed: " . $e->getMessage();
            return 'error';
        }
    }

    // Add new user
    public function addUser($user_id, $firstName, $lastName, $otherNames, $userEmail, $specialisation, $password)
    {
        // Check if a user with the email already exists
        if ($this->isUserExists($userEmail)) {
            return 'exists';
        }

        // Add user if a user does not exist
        try {
            $query = "INSERT INTO users (user_id, first_name, last_name, other_names, users_email, users_role, `users_password`) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$user_id, $firstName, $lastName, $otherNames, $userEmail, $specialisation, $password]);

            return 'success';
        } catch (PDOException $e) {
            echo "User registration failed: " . $e->getMessage();
            return 'error';
        }
    }

    // Add new admin
    public function addAdmin($user_id, $first_name, $last_name, $other_names, $email, $password)
    {
        // Check if a admin or user with the email already exists
        if ($this->isUserExists($email)) {
            return 'exists';
        }

        try {
            $query = "INSERT INTO `users`(`user_id`, `first_name`, `last_name`, `other_names`, `users_email`,
             `users_password`, `users_role`) VALUES (?, ?, ?, ?, ?, ?, 'Admin')";
            $stmt = $this->pdo->prepare($query);

            $stmt->execute([$user_id, $first_name, $last_name, $other_names, $email, $password]);

            return 'success';
        } catch (PDOException $e) {
            echo "Admin registration failed: " . $e->getMessage();
            return 'error';
        }
    }

    // Add user details
    public function addUserDetails($userId, $contact, $specialisation, $storeId)
    {
        try {
            // Check if a user with the contact already exists
            if ($this->getUserContact($userId, $contact)) {
                return 'exists';
            }

            // Add contact if it does not exist
            if (isset($contact)) {
                $query = "INSERT INTO users_contact (users_id, users_contact) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$userId, $contact]);
            }

            // Check if user is associating with a store
            if (isset($storeId)) {
                require_once '../controllers/otpGenerator.php';
                $otpGenerator = new OTPGenerator();

                // Get otp
                $otp = $otpGenerator->generateOTP();

                // Save otp
                $saveOTP = $otpGenerator->storeOTP($storeId, $userId, $otp);

                // Send otp to user's store to verify if the user works in the store
                if ($saveOTP == 'success') {
                    // Get store details (contact)
                    // $storeContact = $this->getStoreById($storeId);

                    $query = "SELECT * FROM stores WHERE store_id = :store_id";
                    $params = array(":store_id" => $storeId);
                    $storeContact = $this->getSingleRecordsByValue($query, $params);

                    $storeContact = $storeContact['store_contact'];

                    $msg = 'Use this code to verify your store. Your verification code is: ';

                    // Send otp
                    $otpGenerator->sendOTP($storeContact, $otp, $msg);
                }

                // Save user's store record
                $query = "INSERT INTO users_store (users_id, store_id) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$userId, $storeId]);

                // Save user's specialisation if user is a mechanic
                if (isset($specialisation)) {
                    $query = "INSERT INTO mech_specialisation (users_id, specialisation) VALUES (?, ?)";
                    $stmt = $this->pdo->prepare($query);
                    $stmt->execute([$userId, $specialisation]);
                }
            }

            return 'success';
        } catch (PDOException $e) {
            echo "Failed to insert contact: " . $e->getMessage();
            return 'error';
        }
    }

    // Add spare part function
    public function addSparePart($sparePartName, $description, $price, $image, $category, $store, $carBrand, $carModel)
    {
        try {
            // Check if the file upload is successful
            if ($image['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleImageUpload($image);
                if (!is_array($uploadResult) || !isset($uploadResult['filename'])) {
                    return array(
                        'status' => 'error',
                        'message' => $uploadResult
                    ); // Return the upload error message
                }

                $imageName = $uploadResult['filename']; // Get the image filename only

                // Ensure $store is an integer
                $store = is_array($store) ? (int)$store['store_id'] : (int)$store;

                // Set car_brand_id and car_model_id to NULL if they are empty
                $carBrand = empty($carBrand) ? null : $carBrand;
                $carModel = empty($carModel) ? null : $carModel;

                $query = "INSERT INTO spare_parts (sparepart_id, name, description, price, image, category_id, store_id, car_brand_id, car_model_id) VALUES (UUID(), ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$sparePartName, $description, $price, $imageName, $category, $store, $carBrand, $carModel]);

                // Check if the database insert was successful
                if ($stmt->rowCount() > 0) {
                    return array(
                        'status' => 'success',
                        'message' => 'Spare part added successfully!'
                    ); // Success response as an array
                } else {
                    return array(
                        'status' => 'error',
                        'message' => 'Failed to add spare part: Database insertion failed.'
                    ); // Error response as an array
                }
            } else {
                // File upload failed or no file selected
                return array(
                    'status' => 'error',
                    'message' => 'File upload failed or no file selected.'
                ); // Error response as an array
            }
        } catch (PDOException $e) {
            return array(
                'status' => 'error',
                'message' => 'Failed to add spare part: ' . $e->getMessage()
            ); // Error response as an array
        }
    }

    // Add record
    public function addRecord($data, $tableName)
    {
        try {
            $table = $tableName;

            // Prepare the column names and values
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));

            // Query statement
            $query = "INSERT INTO $table ($columns) VALUES ($values)";

            // Prepare and execute the statement
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            if ($stmt->rowCount() > 0) {
                return true; // Record added successfully
            } else {
                return 'failed'; // Failed to add record 
            }
        } catch (PDOException $e) {
            echo "Failed to insert data : " . $e->getMessage();
            return false; // Error occured while adding record
        }
    }

    // Add record with single check
    public function addRecordCheck($data, $tableName, $columnName, $value)
    {
        // call the checkISingleField function
        if ($this->checkISingleField($tableName, $columnName, $value)) {
            return 'exists';
        } else {
            try {
                $table = $tableName;

                // Prepare the column names and values
                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                // Query statement
                $query = "INSERT INTO $table ($columns) VALUES ($values)";

                // Prepare and execute the statement
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($data);
                if ($stmt->rowCount() > 0) {
                    return true; // Record added successfully
                } else {
                    return 'failed'; // Failed to add record 
                }
            } catch (PDOException $e) {
                echo "Failed to insert data : " . $e->getMessage();
                return false; // Error occurred while adding record
            }
        }
    }

    // Add a record with an image
    public function addRecordWithImage($data, $imageData, $tableName)
    {
        try {
            $table = $tableName;

            // Check if the file upload is successful
            if ($imageData['error'] === UPLOAD_ERR_OK) {
                $uploadResult = $this->handleImageUpload($imageData);
                if (!is_array($uploadResult) || !isset($uploadResult['filename'])) {
                    return array(
                        'status' => 'error',
                        'message' => 'Image upload failed: ' . $uploadResult
                    ); // Return the upload error message
                }

                $imageName = $uploadResult['filename']; // Get the image filename only

                $data['image'] = $imageName; // Add the image filename to the data array

                $addRecord = $this->addRecord($data, $table); // Add the record to the database

                if ($addRecord) {
                    return array(
                        'status' => 'success',
                        'message' => 'New record added successfully!'
                    );
                } else {
                    return array(
                        'status' => 'error',
                        'message' => 'Failed to add record: Database insertion failed!'
                    );
                }
            } else {
                // echo "File upload failed or no file selected.";
                return array(
                    'status' => 'error',
                    'message' => 'File upload failed or no file selected.'
                );
            }
        } catch (PDOException $e) {
            error_log("Error adding record with image: " . $e->getMessage());
            return array(
                'status' => 'error',
                'message' => $e->getMessage()
            );
        }
    }

    //  Add record by checking it existance by a single field
    public function addRecordBySingleVerification($data, $tableName, $columnName, $value)
    {
        // Verify record existance
        if ($this->recordExistBySingleField($tableName, $columnName, $value)) {
            return 'exists';
        } else {
            // Data does not exist, add record
            try {
                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute($data);

                return true;
            } catch (PDOException $e) {
                echo "Failed to insert data: " . $e->getMessage();
                return false;
            }
        }
    }

    // Add record by checking it existence by multiple fields
    public function addRecordByMultipleVerification($data, $tableName)
    {
        // call the checkMultipleFields function
        if ($this->recordExistByMultipleFieldsStrict($tableName, $data)) {
            return 'exists';
        } else {
            // Data does not exist, proceed with insertion
            try {
                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute($data);

                return true;
            } catch (PDOException $e) {
                echo "Failed to insert data: " . $e->getMessage();
                return false;
            }
        }
    }

    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- Handlers -------------------------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    // function to handle image upload
    private function handleImageUpload($image)
    {
        $maxFileSize = 10 * 1024 * 1024; // 10MB (adjust according to your requirement)
        $allowedExtensions = ['png', 'jpeg', 'jpg'];

        // Check the file size
        if ($image['size'] > $maxFileSize) {
            return 'Large size';
        }

        // Check the file extension
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return 'Invalid extension';
        }

        // Define the target directory to store the uploaded images
        $targetDir = "../uploads/";

        // Generate a unique filename for the uploaded image
        $filename = uniqid() . '_' . $image['name'];

        // Construct the full path for the image file
        $targetPath = $targetDir . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            // File upload successful, return the image filename only
            return ['filename' => $filename];
        } else {
            // Failed to move the uploaded file
            return 'Failed upload';
        }
    }

    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- CHECK ----------------RECORDS------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    //  Verify the value of record by a single field
    private function recordExistBySingleField($tableName, $columnName, $value)
    {
        try {
            $query = "SELECT COUNT(*) FROM $tableName WHERE $columnName = :value";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['value' => $value]);

            $rowCount = $stmt->fetchColumn();

            return $rowCount > 0; // Returns true if the data exists, false otherwise
        } catch (PDOException $e) {
            error_log("Error verifying data existence: " . $e->getMessage());
            throw $e;
        }
    }

    // Verify the value of a record by multiple feilds strict
    private function recordExistByMultipleFieldsStrict($tableName, $data)
    {
        try {
            // Generate the WHERE clause based on the keys in $data
            $conditions = [];
            foreach (array_keys($data) as $column) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = implode(' AND ', $conditions);

            $query = "SELECT COUNT(*) FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);

            $rowCount = $stmt->fetchColumn();

            return $rowCount > 0; // Returns true if the data exists, false otherwise
        } catch (PDOException $e) {
            error_log("Error verifying data existence: " . $e->getMessage());
            throw $e;
        }
    }

    // Verify the value of a record by multiple feilds loose 
    private function recordExistByMultipleFieldsloose($tableName, $data)
    {
        try {
            // Generate the WHERE clause based on the keys in $data
            $conditions = [];
            foreach (array_keys($data) as $column) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = implode(' OR ', $conditions);

            $query = "SELECT COUNT(*) FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);

            $rowCount = $stmt->fetchColumn();

            return $rowCount > 0; // Returns true if the data exists, false otherwise
        } catch (PDOException $e) {
            error_log("Error verifying data existence: " . $e->getMessage());
            throw $e;
        }
    }

    // Check if store exists
    private function isStoreExists($storeName, $storeEmail, $storeContact)
    {
        try {
            // Query the database to check if a store with the same name, email, or contact already exists
            $query = "SELECT COUNT(*) FROM stores WHERE store_name = ? OR store_email = ? OR store_contact = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$storeName, $storeEmail, $storeContact]);

            // Fetch the count of matching stores
            $count = $stmt->fetchColumn();

            // Return true if a store with the same name, email, or contact already exists
            return $count > 0;
        } catch (PDOException $e) {
            echo "Failed to retrieve stores: " . $e->getMessage();
        }
    }

    // Check if user exists
    private function isUserExists($userEmail)
    {
        try {
            // Query the database to check if a user with the email already exists
            $query = "SELECT COUNT(*) FROM users WHERE users_email = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userEmail]);

            // Fetch the count of matching user
            $count = $stmt->fetchColumn();

            // Return true if a user with the same email already exists
            return $count > 0;
        } catch (PDOException $e) {
            echo "Failed to retrieve user: " . $e->getMessage();
        }
    }

    // Check if user's store is verified
    public function isUserStoreVerified($userId, $storeId)
    {
        try {
            // Prepare the query
            $query = "SELECT verification_status FROM users_store WHERE users_id = ? AND store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId, $storeId]);

            // Check if the user is verified
            $status = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($status['verification_status'] == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Failed to check user verification status: " . $e->getMessage();
            return false;
        }
    }

    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- GET / FETCH --------RECORDS--------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    // Get all stores
    public function getStores()
    {
        try {
            // Prepare the query
            $query = "  SELECT DISTINCT stores.store_id, stores.store_name 
                        FROM stores INNER JOIN users ON users.users_role = stores.store_type 
                        WHERE users.user_id = ?";
            $stmt = $this->pdo->prepare($query);
            // Execute the query
            $stmt->execute([$_SESSION['userId']]);

            // Fetch all the rows from the result set
            $stores = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $stores;
        } catch (PDOException $e) {
            echo "Failed to fetch stores: " . $e->getMessage();
            return null;
        }
    }

    // Get store by store ID
    public function getStoreById($storeId)
    {
        try {
            // Prepare the query
            $query = "SELECT * FROM stores WHERE store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$storeId]);

            // Fetch the store
            $store = $stmt->fetch();

            return $store;
        } catch (PDOException $e) {
            echo "Failed to fetch store: " . $e->getMessage();
            return null;
        }
    }

    // Get user's contact by ID or contact
    public function getUserContact($userId, $contact)
    {
        try {
            $query = "SELECT * FROM users_contact WHERE users_id = ? OR users_contact = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId, $contact]);

            $contact = $stmt->fetch(PDO::FETCH_ASSOC);

            return $contact ? $contact : [];
        } catch (PDOException $e) {
            echo "Failed to fetch users contact: " . $e->getMessage();
            return [];
        }
    }

    // Get user's store 
    public function getUserStore($userId)
    {
        try {
            $query = "SELECT stores.store_id, stores.store_name FROM users_store 
                      INNER JOIN stores ON stores.store_id = users_store.store_id 
                      WHERE users_store.users_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId]);
            $store = $stmt->fetch(PDO::FETCH_ASSOC);
            return $store;
        } catch (PDOException $e) {
            echo "Failed to fetch user's store: " . $e->getMessage();
            return null;
        }
    }

    // Get store users
    public function getStoreUsers($storeId)
    {
        try {
            $query = "SELECT * FROM users_store WHERE store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$storeId]);
            $store = $stmt->fetch(PDO::FETCH_ASSOC);
            return $store;
        } catch (PDOException $e) {
            echo "Failed to fetch store user's : " . $e->getMessage();
        }
    }

    // Get user details
    public function getUserDetails()
    {
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            try {
                $query = "SELECT first_name, last_name, other_names, users_email, users_role FROM users WHERE user_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($user) {
                    return $user;
                } else {
                    return null;
                }
            } catch (PDOException $e) {
                echo "Failed to retrieve user's details: " . $e->getMessage();
                return null;
            }
        } else {
            return null;
        }
    }

    // Get user details by email
    public function getUserByEmail($email)
    {
        try {
            $query = "SELECT * FROM users WHERE users_email = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Failed to retrieve user's details: " . $e->getMessage();
            return null;
        }
    }

    // Get user's role
    public function getUsersRole($userId)
    {
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            try {
                $query = "SELECT users_role FROM user WHERE user_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                return $user;
            } catch (PDOException $e) {
                echo "Failed to retrieve user's role: " . $e->getMessage();
                return null;
            }
        } else {
            return null;
        }
    }

    // Get stores and users verification
    public function getStoreVerification($userId)
    {
        try {
            // Prepare the query to retrieve the last entered record for the user
            $query = "SELECT * FROM user_store_otp WHERE users_id = ? ORDER BY otp_id DESC LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId]);

            // Fetch the record
            $verification = $stmt->fetch(PDO::FETCH_ASSOC);

            return $verification;
        } catch (PDOException $e) {
            echo "Failed to fetch store verification: " . $e->getMessage();
            return null;
        }
    }

    // Get all car brands
    public function getCarBrands()
    {
        try {
            $query = "SELECT * FROM car_brand";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $carBrands = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $carBrands;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch car brands: " . $e->getMessage());
        }
    }

    // Get all car models
    public function getCarModels()
    {
        try {
            $query = "SELECT * FROM car_model";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $carModels = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $carModels;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch car models: " . $e->getMessage());
        }
    }

    // Get car models by brand Id
    public function getCarModelsByBrand($carBrandId)
    {
        try {
            $query = "SELECT * FROM car_model WHERE car_brand_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$carBrandId]);

            $carModels = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $carModels;
        } catch (PDOException $e) {
            echo "Failed to fetch car models: " . $e->getMessage();
            return null;
        }
    }

    // Get all spare parts categories
    public function getCategories()
    {
        try {
            $query = "SELECT * FROM categories";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $categories;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch categories: " . $e->getMessage());
        }
    }

    // Get all carousel
    public function getCarousel()
    {
        try {
            $query = "SELECT * FROM carousel";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $carousel = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $carousel;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch carousel: " . $e->getMessage());
        }
    }

    // Get all carousel
    public function getCarousels()
    {
        try {
            $query = "SELECT * FROM `carousel` ORDER BY carousel_ID DESC LIMIT 3";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $carousel = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $carousel;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch carousel: " . $e->getMessage());
        }
    }

    // Get all services
    public function getServices()
    {
        try {
            $query = "SELECT * FROM service";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $services;
        } catch (PDOException $e) {
            throw new Exception("Failed to fetch categories: " . $e->getMessage());
        }
    }

    // Get spare part category by spare part id
    public function getSparePartCategory($sparePartId)
    {
        try {
            $query = "SELECT c.* FROM spare_parts sp 
                      JOIN categories c ON sp.category_id = c.category_id 
                      WHERE sp.sparepart_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$sparePartId]);

            $category = $stmt->fetch(PDO::FETCH_ASSOC);

            return $category;
        } catch (PDOException $e) {
            echo "Error fetching spare part category: " . $e->getMessage();
            return null;
        }
    }

    // Get total spare parts count 
    public function getSparePartCount()
    {
        try {
        } catch (PDOException $e) {
            echo "Failed to fetch spare parts count: " . $e->getMessage();
            return null;
        }
    }

    // Get all spare parts by store ID
    public function getStoreSpareParts()
    {
        $store = $this->getUserStore($_SESSION['userId']);
        if (!$store) {
            // Handle error case when the store is not found for the user.
            return false;
        }
        $store = $store['store_id'];
        try {
            $query =   "SELECT sp.*, ct.*, cb.*
                    FROM spare_parts sp
                    LEFT JOIN car_brand cb ON sp.car_brand_id = cb.car_brand_id
                    INNER JOIN categories ct ON sp.category_id = ct.category_id
                    WHERE sp.store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$store]);

            $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $parts;
        } catch (PDOException $e) {
            // Log or handle the exception gracefully.
            return false;
        }
    }

    // Get store's spare parts
    public function selectSpareInnerJoin()
    {
        try {
            $userID = $this->selectWithOneCondition('users_store', 'users_id', $_SESSION['userId']);

            $query = "SELECT sp.*, ct.*, cb.*
                    FROM spare_parts sp
                    LEFT JOIN car_brand cb ON sp.car_brand_id = cb.car_brand_id
                    INNER JOIN categories ct ON sp.category_id = ct.category_id
                    WHERE sp.store_id = :store_id";

            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':store_id', $userID['store_id'], PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return false;
        }
    }

    // Get spare part item by ID
    public function getSparePartDetails($sparepart_id)
    {
        try {
            $query = "SELECT sp.*, ct.*, cb.*, cm.* 
                        FROM spare_parts sp
                        LEFT JOIN car_brand cb ON sp.car_brand_id = cb.car_brand_id
                        LEFT JOIN car_model cm ON sp.car_model_id = cm.car_model_id
                        INNER JOIN categories ct ON sp.category_id = ct.category_id
                        WHERE sp.sparepart_id = ? LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$sparepart_id]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                return $item;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return false;
        }
    }

    // Get the existing image filename for an entity from the database
    private function getExistingImageFileName($tableName, $primaryKeyColumn, $primaryKeyValue)
    {
        try {
            $query = "SELECT image FROM $tableName WHERE $primaryKeyColumn = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$primaryKeyValue]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && isset($result['image'])) {
                return $result['image'];
            }

            return false; // No image filename found in the database
        } catch (PDOException $e) {
            echo "Failed to fetch image filename: " . $e->getMessage();
            return false;
        }
    }

    // Get multiple records
    public function getRecords($query)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return false;
        }
    }

    // Get a single record by value
    public function getSingleRecordsByValue($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            return $record ? $record : null;
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
            return false;
        }
    }

    // Get multiple records by value
    public function getRecordsByValue($query, $params)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $records;
        } catch (PDOException $e) {
            throw new Exception("Error Fetching Records" . $e->getMessage());
        }
    }



    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- UPDATE ----------------RECORDS--------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    // approve user's store verification
    public function verifyUserStore($userId, $storeId)
    {
        try {
            // Verify the user and store
            $query = "UPDATE user_store_otp SET otp_verified = 1 WHERE users_id = ? AND store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId, $storeId]);

            $statusUpdated = $this->updateVerificationStatus($userId, $storeId);

            // Delete the OTP verification record after verification
            if ($statusUpdated) {
                $query = "DELETE FROM user_store_otp WHERE users_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$userId]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Error verifying user and store: " . $e->getMessage();
            return false;
        }
    }

    // Store the verification status in the database for future reference
    public function updateVerificationStatus($userId, $storeId)
    {
        try {
            // Update the verification status in the users_store table
            $query = "UPDATE users_store SET verification_status = 1 WHERE users_id = ? AND store_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$userId, $storeId]);

            return true; // Verification status updated successfully
        } catch (PDOException $e) {
            echo "Failed to update verification status: " . $e->getMessage();
            return false;
        }
    }

    // Update user record
    public function updateUserRecord($firstName, $lastName, $otherNames, $email, $contact)
    {
        try {
            // Check if a//code... user with the new contact already exists
            if (isset($contact)) {
                $existingContact = $this->getUserContact(null, $contact);
                if ($existingContact && $existingContact['users_id'] !== $_SESSION['userId']) {
                    return 'contact-exists';
                }
            }

            // // Check if a user with the new email already exists
            if (isset($email)) {
                $existingEmail = $this->getUserByEmail($email);
                if ($existingEmail && $existingEmail['user_id'] != $_SESSION['userId']) {
                    return 'email-exists';
                }
            }

            // Get the old contact of the user
            $oldContact = $this->getUserContact($_SESSION['userId'], null);
            $oldContact = $oldContact['users_contact'];

            // Get the old email from the user details retrieved earlier
            $oldEmail = $this->getUserDetails();
            $oldEmail = $oldEmail['users_email'];

            // Proceed with updating the contact if the old and the new contact are not same
            if ($contact !== $oldContact && !empty($contact)) {
                $query = "UPDATE users_contact SET users_contact = ? WHERE users_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$contact, $_SESSION['userId']]);
            }

            // Check if the new email is different from the old email and not empty
            if ($email !== $oldEmail && !empty($email)) {
                // Proceed with updating the email
                $query = "UPDATE users SET users_email = ? WHERE user_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$email, $_SESSION['userId']]);
            }

            // Update other user details
            $query = "UPDATE users SET first_name = ?, last_name = ?, other_names = ? WHERE user_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$firstName, $lastName, $otherNames, $_SESSION['userId']]);

            return true;
        } catch (PDOException $e) {
            echo "Failed to update user's record: " . $e->getMessage();
            return false;
        }
    }

    // Update user password or change password
    public function updateUserPassword($oldPassword, $newPassword)
    {
        try {
            $user = $this->getUserByEmail($_SESSION['userEmail']);
            $hashedPassword = $user['users_password'];

            // Check if the old password matches the hashed password
            if (password_verify($oldPassword, $hashedPassword)) {
                // Old password matches, proceed with updating the password
                $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $query = "UPDATE users SET users_password = ? WHERE user_id = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$newHashedPassword, $_SESSION['userId']]);

                return 'success';
            } else {
                // Old password doesn't match
                return 'wrong';
            }
        } catch (PDOException $e) {
            echo "Failed to update user's password: " . $e->getMessage();
            return false;
        }
    }

    // Update spare part record
    public function updateSparePart($spare_part_id, $car_brand, $car_model, $spare_part_name, $category, $price, $description, $image)
    {
        try {
            // Get the existing image filename for the spare part
            $existingImageFileName = $this->getExistingImageFileName('spare_parts', 'sparepart_id', $spare_part_id);

            // If an image is uploaded, delete the existing image from the upload folder
            if ($image !== null) {
                $this->deleteExistingImage($existingImageFileName);
            }

            // Upload the new image if provided
            if ($image !== null) {
                $imageUploadResult = $this->handleImageUpload($image);
                if (is_array($imageUploadResult) && isset($imageUploadResult['filename'])) {
                    $imageFileName = $imageUploadResult['filename'];
                } else {
                    return 'failed-upload';
                }
            } else {
                // If no new image is provided, retain the existing image filename
                $imageFileName = $existingImageFileName;
            }

            $query = "UPDATE spare_parts SET car_brand_id = ?, car_model_id = ?, name = ?, category_id = ?, price = ?, description = ?, image = ? WHERE sparepart_id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$car_brand, $car_model, $spare_part_name, $category, $price, $description, $imageFileName, $spare_part_id]);

            return true;
        } catch (PDOException $e) {
            echo "Failed to update spare part: " . $e->getMessage();
            return false;
        }
    }

    // Update a record
    public function updateRecord($tableName, $updateData, $primaryKeyColumn, $primaryKeyValue)
    {
        try {
            $table = $tableName;

            // Generate SET clause for UPDATE query
            $updateColumns = array_keys($updateData);
            $updateValues = array_values($updateData);
            $updateSets = array_map(function ($col) {
                return $col . ' = ?';
            }, $updateColumns);
            $updateSetsString = implode(', ', $updateSets);

            // Append the primary key value to the update values array
            $updateValues[] = $primaryKeyValue;

            // Construct the SQL UPDATE query
            $query = "UPDATE $table SET $updateSetsString WHERE $primaryKeyColumn = ?";

            // Execute the SQL UPDATE statement
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($updateValues);

            // Check if any rows were affected by the update
            if ($stmt->rowCount() > 0) {
                return true; // Record updated successfully
            } else {
                return false; // Record not found or no changes made
            }
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage();
            return false; // Error occurred during the update process
        }
    }

    // Update a record with image
    public function updateRecordWithImage($tableName, $primaryKeyColumn, $primaryKeyValue, $updateData, $imageData)
    {
        try {
            $table = $tableName;
            $column = $primaryKeyColumn;
            $value = $primaryKeyValue;
            $image = $imageData;

            // Check if the image is included in the update
            $existingImageFileName = $this->getExistingImageFileName($table, $column, $value);

            if (isset($image['tmp_name']) && $image['tmp_name']) {

                // New image uploaded, process the uploaded image
                $imageFileName = $this->handleImageUpload($image);

                // Add the image filename to the update data array
                $updateData['image'] = $imageFileName['filename'];

                // Delete the existing image file
                $this->deleteExistingImage($existingImageFileName);
            } else {
                // No new image uploaded, retain the existing image filename
                $updateData['image'] = $existingImageFileName;
            }

            $updateRecord = $this->updateRecord($table, $updateData, $column, $value);
            if ($updateRecord) {
                return true;
            } else {
                return 'failed';
            }
        } catch (PDOException $e) {
            echo "Error updating record with image: " . $e->getMessage();
            return false;
        }
    }


    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- DELETE-- -----------RECORD--------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    //  Delete an existing image file 
    private function deleteExistingImage($imageFileName)
    {
        try {
            // The image filename to delete
            $existingImageFileName = $imageFileName;

            if ($existingImageFileName) {
                $uploadDir = "../uploads/";
                $existingImagePath = $uploadDir . $existingImageFileName;
                if (file_exists($existingImagePath)) {
                    if (unlink($existingImagePath)) {
                        // File deleted successfully
                        return true;
                    } else {
                        // Failed to delete the file
                        return 'Failed';
                    }
                } else {
                    // File not found, it might have been deleted or moved manually
                    return 'not-found';
                }
            } else {
                // No existing image found
                return 'not-existing';
            }
        } catch (PDOException $e) {
            echo "Error deleting existing image: " . $e->getMessage();
            return false;
        }
    }

    // Delete a record with an image 
    public function deleteRecordWithImage($tableName, $primaryKeyColumn, $primaryKeyValue)
    {
        try {
            $table = $tableName;
            $column = $primaryKeyColumn;
            $value = $primaryKeyValue;

            // Get the existing image filename for the record
            $existingImageFileName = $this->getExistingImageFileName($table, $column, $value);

            // Delete the record from the database
            $deleteRecord = $this->deleteRecord($table, $column, $value);

            if ($deleteRecord) {
                // Delete the existing image file if it exists
                $deleteImageResult = $this->deleteExistingImage($existingImageFileName);

                // Check the result of deleting the image file
                if ($deleteImageResult === true) {
                    return true; // Successfully deleted the record and the image file
                } elseif ($deleteImageResult === 'not-found') {
                    return 'not-found'; // Record deleted, but image file not found
                } elseif ($deleteImageResult === 'not-existing') {
                    return 'not-existing'; // Record deleted, but no image file existed
                } else {
                    return 'Failed'; // Failed to delete the image file
                }
            } else {
                return false; // Failed to delete the record
            }
        } catch (PDOException $e) {
            echo "Failed to delete record with image: " . $e->getMessage();
            return false;
        }
    }

    // Delete a record
    public function deleteRecord($tableName, $primaryKeyColumn, $primaryKeyValue)
    {
        try {
            $table = $tableName;
            $column = $primaryKeyColumn;
            $value = $primaryKeyValue;

            $query = "DELETE FROM $table WHERE $column = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$value]);

            return true;
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage();
            return false;
        }
    }

    /**
     * --------------------------------------------------------------------------------------------------
     * --------------------------------- BOFFIE'S -----------RECORD--------------------------------------
     * --------------------------------------------------------------------------------------------------
     */

    // insert function
    // public function insert($data, $tableName)
    // {
    //     try {
    //         $columns = implode(", ", array_keys($data));
    //         $values = ":" . implode(", :", array_keys($data));

    //         $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

    //         $stmt = $this->pdo->prepare($query);
    //         $stmt->execute($data);
    //         return true;
    //     } catch (PDOException $e) {
    //         echo "Failed to insert data : " . $e->getMessage();
    //         return false;
    //     }
    // }

    // select all function
    public function select($tableName)
    {
        try {
            $query = "SELECT * FROM ($tableName)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error selecting data: " . $e->getMessage();
            return false;
        }
    }

    // select function with one condition
    public function selectWithOneCondition($tableName, $columnName, $value)
    {
        try {
            $query = "SELECT * FROM $tableName WHERE $columnName = :value";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['value' => $value]);

            return $stmt->fetch(PDO::FETCH_ASSOC); // Returns the data exists, false otherwise
        } catch (PDOException $e) {
            echo "Error checking if data exists: " . $e->getMessage();
            return false;
        }
    }

    // function that check a single feild
    public function checkISingleField($tableName, $columnName, $value)
    {
        try {
            $query = "SELECT COUNT(*) FROM $tableName WHERE $columnName = :value";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute(['value' => $value]);

            $rowCount = $stmt->fetchColumn();

            return $rowCount > 0; // Returns true if the data exists, false otherwise
        } catch (PDOException $e) {
            echo "Error checking if data exists: " . $e->getMessage();
            return false;
        }
    }

    // function that check data in multiple feilds
    public function checkIMultipleFields($tableName, $data)
    {
        try {
            // Generate the WHERE clause based on the keys in $data
            $conditions = [];
            foreach (array_keys($data) as $column) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = implode(' AND ', $conditions);

            $query = "SELECT COUNT(*) FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);

            $rowCount = $stmt->fetchColumn();

            return $rowCount > 0; // Returns true if the data exists, false otherwise
        } catch (PDOException $e) {
            echo "Error checking if data exists: " . $e->getMessage();
            return false;
        }
    }

    // insert function that checks if data already exists in different feilds
    public function insertWithCheckMultipleCheck($data, $tableName)
    {
        // call the checkMultipleFields function
        if ($this->checkIMultipleFields($tableName, $data)) {
            return 'exists';
        } else {
            // Data does not exist, proceed with insertion
            try {
                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute($data);

                return true;
            } catch (PDOException $e) {
                echo "Failed to insert data: " . $e->getMessage();
                return false;
            }
        }
    }

    // insert function that checks if data already exists in different feilds
    public function insertWithCheckSingleFeild($data, $tableName, $columnName, $value)
    {
        // call the insertWithCheckSingleFelid function
        if ($this->checkISingleField($tableName, $columnName, $value)) {
            return 'exists';
        } else {
            // Data does not exist, proceed with insertion
            try {
                $columns = implode(", ", array_keys($data));
                $values = ":" . implode(", :", array_keys($data));

                $query = "INSERT INTO $tableName ($columns) VALUES ($values)";

                $stmt = $this->pdo->prepare($query);
                $stmt->execute($data);

                return true;
            } catch (PDOException $e) {
                echo "Failed to insert data: " . $e->getMessage();
                return false;
            }
        }
    }

    public function selectDetailInnerJoin()
    {
        try {
            if (isset($_GET['sparepart_id'])) {
                $sparepart_id = $_GET['sparepart_id'];

                $query = "SELECT sp.*, cb.*, cm.*, ct.*, s.*, st.*
                    FROM spare_parts sp
                    INNER JOIN car_brand cb ON sp.car_brand_id = cb.car_brand_id
                    INNER JOIN car_model cm ON sp.car_model_id = cm.car_model_id
                    INNER JOIN categories ct ON sp.category_id = ct.category_id
                    INNER JOIN stores st ON sp.store_id = st.store_id
                    INNER JOIN users_store s ON sp.store_id = s.store_id
                    WHERE sp.sparepart_id = :sparepart_id";

                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':sparepart_id', $sparepart_id, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error selecting data: " . $e->getMessage();
            return false;
        }
    }
}