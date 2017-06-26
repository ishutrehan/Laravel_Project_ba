<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

$s = 'public.';

Route::get('/',         ['as' => $s . 'home',   'uses' => 'PagesController@getHome']);
Route::get('/home',         ['as' => $s . 'home',   'uses' => 'PagesController@getHome']);
Route::get('/aboutus', ['as' => $s . 'aboutus', 'uses' => 'PagesController@getAboutus']);
Route::get('/terms-use', ['as' => $s . 'terms-use', 'uses' => 'PagesController@getTermsuse']);
Route::get('/contact-us', ['as' => $s . 'contact-us', 'uses' => 'PagesController@getContactus']);
Route::post('/contact', ['as' => $s . 'contact', 'uses' => 'PagesController@contact']);
Route::post('/contact-page', ['as' => $s . 'contact-page', 'uses' => 'PagesController@contactPage']);
Route::get('/getusername', ['as' => $s . 'getusername', 'uses' => 'PagesController@getUsername']);
Route::post('/resetusername', ['as' => $s . 'contact', 'uses' => 'PagesController@resetUsername']);
Route::get('/explore-page', ['as' => $s . 'explore-page', 'uses' => 'PagesController@ExplorePage']);
Route::post('/checkque', ['as' => $s . 'checkque', 'uses' => 'UserController@checkQuestion']);
Route::post('/save-note', ['as' => $s . 'save-note', 'uses' => 'UserController@saveNote']);
Route::get('/pricing', ['as' => $s . 'pricing', 'uses' => 'PagesController@pricingPage']);
Route::get('/payment', ['as' => $s . 'payment', 'uses' => 'UserController@getPaymentPage']);


