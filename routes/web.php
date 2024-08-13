<?php

use App\Http\Controllers\Admin\AdminAccountsController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Routes;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

use App\Http\Controllers\LandingController;

/* ADMIN CONTROLLER */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CertificationRequestController;
use App\Http\Controllers\Admin\DealersController as AdminDealersController;
use App\Http\Controllers\Admin\InsuranceController as AdminInsuranceController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\LoungeMembersController;
use App\Http\Controllers\Admin\PetRegistrationController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RandomGiftDropController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\TrainingTicketsController;
/* Update user time */
use App\Http\Controllers\Admin\UpdateUserCreatedAtController;


/* USER CONTROLLER */
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\CreateController;
use App\Http\Controllers\User\DeleteController;
use App\Http\Controllers\User\SelectController;
use App\Http\Controllers\User\UpdateController;
use App\Http\Controllers\User\ViewProfileController;
use App\Http\Controllers\User\PostFeedController;

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\GoogleAuthController;
use App\Http\Controllers\User\RegistrationController;

use App\Http\Controllers\User\FollowController;
use App\Http\Controllers\User\MessengerController;
use App\Http\Controllers\User\IAGDMembershipController;

use App\Http\Controllers\User\CertificateController;
use App\Http\Controllers\User\InsuranceController;
use App\Http\Controllers\User\DogTrainingController;

use App\Http\Controllers\User\AlbumController;
use App\Http\Controllers\User\AnimalCertificationController;
use App\Http\Controllers\User\TermsCondition;
use App\Http\Controllers\User\CookiesPolicy;
use App\Http\Controllers\User\PrivacyPolicy;
use App\Http\Controllers\User\ViewPostController;

use App\Http\Controllers\User\SearchController;
use App\Http\Controllers\User\ShareController;
use App\Http\Controllers\User\NavUserNotification;

use App\Http\Controllers\User\LogoutController;
use App\Http\Controllers\User\PetController;
use App\Http\Controllers\User\QrCodeController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\User\ApiPetsController;
use App\Http\Controllers\User\ProductsAndServicesController;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\User\DealersController;

/* END USER CONTROLLER */

/**
 * ROUTES FOR USERS
 */
Route::get('/', [LandingController::class, 'index'])->name('user.landing');

Route::get('/get_file', [UserController::class, 'get_file'])->middleware(Cors::class);
// Route::middleware(['cors'])->group(function () {
//     Route::get('/get_file', [UserController::class, 'get_file'])->name('user.get_file');
// });



/*
    LOGIN VIEW
*/
Route::get('/log_in', [UserController::class, 'log_in'])->name('user.login');

/*
    LOGIN FUNCTION
*/
Route::post('/user_loginvalidation', [LoginController::class, 'user_loginvalidation'])->name('user.user_loginvalidation');
Route::post('/ajax/linkmyAccount', [GoogleAuthController::class, 'linkmyAccount'])->name('user.linkmyAccount');

/*
    REGISTRATION VIEW
*/
Route::get('/email_confirmation', [RegistrationController::class, 'email_confirmation'])->name('user.email_confirmation');
Route::get('/user_registration', [RegistrationController::class, 'user_registration'])->name('user.user_registration');
Route::get('/account-link-google', [GoogleAuthController::class, 'account_link_google'])->name('user.account_link_google');

/*
    REGISTRATION FUNCTION
*/
Route::post('/ajax/verify-email-address', [RegistrationController::class, 'verify_email_address'])->name('user.verify_email_address');
Route::post('/ajax/create-account', [RegistrationController::class, 'create_account'])->name('user.create_account');


/*
    EMAIL VERIFICATION TEMPLATE
*/
Route::get('/email_verification_sample', [RegistrationController::class, 'email_verification_sample'])->name('user.email_verification_sample');

/*
    FORGOT PASSWORD VIEW
*/
Route::get('/reset_your_password', [RegistrationController::class, 'reset_your_password'])->name('user.reset_your_password');
Route::get('/forgot_password', [RegistrationController::class, 'forgot_password'])->name('user.forgot_password');

/*
    FORGOT PASSWORD FUNCTION
*/
Route::post('/check_email_address', [RegistrationController::class, 'check_email_address'])->name('user.check_email_address');
Route::get('/resend_password_reset', [SelectController::class, 'resend_password_reset'])->name('user.resend_password_reset');
Route::post('/update_new_password', [UpdateController::class, 'update_new_password'])->name('user.update_new_password');

/*
    FORGOT PASSWORD EMAIL TEMPLATE
*/
Route::get('/password_reset_template', [UserController::class, 'password_reset_template'])->name('user.password_reset_template');

/*
    GOOGLE SUPPORT
*/
Route::get('/google-auth-redirect', [GoogleAuthController::class, 'google_auth_redirect'])->name('user.google_auth_redirect');
Route::get('/google-auth', [GoogleAuthController::class, 'google_auth'])->name('user.google_auth');
Route::post('/ajax/validate-g-login', [GoogleAuthController::class, 'validate_g_login'])->name('user.validate_g_login');




