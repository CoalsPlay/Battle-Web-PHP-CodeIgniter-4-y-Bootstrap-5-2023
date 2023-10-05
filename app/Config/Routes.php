<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Inicio');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/(:num)', 'Home::index/$1');
$routes->match(['get', 'post'], '/news/(:num)', 'News::index/$1');
$routes->match(['get', 'post'], '/news/(:num)/(:num)', 'News::index/$1');
$routes->get('/staff', 'Home::staff');
$routes->get('/top', 'Home::top');
$routes->get('/faq', 'Home::faq');
$routes->get('/maintenance', 'Home::maintenance');
$routes->get('/mobs_list', 'Mobs::mobs_list');
$routes->get('/mobs_list/(:num)', 'Mobs::mobs_list');



$routes->group('', static function ($routes) {
    $routes->group('',['filter'=>'AlreadyLoggedIn'], static function ($routes) {

        // Rutas a las que no se puede acceder estando conectado.
        $routes->get('/login', 'Auth::login', ['as' => 'login']);
        $routes->get('/register', 'Auth::register', ['as' => 'register']);
        $routes->post('/auth/save', 'Auth::save', ['as' => 'save']);
        $routes->post('/auth/check', 'Auth::check', ['as' => 'check']);
        $routes->match(['get', 'post'], '/forgot_password', 'Auth::forgot_password', ['as' => 'forgot_password']);
        $routes->match(['get', 'post'], '/auth/password_update', 'Auth::password_update/$1', ['as' => 'password_update']);
    });

    
});

$routes->group('', ['filter'=>'AuthCheck'], static function ($routes) {

    // Rutas a las que no se puede acceder sin estar conectado.
    $routes->match(['get', 'post'], '/inventory', 'Inventory::index');
    $routes->match(['get', 'post'], '/inventory/(:num)', 'Inventory::index/$1');

    $routes->get('/auth/logout', 'Auth::logout', ['as' => 'logout']);

    $routes->get('/users_list', 'Home::users_list');
    $routes->get('/users_list/(:num)', 'Home::users_list/$1');

    $routes->post('/attributes', 'Attributes::index');

    // Rutas de perfiles
    $routes->match(['get', 'post'], '/profile/(:any)', 'Profile::index/$1');

    // Rutas de perfiles
    $routes->match(['get', 'post'], '/shop', 'Shop::index');
    $routes->match(['get', 'post'], '/shop/(:num)', 'Shop::index/$1');

    // Rutas de la sección mapa
    $routes->get('/map', 'Map::map');
    $routes->match(['get', 'post'], '/map/explore/(:num)', 'Map::explore/$1');
    $routes->match(['get', 'post'], '/map/fight', 'Map::fight');
    $routes->match(['get', 'post'], '/duel', 'Map::duel');

    // Rutas de sección de soporte
    $routes->match(['get', 'post'], '/report_bug', 'Feedback::report_bug');
    $routes->match(['get', 'post'], '/suggestion', 'Feedback::suggestion');

    // Sistema de amigos
    $routes->match(['get', 'post'], '/friends', 'Friends::index');
    $routes->match(['get', 'post'], '/friends/(:num)', 'Friends::index');

    // Mensajería privada
    $routes->match(['get', 'post'], '/inbox', 'Inbox::index');
    $routes->match(['get', 'post'], '/inbox/(:num)', 'Inbox::index');
    $routes->match(['get', 'post'], '/send_msg', 'Inbox::send_msg');
    $routes->match(['get', 'post'], '/sent_msg', 'Inbox::sent_msg');
    $routes->match(['get', 'post'], '/sent_msg/(:num)', 'Inbox::sent_msg');

    // Rutas de configuración de cuenta
    $routes->get('/settings', 'Settings::index');
    $routes->match(['get', 'post'], '/settings/change_information', 'Settings::change_information');
    $routes->match(['get', 'post'], '/settings/change_password', 'Settings::change_password');
    $routes->match(['get', 'post'], '/settings/change_avatar', 'Settings::change_avatar');

    // Rutas de administración
    $routes->get('/admin/administration', 'Administration::index');

    $routes->match(['get', 'post'], '/admin/configuration', 'Administration::configuration');

    $routes->match(['get', 'post'], '/admin/game_options', 'Administration::game_options');

    $routes->match(['get', 'post'], '/admin/feedback', 'Administration::feedback');

    $routes->match(['get', 'post'], '/admin/users', 'Administration::users');
    $routes->match(['get', 'post'], '/admin/users/(:num)', 'Administration::users/$1');
    $routes->match(['get', 'post'], '/admin/user/edit/(:num)', 'Administration::user_edit/$1');
    $routes->match(['get', 'post'], '/admin/user/edit/', 'Administration::user_edit');

    $routes->match(['get', 'post'], '/admin/ranks', 'Administration::ranks');

    $routes->match(['get', 'post'], '/admin/faq_center', 'Administration::faq_center');
    $routes->match(['get', 'post'], '/admin/faq_add', 'Administration::faq_add');
    $routes->match(['get', 'post'], '/admin/faq/edit/(:num)', 'Administration::faq_edit/$1');
    $routes->match(['get', 'post'], '/admin/faq/edit/', 'Administration::faq_edit');
    $routes->match(['get', 'post'], '/admin/faq', 'Administration::faq_edit');

    $routes->get('/admin/shop', 'Administration::shop');
    $routes->match(['get', 'post'], '/admin/shop/(:num)', 'Administration::shop/$1');
    $routes->match(['get', 'post'], '/admin/shop/item/add', 'Administration::item_add');
    $routes->match(['get', 'post'], '/admin/shop/item/edit/(:num)', 'Administration::item_edit/$1');
    $routes->match(['get', 'post'], '/admin/shop/item/edit/', 'Administration::item_edit/');

    $routes->match(['get', 'post'], '/admin/news_manager', 'Administration::news_manager');
    $routes->match(['get', 'post'], '/admin/news_manager/(:num)', 'Administration::news_manager/$1');
    $routes->match(['get', 'post'], '/admin/news/edit/(:num)', 'Administration::edit_news/$1');
    $routes->match(['get', 'post'], '/admin/news/edit/', 'Administration::edit_news');
    $routes->match(['get', 'post'], '/admin/news/', 'Administration::edit_news');

    $routes->match(['get', 'post'], '/admin/categories_and_maps', 'Administration::categories_and_maps');
    $routes->match(['get', 'post'], '/admin/add_map', 'Administration::add_map');
    $routes->match(['get', 'post'], '/admin/categories_and_maps/map/edit/(:num)', 'Administration::edit_map/$1');
    $routes->match(['get', 'post'], '/admin/categories_and_maps/map/edit/', 'Administration::edit_map/');
    $routes->match(['get', 'post'], '/admin/categories_and_maps/category/edit/(:num)', 'Administration::edit_category/$1');
    $routes->match(['get', 'post'], '/admin/categories_and_maps/category/edit/', 'Administration::edit_category/');

    $routes->match(['get', 'post'], '/admin/mobs_manager', 'Administration::mobs_manager');
    $routes->match(['get', 'post'], '/admin/mobs_manager/(:num)', 'Administration::mobs_manager');
    $routes->match(['get', 'post'], '/admin/mob/add', 'Administration::mob_add');
    $routes->match(['get', 'post'], '/admin/mob/edit/(:num)', 'Administration::mob_edit/$1');
    $routes->match(['get', 'post'], '/admin/mob/edit/', 'Administration::mob_edit/');


});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