$s = 'social.';
Route::get('/social/redirect/{provider}',   ['as' => $s . 'redirect',   'uses' => 'Auth\SocialController@getSocialRedirect']);
Route::get('/social/handle/{provider}',     ['as' => $s . 'handle',     'uses' => 'Auth\SocialController@getSocialHandle']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth:administrator'], function()
{
    $a = 'admin.';
    Route::get('/', ['as' => $a . 'home', 'uses' => 'AdminController@getHome']);
    Route::get('/members', ['as' => $a . 'members', 'uses' => 'AdminController@getMembers']);
    Route::get('/tests/{uid}', ['as' => $a . 'tests', 'uses' => 'AdminController@getTests']);
    Route::get('/edit-user/{user_id}', ['as' => $a . 'edit-user', 'uses' => 'AdminController@editMember']);
    Route::post('/update-member', ['as' => $a . 'update-member', 'uses' => 'AdminController@updateMember']);
    Route::post('/update-subs', ['as' => $a . 'update-subs', 'uses' => 'AdminController@updateSubscription']);
    Route::get('/add-user', ['as' => $a . 'add-user', 'uses' => 'AdminController@addMember']);
    Route::post('/add-member', ['as' => $a . 'add-member', 'uses' => 'AdminController@saveMember']);
    Route::get('/end-subs/{id}', ['as' => $a . 'end-subs', 'uses' => 'AdminController@cancelSubscription']);
    Route::get('/delete-user/{user_id}', ['as' => $a . 'delete-user', 'uses' => 'AdminController@deleteMember']);
    
    Route::get('/add-test', ['as' => $a . 'add-test', 'uses' => 'AdminController@addTest']);
    Route::post('/recent-updates', ['as' => $a . 'recent-updates', 'uses' => 'AdminController@recentUpdates']);
    Route::get('/pages', ['as' => $a . 'pages', 'uses' => 'AdminController@pages']);
    Route::post('/update-pages', ['as' => $a . 'update-pages', 'uses' => 'AdminController@updatePages']);
    
    Route::get('/delete-updates/{rid}', ['as' => $a . 'delete-updates', 'uses' => 'AdminController@deleteUpdates']);

    Route::get('/pay-history', ['as' => $a . 'pay-history', 'uses' => 'AdminController@payHistory']);
    Route::post('/filter-payment', ['as' => $a . 'filter-payment', 'uses' => 'AdminController@filterPayment']);

    Route::get('/info', ['as' => $a . 'info', 'uses' => 'AdminController@addInfo']);
    Route::post('/update-info', ['as' => $a . 'update-info', 'uses' => 'AdminController@updateInfo']);

    // Preview
    Route::get('/mcq-preview', ['as' => $a . 'mcq-preview', 'uses' => 'AdminController@mcqPreview']);
    Route::get('/next-preview-mcq/{index}', ['as' => $a . 'next-preview-mcq', 'uses' => 'AdminController@mcqPreview']);

    // Add test view
    Route::get('exam/mcq-emq', ['as' => $a . 'mcq-emq', 'uses' => 'AdminController@viewMcqEmq']);
    Route::get('exam/essay-questions', ['as' => $a . 'essay-questions', 'uses' => 'AdminController@viewEssayQuestions']);
    Route::get('exam/morphology', ['as' => $a . 'morphology', 'uses' => 'AdminController@viewMorphology']);
    Route::get('exam/quality-assurance', ['as' => $a . 'quality-assurance', 'uses' => 'AdminController@viewQualityAssurance']);
    Route::get('exam/transfusion', ['as' => $a . 'transfusion', 'uses' => 'AdminController@viewTransfusion']);
    
    // Add test save
    Route::post('/add-mcq-emq', ['as' => $a . 'add-mcq-emq', 'uses' => 'AdminController@addMcqEmq']);
    Route::get('exam/mcq-emq', ['as' => $a . 'mcq-emq', 'uses' => 'AdminController@viewMcqEmq']);
    Route::post('/add-essay-ques', ['as' => $a . 'add-essay-ques', 'uses' => 'AdminController@addEssayques']);
    Route::post('/add-morphology', ['as' => $a . 'add-morphology', 'uses' => 'AdminController@addMorphology']);
    Route::post('/add-quality-assurance', ['as' => $a . 'add-quality-assurance', 'uses' => 'AdminController@addQualityAssurance']);
    Route::post('/add-transfusion', ['as' => $a . 'add-transfusion', 'uses' => 'AdminController@addTransfusion']);

    // Update
    Route::post('/update-essay-ques', ['as' => $a . 'update-essay-ques', 'uses' => 'AdminController@UpdateEssayques']);
    Route::post('/update-morphology', ['as' => $a . 'update-morphology', 'uses' => 'AdminController@updateMorphology']);
    Route::post('/update-quality-assurance', ['as' => $a . 'update-quality-assurance', 'uses' => 'AdminController@updateQualityAssurance']);
    Route::post('/update-transfusion', ['as' => $a . 'update-transfusion', 'uses' => 'AdminController@updateTransfusion']);
    Route::post('/update-mcq-emq', ['as' => $a . 'update-mcq-emq', 'uses' => 'AdminController@updateMcqEmq']);

    // Delete
    Route::get('/delete-question-mcq/{r_id}', ['as' => $a . 'delete-question-mcq', 'uses' => 'AdminController@deleteQuestionmcq']);
    Route::get('/delete-question-essay/{r_id}', ['as' => $a . 'delete-question-essay', 'uses' => 'AdminController@deleteQuestionEssay']);
    Route::get('/delete-question-morphology/{r_id}', ['as' => $a . 'delete-question-morphology', 'uses' => 'AdminController@deleteQuestionMorphology']);
    Route::get('/delete-quality-assurance/{r_id}', ['as' => $a . 'delete-quality-assurance', 'uses' => 'AdminController@deleteQuestionQualityAssurance']);
    Route::get('/delete-transfusion/{r_id}', ['as' => $a . 'delete-transfusion', 'uses' => 'AdminController@deleteQuestionTransfusion']);

    // Edit
    Route::get('/edit-question-mcq/{r_id}', ['as' => $a . 'edit-question-mcq', 'uses' => 'AdminController@editQuestionMcq']);

    Route::get('/preview-question-mcq/{r_id}', ['as' => $a . 'preview-question-mcq', 'uses' => 'AdminController@previewQuestionMcq']);

    Route::get('/edit-question-essay/{r_id}', ['as' => $a . 'edit-question-essay', 'uses' => 'AdminController@editQuestionEssay']);
    Route::get('/edit-question-morphology/{r_id}', ['as' => $a . 'edit-question-morphology', 'uses' => 'AdminController@editQuestionMorphology']);
    Route::get('/edit-quality-assurance/{r_id}', ['as' => $a . 'edit-quality-assurance', 'uses' => 'AdminController@editQualityAssurance']);
    Route::get('/edit-transfusion/{r_id}', ['as' => $a . 'edit-transfusion', 'uses' => 'AdminController@editTransfusion']);

    // preview
    Route::get('/preview-question-mcq/{r_id}', ['as' => $a . 'preview-question-mcq', 'uses' => 'AdminController@previewQuestionMcq']);
    Route::get('/preview-question-essay/{r_id}', ['as' => $a . 'preview-question-essay', 'uses' => 'AdminController@previewQuestionEssay']);
    Route::get('/preview-question-morphology/{r_id}', ['as' => $a . 'preview-question-morphology', 'uses' => 'AdminController@previewQuestionMorphology']);
    Route::get('/preview-question-quality/{r_id}', ['as' => $a . 'preview-question-quality', 'uses' => 'AdminController@previewQuestionQuality']);
    Route::get('/preview-question-transfusion/{r_id}', ['as' => $a . 'preview-question-transfusion', 'uses' => 'AdminController@previewQuestionTransfusion']);

});