/* Terms and condition */
Route::get('terms_condition', [TermsCondition::class, 'index'])->name('user.terms_condition');

/* Cookies Policy */
Route::get('cookies_policy', [CookiesPolicy::class, 'index'])->name('user.cookies_policy');

/* Privacy Policy */
Route::get('privacy_policy', [PrivacyPolicy::class, 'index'])->name('user.privacy_policy');

/* Registration */
Route::get('/user_registered_members', [UserController::class, 'user_registered_members'])->name('user.user_registered_members');
Route::post('/create_user_registration', [UserController::class, 'create_user_registration'])->name('user.create_user_registration');

Route::post('/check_iagd_number', [SelectController::class, 'check_iagd_number'])->name('user.check_iagd_number');
Route::get('/verify_iagd_number_email', [UserController::class, 'verify_iagd_number_email'])->name('user.verify_iagd_number_email');

Route::get('/create_password_foruser', [UserController::class, 'create_password_foruser'])->name('user.create_password_foruser');

Route::post('/register_user_pass', [CreateController::class, 'register_user_pass'])->name('user.register_user_pass');

Route::get('/resend_email', [SelectController::class, 'resend_email'])->name('user.resend_email');

/* Password reset */


Route::get('/resend_mail_passreset', [SelectController::class, 'resend_mail_passreset'])->name('user.resend_mail_passreset'); // for removal i think AHHAHAHA



/*
    PET REGISTRATION
*/
Route::get('/pet_registration', [UserController::class, 'pet_registration'])->name('user.pet_registration');
Route::get('/pet_registration_form', [UserController::class, 'pet_registration_form'])->name('user.pet_registration_form');
/*
    PET REGISTRATION FUNCTION
*/
Route::post('/ajax/register-pet', [CreateController::class, 'register_pet'])->name('user.register_pet');


Route::get('/scanner', [QrCodeController::class, 'qrcode_scanner'])->name('user.qrcode_scanner');
Route::get('/qr/result/user', [QrCodeController::class, 'qr_result_user'])->name('user.qr_result_user');



