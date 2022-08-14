<?php

use App\Http\Controllers\paymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('middleware/{age}','AdminController@index');
// Route::get('middleware/show/{age}','AdminController@show');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

// Route::get('admin/dashboard','AdminController@dashboard')->middleware('auth','checkRole');

Route::middleware('auth')->group(function () {

    Route::get('admin', 'DashboardController@show')->name('dashboard');
    Route::get('dashboard', 'DashboardController@show')->name('dashboard');

    // Quản Lý Người Dùng
    Route::group(['prefix' => 'admin/users'], function () {
        Route::get('/list', 'UsersController@list')->middleware('can:User_list');
        Route::get('/add', 'UsersController@add')->name('user.add')->middleware('can:User_add');
        Route::post('/store', 'UsersController@store');
        Route::get('/delete/{id}', 'UsersController@delete')->name('user.delete')->middleware('can:User_delete');
        Route::post('/action', 'UsersController@action');
        Route::get('/edit/{id}', 'UsersController@edit')->name('user.edit')->middleware('can:User_edit');
        Route::post('/update/{id}', 'UsersController@Update')->name('user.update');
    });


    //Quản lý trang
    Route::group(['prefix' => 'admin/page/'], function () {
        Route::get('list', 'PagesController@list')->middleware('can:Page_list');
        Route::get('add', 'PagesController@add')->middleware('can:Page_add');
        Route::post('action_add', 'PagesController@action_add')->name('page.add');
        Route::get('edit/{id}', 'PagesController@edit')->name('page.edit')->middleware('can:Page_edit');
        Route::post('update/{id}', 'PagesController@action_update')->name('page.update');
        Route::get('delete/{id}', 'PagesController@delete')->name('page.delete')->middleware('can:Page_delete');
        Route::post('action_checkbox', 'PagesController@action_checkbox')->name('page.action');
    });


    //Quản lý bài viết
    Route::group(['prefix' => 'admin/post'], function () {
        Route::group(['prefix' => 'cat'], function () {
            Route::get('list', 'Post_catController@list')->name('Post_cat.list');
            Route::post('store', 'Post_catController@store')->name('Post_cat.store');

            Route::get('delete/{id}', 'Post_catController@delete')->name('post_cat.delete');
        });

        Route::get('list', 'PostsController@list')->name('post.list')->middleware('can:Post_list');
        Route::get('add', 'PostsController@add')->name('post.add')->middleware('can:Post_add');;
        Route::post('store', 'PostsController@store');
        Route::get('edit/{id}', 'PostsController@edit')->name('post.edit')->middleware('can:Post_edit');;
        Route::post('update/{id}', 'PostsController@update');
        Route::get('delete/{id}', 'PostsController@delete')->name('post.delete')->middleware('can:Post_delete');;
        Route::post('list_action', 'PostsController@list_action')->name('post.list_action');
    });

    //Quản lý sản phẩm
    Route::group(['prefix' => 'admin/product'], function () {
        Route::group(['prefix' => 'cat'], function () {
            Route::get('/list', 'Cat_productController@list_cat');

            Route::post('/store', 'Cat_productController@store')->name('cat_product.store');

            Route::get('edit/{id}', 'Cat_productController@edit')->name('cat_product.edit');
            Route::post('update/{id}', 'Cat_productController@update');

            Route::get('delete/{id}', 'Cat_productController@delete')->name('cat_product.delete');
        });

        Route::group(['prefix' => 'image'], function () {
            Route::get('/{id}', 'ImagesController@images')->name('product.images');
            Route::post('/{id}', 'ImagesController@add')->name('images.add');
            Route::post('{id}/list_action', 'ImagesController@list_action')->name('image.list_action');
            Route::get('delete/{id}', 'ImagesController@delete')->name('images.delete');
        });

        Route::get('list', 'ProductController@list_product')->middleware('can:Product_list');

        Route::get('add', 'ProductController@add_product')->name('product.add')->middleware('can:Product_add');
        Route::post('store', 'ProductController@store');

        Route::get('edit/{id}', 'ProductController@edit_product')->name('product.edit')->middleware('can:Product_edit');
        Route::post('update/{id}', 'ProductController@update')->name('product.update');

        Route::get('delete/{id}', 'ProductController@delete_product')->name('product.delete')->middleware('can:Product_delete');

        Route::post('list_action', 'ProductController@list_action')->name('product.action');
    });

    //Quản lý sliders
    Route::group(['prefix' => 'admin/slider'], function () {
        Route::get('list', 'SliderController@list')->name('slider.list')->middleware('can:Slider_list');

        Route::post('store', 'SliderController@store')->name('slider.store');
        Route::get('delete/{id}', 'SliderController@delete')->name('slider.delete')->middleware('can:Slider_delete');

        Route::post('action', 'SliderController@action')->name('slider.action');
    });

    //quan ly order 
    Route::group(['prefix' => 'admin/order'], function () {
        Route::get('list', 'OrderController@list')->name('order.list')->middleware('can:Order_list');
        Route::get('order_detail/{id}', 'OrderController@detail')->name('order.order_detail');
        Route::get('order_cancel/{id}', 'OrderController@cancel')->name('order.cancel');
        Route::post('action', 'OrderController@action')->name('order.action');
        Route::post('order_detail/action/{id}', 'OrderController@order_detail_action')->name('order_detail.action');
    });
    //quan ly Roles
    Route::group(['prefix' => 'admin/roles'], function () {
        Route::get('list', 'RolesController@list')->name('Roles.list')->middleware('can:Role_list');
        Route::get('add', 'RolesController@add')->middleware('can:Role_add');
        Route::post('store', 'RolesController@store')->name('roles.store');


        Route::get('delete/{id}', 'RolesController@delete')->name('roles.delete')->middleware('can:Role_delete');
        Route::get('edit/{id}', 'RolesController@edit')->name('roles.edit')->middleware('can:Role_edit');
        Route::post('update/{id}', 'RolesController@update')->name('roles.update');

        Route::get('permission', 'RolesController@permission')->name('roles.permission');
        Route::post('permission/store', 'RolesController@permission_store')->name('permission.add');;
    });
});

