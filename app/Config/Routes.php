<?php namespace Config;

// Create a new instance of our RouteCollection class.

$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Front\HomeController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


// Front
$routes->group('', ['namespace' => 'App\Controllers\Front'], function ($routes) {
    $routes->get('', 'HomeController::index');

    // Auth
    $routes->get('login', 'AuthController::login', ['as' => 'front_login']);
    $routes->get('register', 'AuthController::register', ['as' => 'front_register']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');
    $routes->post('register', 'AuthController::attemptRegister');

    // Category
    $routes->get('category', 'CategoryController::index');

    // Course
    $routes->get('course/(:any)', 'CourseController::index/$1');
    $routes->get('player/(:any)/lecture/(:num)', 'CourseController::showPlayer/$1/$2');
    $routes->post('course/add_comment', 'CourseController::addComment', ['filter' => 'login_front']);
    $routes->post('course/complete_course/(:num)', 'CourseController::completeCourse/$1', ['filter' => 'login_front']);

    // Lesson
    $routes->post('lesson/mark_as_watched/(:num)', 'LessonController::markAsWatched/$1', ['filter' => 'login_front']);
    $routes->post('lesson/mark_as_unwatched/(:num)', 'LessonController::markAsUnwatched/$1', ['filter' => 'login_front']);

    // Contact
    $routes->get('contact', 'ContactController::index');
    $routes->post('contact', 'ContactController::sendMail');

    // Content
    $routes->get('content/(:any)', 'ContentController::index/$1');

    // Card
    $routes->get('cart', 'CartController::index');
    $routes->post('cart', 'CartController::addToCart');

    // Checkout
    $routes->get('checkout', 'CheckoutController::index');
    $routes->post('checkout', 'CheckoutController::attemptPay');
    $routes->post('checkout_callback', 'CheckoutController::paymentCallback');

    // Account
    $routes->group('account', function ($routes) {
        $routes->get('/', 'AccountController::index');
        $routes->get('courses', 'AccountController::courses');
        $routes->get('orders', 'AccountController::orders');
        $routes->get('profile', 'AccountController::profile');
        $routes->post('profile', 'AccountController::attemptUpdateProfile');
        $routes->get('certificate','AccountController::certificate');
        $routes->get('change_password','AccountController::changePassword');
        $routes->post('change_password','AccountController::attemptChangePassword');

    });
});

// Admin
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->get('/', 'HomeController::index');
    $routes->get('order_count_statistics', 'HomeController::orderCountByMonth');
    $routes->get('total_income_by_month', 'HomeController::totalIncomeByMonth');
    $routes->get('sold_course_statistics', 'HomeController::soldCourseCountByMonth');
    $routes->get('best_selling_courses', 'HomeController::bestSellingCourses');

    // Profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'ProfileController::index');
        $routes->post('/', 'ProfileController::updateProfile');
        $routes->get('change_password', 'ProfileController::changePassword');
        $routes->post('change_password', 'ProfileController::attemptChangePassword');
    });

    // Login/out
    $routes->get('login', 'AuthController::login', ['as' => 'admin_login']);
    $routes->post('login', 'AuthController::attemptLogin');
    $routes->get('logout', 'AuthController::logout');

    // Registration
    /*$routes->get('register', 'AuthController::register', ['as' => 'register']);
    $routes->post('register', 'AuthController::attemptRegister');*/

    // Activation
    $routes->get('activate-account', 'AuthController::activateAccount', ['as' => 'activate-account']);
    $routes->get('resend-activate-account', 'AuthController::resendActivateAccount', ['as' => 'resend-activate-account']);

    // Forgot/Resets
    $routes->get('forgot', 'AuthController::forgotPassword', ['as' => 'forgot']);
    $routes->post('forgot', 'AuthController::attemptForgot');
    $routes->get('reset-password', 'AuthController::resetPassword', ['as' => 'admin-reset-password']);
    $routes->post('reset-password', 'AuthController::attemptReset');

    // Order
    $routes->group('order', function ($routes) {
        $routes->get('/', 'OrderController::index');
        $routes->post('list', 'OrderController::list');
        $routes->get('detail/(:num)', 'OrderController::orderDetail/$1');
    });

    // Course
    $routes->group('course', function ($routes) {
        $routes->get('/', 'CourseController::index');
        $routes->get('create', 'CourseController::create');
        $routes->post('create', 'CourseController::attemptCreate');
        $routes->get('edit/(:num)', 'CourseController::edit/$1');
        $routes->post('update', 'CourseController::update');
        $routes->get('delete/(:num)', 'CourseController::delete/$1');
    });

    // Category
    $routes->group('category', function ($routes) {
        $routes->get('/', 'CategoryController::index');
        $routes->get('get_tree', 'CategoryController::getTree');
        $routes->post('create', 'CategoryController::attemptCreate');
        $routes->get('delete/(:num)', 'CategoryController::delete/$1');
        $routes->post('move_category', 'CategoryController::moveCategory');
        $routes->get('edit/(:num)', 'CategoryController::edit/$1');
        $routes->post('update', 'CategoryController::update');
    });

    // Section
    $routes->group('section', function ($routes) {
        $routes->get('/', 'SectionController::index');
        $routes->get('delete/(:num)', 'SectionController::delete/$1');
        $routes->post('create', 'SectionController::attemptCreate');
        $routes->post('update', 'SectionController::update');
        $routes->get('list_by_course/(:num)', 'SectionController::listByCourse/$1');
    });

    // Site Settings
    $routes->get('site_settings', 'SiteSettingsController::index');
    $routes->post('site_settings', 'SiteSettingsController::update');

    // User
    $routes->group('user', function ($routes) {
        $routes->get('/', 'UserController::index');
        $routes->get('create', 'UserController::create');
        $routes->post('create', 'UserController::attemptCreate');
        $routes->get('edit/(:num)', 'UserController::edit/$1');
        $routes->post('update', 'UserController::update');
    });

    // Comment
    $routes->group('comment', function ($routes) {
        $routes->get('/', 'CommentController::index');
        $routes->post('list', 'CommentController::list');
        $routes->post('change_status', 'CommentController::changeStatus');
        $routes->get('delete/(:num)', 'CommentController::delete/$1');
    });

    // Content
    $routes->group('content', function ($routes) {
        $routes->get('/','ContentsController::index');
        $routes->post('list', 'ContentsController::list');
        $routes->get('create', 'ContentsController::create');
        $routes->post('create', 'ContentsController::attemptCreate');
        $routes->get('edit/(:num)', 'ContentsController::edit/$1');
        $routes->post('update', 'ContentsController::update');
        $routes->post('change_status', 'ContentsController::changeStatus');
        $routes->get('delete/(:num)', 'ContentsController::delete/$1');
    });

    // Lesson
    $routes->group('lesson', function ($routes) {
        $routes->get('/', 'LessonController::index');
        $routes->get('create', 'LessonController::create');
        $routes->post('create', 'LessonController::attemptCreate');
        $routes->get('edit/(:num)', 'LessonController::edit/$1');
        $routes->post('update', 'LessonController::update');
        $routes->get('delete/(:num)', 'LessonController::delete/$1');
        $routes->post('list', 'LessonController::list');
    });

    // Customer
    $routes->group('customer', function ($routes) {
        $routes->get('/', 'CustomerController::index');
        $routes->post('list', 'CustomerController::list');
    });

    $routes->get('certificate', 'CertificateController::index');
    $routes->post('certificate/list', 'CertificateController::list');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