Route::middleware(['auth:web'])->group(function () {
    /* -------------------------------------------------------------------------- */
    /*                        Post feed view and functions                        */
    /* -------------------------------------------------------------------------- */
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('/ajax/comment_in_post', [PostFeedController::class, 'comment_in_post'])->name('user.comment_in_post');
    Route::post('/ajax/get_paginate_comments', [PostFeedController::class, 'get_paginate_comments'])->name('user.get_paginate_comments');
    Route::post('/ajax/get_latest_comments', [PostFeedController::class, 'get_latest_comments'])->name('user.get_latest_comments');
    Route::post('/ajax/post/delete', [PostFeedController::class, 'post_delete'])->name('user.post_delete');
    Route::get('/ajax/post/get', [PostFeedController::class, 'post_get'])->name('user.post_get');
    Route::get('/ajax/post/get_specific', [PostFeedController::class, 'post_get_specific'])->name('user.post_get_specific');
    Route::post('/ajax/post/reaction/create', [PostFeedController::class, 'post_reaction_create'])->name('user.post_reaction_create');
    Route::post('/ajax/post/reaction/view', [PostFeedController::class, 'post_reaction_view'])->name('user.post_reaction_view');
    Route::post('/ajax/post/create', [PostFeedController::class, 'create_new_post'])->name('user.create_new_post');
    Route::any('/ajax/post/comment/view', [PostFeedController::class, 'view_comments'])->name('user.view_comments');
    Route::post('/ajax/post/comment/delete', [PostFeedController::class, 'delete_comments'])->name('user.delete_comments');

    /* -------------------------------------------------------------------------- */
    /*                            View post controller                            */
    /* -------------------------------------------------------------------------- */
    Route::get('view/post', [ViewPostController::class, 'view_this_posts'])->name('user.view_this_posts');

    /* -------------------------------------------------------------------------- */
    /*                              Search controller                             */
    /* -------------------------------------------------------------------------- */
    Route::post('search', [SearchController::class, 'search_view'])->name('user.search_view');
    Route::post('/ajax/search', [SearchController::class, 'search_all'])->name('user.search_all');
    Route::post('/ajax/search/user/paginated', [SearchController::class, 'add_user_paginated'])->name('user.add_user_paginated');

    /* -------------------------------------------------------------------------- */
    /*                                 Share post                                 */
    /* -------------------------------------------------------------------------- */
    route::post('/ajax/share/post/get', [ShareController::class, 'get_post_byuuid'])->name('user.get_post_byuuid');
    route::post('/ajax/share/post/create', [ShareController::class, 'share_post_create'])->name('user.share_post_create');


    Route::get('/gallery', [UserController::class, 'pet_gallery'])->name('gallery');
    Route::get('/LogoutUser', [LogoutController::class, 'LogoutUser'])->name('logout.user');

    Route::get('/user_profile', [UserController::class, 'user_profile'])->name('user.user_profile');

    Route::get('/pet_trades', [UserController::class, 'pet_trades'])->name('pet_trades');

    Route::get('/advertisements', [UserController::class, 'advertisements'])->name('advertisements');
    Route::get('/advertisements_info/{uuid}', [UserController::class, 'advertisements_info'])->name('advertisements_info');

    /* Check for removal */
    Route::get('/kennel', [UserController::class, 'kennel'])->name('kennel');
    Route::get('/kennel_info/{petno}', [UserController::class, 'kennel_info'])->name('kennel_info');
    Route::get('/kennel_unregistered', [UserController::class, 'kennel_unregistered'])->name('kennel_unregistered');
    Route::get('/kennel_unregistered_info/{petuuid}', [UserController::class, 'kennel_unregistered_info'])->name('kennel_unregistered_info');

    Route::get('/cattery', [UserController::class, 'cattery'])->name('cattery');
    Route::get('/cattery_info/{petno}', [UserController::class, 'cattery_info'])->name('cattery_info');
    Route::get('/cattery_unregistered', [UserController::class, 'cattery_unregistered'])->name('cattery_unregistered');
    Route::get('/cattery_unregistered_info/{petuuid}', [UserController::class, 'cattery_unregistered_info'])->name('cattery_unregistered_info');

    Route::get('/rabbitry', [UserController::class, 'rabbitry'])->name('rabbitry');
    Route::get('/rabbitry_info/{petno}', [UserController::class, 'rabbitry_info'])->name('rabbitry_info');
    Route::get('/rabbitry_unregistered', [UserController::class, 'rabbitry_unregistered'])->name('rabbitry_unregistered');
    Route::get('/rabbitry_unregistered_info/{petuuid}', [UserController::class, 'rabbitry_unregistered_info'])->name('rabbitry_unregistered_info');

    Route::get('/coop', [UserController::class, 'coop'])->name('coop');
    Route::get('/coop_info/{petno}', [UserController::class, 'coop_info'])->name('coop_info');
    Route::get('/coop_unregistered', [UserController::class, 'coop_unregistered'])->name('coop_unregistered');
    Route::get('/coop_unregistered_info/{petuuid}', [UserController::class, 'coop_unregistered_info'])->name('coop_unregistered_info');

    Route::get('/other_animal', [UserController::class, 'other_animal'])->name('other_animal');
    Route::get('/other_animal_info/{petno}', [UserController::class, 'other_animal_info'])->name('other_animal_info');
    Route::get('/other_animal_unregistered', [UserController::class, 'other_animal_unregistered'])->name('other_animal_unregistered');
    Route::get('/other_animal_unregistered_info/{petuuid}', [UserController::class, 'other_animal_unregistered_info'])->name('other_animal_unregistered_info');

    Route::post('/upload_pet_image', [UserController::class, 'upload_pet_image'])->name('user.upload_pet_image');

    Route::post('/upload_receipt', [UserController::class, 'upload_receipt'])->name('user.upload_receipt');

    Route::post('/ajax/toggle_pet_visibility', [UpdateController::class, 'toggle_pet_visibility'])->name('user.toggle_pet_visibility');
    /* Check for removal end */

    Route::post('/Update_profile', [UserController::class, 'update_user_profile'])->name('user.profile-update');
    Route::post('/upload_cropped_image', [UserController::class, 'upload_cropped_image'])->name('user.upload_cropped_image');

    Route::post('/upload_dog_image', [CreateController::class, 'upload_dog_image'])->name('user.upload_dog_image');


    Route::post('/create_post', [CreateController::class, 'create_post'])->name('user.create_post');

    Route::get('/ajax_allpost', [SelectController::class, 'ajax_allpost'])->name('user.ajax_allpost');

    Route::get('/view_post', [UserController::class, 'view_post'])->name('user.view_post');

    Route::get('/CheckUserLiked', [SelectController::class, 'CheckUserLiked'])->name('user.CheckUserLiked');

    Route::post('/UpdateTimezUser', [UpdateController::class, 'UpdateTimezUser'])->name('user.UpdateTimezUser');

    Route::post('/update_my_profile', [UpdateController::class, 'update_my_profile'])->name('user.update_my_profile');

    Route::post('/update_my_password', [UpdateController::class, 'update_my_password'])->name('user.update_my_password');

    Route::get('/view_pet_details', [UserController::class, 'view_pet_details'])->name('user.view_pet_details');

    Route::post('/delete_this_pet_record', [DeleteController::class, 'delete_this_pet_record'])->name('user.delete_this_pet_record');

    Route::post('/get_all_comments_thispost', [SelectController::class, 'get_all_comments_thispost'])->name('user.get_all_comments_thispost');

    Route::post('/insert_new_comment', [CreateController::class, 'insert_new_comment'])->name('user.insert_new_comment');

    Route::post('/update_comment_section_data', [SelectController::class, 'update_comment_section_data'])->name('user.update_comment_section_data');

    Route::post('/GetLatestComment', [SelectController::class, 'GetLatestComment'])->name('user.GetLatestComment');

    Route::post('/add_pet_unregistered', [CreateController::class, 'add_pet_unregistered'])->name('user.add_pet_unregistered');

    Route::post('/add_dog', [UpdateController::class, 'add_dog'])->name('user.add_dog');
    Route::post('/update_dog', [UpdateController::class, 'update_dog'])->name('user.update_dog');
    Route::post('/add_dog_unregistered', [CreateController::class, 'add_dog_unregistered'])->name('user.add_dog_unregistered');
    Route::post('/update_dog_unregistered', [UpdateController::class, 'update_dog_unregistered'])->name('user.update_dog_unregistered');
    Route::get('/cancel_dog_registration/{petuuid}', [UpdateController::class, 'cancel_dog_registration'])->name('user.cancel_dog_registration');

    Route::post('/add_cat', [UpdateController::class, 'add_cat'])->name('user.add_cat');
    Route::post('/update_cat', [UpdateController::class, 'update_cat'])->name('user.update_cat');
    Route::post('/add_cat_unregistered', [CreateController::class, 'add_cat_unregistered'])->name('user.add_cat_unregistered');
    Route::post('/update_cat_unregistered', [UpdateController::class, 'update_cat_unregistered'])->name('user.update_cat_unregistered');
    Route::get('/cancel_cat_registration/{petuuid}', [UpdateController::class, 'cancel_cat_registration'])->name('user.cancel_cat_registration');

    Route::post('/add_rabbit', [UpdateController::class, 'add_rabbit'])->name('user.add_rabbit');
    Route::post('/update_rabbit', [UpdateController::class, 'update_rabbit'])->name('user.update_rabbit');
    Route::post('/add_rabbit_unregistered', [CreateController::class, 'add_rabbit_unregistered'])->name('user.add_rabbit_unregistered');
    Route::post('/update_rabbit_unregistered', [UpdateController::class, 'update_rabbit_unregistered'])->name('user.update_rabbit_unregistered');
    Route::get('/cancel_rabbit_registration/{petuuid}', [UpdateController::class, 'cancel_rabbit_registration'])->name('user.cancel_rabbit_registration');

    Route::post('/add_bird', [UpdateController::class, 'add_bird'])->name('user.add_bird');
    Route::post('/update_bird', [UpdateController::class, 'update_bird'])->name('user.update_bird');
    Route::post('/add_bird_unregistered', [CreateController::class, 'add_bird_unregistered'])->name('user.add_bird_unregistered');
    Route::post('/update_bird_unregistered', [UpdateController::class, 'update_bird_unregistered'])->name('user.update_bird_unregistered');
    Route::get('/cancel_bird_registration/{petuuid}', [UpdateController::class, 'cancel_bird_registration'])->name('user.cancel_bird_registration');

    Route::post('/add_other_animal', [UpdateController::class, 'add_other_animal'])->name('user.add_other_animal');
    Route::post('/update_other_animal', [UpdateController::class, 'update_other_animal'])->name('user.update_other_animal');
    Route::post('/add_other_animal_unregistered', [CreateController::class, 'add_other_animal_unregistered'])->name('user.add_other_animal_unregistered');
    Route::post('/update_other_animal_unregistered', [UpdateController::class, 'update_other_animal_unregistered'])->name('user.update_other_animal_unregistered');
    Route::get('/cancel_other_animal_registration/{petuuid}', [UpdateController::class, 'cancel_other_animal_registration'])->name('user.cancel_other_animal_registration');

    // download file
    Route::post('/download_file', [UserController::class, 'download_file'])->name('user.download_file');



    Route::post('/add_advertisement', [CreateController::class, 'add_advertisement'])->name('user.add_advertisement');
    Route::post('/update_advertisement', [UpdateController::class, 'update_advertisement'])->name('user.update_advertisement');


    Route::post('/create_trade', [CreateController::class, 'create_trade'])->name('user.create_trade');
    Route::post('/create_trade_request', [CreateController::class, 'create_trade_request'])->name('user.create_trade_request');
    Route::post('/cancel_trade_request', [UpdateController::class, 'cancel_trade_request'])->name('user.cancel_trade_request');
    Route::post('/reject_trade_request', [UpdateController::class, 'reject_trade_request'])->name('user.reject_trade_request');
    Route::post('/close_trade', [UpdateController::class, 'close_trade'])->name('user.close_trade');

    Route::get('/ajax_alltrade', [SelectController::class, 'ajax_alltrade'])->name('user.ajax_alltrade');
    Route::get('/ajax_allrequest', [SelectController::class, 'ajax_allrequest'])->name('user.ajax_allrequest');

    Route::get('/view_trade/{tradeno}', [UserController::class, 'view_trade'])->name('user.view_trade');

    /*
        MEMBER VIEW PROFILE
    */
    Route::get('/view/members-details', [ViewProfileController::class, 'view_members'])->name('user.view_members');
    Route::get('/ajax/get-all-post', [ViewProfileController::class, 'get_all_post'])->name('user.get_all_post');
    Route::post('/ajax/react-to-post', [ViewProfileController::class, 'react_to_post'])->name('user.react_to_post');

    Route::get('/view/members-comments', [ViewProfileController::class, 'view_comments'])->name('user.view_commentss'); // edited bug same with post view_comments
    Route::get('/ajax/get-all-comment', [ViewProfileController::class, 'get_all_comment'])->name('user.get_all_comment');

    Route::get('/view/members-reacts', [ViewProfileController::class, 'view_reacts'])->name('user.view_reacts');
    Route::get('/ajax/get-all-react', [ViewProfileController::class, 'get_all_react'])->name('user.get_all_react');

    Route::get('/view/follows', [ViewProfileController::class, 'view_follows'])->name('user.view_follows');
    Route::post('/ajax/get_user_follower', [ViewProfileController::class, 'get_user_follower'])->name('user.get_user_follower');

    Route::get('/view/message/user', [ViewProfileController::class, 'message_user_card'])->name('user.message_user_card');




    Route::get('/view/members-advertisements', [ViewProfileController::class, 'view_members_advertisements'])->name('user.view_members_advertisements');

    Route::get('/view/pets', [ViewProfileController::class, 'view_members_pets'])->name('user.view_members_pets');
    Route::post('/ajax/get_user_pets', [ViewProfileController::class, 'get_user_pets'])->name('user.get_user_pets');

    Route::get('/view/members-profile', [ViewProfileController::class, 'view_members_profile'])->name('user.view_members_profile');

    /* Users album */
    Route::get('/view/album', [AlbumController::class, 'view_user_album'])->name('user.view_user_album');
    Route::post('/ajax/get_all_attachment', [AlbumController::class, 'get_all_attachment'])->name('user.get_all_attachment');


    Route::get('/ajax/members-details', [ViewProfileController::class, 'getMemberDetails'])->name('user.getMemberDetails');
    Route::get('/ajax/members-advertisements', [ViewProfileController::class, 'getMemberAdvertisements'])->name('user.getMemberAdvertisements');

    Route::get('/ajax/countProfileLikes', [ViewProfileController::class, 'countProfileLikes'])->name('user.countProfileLikes');
    Route::get('/ajax/countProfileFollowers', [ViewProfileController::class, 'countProfileFollowers'])->name('user.countProfileFollowers');

    Route::post('/ajax/message_user', [ViewProfileController::class, 'message_user'])->name('user.message_user');
    Route::post('/ajax/send_user_message', [ViewProfileController::class, 'send_user_message'])->name('user.send_user_message');
    Route::post('/ajax/update_message', [ViewProfileController::class, 'update_message'])->name('user.update_message');

    Route::get('/qrcode/download', [QrCodeController::class, 'qrcode_download'])->name('user.qrcode_download');

    /* Referrals */

    Route::get('/user/referrals', [UserController::class, 'my_referrals'])->name('user.my_referrals');


    /*
        FOLLOW
    */
    Route::get('/follow', [FollowController::class, 'index'])->name('user.follow');
    Route::get('/follow/user', [FollowController::class, 'follow_user'])->name('user.follow_user');

    /* -------------------------------------------------------------------------- */
    /*                                  Messenger                                 */
    /* -------------------------------------------------------------------------- */
    Route::get('/messenger', [MessengerController::class, 'index'])->name('user.messenger');
    Route::get('/ajax/all-follows', [MessengerController::class, 'all_follows'])->name('user.all_follows');
    Route::post('/ajax/messenger/search/users', [MessengerController::class, 'search_users'])->name('user.search_users');
    Route::post('/ajax/messenger/conversation/get', [MessengerController::class, 'get_conversation'])->name('user.get_conversation');
    Route::post('/ajax/messenger/user/get', [MessengerController::class, 'get_user_details'])->name('user.get_user_details');


    Route::post('/ajax/send-message', [MessengerController::class, 'sendMessage'])->name('user.sendMessage');
    Route::post('/ajax/update_messengerChatContent', [MessengerController::class, 'update_messengerChatContent'])->name('user.update_messengerChatContent');
    Route::post('/ajax/get_last_message_at', [MessengerController::class, 'get_last_message_at'])->name('user.get_last_message_at');
    Route::post('/ajax/messenger/get/message', [MessengerController::class, 'get_message'])->name('user.get_message');


    Route::get('/example/getmetadata', [MessengerController::class, 'getmetadata'])->name('user.getmetadata');
    Route::get('/example/CheckifStringhaslink', [MessengerController::class, 'CheckifStringhaslink'])->name('user.CheckifStringhaslink');

    /* IAGD membership */
    Route::get('/be_a_member', [IAGDMembershipController::class, 'be_a_member'])->name('user.be_a_member');
    Route::post('/ajax/register_as_a_member', [IAGDMembershipController::class, 'register_as_a_member'])->name('user.register_as_a_member');


    /* CERTIFICATE GENERATOR */
    Route::post('/Create_certificate_animal_registration', [CertificateController::class, 'Create_certificate_animal_registration'])->name('users.Create_certificate_animal_registration');
    Route::post('/Create_certificate_animal_pedigree', [CertificateController::class, 'Create_certificate_animal_pedigree'])->name('users.Create_certificate_animal_pedigree');

    Route::get('/ajax_get_details_pet', [CertificateController::class, 'ajax_get_details_pet'])->name('users.ajax_get_details_pet');

    /* Nav notifications */
    Route::get('/ajax/notification/get', [NavUserNotification::class, 'getNotificationsForUser'])->name('user.get_notifications');
    Route::post('/ajax/notification/view', [NavUserNotification::class, 'viewUserNotification'])->name('user.view_notification');

    /* Admin */
    Route::get('/admin/signin/validation', [AdminController::class, 'admin_sign_validation'])->name('admin.admin_sign_validation');


    /* Dog Training */
    Route::get('/user/training', [DogTrainingController::class, 'index'])->name('user.training');
    Route::post('/user/training/assitance/create', [DogTrainingController::class, 'training_create_assistance'])->name('user.training_create_assistance');

    /* -------------------------------------------------------------------------- */
    /*                              Insurance routes                              */
    /* -------------------------------------------------------------------------- */
    Route::get('/user/insurance/request', [InsuranceController::class, 'index'])->name('user.insurance');
    Route::get('/user/insurance', [InsuranceController::class, 'insuranceView'])->name('user.insuranceView');
    Route::get('/user/insurance/details', [InsuranceController::class, 'insuranceDetails'])->name('user.insuranceDetails');
    Route::post('/user/insurance/avail', [InsuranceController::class, 'insuranceAvail'])->name('user.insuranceAvail');
    Route::get('/user/insurance/availed', [InsuranceController::class, 'getUserAvailedInsurance'])->name('user.getUserAvailedInsurance');


    /* -------------------------------------------------------------------------- */
    /*                        New animal page registration                        */
    /* -------------------------------------------------------------------------- */
    Route::get('/user/certificate/request', [AnimalCertificationController::class, 'index'])->name('user.animal_certifcation');
    Route::post('/user/certificate/request/create', [AnimalCertificationController::class, 'request_cert_create'])->name('user.request_cert_create');
    Route::get('/user/pet/list', [PetController::class, 'index'])->name('user.pet_list');
    Route::post('/user/pet/get', [PetController::class, 'get_all_pets'])->name('user.get_all_pets');
    Route::get('/user/pet/form/dog', [PetController::class, 'form_register_dog'])->name('user.form_register_dog');
    Route::post('/user/pet/dog/register', [PetController::class, 'register_new_dog'])->name('user.register_new_dog');
    Route::get('/user/pet/details', [PetController::class, 'pet_details'])->name('user.pet_details');
    Route::post('/user/pet/delete', [PetController::class, 'petDelete'])->name('user.petDelete');

    Route::post('/user/pet/register', [PetController::class, 'petRegister'])->name('user.petRegister');
    Route::get('/user/pet/form/cat', [PetController::class, 'formCatRegistration'])->name('user.formCatRegistration');
    Route::get('/user/pet/form/bird', [PetController::class, 'formBirdRegistration'])->name('user.formBirdRegistration');
    Route::get('/user/pet/form/rabbit', [PetController::class, 'formRabbitRegistration'])->name('user.formRabbitRegistration');
    /* Products */
    Route::get('products', [ProductsController::class, 'show'])->name('products.show');

    /* -------------------------------------------------------------------------- */
    /*                            Product and services                            */
    /* -------------------------------------------------------------------------- */
    Route::get('/products/list', [ProductsAndServicesController::class, 'index'])->name('user.products.list');
    Route::get('/products/view/cart', [ProductsAndServicesController::class, 'viewCartPage'])->name('user.viewCartPage');
    Route::get('/products/cart', [ProductsAndServicesController::class, 'getMyCart'])->name('user.products.showMyCart');
    Route::post('/products/cart/add', [ProductsAndServicesController::class, 'addToCartItem'])->name('user.products.addToCartItem');
    Route::post('/products/cart/remove', [ProductsAndServicesController::class, 'removeItemFromCart'])->name('user.products.removeItemFromCart');
    Route::post('/products/cart/checkout', [ProductsAndServicesController::class, 'cartItemCheckout'])->name('user.products.cartItemCheckout');

    Route::get('/services', [ProductsAndServicesController::class, 'dogTrainingServices'])->name('user.services.list');
    Route::get('/services/cart', [ProductsAndServicesController::class, 'getServicesCart'])->name('user.services.getServicesCart');
    Route::post('/services/cart/add', [ProductsAndServicesController::class, 'addToCartService'])->name('user.services.addToCartService');
    Route::post('/services/cart/delete', [ProductsAndServicesController::class, 'serviceCartDelete'])->name('user.services.serviceCartDelete');
    Route::get('/services/cart/checkout', [ProductsAndServicesController::class, 'serviceCheckout'])->name('user.services.serviceCheckout');

    Route::get('/services/enrollment', [ProductsAndServicesController::class, 'servicesEnrollmentForm'])
    ->name('user.servicesEnrollmentForm.form');
    Route::post('/services/enrollment/add', [ProductsAndServicesController::class, 'enrollThisPet'])
    ->name('user.servicesEnrollmentForm.enrollThisPet');
    Route::get('/services/enrollment/cart', [ProductsAndServicesController::class, 'enrollmentCartService'])
    ->name('user.servicesEnrollmentForm.enrollmentCartService');
    Route::post('/services/enrollment/cart/remove', [ProductsAndServicesController::class, 'enrollmentCartServiceRemove'])
    ->name('user.enrollmentCartServiceRemove');

    /**
     * This is the dealers routes and its sub routes
     * @param prefix 'dealer'
     * @return \Illuminate\Routing\RouteRegistrar
     */
    Route::prefix('dealer')->group(function () {
        Route::get('/', [DealersController::class, 'index'])->name('dealer');
        Route::post('/create', [DealersController::class, 'create'])->name('dealer.create');
    });
});