//FRONT_END

Route::namespace('User')->group(function () {
    Route::get('/', 'UserHomeController@index')->name('home');
    Route::get('page/{slug}', 'UserPageController@page')->name('page');
    Route::get('blog', 'UserBlogController@index');
    Route::get('blog/{id}-{slug}.html', 'UserBlogController@detail')->name('blog.detail');

    Route::get('/{cat_id}-{slug}.html','UserProductController@product_cat')->name('product.cat');
    // Route::get('product/{id}','UserProductController@product_detail')->name('product.detail');
    Route::get('san-pham/{id}-{slug}.html','UserProductController@product_detail')->name('product.detail');

    Route::post('product/search','UserProductController@product_search')->name('product.search');

    Route::post('/cart/add','UserCartController@add')->name('cart.add');
    Route::get('/gio-hang','UserCartController@show')->name('cart.show');
    Route::get('/mua-ngay/{id}','UserCartController@buy_now')->name('cart.buy_now');
    Route::get('gio-hang/remove/{rowId}','UserCartController@remove')->name('cart.remove');
    Route::get('cart/destroy','UserCartController@destroy')->name('cart.destroy');
    Route::post('gio-hang/update','UserCartController@update')->name('cart.update');
    Route::get('gio-hang/thanh-toan','UserCartController@checkout')->name('cart.checkout');
    Route::post('gio-hang/customer','UserCartController@customer')->name('cart.customer');
    Route::get('gio-hang/dat-hang-thanh-cong','UserCartController@checkout_ok')->name('cart.checkout_ok');

    Route::get('hinh-thuc-thanh-toan','paymentController@payment')->name('payment');

});
   
   

