<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('myRoute', function () {
//    echo 'http://localhost/PHP_Laravel_QHO/shop/public/myRoute nè!!!';
//});

/*
Route::post('myRoute', function () {
//    return view('myView1');
    echo 'Kiểu post';
})->name('xyz1');

Route::get('myRoute', function () {
    return view('myView1');
//    echo 'Kiểu get';
})->name('xyz');

Route::put('myRoute', function () {
    echo 'Kiểu put';
})->name('xyz2');

Route::delete('myRoute/poi', function () {
    echo 'Kiểu delete';
})->name('xyz3');

Route::patch('myRoute/mnb', function () {
    echo 'Kiểu patch';
})->name('xyz4');
*/

/* -------- ADMIN -------- */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Backend', 'middleware' => ['checkRoles:admin,writer']], function(){
    Auth::routes();

    // http://localhost/PHP_Laravel_QHO/shop/public/admin
    Route::get('/', 'ProductController@index')->name('default');

//    User
    Route::get('/users', 'UserController@index')->name('user.index');//->middleware(['checkRoles:admin,writer']);
    Route::get('/users/create', 'UserController@create')->name('user.create');
    Route::post('/users', 'UserController@store')->name('user.store');
//Route::get('/users/{id}/xyz/{name}', 'UserController@show')->where([
//    'id'    => '[0-9]+',
//    'name'  => '[a-zA-Z]+'
//]);
    Route::get('users/{id}', 'UserController@show')->where('id', '[0-9]+')->name('user.show');
    Route::put('/users/{id}', 'UserController@update')->name('user.update');
    Route::delete('/users/{id}', 'UserController@delete')->name('user.delete');
    
//    Category
    Route::get('/categories', 'CategoryController@index')->name('category.index');
    Route::get('/categories/create', 'CategoryController@create')->name('category.create');
    Route::post('/categories', 'CategoryController@store')->name('category.store');
    Route::get('categories/{id}', 'CategoryController@show')->where('id', '[0-9]+')->name('category.show');
    Route::put('/categories/{id}', 'CategoryController@update')->name('category.update');
    Route::delete('/categories/{id}', 'CategoryController@delete')->name('category.delete');
    
//    Product
    Route::get('/products', 'ProductController@index')->name('product.index');
    Route::get('/products/create', 'ProductController@create')->name('product.create');
    Route::post('/products', 'ProductController@store')->name('product.store');
    Route::get('products/{id}', 'ProductController@show')->where('id', '[0-9]+')->name('product.show');
    Route::put('/products/{id}', 'ProductController@update')->name('product.update');
    Route::delete('/products/{id}', 'ProductController@delete')->name('product.delete');
    Route::patch('/products/{id}', 'ProductController@setFeaturedProduct')->name('product.setFeaturedProduct');

//    Order
    Route::get('/orders', 'OrderController@index')->name('order.index');
    Route::get('orders/{id}', 'OrderController@show')->where('id', '[0-9]+')->name('order.show');
    Route::delete('/orders/{id}', 'OrderController@delete')->name('order.delete');
});

/* -------- FRONTEND -------- */
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend'], function(){
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/products', 'HomeController@indexProducts')->name('home.indexProducts');
    Route::get('/products/{slug}-{id}.html', 'HomeController@show')
            ->name('home.show')
            ->where([
                'slug' => '[a-z-]+',
                'id' => '[0-9]+'
            ]);
    Route::post('/products/{slug}-{id}.html', 'HomeController@saveComment')
        ->name('home.saveComment')
        ->where([
            'slug' => '[a-z-]+',
            'id' => '[0-9]+'
        ]);
    Route::get('/cart', 'CartController@index')->name('cart.index');
    Route::post('/cart', 'CartController@updateCart')->name('cart.updateCart');
    Route::get('/cart/{id}/delete', 'CartController@deleteCart')->name('cart.deleteCart');
    Route::get('/cart/deleteAll', 'CartController@deleteAll')->name('cart.deleteAll');

    Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
    Route::post('/checkout', 'CheckoutController@placeOrder')->name('checkout.placeOrder');
    Route::get('/thankyou', 'CheckoutController@thankYou')->name('checkout.thankYou');
});

/* -------- API -------- */
Route::group(['prefix' => 'api', 'as' => 'api.', 'namespace' => 'Frontend'], function(){
    /* CART */
//    http://localhost/PHP_Laravel_QHO/shop/public/api/cart
//                                               (prefix)
    Route::get('/cart', 'CartController@getCart')->name('cart.getCart');
    Route::post('/cart', 'CartController@addToCart')->name('cart.addToCart');
});

// Tạo ra 2 role: admin và owner
Route::get('/tao-2-role', function(){
    // Cách 1:
    $owner = new \App\Role();
    $owner->name         = 'owner';
    $owner->display_name = 'Project Owner'; // optional
    $owner->description  = 'User is the owner of a given project'; // optional
    $owner->save();
    // Cách 2: bên model Role.php phải có $fillable
    \App\Role::create([
        'name' => 'admin',
        'display_name' => 'User Administrator',
        'description' => 'User is allowed to manage and edit other users',
    ]);
});

// Gán role cho user nào đó
Route::get('/assign-role-cho-user', function (){
    $henry_chung = \App\User::find(1);
    $henry_chung->attachRole(\App\Role::where('name', '=', 'admin')->first());
});

// Xóa bỏ role cho user nào đó
Route::get('/xoa-role-cua-user', function (){
    $henry_chung = \App\User::find(1);
    $henry_chung->detachRole(\App\Role::where('name', '=', 'admin')->first());
});

// Tạo 1 permission
Route::get('/tao-1-permission', function (){
    \App\Permission::create([
        'name' => 'upload',
        'display_name' => 'Upload Files or Photos',
        'description' => 'Allow members can upload their files'
    ]);
});

// Gán 1 permission nào đó cho 1 cái role nào đó
Route::get('gan-permission-cho-role', function (){
   $role_co_id_1 = \App\Role::find(1);
   $role_co_id_1->attachPermission(\App\Permission::where('name', '=', 'upload')->first());
});

// Test role trong blade template
Route::get('test-role', function(){
    return view('test-role');
});

// Không được xoá
//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