/**
 * ROUTES FOR ADMINS
 */
Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::post('/admin/LoginValidation', [AdminController::class, 'LoginValidation'])->name('admin.LoginValidation');

Route::middleware(['auth:web_admin'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/Dashboard', [AdminController::class, 'Dashboard'])->name('admin.Dashboard');
        Route::get('/IAGD_Members', [AdminController::class, 'IAGD_Members'])->name('admin.IAGD_Members');
        Route::get('/member_registration', [AdminController::class, 'member_registration'])->name('admin.registration');
        Route::get('/logout_admin', [AdminController::class, 'logout_admin'])->name('admin.logout');

        Route::get('/users_post', [AdminController::class, 'users_post'])->name('admin.users_post');

        Route::get('/Membership_Upgrade', [MembershipController::class, 'Membership_Upgrade'])->name('admin.Membership_Upgrade');
        Route::get('/upgrade_membership', [MembershipController::class, 'upgrade_membership'])->name('admin.upgrade_membership');

        /* -------------------------------------------------------------------------- */
        /*                            Lounge members routes                           */
        /* -------------------------------------------------------------------------- */
        Route::get('/Lounge_Members', [LoungeMembersController::class, 'Lounge_Members'])->name('admin.Lounge_Members');
        Route::post('/Lounge_Members/referral/update', [LoungeMembersController::class, 'updateReferralNumber'])->name('admin.updateReferralNumber');

        Route::get('/Dog_Registration', [PetRegistrationController::class, 'Dog_Registration'])->name('admin.Dog_Registration');
        Route::get('/Cat_Registration', [PetRegistrationController::class, 'Cat_Registration'])->name('admin.Cat_Registration');
        Route::get('/Rabbit_Registration', [PetRegistrationController::class, 'Rabbit_Registration'])->name('admin.Rabbit_Registration');
        Route::get('/Bird_Registration', [PetRegistrationController::class, 'Bird_Registration'])->name('admin.Bird_Registration');
        Route::get('/Other_Registration', [PetRegistrationController::class, 'Other_Registration'])->name('admin.Other_Registration');

        Route::post('/ajax/get_pet_reg_adtl', [PetRegistrationController::class, 'get_pet_reg_adtl'])->name('admin.get_pet_reg_adtl');


        route::get('/send_emailverification', [AdminController::class, 'send_emailverification'])->name('admin.sendmail_verification');
        route::get('/template_email_verification', [AdminController::class, 'template_email_verification'])->name('admin.template_email_verification');

        /* -------------------------------------------------------------------------- */
        /*                            Admin accounts routes                           */
        /* -------------------------------------------------------------------------- */
        Route::get('/accounts_list', [AdminAccountsController::class, 'index'])->name('admin.accounts_list');
        Route::get('/accounts/get', [AdminAccountsController::class, 'account_all'])->name('admin.account_all');
        Route::post('/accounts/delete', [AdminAccountsController::class, 'delete_account_byid'])->name('admin.delete_account_byid');
        Route::get('/accounts/form', [AdminAccountsController::class, 'admin_account_form'])->name('admin.admin_account_form');
        Route::post('/ajax/user/get', [AdminAccountsController::class, 'user_get'])->name('admin.user_get');
        Route::post('/ajax/user/create', [AdminAccountsController::class, 'useradmin_create'])->name('admin.useradmin_create');



        /* -------------------------------------------------------------------------- */
        /*                              Gift drop routes                              */
        /* -------------------------------------------------------------------------- */
        route::get('/random_gift_drop', [RandomGiftDropController::class, 'index'])->name('admin.random_gift_drop');

        /* -------------------------------------------------------------------------- */
        /*                            Certification request                           */
        /* -------------------------------------------------------------------------- */
        route::get('/cetification/requests', [CertificationRequestController::class, 'index'])->name('admin.certification_requests');


        /* -------------------------------------------------------------------------- */
        /*                              Training Tickets                              */
        /* -------------------------------------------------------------------------- */
        route::get('/training/tickets', [TrainingTicketsController::class, 'index'])->name('admin.training_tickets');
        route::post('/training/tickets/close', [TrainingTicketsController::class, 'ticket_close'])->name('admin.ticket_close');

        /* -------------------------------------------------------------------------- */
        /*                               Admin products                               */
        /* -------------------------------------------------------------------------- */
        route::get('/products', [AdminProductController::class, 'index'])->name('admin.products');
        route::get('/products/orders', [AdminProductController::class, 'productOrders'])->name('admin.productOrders');
        route::post('/products/create', [AdminProductController::class, 'createNewProduct'])->name('admin.createNewProduct');
        route::post('/products/accept', [AdminProductController::class, 'acceptOrders'])->name('admin.acceptOrders');
        route::post('/products/cancel', [AdminProductController::class, 'cancelOrders'])->name('admin.cancelOrders');


        /* -------------------------------------------------------------------------- */
        /*                               Admin services                               */
        /* -------------------------------------------------------------------------- */
        Route::get('/services', [ServicesController::class, 'index'])->name('admin.services');
        Route::get('/services/enrollments', [ServicesController::class, 'serviceEnrollments'])->name('admin.serviceEnrollments');
        Route::post('/services/create', [ServicesController::class, 'createNewService'])->name('admin.createNewService');

        /* -------------------------------------------------------------------------- */
        /*                               Admin Insurance                              */
        /* -------------------------------------------------------------------------- */
        Route::get('/insurance', [AdminInsuranceController::class, 'index'])->name('admin.insuranceView');
        Route::get('/insurance/form', [AdminInsuranceController::class, 'insuranceFormCreate'])->name('admin.insuranceFormCreate');
        Route::post('/insurance/create', [AdminInsuranceController::class, 'insuranceCreate'])->name('admin.insuranceCreate');
        Route::get('/insurance/delete', [AdminInsuranceController::class, 'insuranceDelete'])->name('admin.insuranceDelete');


        Route::get('storage/insurance_files/{path}', function ($path) {
            $filePath = storage_path('app/insurance_files/' . $path);

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }

            abort(404);
        })->where('path', '.*');

        /**
         * Dealers route group
         * @param string 'dealers'
         * @return \Illuminate\Routing\RouteRegistrar
         */
        Route::prefix('dealers')->group(function () {

            /**
             * Dealers page route
             * @param string '/'
             * @param controller [AdminDealersController::class
             * @param function 'index']
             * @return \Illuminate\Routing\Route
             */
            Route::get('/', [AdminDealersController::class, 'index'])->name('admin.dealers');


            /**
             * Approved dealrs page route
             * @param string '/approved'
             * @param controller [AdminDealersController::class
             * @param function 'index']
             * @return \Illuminate\Routing\Route
             */
            Route::post('/update/status', [AdminDealersController::class, 'updateDealerStatus'])->name('admin.dealers.update.status');

        });
    });
});

