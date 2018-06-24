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

Route::get('category/{category}',['uses'=>'ArticleController@categoryArticle','as'=>'categoryArticle']);

Route::get('popular-products',['uses'=>'ArticleController@popularProducts','as'=>'popularProducts']);

Route::get('best-sellers',['uses'=>'ArticleController@bestSellers','as'=>'bestSellers']);

Route::resource('contact','ContactController',['only'=>['index'],'names'=>['index'=>'contact']]);

Route::get('about',['uses'=>'ContactController@about','as'=>'about']);

Route::get('delivery',['uses'=>'ContactController@delivery','as'=>'delivery']);
