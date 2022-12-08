<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('setting', 'Backend\SettingController@index')->name('setting.index');
    Route::put('setting/update', 'Backend\SettingController@update')->name('setting.update');


    Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard'], function () {
        Route::get('', 'Backend\DashboardController@index')->name('index');
    });

    Route::group(['as' => 'menu.', 'prefix' => 'menu'], function () {
        Route::get('', 'Backend\MenuController@index')->name('index');
        Route::get('/indexnp', 'Backend\MenuController@indexnp')->name('indexnp');
        Route::post('', 'Backend\MenuController@store')->name('store');
        Route::put('', 'Backend\MenuController@update')->name('update');
        Route::get('{menu}', 'Backend\MenuController@destroy')->name('destroy');

        Route::group(['as' => 'subMenu.'], function () {
            Route::post('{menu}/subMenu', 'Backend\MenuController@storeSubMenu')->name('store');
            Route::get('{menu}/subMenu/{subMenu}', 'Backend\MenuController@destroySubMenu')->name('destroy');
            Route::get('{menu}/subMenuModal', 'Backend\MenuController@subMenuModal')->name('component.modal');

            Route::group(['as' => 'childsubMenu.'], function () {
                Route::post('{subMenu}/subMenu/childsubMenu', 'Backend\MenuController@storeChildSubMenu')->name('store');
                Route::get('{menu}/subMenu/{subMenu}/childsubMenu/{childSubMenu}', 'Backend\MenuController@destroyChildSubMenu')->name('destroy');
                Route::get('{subMenu}/childsubMenuModal', 'Backend\MenuController@childsubMenuModal')->name('component.childmodal');
            });
        });
    });


    /*
    |--------------------------------------------------------------------------
    | User CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'user.', 'prefix' => 'user',], function () {
        Route::get('', 'Backend\UserController@index')->name('index')->middleware('permission:user-index');
        Route::get('user-data', 'Backend\UserController@getAllData')->name('data')->middleware('permission:user-data');
        Route::get('create', 'User\UserController@create')->name('create')->middleware('permission:user-create');
        Route::post('', 'Backend\UserController@store')->name('store')->middleware('permission:user-store');
        Route::get('{user}/edit', 'Backend\UserController@edit')->name('edit')->middleware('permission:user-edit');
        Route::put('{user}', 'Backend\UserController@update')->name('update')->middleware('permission:user-update');
        Route::get('user/{id}/destroy', 'Backend\UserController@destroy')->name('destroy')->middleware('permission:user-delete');
        Route::get('update-profile', 'Backend\UserController@profileUpdate')->name('profileUpdate');
        Route::post('update-profile/{id}', 'Backend\UserController@profileUpdateStore')->name('updateProfile');

    });

    /*
    |--------------------------------------------------------------------------
    | Role CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'role.', 'prefix' => 'role',], function () {
        Route::get('', 'Backend\RoleController@index')->name('index')->middleware('permission:role-index');
        Route::get('role-data', 'Backend\RoleController@getAllData')->name('data')->middleware('permission:role-data');
        Route::get('create', 'Backend\RoleController@create')->name('create')->middleware('permission:role-create');
        Route::post('', 'Backend\RoleController@store')->name('store')->middleware('permission:role-store');
        Route::get('{role}/edit', 'Backend\RoleController@edit')->name('edit')->middleware('permission:role-edit');
        Route::put('{role}', 'Backend\RoleController@update')->name('update')->middleware('permission:role-update');
        Route::get('role/{id}/destroy', 'Backend\RoleController@destroy')->name('destroy')->middleware('permission:role-delete');
    });

    /*
    |--------------------------------------------------------------------------
    | Permission CRUD
    |--------------------------------------------------------------------------
    |
    */

    Route::group(['as' => 'permission.', 'prefix' => 'permission',], function () {
        Route::get('', 'Backend\PermissionController@index')->name('index')->middleware('permission:role-index');
        Route::get('permission-data', 'Backend\PermissionController@getAllData')->name('data')->middleware('permission:role-data');
        Route::get('create', 'Backend\PermissionController@create')->name('create')->middleware('permission:permission-create');
        Route::post('', 'Permission\Backend@store')->name('store')->middleware('permission:role-store');
        Route::get('{permission}/edit', 'Backend\PermissionController@edit')->name('edit')->middleware('permission:permission-edit');
        Route::put('{permission}', 'Backend\PermissionController@update')->name('update')->middleware('permission:role-update');
        Route::get('permission/{id}/destroy', 'Backend\PermissionController@destroy')->name('destroy')->middleware('permission:permission-delete');
    });

    /*
        |--------------------------------------------------------------------------
        | Page CRUD Routes
        |--------------------------------------------------------------------------
        */
    Route::group(['as' => 'page.', 'prefix' => 'page'], function () {
        Route::get('', 'Backend\PageController@index')->name('index');
        Route::get('create', 'Backend\PageController@create')->name('create');
        Route::post('', 'Backend\PageController@store')->name('store');
        // Route::get('{page}', 'Backend\PageController@show')->name('show');
        Route::get('{page}/edit', 'Backend\PageController@edit')->name('edit');
        Route::put('{page}', 'Backend\PageController@update')->name('update');
        Route::get('{id}', 'Backend\PageController@destroy')->name('destroy');
    });

    Route::group(['as' => 'slider.', 'prefix' => 'slider'], function () {
        Route::get('', 'Backend\SliderController@index')->name('index');
        Route::get('create', 'Backend\SliderController@create')->name('create');
        Route::post('', 'Backend\SliderController@store')->name('store');
        Route::put('{slider}', 'Backend\SliderController@update')->name('update');
        Route::get('{slider}/edit', 'Backend\SliderController@edit')->name('edit');
        Route::get('{id}', 'Backend\SliderController@destroy')->name('destroy');
    });

    Route::group(['as' => 'category.', 'prefix' => 'category'], function () {
        Route::get('', 'Backend\CategoryController@index')->name('index');
        Route::get('create', 'Backend\CategoryController@create')->name('create');
        Route::post('', 'Backend\CategoryController@store')->name('store');
        Route::put('{category}', 'Backend\CategoryController@update')->name('update');
        Route::get('{category}/edit', 'Backend\CategoryController@edit')->name('edit');
        Route::get('{id}', 'Backend\CategoryController@destroy')->name('destroy');
    });

    Route::group(['as' => 'subcategory.', 'prefix' => 'subcategory'], function () {
        Route::get('', 'Backend\SubCategoryController@index')->name('index');
        Route::get('create', 'Backend\SubCategoryController@create')->name('create');
        Route::post('', 'Backend\SubCategoryController@store')->name('store');
        Route::put('{subcategory}', 'Backend\SubCategoryController@update')->name('update');
        Route::get('{subcategory}/edit', 'Backend\SubCategoryController@edit')->name('edit');
        Route::get('{id}', 'Backend\SubCategoryController@destroy')->name('destroy');
    });

    Route::group(['as' => 'service.', 'prefix' => 'service'], function () {
        Route::get('', 'Backend\ServiceController@index')->name('index');
        Route::get('create', 'Backend\ServiceController@create')->name('create');
        Route::post('', 'Backend\ServiceController@store')->name('store');
        Route::put('{service}', 'Backend\ServiceController@update')->name('update');
        Route::get('{service}/edit', 'Backend\ServiceController@edit')->name('edit');
        Route::get('{id}', 'Backend\ServiceController@destroy')->name('destroy');
    });

    Route::group(['as' => 'training.', 'prefix' => 'training'], function () {
        Route::get('', 'Backend\TrainingController@index')->name('index');
        Route::get('create', 'Backend\TrainingController@create')->name('create');
        Route::post('', 'Backend\TrainingController@store')->name('store');
        Route::put('{training}', 'Backend\TrainingController@update')->name('update');
        Route::get('{training}/edit', 'Backend\TrainingController@edit')->name('edit');
        Route::get('{id}', 'Backend\TrainingController@destroy')->name('destroy');
    });

    Route::group(['as' => 'product.', 'prefix' => 'product'], function () {
        Route::get('', 'Backend\ProductController@index')->name('index');
        Route::get('create', 'Backend\ProductController@create')->name('create');
        Route::post('', 'Backend\ProductController@store')->name('store');
        Route::put('{product}', 'Backend\ProductController@update')->name('update');
        Route::get('{product}/edit', 'Backend\ProductController@edit')->name('edit');
        Route::get('{id}', 'Backend\ProductController@destroy')->name('destroy');
        Route::post('productcategory', 'Backend\ProductController@productCategoryAjax')->name('productcategoryajax');
    });

    Route::group(['as' => 'brand.', 'prefix' => 'brand'], function () {
        Route::get('', 'Backend\BrandController@index')->name('index');
        Route::get('create', 'Backend\BrandController@create')->name('create');
        Route::post('', 'Backend\BrandController@store')->name('store');
        Route::put('{brand}', 'Backend\BrandController@update')->name('update');
        Route::get('{brand}/edit', 'Backend\BrandController@edit')->name('edit');
        Route::get('{id}', 'Backend\BrandController@destroy')->name('destroy');
    });


    Route::group(['as' => 'testimonial.', 'prefix' => 'testimonial'], function () {
        Route::get('', 'Backend\TestimonialController@index')->name('index');
        Route::get('create', 'Backend\TestimonialController@create')->name('create');
        Route::post('', 'Backend\TestimonialController@store')->name('store');
        Route::put('{testimonial}', 'Backend\TestimonialController@update')->name('update');
        Route::get('{testimonial}/edit', 'Backend\TestimonialController@edit')->name('edit');
        Route::get('{id}', 'Backend\TestimonialController@destroy')->name('destroy');
    });

    Route::group(['as' => 'deal.', 'prefix' => 'deal'], function () {
        Route::get('', 'Backend\DealController@index')->name('index');
        Route::get('create', 'Backend\DealController@create')->name('create');
        Route::post('', 'Backend\DealController@store')->name('store');
        Route::put('{deal}', 'Backend\DealController@update')->name('update');
        Route::put('', 'Backend\DealController@teamOrder')->name('update.order');
        Route::get('{deal}/edit', 'Backend\DealController@edit')->name('edit');
        Route::get('{id}', 'Backend\DealController@destroy')->name('destroy');
    });

    Route::group(['as' => 'contact.', 'prefix' => 'contact'], function () {
        Route::get('', 'Backend\ContactController@index')->name('index');
        Route::get('{contact}', 'Backend\ContactController@destroy')->name('destroy');
    });
});