Route::group(['prefix' => 'user', 'middleware' => 'auth:user'], function()
{
    $a = 'user.';
    Route::get('/', ['as' => $a . 'home', 'uses' => 'UserController@getHome']);
    Route::get('/subscribe', ['as' => $a . 'subscribe', 'uses' => 'UserController@getSubscribeForm']);
    Route::get('/payments', ['as' => $a . 'payments', 'uses' => 'UserController@getPayments']);
    Route::post('/get-mcq-ques', ['as' => $a . 'get-mcq-ques', 'uses' => 'UserController@getMcqQues']);
    Route::post('/mcq-ques-page', ['as' => $a . 'mcq-ques-page', 'uses' => 'UserController@McqQuesPage']);
    Route::post('/essay-ques-page', ['as' => $a . 'essay-ques-page', 'uses' => 'UserController@EssayQuesPage']);
    Route::post('/stipe-payment', ['as' => $a . 'stipe-payment', 'uses' => 'UserController@stripePayment']);
    Route::get('/verify', ['as' => $a . 'verify', 'uses' => 'UserController@verifyAccount']);
    
    Route::post('/get-essay-ques', ['as' => $a . 'get-essay-ques', 'uses' => 'UserController@getEssayQues']);
    Route::post('/get-morphology-ques', ['as' => $a . 'get-morphology-ques', 'uses' => 'UserController@getMorphologyQues']);
    
    Route::post('/morphology-ques-page', ['as' => $a . 'morphology-ques-page', 'uses' => 'UserController@MorphologyQuesPage']);
    Route::post('/morphology-ques-page-next', ['as' => $a . 'morphology-ques-page-next', 'uses' => 'UserController@MorphologyQuesNextPage']);
    
    Route::post('/get-quality-assurance-ques', ['as' => $a . 'get-quality-assurance-ques', 'uses' => 'UserController@getQualityAssuranceQues']);
    Route::post('/quality-assurance-page', ['as' => $a . 'quality-assurance-page', 'uses' => 'UserController@QualityAssuranceQuesPage']);

    Route::post('/get-transfusion-ques', ['as' => $a . 'get-transfusion-ques', 'uses' => 'UserController@TransfusionQuesPage']);
    Route::post('/transfusion-page', ['as' => $a . 'transfusion-page', 'uses' => 'UserController@TransfusionQues']);
    Route::post('/transfusion-page-next', ['as' => $a . 'transfusion-page-next', 'uses' => 'UserController@TransfusionQuesNextPage']);

    Route::get('/edit-profile', ['as' => $a . 'edit-profile', 'uses' => 'UserController@editProfilePage']);
    Route::post('/update-user', ['as' => $a . 'update-user', 'uses' => 'UserController@updateUser']);
    Route::post('/update-user-pass', ['as' => $a . 'update-user-pass', 'uses' => 'UserController@updateUserPass']);

    Route::get('/invoice-page/{pid}', ['as' => $a . 'invoice-page', 'uses' => 'UserController@invoicePage']);


    Route::group(['middleware' => 'activated'], function ()
    {
        $m = 'activated.';
        Route::get('protected', ['as' => $m . 'protected', 'uses' => 'UserController@getProtected']);
    });

    Route::group(['middleware' => 'subscription'], function ()
    {
        $m = 'subscription.';
        Route::get('/mcq-emq-opt', ['as' => $m . 'exam-mcq-emq-opt', 'uses' => 'UserController@getMcqEmqOpt']);
        Route::get('/essay-questions', ['as' => $m . 'exam-essay-questions', 'uses' => 'UserController@getEssayOpt']);
        Route::get('/morphology', ['as' => $m . 'exam-morphology', 'uses' => 'UserController@getMorphologyOpt']);
        Route::get('/quality-assurance', ['as' => $m . 'exam-quality-assurance', 'uses' => 'UserController@getQualityAssuranceOpt']);
        Route::get('/transfusion', ['as' => $m . 'exam-transfusion', 'uses' => 'UserController@getTransfusionOpt']);
    });

});

Route::group(['middleware' => 'auth:all'], function()
{
    $a = 'authenticated.';
    Route::get('/logout', ['as' => $a . 'logout', 'uses' => 'Auth\LoginController@logout']);
    Route::get('/activate/{token}', ['as' => $a . 'activate', 'uses' => 'ActivateController@activate']);
    Route::get('/activate', ['as' => $a . 'activation-resend', 'uses' => 'ActivateController@resend']);
    Route::get('not-activated', ['as' => 'not-activated', 'uses' => function () {
        return view('errors.not-activated');
    }]);
    Route::get('no-subscription', ['as' => 'no-subscription', 'uses' => function () {
        return view('errors.no-subscription');
    }]);
});

Auth::routes(['login' => 'auth.login']);
