<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');
?>

<div class="container">
    <div class="row">
        <!--Sidebar-->
        <div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
            <div class="closeFilter d-block d-md-none d-lg-none"><i class="icon icon anm anm-times-l"></i></div>
            <div class="sidebar_tags">
                <!--Categories-->
                <div class="sidebar_widget categories filter-widget">
                    <div class="widget-content">
                        <ul class="sidebar_categories">
                            <li class="lvl-1"><a href="#agree-to-legal-terms" class="site-nav">AGREEMENT TO OUR LEGAL TERMS</a></li>
                            <li class="lvl-1"><a href="#our-services" class="site-nav">OUR SERVICES</a></li>
                            <li class="lvl-1"><a href="#intellectual-property-right" class="site-nav">INTELLECTUAL PROPERTY RIGHTS</a></li>
                            <li class="lvl-1"><a href="#user-represtations" class="site-nav">USER REPRESENTATIONS</a></li>
                            <li class="lvl-1"><a href="#user-registrations" class="site-nav">USER REGISTRATION</a></li>
                            <li class="lvl-1"><a href="#products" class="site-nav">PRODUCTS</a></li>
                            <li class="lvl-1"><a href="#purchases-and-payment" class="site-nav">PURCHASES AND PAYMENT</a></li>
                            <li class="lvl-1"><a href="#return-policy" class="site-nav">RETURN POLIC</a></li>
                            <li class="lvl-1"><a href="#prohibited-activities" class="site-nav">PROHIBITED ACTIVITIES</a></li>
                            <li class="lvl-1"><a href="#user-generated-contributions" class="site-nav">USER GENERATED CONTRIBUTIONS</a></li>
                            <li class="lvl-1"><a href="#contribution-licence" class="site-nav">CONTRIBUTION LICENCE</a></li>
                            <li class="lvl-1"><a href="#social-media" class="site-nav">SOCIAL MEDIA</a></li>
                            <li class="lvl-1"><a href="#third-party-websites-and-content" class="site-nav">THIRD-PARTY WEBSITES AND CONTENT</a></li>
                            <li class="lvl-1"><a href="#service-management" class="site-nav">SERVICE MANAGEMENT</a></li>
                            <li class="lvl-1"><a href="#privacy-policy" class="site-nav">PRIVACY POLICY</a></li>
                            <li class="lvl-1"><a href="#digital-millennium-copyright" class="site-nav">DIGITAL MILLENNIUM COPYRIGHT ACT (DMCA) NOTICE AND POLICY</a></li>
                            <li class="lvl-1"><a href="#term-and-termination" class="site-nav">TERM AND TERMINATION</a></li>
                            <li class="lvl-1"><a href="#modification-and-interruptions" class="site-nav">MODIFICATIONS AND INTERRUPTIONS</a></li>
                            <li class="lvl-1"><a href="#governing-law" class="site-nav">GOVERNING LAW</a></li>
                            <li class="lvl-1"><a href="#dispute-resolution" class="site-nav">DISPUTE RESOLUTION</a></li>
                            <li class="lvl-1"><a href="#corrections" class="site-nav">CORRECTIONS</a></li>
                            <li class="lvl-1"><a href="#disclaimer" class="site-nav">DISCLAIMER</a></li>
                            <li class="lvl-1"><a href="#limitations-of-liability" class="site-nav">LIMITATIONS OF LIABILITY</a></li>
                            <li class="lvl-1"><a href="#indemnification" class="site-nav">INDEMNIFICATION</a></li>
                            <li class="lvl-1"><a href="#user-data" class="site-nav">USER DATA</a></li>
                            <li class="lvl-1"><a href="#ects" class="site-nav">ELECTRONIC COMMUNICATIONS, TRANSACTIONS, AND SIGNATURES</a></li>
                            <li class="lvl-1"><a href="#miscellaneous" class="site-nav">MISCELLANEOUS</a></li>
                        </ul>
                    </div>
                </div>
                <!--Categories-->

            </div>
        </div>
        <!--End Sidebar-->

        <!--Main Content-->
        <div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col shop-grid-5">
            <div class="productList">
                <div class="category-description">
                    <h1 class="text-center pt-5">Terms and Conditions</h1>
                </div>
                <hr>

                <div class="grid-products grid--view-items">
                    <div class="row">
                        <div class="card" id="agree-to-legal-terms">
                            <div class="card-body">
                                <h3>Agree to our legal terms</h3>
                                <p>
                                    We are <b>MECHANICAL ASSURANCE BEAREAU- MECAB</b> ('Company', 'we', 'us', or 'our'), a company registered in Ghana at P. O BOX 36, WINNEBA, CENTRAL REGION , WINNEBA, CENTRAL REGION.
                                    We operate the website http://www.mecab.org (the 'Site'), as well as any other related products and services that refer or link to these legal terms (the 'Legal Terms') (collectively, the 'Services').
                                    the sites makes it easy for users to find anything they need related to cars and automobiles.
                                    You can contact us by phone at +233244791855, email at bamfoadwuma@gmail.com, or by mail to P. O BOX 36, WINNEBA, CENTRAL REGION , WINNEBA, CENTRAL REGION Ghana.
                                    These Legal Terms constitute a legally binding agreement made between you, whether personally or on behalf of an entity ('you'), and MECHANICAL ASSURANCE BEAREAU- MECAB, concerning your access to and use of the Services. You agree that by accessing the Services, you have read, understood, and agreed to be bound by all of these Legal Terms. IF YOU DO NOT AGREE WITH ALL OF THESE LEGAL TERMS, THEN YOU ARE EXPRESSLY PROHIBITED FROM USING THE SERVICES AND YOU MUST DISCONTINUE USE IMMEDIATELY.
                                    We will provide you with prior notice of any scheduled changes to the Services you are using. Changes to Legal Terms will become effective one (1) days after the notice is given, except if the changes apply to new functionality, in which case the changes will be effective immediately. By continuing to use the Services after the effective date of any changes, you agree to be bound by the modified terms. If you disagree with such changes, you may terminate Services as per the section 'TERM AND TERMINATION'.
                                    The Services are intended for users who are at least 13 years of age. All users who are minors in the jurisdiction in which they reside (generally under the age of 18) must have the permission of, and be directly supervised by, their parent or guardian to use the Services. If you are a minor, you must have your parent or guardian read and agree to these Legal Terms prior to you using the Services.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="our-services">
                            <div class="card-body">
                                <h3>Our services</h3>
                                <p>
                                    The information provided when using the Services is not intended for distribution to or use by any person or entity in any jurisdiction or country where such distribution or use would be contrary to law or regulation or which would subject us to any registration requirement within such jurisdiction or country. Accordingly, those persons who choose to access the Services from other locations do so on their own initiative and are solely responsible for compliance with local laws, if and to the extent local laws are applicable.
                                    The Services are not tailored to comply with industry-specific regulations (Health Insurance Portability and Accountability Act (HIPAA), Federal Information Security Management Act (FISMA), etc.), so if your interactions would be subjected to such laws, you may not use the Services. You may not use the Services in a way that would violate the Gramm-Leach-Bliley Act (GLBA).
                                </p>
                            </div>
                        </div>
                        <div class="card" id="intellectual-property-right">
                            <div class="card-body">
                                <h3>INTELLECTUAL PROPERTY RIGHTS</h3>
                                <h5>Our intellectual property</h5>
                                <p>
                                    We are the owner or the licensee of all intellectual property rights in our Services, including all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics in the Services (collectively, the 'Content'), as well as the trademarks, service marks, and logos contained therein (the 'Marks').
                                    Our Content and Marks are protected by copyright and trademark laws (and various other intellectual property rights and unfair competition laws) and treaties in the United States and around the world.
                                    The Content and Marks are provided in or through the Services 'AS IS' for your personal, non-commercial use or internal business purpose only.
                                </p>
                                <h5>Use of our Services</h5>
                                <p>
                                    Subject to your compliance with these Legal Terms, including the 'PROHIBITED ACTIVITIES' section below, we grant you a non-exclusive, non-transferable, revocable licence to:
                                    <span>
                                        <ul class="p-3">
                                            <li>Access the Services and</li>
                                            <li>Download or print a copy of any portion of the Content to which you have properly gained access.</li>
                                        </ul>
                                    </span>
                                    solely for your personal, non-commercial use or internal business purpose.
                                    Except as set out in this section or elsewhere in our Legal Terms, no part of the Services and no Content or Marks may be copied, reproduced, aggregated, republished, uploaded, posted, publicly displayed, encoded, translated, transmitted, distributed, sold, licensed, or otherwise exploited for any commercial purpose whatsoever, without our express prior written permission.
                                    If you wish to make any use of the Services, Content, or Marks other than as set out in this section or elsewhere in our Legal Terms, please address your request to: bamfoadwuma@gmail.com. If we ever grant you the permission to post, reproduce, or publicly display any part of our Services or Content, you must identify us as the owners or licensors of the Services, Content, or Marks and ensure that any copyright or proprietary notice appears or is visible on posting, reproducing, or displaying our Content.
                                    We reserve all rights not expressly granted to you in and to the Services, Content, and Marks.
                                    Any breach of these Intellectual Property Rights will constitute a material breach of our Legal Terms and your right to use our Services will terminate immediately.
                                </p>
                                <h4>Your submissions and contributions</h4>
                                <p>
                                    Please review this section and the 'PROHIBITED ACTIVITIES' section carefully prior to using our Services to understand the (a) rights you give us and (b) obligations you have when you post or upload any content through the Services.
                                </p>
                                <h5>
                                    Submissions
                                </h5>
                                <p>
                                    By directly sending us any question, comment, suggestion, idea, feedback, or other information about the Services ('Submissions'), you agree to assign to us all intellectual property rights in such Submission. You agree that we shall own this Submission and be entitled to its unrestricted use and dissemination for any lawful purpose, commercial or otherwise, without acknowledgment or compensation to you.
                                </p>
                                <h5>Contributions</h5>
                                <p>
                                    The Services may invite you to chat, contribute to, or participate in blogs, message boards, online forums, and other functionality during which you may create, submit, post, display, transmit, publish, distribute, or broadcast content and materials to us or through the Services, including but not limited to text, writings, video, audio, photographs, music, graphics, comments, reviews, rating suggestions, personal information, or other material ('Contributions'). Any Submission that is publicly posted shall also be treated as a Contribution.
                                </p>
                                <p>
                                    You understand that Contributions may be viewable by other users of the Services and possibly through third-party websites.
                                </p>
                                <p>
                                    <b>When you post Contributions, you grant us a licence (including use of your name, trademarks, and logos)</b>
                                    posting any Contributions, you grant us an unrestricted, unlimited, irrevocable, perpetual, non-exclusive, transferable, royalty-free, fully-paid, worldwide right, and licence to: use, copy, reproduce, distribute, sell, resell, publish, broadcast, retitle, store, publicly perform, publicly display, reformat, translate, excerpt (in whole or in part), and exploit your Contributions (including, without limitation, your image, name, and voice) for any purpose, commercial, advertising, or otherwise, to prepare derivative works of, or incorporate into other works, your Contributions, and to sublicence the licences granted in this section. Our use and distribution may occur in any media formats and through any media channels.
                                </p>
                                <p>
                                    This licence includes our use of your name, company name, and franchise name, as applicable, and any of the trademarks, service marks, trade names, logos, and personal and commercial images you provide.
                                </p>
                                <p>
                                    <b>You are responsible for what you post or upload:</b>
                                    By sending us Submissions and/or posting Contributions through any part of the Services or making Contributions accessible through the Services by linking your account through the Services to any of your social networking accounts, you:
                                </p>
                                <p>
                                <ul class="p-3">
                                    <li>
                                        Confirm that you have read and agree with our 'PROHIBITED ACTIVITIES' and will not post, send, publish, upload, or transmit through the Services any Submission nor post any Contribution that is illegal, harassing, hateful, harmful, defamatory, obscene, bullying, abusive, discriminatory, threatening to any person or group, sexually explicit, false, inaccurate, deceitful, or misleading;
                                    </li>
                                    <li>
                                        To the extent permissible by applicable law, waive any and all moral rights to any such Submission and/or Contribution;
                                    </li>
                                    <li>
                                        Warrant that any such Submission and/or Contributions are original to you or that you have the necessary rights and licences to submit such Submissions and/or Contributions and that you have full authority to grant us the above-mentioned rights in relation to your Submissions and/or Contributions; and
                                    </li>
                                    <li>
                                        Warrant and represent that your Submissions and/or Contributions do not constitute confidential information.
                                    </li>
                                </ul>
                                </p>
                                <p>
                                    You are solely responsible for your Submissions and/or Contributions and you expressly agree to reimburse us for any and all losses that we may suffer because of your breach of (a) this section, (b) any third party’s intellectual property rights, or (c) applicable law.
                                </p>
                                <p>
                                    <b> We may remove or edit your Content: </b> we have no obligation to monitor any Contributions, we shall have the right to remove or edit any Contributions at any time without notice if in our reasonable opinion we consider such Contributions harmful or in breach of these Legal Terms. If we remove or edit any such Contributions, we may also suspend or disable your account and report you to the authorities.
                                </p>
                                <h5>Copyright infringement</h5>
                                <p>
                                    We respect the intellectual property rights of others. If you believe that any material available on or through the Services infringes upon any copyright you own or control, please immediately refer to the 'DIGITAL MILLENNIUM COPYRIGHT ACT (DMCA) NOTICE AND POLICY' section below.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="user-represtations">
                            <div class="card-body">
                                <h3>USER REPRESENTATIONS</h3>
                                <p>
                                    By using the Services, you represent and warrant that:
                                <ol class="p-3">
                                    <li>
                                        All registration information you submit will be true, accurate, current, and complete;
                                    </li>
                                    <li>
                                        You will maintain the accuracy of such information and promptly update such registration information as necessary;
                                    </li>
                                    <li>
                                        You have the legal capacity and you agree to comply with these Legal Terms;
                                    </li>
                                    <li>
                                        You are not under the age of 13;
                                    </li>
                                    <li>
                                        You are not a minor in the jurisdiction in which you reside, or if a minor, you have received parental permission to use the Services;
                                    </li>
                                    <li>
                                        You will not access the Services through automated or non-human means, whether through a bot, script or otherwise;
                                    </li>
                                    <li>
                                        You will not use the Services for any illegal or unauthorised purpose; and
                                    </li>
                                    <li>
                                        Your use of the Services will not violate any applicable law or regulation.
                                    </li>
                                </ol>
                                If you provide any information that is untrue, inaccurate, not current, or incomplete, we have the right to suspend or terminate your account and refuse any and all current or future use of the Services (or any portion thereof).
                                </p>
                            </div>
                        </div>
                        <div class="card" id="user-registrations">
                            <div class="card-body">
                                <h3>USER REGISTRATION</h3>
                                <p>
                                    You may be required to register to use the Services. You agree to keep your password confidential and will be responsible for all use of your account and password. We reserve the right to remove, reclaim, or change a username you select if we determine, in our sole discretion, that such username is inappropriate, obscene, or otherwise objectionable.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="products">
                            <div class="card-body">
                                <h3>PRODUCTS</h3>
                                <p>
                                    We make every effort to display as accurately as possible the colours, features, specifications, and details of the products available on the Services. However, we do not guarantee that the colours, features, specifications, and details of the products will be accurate, complete, reliable, current, or free of other errors, and your electronic display may not accurately reflect the actual colours and details of the products. All products are subject to availability, and we cannot guarantee that items will be in stock. We reserve the right to discontinue any products at any time for any reason. Prices for all products are subject to change.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="purchases-and-payment">
                            <div class="card-body">
                                <h3>PURCHASES AND PAYMENT</h3>
                                <p>
                                    We accept the following forms of payment:
                                <ul class="p-3">
                                    <li>Visa</li>
                                    <li>Mastercard</li>
                                    <li>mobile money</li>
                                </ul>
                                You agree to provide current, complete, and accurate purchase and account information for all purchases made via the Services. You further agree to promptly update account and payment information, including email address, payment method, and payment card expiration date, so that we can complete your transactions and contact you as needed. Sales tax will be added to the price of purchases as deemed required by us. We may change prices at any time. All payments shall be in ghana cedis.
                                You agree to pay all charges at the prices then in effect for your purchases and any applicable shipping fees, and you authorise us to charge your chosen payment provider for any such amounts upon placing your order. If your order is subject to recurring charges, then you consent to our charging your payment method on a recurring basis without requiring your prior approval for each recurring charge, until such time as you cancel the applicable order. We reserve the right to correct any errors or mistakes in pricing, even if we have already requested or received payment.
                                We reserve the right to refuse any order placed through the Services. We may, in our sole discretion, limit or cancel quantities purchased per person, per household, or per order. These restrictions may include orders placed by or under the same customer account, the same payment method, and/or orders that use the same billing or shipping address. We reserve the right to limit or prohibit orders that, in our sole judgement, appear to be placed by dealers, resellers, or distributors.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="return-policy">
                            <div class="card-body">
                                <h3>RETURN POLICY</h3>
                                <p>
                                    Please review our Return Policy posted on the Services prior to making any purchases.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="prohibited-activities">
                            <div class="card-body">
                                <h3>PROHIBITED ACTIVITIES</h3>
                                <p>
                                    You may not access or use the Services for any purpose other than that for which we make the Services available. The Services may not be used in connection with any commercial endeavours except those that are specifically endorsed or approved by us.
                                    As a user of the Services, you agree not to:
                                <ol class="p-3">
                                    <li>Systematically retrieve data or other content from the Services to create or compile, directly or indirectly, a collection, compilation, database, or directory without written permission from us.</li>
                                    <li>Trick, defraud, or mislead us and other users, especially in any attempt to learn sensitive account information such as user passwords.</li>
                                    <li>Circumvent, disable, or otherwise interfere with security-related features of the Services, including features that prevent or restrict the use or copying of any Content or enforce limitations on the use of the Services and/or the Content contained therein.</li>
                                    <li>Disparage, tarnish, or otherwise harm, in our opinion, us and/or the Services.</li>
                                    <li>Use any information obtained from the Services in order to harass, abuse, or harm another person.</li>
                                    <li>Make improper use of our support services or submit false reports of abuse or misconduct.</li>
                                    <li>Use the Services in a manner inconsistent with any applicable laws or regulations.</li>
                                    <li>Engage in unauthorised framing of or linking to the Services.</li>
                                    <li>Upload or transmit (or attempt to upload or to transmit) viruses, Trojan horses, or other material, including excessive use of capital letters and spamming (continuous posting of repetitive text), that interferes with any party’s uninterrupted use and enjoyment of the Services or modifies, impairs, disrupts, alters, or interferes with the use, features, functions, operation, or maintenance of the Services.</li>
                                    <li>Engage in any automated use of the system, such as using scripts to send comments or messages, or using any data mining, robots, or similar data gathering and extraction tools.</li>
                                    <li>Delete the copyright or other proprietary rights notice from any Content.</li>
                                    <li>Attempt to impersonate another user or person or use the username of another user.</li>
                                    <li>Upload or transmit (or attempt to upload or to transmit) any material that acts as a passive or active information collection or transmission mechanism, including without limitation, clear graphics interchange formats ('gifs'), 1×1 pixels, web bugs, cookies, or other similar devices (sometimes referred to as 'spyware' or 'passive collection mechanisms' or 'pcms').</li>
                                    <li>Interfere with, disrupt, or create an undue burden on the Services or the networks or services connected to the Services.</li>
                                    <li>Harass, annoy, intimidate, or threaten any of our employees or agents engaged in providing any portion of the Services to you.</li>
                                    <li>Attempt to bypass any measures of the Services designed to prevent or restrict access to the Services, or any portion of the Services.</li>
                                    <li>Copy or adapt the Services' software, including but not limited to Flash, PHP, HTML, JavaScript, or other code.</li>
                                    <li>Except as permitted by applicable law, decipher, decompile, disassemble, or reverse engineer any of the software comprising or in any way making up a part of the Services.</li>
                                    <li>Except as may be the result of standard search engine or Internet browser usage, use, launch, develop, or distribute any automated system, including without limitation, any spider, robot, cheat utility, scraper, or offline reader that accesses the Services, or use or launch any unauthorised script or other software.</li>
                                    <li>Use a buying agent or purchasing agent to make purchases on the Services.</li>
                                    <li>Make any unauthorised use of the Services, including collecting usernames and/or email addresses of users by electronic or other means for the purpose of sending unsolicited email, or creating user accounts by automated means or under false pretences.</li>
                                    <li>Use the Services as part of any effort to compete with us or otherwise use the Services and/or the Content for any revenue-generating endeavour or commercial enterprise.</li>
                                    <li>Sell or otherwise transfer your profile.</li>
                                </ol>
                                </p>
                            </div>
                        </div>
                        <div class="card" id="user-generated-contributions">
                            <div class="card-body">
                                <h3>USER GENERATED CONTRIBUTIONS</h3>
                                <p>
                                    The Services may invite you to chat, contribute to, or participate in blogs, message boards, online forums, and other functionality, and may provide you with the opportunity to create, submit, post, display, transmit, perform, publish, distribute, or broadcast content and materials to us or on the Services, including but not limited to text, writings, video, audio, photographs, graphics, comments, suggestions, or personal information or other material (collectively, 'Contributions'). Contributions may be viewable by other users of the Services and through third-party websites. As such, any Contributions you transmit may be treated as non-confidential and non-proprietary. When you create or make available any Contributions, you thereby represent and warrant that:
                                <ol class="p-3">
                                    <li>The creation, distribution, transmission, public display, or performance, and the accessing, downloading, or copying of your Contributions do not and will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark, trade secret, or moral rights of any third party.</li>
                                    <li>You are the creator and owner of or have the necessary licences, rights, consents, releases, and permissions to use and to authorise us, the Services, and other users of the Services to use your Contributions in any manner contemplated by the Services and these Legal Terms.</li>
                                    <li>You have the written consent, release, and/or permission of each and every identifiable individual person in your Contributions to use the name or likeness of each and every such identifiable individual person to enable inclusion and use of your Contributions in any manner contemplated by the Services and these Legal Terms.</li>
                                    <li>Your Contributions are not false, inaccurate, or misleading.</li>
                                    <li>Your Contributions are not unsolicited or unauthorised advertising, promotional materials, pyramid schemes, chain letters, spam, mass mailings, or other forms of solicitation.</li>
                                    <li>Your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing, libellous, slanderous, or otherwise objectionable (as determined by us).</li>
                                    <li>Your Contributions do not ridicule, mock, disparage, intimidate, or abuse anyone.</li>
                                    <li>Your Contributions are not used to harass or threaten (in the legal sense of those terms) any other person and to promote violence against a specific person or class of people.</li>
                                    <li>Your Contributions do not violate any applicable law, regulation, or rule.</li>
                                    <li>Your Contributions do not violate the privacy or publicity rights of any third party.</li>
                                    <li>Your Contributions do not violate any applicable law concerning child pornography, or otherwise intended to protect the health or well-being of minors.</li>
                                    <li>Your Contributions do not include any offensive comments that are connected to race, national origin, gender, sexual preference, or physical handicap.</li>
                                    <li>Your Contributions do not otherwise violate, or link to material that violates, any provision of these Legal Terms, or any applicable law or regulation.</li>
                                </ol>
                                Any use of the Services in violation of the foregoing violates these Legal Terms and may result in, among other things, termination or suspension of your rights to use the Services.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="contribution-licence">
                            <div class="card-body">
                                <h3>CONTRIBUTION LICENCE</h3>
                                <p>
                                    By posting your Contributions to any part of the Services or making Contributions accessible to the Services by linking your account from the Services to any of your social networking accounts, you automatically grant, and you represent and warrant that you have the right to grant, to us an unrestricted, unlimited, irrevocable, perpetual, non-exclusive, transferable, royalty-free, fully-paid, worldwide right, and licence to host, use, copy, reproduce, disclose, sell, resell, publish, broadcast, retitle, archive, store, cache, publicly perform, publicly display, reformat, translate, transmit, excerpt (in whole or in part), and distribute such Contributions (including, without limitation, your image and voice) for any purpose, commercial, advertising, or otherwise, and to prepare derivative works of, or incorporate into other works, such Contributions, and grant and authorise sublicences of the foregoing. The use and distribution may occur in any media formats and through any media channels.
                                    This licence will apply to any form, media, or technology now known or hereafter developed, and includes our use of your name, company name, and franchise name, as applicable, and any of the trademarks, service marks, trade names, logos, and personal and commercial images you provide. You waive all moral rights in your Contributions, and you warrant that moral rights have not otherwise been asserted in your Contributions.
                                    We do not assert any ownership over your Contributions. You retain full ownership of all of your Contributions and any intellectual property rights or other proprietary rights associated with your Contributions. We are not liable for any statements or representations in your Contributions provided by you in any area on the Services. You are solely responsible for your Contributions to the Services and you expressly agree to exonerate us from any and all responsibility and to refrain from any legal action against us regarding your Contributions.
                                    We have the right, in our sole and absolute discretion, (1) to edit, redact, or otherwise change any Contributions; (2) to re-categorise any Contributions to place them in more appropriate locations on the Services; and (3) to pre-screen or delete any Contributions at any time and for any reason, without notice. We have no obligation to monitor your Contributions.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="guidelines-for-review">
                            <div class="card-body">
                                <h3>GUIDELINES FOR REVIEWS</h3>
                                <p>
                                    We may provide you areas on the Services to leave reviews or ratings. When posting a review, you must comply with the following criteria:
                                <ol class="p-3">
                                    <li>you should have firsthand experience with the person/entity being reviewed;</li>
                                    <li>your reviews should not contain offensive profanity, or abusive, racist, offensive, or hateful language;</li>
                                    <li>your reviews should not contain discriminatory references based on religion, race, gender, national origin, age, marital status, sexual orientation, or disability;</li>
                                    <li>your reviews should not contain references to illegal activity;</li>
                                    <li>you should not be affiliated with competitors if posting negative reviews;</li>
                                    <li>you should not make any conclusions as to the legality of conduct;</li>
                                    <li>you may not post any false or misleading statements; and</li>
                                    <li>you may not organise a campaign encouraging others to post reviews, whether positive or negative.</li>
                                </ol>
                                We may accept, reject, or remove reviews in our sole discretion. We have absolutely no obligation to screen reviews or to delete reviews, even if anyone considers reviews objectionable or inaccurate. Reviews are not endorsed by us, and do not necessarily represent our opinions or the views of any of our affiliates or partners. We do not assume liability for any review or for any claims, liabilities, or losses resulting from any review. By posting a review, you hereby grant to us a perpetual, non-exclusive, worldwide, royalty-free, fully paid, assignable, and sublicensable right and licence to reproduce, modify, translate, transmit by any means, display, perform, and/or distribute all content relating to review.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="social-media">
                            <div class="card-body">
                                <h3>SOCIAL MEDIA</h3>
                                <p>
                                    As part of the functionality of the Services, you may link your account with online accounts you have with third-party service providers (each such account, a 'Third-Party Account') by either: (1) providing your Third-Party Account login information through the Services; or (2) allowing us to access your Third-Party Account, as is permitted under the applicable terms and conditions that govern your use of each Third-Party Account. You represent and warrant that you are entitled to disclose your Third-Party Account login information to us and/or grant us access to your Third-Party Account, without breach by you of any of the terms and conditions that govern your use of the applicable Third-Party Account, and without obligating us to pay any fees or making us subject to any usage limitations imposed by the third-party service provider of the Third-Party Account. By granting us access to any Third-Party Accounts, you understand that (1) we may access, make available, and store (if applicable) any content that you have provided to and stored in your Third-Party Account (the 'Social Network Content') so that it is available on and through the Services via your account, including without limitation any friend lists and (2) we may submit to and receive from your Third-Party Account additional information to the extent you are notified when you link your account with the Third-Party Account. Depending on the Third-Party Accounts you choose and subject to the privacy settings that you have set in such Third-Party Accounts, personally identifiable information that you post to your Third-Party Accounts may be available on and through your account on the Services. Please note that if a Third-Party Account or associated service becomes unavailable or our access to such Third-Party Account is terminated by the third-party service provider, then Social Network Content may no longer be available on and through the Services. You will have the ability to disable the connection between your account on the Services and your Third-Party Accounts at any time. PLEASE NOTE THAT YOUR RELATIONSHIP WITH THE THIRD-PARTY SERVICE PROVIDERS ASSOCIATED WITH YOUR THIRD-PARTY ACCOUNTS IS GOVERNED SOLELY BY YOUR AGREEMENT(S) WITH SUCH THIRD-PARTY SERVICE PROVIDERS. We make no effort to review any Social Network Content for any purpose, including but not limited to, for accuracy, legality, or non-infringement, and we are not responsible for any Social Network Content. You acknowledge and agree that we may access your email address book associated with a Third-Party Account and your contacts list stored on your mobile device or tablet computer solely for purposes of identifying and informing you of those contacts who have also registered to use the Services. You can deactivate the connection between the Services and your Third-Party Account by contacting us using the contact information below or through your account settings (if applicable). We will attempt to delete any information stored on our servers that was obtained through such Third-Party Account, except the username and profile picture that become associated with your account.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="third-party-websites-and-content">
                            <div class="card-body">
                                <h3>THIRD-PARTY WEBSITES AND CONTENT</h3>
                                <p>
                                    The Services may contain (or you may be sent via the Site) links to other websites ('Third-Party Websites') as well as articles, photographs, text, graphics, pictures, designs, music, sound, video, information, applications, software, and other content or items belonging to or originating from third parties ('Third-Party Content'). Such Third-Party Websites and Third-Party Content are not investigated, monitored, or checked for accuracy, appropriateness, or completeness by us, and we are not responsible for any Third-Party Websites accessed through the Services or any Third-Party Content posted on, available through, or installed from the Services, including the content, accuracy, offensiveness, opinions, reliability, privacy practices, or other policies of or contained in the Third-Party Websites or the Third-Party Content. Inclusion of, linking to, or permitting the use or installation of any Third-Party Websites or any Third-Party Content does not imply approval or endorsement thereof by us. If you decide to leave the Services and access the Third-Party Websites or to use or install any Third-Party Content, you do so at your own risk, and you should be aware these Legal Terms no longer govern. You should review the applicable terms and policies, including privacy and data gathering practices, of any website to which you navigate from the Services or relating to any applications you use or install from the Services. Any purchases you make through Third-Party Websites will be through other websites and from other companies, and we take no responsibility whatsoever in relation to such purchases which are exclusively between you and the applicable third party. You agree and acknowledge that we do not endorse the products or services offered on Third-Party Websites and you shall hold us blameless from any harm caused by your purchase of such products or services. Additionally, you shall hold us blameless from any losses sustained by you or harm caused to you relating to or resulting in any way from any Third-Party Content or any contact with Third-Party Websites.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="service-management">
                            <div class="card-body">
                                <h3>SERVICES MANAGEMENT</h3>
                                <p>
                                    We reserve the right, but not the obligation, to: (1) monitor the Services for violations of these Legal Terms; (2) take appropriate legal action against anyone who, in our sole discretion, violates the law or these Legal Terms, including without limitation, reporting such user to law enforcement authorities; (3) in our sole discretion and without limitation, refuse, restrict access to, limit the availability of, or disable (to the extent technologically feasible) any of your Contributions or any portion thereof; (4) in our sole discretion and without limitation, notice, or liability, to remove from the Services or otherwise disable all files and content that are excessive in size or are in any way burdensome to our systems; and (5) otherwise manage the Services in a manner designed to protect our rights and property and to facilitate the proper functioning of the Services.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="privacy-policy">
                            <div class="card-body">
                                <h3>PRIVACY POLICY</h3>
                                <p>
                                    We care about data privacy and security. By using the Services, you agree to be bound by our Privacy Policy posted on the Services, which is incorporated into these Legal Terms. Please be advised the Services are hosted in Ghana. If you access the Services from any other region of the world with laws or other requirements governing personal data collection, use, or disclosure that differ from applicable laws in Ghana, then through your continued use of the Services, you are transferring your data to Ghana, and you expressly consent to have your data transferred to and processed in Ghana. Further, we do not knowingly accept, request, or solicit information from children or knowingly market to children. Therefore, in accordance with the U.S. Children’s Online Privacy Protection Act, if we receive actual knowledge that anyone under the age of 13 has provided personal information to us without the requisite and verifiable parental consent, we will delete that information from the Services as quickly as is reasonably practical.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="digital-millennium-copyright">
                            <div class="card-body">
                                <h3>DIGITAL MILLENNIUM COPYRIGHT ACT (DMCA) NOTICE AND POLICY</h3>
                                <h4>Notifications</h4>
                                <p>
                                    We respect the intellectual property rights of others. If you believe that any material available on or through the Services infringes upon any copyright you own or control, please immediately notify our Designated Copyright Agent using the contact information provided below (a 'Notification'). A copy of your Notification will be sent to the person who posted or stored the material addressed in the Notification. Please be advised that pursuant to federal law you may be held liable for damages if you make material misrepresentations in a Notification. Thus, if you are not sure that material located on or linked to by the Services infringes your copyright, you should consider first contacting an attorney.
                                    All Notifications should meet the requirements of DMCA 17 U.S.C. § 512(c)(3) and include the following information: (1) A physical or electronic signature of a person authorised to act on behalf of the owner of an exclusive right that is allegedly infringed; (2) identification of the copyrighted work claimed to have been infringed, or, if multiple copyrighted works on the Services are covered by the Notification, a representative list of such works on the Services; (3) identification of the material that is claimed to be infringing or to be the subject of infringing activity and that is to be removed or access to which is to be disabled, and information reasonably sufficient to permit us to locate the material; (4) information reasonably sufficient to permit us to contact the complaining party, such as an address, telephone number, and, if available, an email address at which the complaining party may be contacted; (5) a statement that the complaining party has a good faith belief that use of the material in the manner complained of is not authorised by the copyright owner, its agent, or the law; and (6) a statement that the information in the notification is accurate, and under penalty of perjury, that the complaining party is authorised to act on behalf of the owner of an exclusive right that is allegedly infringed upon.
                                </p>
                                <h4>Counter Notification</h4>
                                <p>
                                    If you believe your own copyrighted material has been removed from the Services as a result of a mistake or misidentification, you may submit a written counter notification to [us/our Designated Copyright Agent] using the contact information provided below (a 'Counter Notification'). To be an effective Counter Notification under the DMCA, your Counter Notification must include substantially the following:
                                <ol class="p-3">
                                    <li>identification of the material that has been removed or disabled and the location at which the material appeared before it was removed or disabled; </li>
                                    <li>a statement that you consent to the jurisdiction of the Federal District Court in which your address is located, or if your address is outside the United States, for any judicial district in which we are located; </li>
                                    <li>a statement that you will accept service of process from the party that filed the Notification or the party's agent; </li>
                                    <li>your name, address, and telephone number; </li>
                                    <li>a statement under penalty of perjury that you have a good faith belief that the material in question was removed or disabled as a result of a mistake or misidentification of the material to be removed or disabled; and </li>
                                    <li>your physical or electronic signature.</li>
                                </ol>

                                If you send us a valid, written Counter Notification meeting the requirements described above, we will restore your removed or disabled material, unless we first receive notice from the party filing the Notification informing us that such party has filed a court action to restrain you from engaging in infringing activity related to the material in question. Please note that if you materially misrepresent that the disabled or removed content was removed by mistake or misidentification, you may be liable for damages, including costs and attorney's fees. Filing a false Counter Notification constitutes perjury.</br>
                                Designated Copyright Agent <br>
                                Ghana copyright Associatio <br>
                                Attn: Copyright Agent <br>
                                mbanaana@gmail.com <br>
                                winneba, Central Region <br>
                                Ghana <br>
                                exudetimes@gmail.com <br>
                                </p>
                            </div>
                        </div>
                        <div class="card" id="term-and-termination">
                            <div class="card-body">
                                <h3>TERM AND TERMINATION</h3>
                                <p>
                                    These Legal Terms shall remain in full force and effect while you use the Services. WITHOUT LIMITING ANY OTHER PROVISION OF THESE LEGAL TERMS, WE RESERVE THE RIGHT TO, IN OUR SOLE DISCRETION AND WITHOUT NOTICE OR LIABILITY, DENY ACCESS TO AND USE OF THE SERVICES (INCLUDING BLOCKING CERTAIN IP ADDRESSES), TO ANY PERSON FOR ANY REASON OR FOR NO REASON, INCLUDING WITHOUT LIMITATION FOR BREACH OF ANY REPRESENTATION, WARRANTY, OR COVENANT CONTAINED IN THESE LEGAL TERMS OR OF ANY APPLICABLE LAW OR REGULATION. WE MAY TERMINATE YOUR USE OR PARTICIPATION IN THE SERVICES OR DELETE YOUR ACCOUNT AND ANY CONTENT OR INFORMATION THAT YOU POSTED AT ANY TIME, WITHOUT WARNING, IN OUR SOLE DISCRETION.
                                    If we terminate or suspend your account for any reason, you are prohibited from registering and creating a new account under your name, a fake or borrowed name, or the name of any third party, even if you may be acting on behalf of the third party. In addition to terminating or suspending your account, we reserve the right to take appropriate legal action, including without limitation pursuing civil, criminal, and injunctive redress.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="modification-and-interruptions">
                            <div class="card-body">
                                <h3>MODIFICATIONS AND INTERRUPTIONS</h3>
                                <p>
                                    We reserve the right to change, modify, or remove the contents of the Services at any time or for any reason at our sole discretion without notice. However, we have no obligation to update any information on our Services. We also reserve the right to modify or discontinue all or part of the Services without notice at any time. We will not be liable to you or any third party for any modification, price change, suspension, or discontinuance of the Services.
                                    We cannot guarantee the Services will be available at all times. We may experience hardware, software, or other problems or need to perform maintenance related to the Services, resulting in interruptions, delays, or errors. We reserve the right to change, revise, update, suspend, discontinue, or otherwise modify the Services at any time or for any reason without notice to you. You agree that we have no liability whatsoever for any loss, damage, or inconvenience caused by your inability to access or use the Services during any downtime or discontinuance of the Services. Nothing in these Legal Terms will be construed to obligate us to maintain and support the Services or to supply any corrections, updates, or releases in connection therewith.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="governing-law">
                            <div class="card-body">
                                <h3>GOVERNING LAW</h3>
                                <p>
                                    These Legal Terms shall be governed by and defined following the laws of Ghana. MECHANICAL ASSURANCE BEAREAU- MECAB and yourself irrevocably consent that the courts of Ghana shall have exclusive jurisdiction to resolve any dispute which may arise in connection with these Legal Terms.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="dispute-resolution">
                            <div class="card-body">
                                <h3>DISPUTE RESOLUTION</h3>
                                <h4>Informal Negotiations</h4>
                                <p>
                                    To expedite resolution and control the cost of any dispute, controversy, or claim related to these Legal Terms (each a 'Dispute' and collectively, the 'Disputes') brought by either you or us (individually, a 'Party' and collectively, the 'Parties'), the Parties agree to first attempt to negotiate any Dispute (except those Disputes expressly provided below) informally for at least sixty (60) days before initiating arbitration. Such informal negotiations commence upon written notice from one Party to the other Party.
                                </p>
                                <h4>Binding Arbitration</h4>
                                <p>Any dispute arising out of or in connection with these Legal Terms, including any question regarding its existence, validity, or termination, shall be referred to and finally resolved by the International Commercial Arbitration Court under the European Arbitration Chamber (Belgium, Brussels, Avenue Louise, 146) according to the Rules of this ICAC, which, as a result of referring to it, is considered as the part of this clause. The number of arbitrators shall be five (5). The seat, or legal place, or arbitration shall be Accra, Ghana. The language of the proceedings shall be English. The governing law of these Legal Terms shall be substantive law of Ghana.</p>
                                <h4>Restrictions</h4>
                                <p>The Parties agree that any arbitration shall be limited to the Dispute between the Parties individually. To the full extent permitted by law, (a) no arbitration shall be joined with any other proceeding; (b) there is no right or authority for any Dispute to be arbitrated on a class-action basis or to utilise class action procedures; and (c) there is no right or authority for any Dispute to be brought in a purported representative capacity on behalf of the general public or any other persons.</p>
                                <h4>Exceptions to Informal Negotiations and Arbitration</h4>
                                <p>The Parties agree that the following Disputes are not subject to the above provisions concerning informal negotiations binding arbitration: (a) any Disputes seeking to enforce or protect, or concerning the validity of, any of the intellectual property rights of a Party; (b) any Dispute related to, or arising from, allegations of theft, piracy, invasion of privacy, or unauthorised use; and (c) any claim for injunctive relief. If this provision is found to be illegal or unenforceable, then neither Party will elect to arbitrate any Dispute falling within that portion of this provision found to be illegal or unenforceable and such Dispute shall be decided by a court of competent jurisdiction within the courts listed for jurisdiction above, and the Parties agree to submit to the personal jurisdiction of that court.</p>
                            </div>
                        </div>
                        <div class="card" id="corrections">
                            <div class="card-body">
                                <h3>CORRECTIONS</h3>
                                <p>
                                    There may be information on the Services that contains typographical errors, inaccuracies, or omissions, including descriptions, pricing, availability, and various other information. We reserve the right to correct any errors, inaccuracies, or omissions and to change or update the information on the Services at any time, without prior notice.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="disclaimer">
                            <div class="card-body">
                                <h3>DISCLAIMER</h3>
                                <p>
                                    THE SERVICES ARE PROVIDED ON AN AS-IS AND AS-AVAILABLE BASIS. YOU AGREE THAT YOUR USE OF THE SERVICES WILL BE AT YOUR SOLE RISK. TO THE FULLEST EXTENT PERMITTED BY LAW, WE DISCLAIM ALL WARRANTIES, EXPRESS OR IMPLIED, IN CONNECTION WITH THE SERVICES AND YOUR USE THEREOF, INCLUDING, WITHOUT LIMITATION, THE IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND NON-INFRINGEMENT. WE MAKE NO WARRANTIES OR REPRESENTATIONS ABOUT THE ACCURACY OR COMPLETENESS OF THE SERVICES' CONTENT OR THE CONTENT OF ANY WEBSITES OR MOBILE APPLICATIONS LINKED TO THE SERVICES AND WE WILL ASSUME NO LIABILITY OR RESPONSIBILITY FOR ANY
                                <ol class="p-3">
                                    <li>ERRORS, MISTAKES, OR INACCURACIES OF CONTENT AND MATERIALS, </li>
                                    <li>PERSONAL INJURY OR PROPERTY DAMAGE, OF ANY NATURE WHATSOEVER, RESULTING FROM YOUR ACCESS TO AND USE OF THE SERVICES, </li>
                                    <li>ANY UNAUTHORISED ACCESS TO OR USE OF OUR SECURE SERVERS AND/OR ANY AND ALL PERSONAL INFORMATION AND/OR FINANCIAL INFORMATION STORED THEREIN, </li>
                                    <li>ANY INTERRUPTION OR CESSATION OF TRANSMISSION TO OR FROM THE SERVICES, </li>
                                    <li>ANY BUGS, VIRUSES, TROJAN HORSES, OR THE LIKE WHICH MAY BE TRANSMITTED TO OR THROUGH THE SERVICES BY ANY THIRD PARTY, AND/OR </li>
                                    <li>ANY ERRORS OR OMISSIONS IN ANY CONTENT AND MATERIALS OR FOR ANY LOSS OR DAMAGE OF ANY KIND INCURRED AS A RESULT OF THE USE OF ANY CONTENT POSTED, TRANSMITTED, OR OTHERWISE MADE AVAILABLE VIA THE SERVICES.</li>
                                </ol>
                                WE DO NOT WARRANT, ENDORSE, GUARANTEE, OR ASSUME RESPONSIBILITY FOR ANY PRODUCT OR SERVICE ADVERTISED OR OFFERED BY A THIRD PARTY THROUGH THE SERVICES, ANY HYPERLINKED WEBSITE, OR ANY WEBSITE OR MOBILE APPLICATION FEATURED IN ANY BANNER OR OTHER ADVERTISING, AND WE WILL NOT BE A PARTY TO OR IN ANY WAY BE RESPONSIBLE FOR MONITORING ANY TRANSACTION BETWEEN YOU AND ANY THIRD-PARTY PROVIDERS OF PRODUCTS OR SERVICES. AS WITH THE PURCHASE OF A PRODUCT OR SERVICE THROUGH ANY MEDIUM OR IN ANY ENVIRONMENT, YOU SHOULD USE YOUR BEST JUDGEMENT AND EXERCISE CAUTION WHERE APPROPRIATE.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="limitations-of-liability">
                            <div class="card-body">
                                <h3>LIMITATIONS OF LIABILITY</h3>
                                <p>
                                    IN NO EVENT WILL WE OR OUR DIRECTORS, EMPLOYEES, OR AGENTS BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DIRECT, INDIRECT, CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL, OR PUNITIVE DAMAGES, INCLUDING LOST PROFIT, LOST REVENUE, LOSS OF DATA, OR OTHER DAMAGES ARISING FROM YOUR USE OF THE SERVICES, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. NOTWITHSTANDING ANYTHING TO THE CONTRARY CONTAINED HEREIN, OUR LIABILITY TO YOU FOR ANY CAUSE WHATSOEVER AND REGARDLESS OF THE FORM OF THE ACTION, WILL AT ALL TIMES BE LIMITED TO THE AMOUNT PAID, IF ANY, BY YOU TO US DURING THE eight (8) mONTH PERIOD PRIOR TO ANY CAUSE OF ACTION ARISING. CERTAIN US STATE LAWS AND INTERNATIONAL LAWS DO NOT ALLOW LIMITATIONS ON IMPLIED WARRANTIES OR THE EXCLUSION OR LIMITATION OF CERTAIN DAMAGES. IF THESE LAWS APPLY TO YOU, SOME OR ALL OF THE ABOVE DISCLAIMERS OR LIMITATIONS MAY NOT APPLY TO YOU, AND YOU MAY HAVE ADDITIONAL RIGHTS.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="indemnification">
                            <div class="card-body">
                                <h3>INDEMNIFICATION</h3>
                                <p>
                                    You agree to defend, indemnify, and hold us harmless, including our subsidiaries, affiliates, and all of our respective officers, agents, partners, and employees, from and against any loss, damage, liability, claim, or demand, including reasonable attorneys’ fees and expenses, made by any third party due to or arising out of: (1) your Contributions; (2) use of the Services; (3) breach of these Legal Terms; (4) any breach of your representations and warranties set forth in these Legal Terms; (5) your violation of the rights of a third party, including but not limited to intellectual property rights; or (6) any overt harmful act toward any other user of the Services with whom you connected via the Services. Notwithstanding the foregoing, we reserve the right, at your expense, to assume the exclusive defence and control of any matter for which you are required to indemnify us, and you agree to cooperate, at your expense, with our defence of such claims. We will use reasonable efforts to notify you of any such claim, action, or proceeding which is subject to this indemnification upon becoming aware of it.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="user-data">
                            <div class="card-body">
                                <h3>USER DATA</h3>
                                <p>
                                    We will maintain certain data that you transmit to the Services for the purpose of managing the performance of the Services, as well as data relating to your use of the Services. Although we perform regular routine backups of data, you are solely responsible for all data that you transmit or that relates to any activity you have undertaken using the Services. You agree that we shall have no liability to you for any loss or corruption of any such data, and you hereby waive any right of action against us arising from any such loss or corruption of such data.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="ects">
                            <div class="card-body">
                                <h3>ELECTRONIC COMMUNICATIONS, TRANSACTIONS, AND SIGNATURES</h3>
                                <p>
                                    Visiting the Services, sending us emails, and completing online forms constitute electronic communications. You consent to receive electronic communications, and you agree that all agreements, notices, disclosures, and other communications we provide to you electronically, via email and on the Services, satisfy any legal requirement that such communication be in writing. YOU HEREBY AGREE TO THE USE OF ELECTRONIC SIGNATURES, CONTRACTS, ORDERS, AND OTHER RECORDS, AND TO ELECTRONIC DELIVERY OF NOTICES, POLICIES, AND RECORDS OF TRANSACTIONS INITIATED OR COMPLETED BY US OR VIA THE SERVICES. You hereby waive any rights or requirements under any statutes, regulations, rules, ordinances, or other laws in any jurisdiction which require an original signature or delivery or retention of non-electronic records, or to payments or the granting of credits by any means other than electronic means.
                                </p>
                            </div>
                        </div>
                        <div class="card" id="miscellaneous">
                            <div class="card-body">
                                <h3> MISCELLANEOUS</h3>
                                <p>
                                    These Legal Terms and any policies or operating rules posted by us on the Services or in respect to the Services constitute the entire agreement and understanding between you and us. Our failure to exercise or enforce any right or provision of these Legal Terms shall not operate as a waiver of such right or provision. These Legal Terms operate to the fullest extent permissible by law. We may assign any or all of our rights and obligations to others at any time. We shall not be responsible or liable for any loss, damage, delay, or failure to act caused by any cause beyond our reasonable control. If any provision or part of a provision of these Legal Terms is determined to be unlawful, void, or unenforceable, that provision or part of the provision is deemed severable from these Legal Terms and does not affect the validity and enforceability of any remaining provisions. There is no joint venture, partnership, employment or agency relationship created between you and us as a result of these Legal Terms or use of the Services. You agree that these Legal Terms will not be construed against us by virtue of having drafted them. You hereby waive any and all defences you may have based on the electronic form of these Legal Terms and the lack of signing by the parties hereto to execute these Legal Terms.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End Main Content-->
    </div>
</div>

<?php
include_once('includes/footer.php')
?>