Route::get('/register', 'Frontend\CustomerController@viewCustomerRegister')->name('user-register');
Route::post('/customer/register', 'Frontend\CustomerController@customerRegister')->name('customer-register');
Route::get('/customer-login', 'Frontend\CustomerController@viewCustomerLogin')->name('user-login');
Route::post('/customer/login', 'Frontend\CustomerController@customerLogin')->name('customer-login');

Route::group(['middleware' => 'auth:customer'], function () {

    Route::post('/customer/logout', 'Frontend\CustomerController@logout')->name('customer-logout');
    Route::post('/addtocart', 'Frontend\CartController@addCart')->name('add-to-cart');
    Route::get('/cart/{id}', 'Frontend\CartController@destroy')->name('delete-cart');
    Route::get('/cart', 'Frontend\CartController@viewCart')->name('view-cart');
    Route::post('/update-cart', 'Frontend\CartController@update')->name('update-cart');
    Route::get('/checkout', 'Frontend\CartController@checkout')->name('checkout');
    Route::post('/order', 'Frontend\OrderController@store')->name('order');
    Route::get('/order-details/{order_number}', 'Frontend\OrderController@orderDetails')->name('order-details');
    Route::get('/my-account', 'Frontend\CustomerController@myAccount')->name('my-account');
    Route::get('/view-order', 'Frontend\OrderController@viewOrder')->name('view-order');
    Route::post('/update-payment-status', 'Frontend\OrderController@updatePaymentStatus')->name('update-payment-status');
    Route::get('/view-order-items', 'Frontend\OrderController@viewOrderItems')->name('view-order-items');
    Route::get('/address/edit/{id}',  'Frontend\CustomerController@editAddress')->name('edit-address');
    Route::post('/address/save',  'Frontend\CustomerController@updateAddress')->name('update-address');
});





Route::get('', 'Frontend\FrontendController@homepage')->name('homepage');
Route::get('about', 'Frontend\FrontendController@about')->name('about');
Route::get('services', 'Frontend\FrontendController@services')->name('services');
Route::get('trainingsdetail/{trainings}', 'Frontend\FrontendController@trainingsDetail')->name('trainings.detail');

Route::get('products/{slug}', 'Frontend\FrontendController@getproductbyCategory')->name('products');
Route::get('productdetail/{products}', 'Frontend\FrontendController@productdetailbyCategory')->name('products.detail');
Route::post('productsortby', 'Frontend\FrontendController@productsortBy')->name('productsortby');
//route for ajax
Route::post('quick-view-product', 'Frontend\FrontendController@quickViewProduct')->name('quick-view-product');
//
Route::get('all-products/{id}', 'Frontend\FrontendController@getproductbySubCategory')->name('all-products');
Route::post('contact', 'Frontend\FrontendController@sendcontact')->name('send-contact');
Route::get('contact', 'Frontend\FrontendController@contact')->name('contact');


Route::get('/search/', 'Frontend\FrontendController@searchResult')->name('search');

Route::get('{page}', 'Frontend\FrontendController@page')->name('page.detail');