route::get('updateUserCreate_At', [UpdateUserCreatedAtController::class, 'updateUserCreate_At'])->name('admin.updateUserCreate_At');
Route::get('/api/example/pets', [ApiPetsController::class, 'getallPets'])->name('api.example.getallPets');



/* ARTISAN */
// Route::get('migrate', function () {
//     Artisan::call('migrate');
// });

// Route::get('migrate-fresh', function () {
//     Artisan::call('migrate:fresh');
// });

// Route::get('db-seeder', function () {
//     Artisan::call('db:seed', [
//         '--class' => DatabaseSeeder::class
//     ]);
// });
// Route::get('maintenance-on', function () {
//     Artisan::call('down');
// });
// Route::get('maintenance-off', function () {
//     Artisan::call('up');
// });




// Route::get('route-cache', function () {
//     Artisan::call('route:cache');
// });
// Route::get('route-clear', function () {
//     Artisan::call('route:clear');
// });
// Route::get('route-list', function () {
//     Artisan::call('route:list');
// });

// Route::get('config-clear', function () {
//     Artisan::call('config:clear');
// });
// Route::get('cache-clear', function () {
//     Artisan::call('cache:clear');
// });

// Route::get('view-clear', function () {
//     Artisan::call('view:clear');
// });

// Route::get('sockets/serve', function () {
//     Artisan::call('websockets:serve');
// });
