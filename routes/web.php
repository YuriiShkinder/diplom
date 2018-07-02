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

Route::resource('/','IndexController',['only'=>['index'],'names'=>['index'=>'home']]);

Route::resource('article','ArticleController',['only'=>['index'],'names'=>['index'=>'allArticles']]);

Route::post('filter/article',['uses'=>'ArticleController@articleFilter','as'=>'articleFilter']);

Route::post('search/article',['uses'=>'ArticleController@searchArticle','as'=>'searchArticle']);

Route::post('comment/article',['uses'=>'ArticleController@addComment','as'=>'addComment']);

Route::post('like/article/{article}',['uses'=>'ArticleController@likeArticle','as'=>'likeArticle']);

Route::post('like/comment/{comment}',['uses'=>'ArticleController@likeComment','as'=>'likeComment']);

Route::get('show/{category}/{article}',['uses'=>'ArticleController@show','as'=>'showArticle']);

Route::get('category/{category}',['uses'=>'ArticleController@categoryArticle','as'=>'categoryArticle']);

Route::get('popular-products',['uses'=>'ArticleController@popularProducts','as'=>'popularProducts']);

Route::get('best-sellers',['uses'=>'ArticleController@bestSellers','as'=>'bestSellers']);

Route::resource('contact','ContactController',['only'=>['index'],'names'=>['index'=>'contact']]);

Route::get('about',['uses'=>'ContactController@about','as'=>'about']);

Route::get('delivery',['uses'=>'ContactController@delivery','as'=>'delivery']);

Route::get('login',['uses'=>'Auth\LoginController@showLoginForm'])->name('login');

Route::post('login',['uses'=>'Auth\LoginController@login']);

Route::get('logout',['uses'=>'Auth\LoginController@logout']);

Route::group(['prefix' => 'register'],function (){

    Route::get('/', 'Auth\RegisterController@showRegistrationForm')->name('register');

    Route::post('/', 'Auth\RegisterController@register');

});

Route::group(['prefix' => 'cart'],function (){

    Route::get('/', 'CartController@index')->name('cart');

    Route::post('/add-item/{article}', 'CartController@addProduct')->name('addProduct');

    Route::post('/update-item/{article}', 'CartController@updateProduct')->name('updateProduct');

    Route::post('/remove-item/{article}', 'CartController@removeProduct')->name('removeProduct');

});

Route::group(['prefix' => 'wish'],function (){

    Route::get('/', 'WishController@index')->name('wish');

    Route::post('/add-item/{article}', 'WishController@addWish')->name('addWish');

    Route::post('/update-item/{article}', 'WishController@addCart')->name('addCart');

    Route::post('/remove-item/{article}', 'WishController@removeWish')->name('removeWish');

});

Route::group(['prefix' => 'acount','middleware'=> 'auth'],function (){

    Route::get('/', 'AcountController@index')->name('acount');

    Route::post('/edit', 'AcountController@edit')->name('acountEdit');

    Route::post('/edit/pass', 'AcountController@editPass')->name('editPass');

    Route::post('/edit/foto', 'AcountController@editFoto')->name('editFoto');

});

Route::group(['prefix' => 'admin','middleware'=> 'auth'],function (){

    Route::get('/', 'Admin\IndexController@index')->name('admin');

    Route::get('/pagination', 'Admin\IndexController@pagination');

    Route::get('/comments', 'Admin\IndexController@paginationComments');

    Route::match(['get','post'],'/addcategory',['uses' => 'Admin\IndexController@addCategory','as' => 'addCategory']);

    Route::match(['get','post'],'/edit/category/{category}', 'Admin\IndexController@editCategory')->name('editCategory');

    Route::post('/delete/category/{category}', 'Admin\IndexController@deleteCategory')->name('deleteCategory');

    Route::post('/delete/user/{user}', 'Admin\IndexController@deleteUser')->name('deleteUser');

    Route::match(['get','post'],'/addArticle',['uses' => 'Admin\IndexController@addArticle','as' => 'addArticle']);
});

