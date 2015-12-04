<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::group(['domain' => 'acikteknoloji.com'],function()
{
  Route::get('/',['as' => 'home','uses' => 'HomeController@showWelcome']);
  Route::get('/search',['as' => 'search','uses' => 'HomeController@search']);
  Route::get('/login',['as' => 'login','uses' => 'HomeController@loginView'])->before('guest');
  Route::post('/login',['uses' => 'HomeController@login'])->before('guest');
  Route::get('/register',['as' => 'register','uses' => 'HomeController@registerView'])->before('guest');
  Route::post('/register',['uses' => 'HomeController@register'])->before('guest');
  Route::get('/logout',['as' => 'logout','uses' => 'HomeController@logout'])->before('auth');
  Route::get('/pickcomment/{id}',['as' => 'pickcomment','uses' => 'PostController@pickComment'])->before('auth');
  Route::get('/removecomment',['as' => 'removecomment','uses' => 'PostController@removeComment'])->before('auth');
  Route::get('/subtitle/create',['as' => 'subtitle.create','uses' => 'SubtitleController@createSubtitleView'])->before('auth');
  Route::post('/subtitle/create',['uses' => 'SubtitleController@createSubtitle'])->before('auth');

  Route::get('/subtitle/delete/{id}',['as' => 'subtitle.delete','uses' => 'SubtitleController@deleteSubtitle'])->before('auth');
  Route::get('/post/delete/{id}',['as' => 'post.delete','uses' => 'PostController@deletePost'])->before('auth');

  Route::get('/post/edit/{id}',['as' => 'post.edit','uses' => 'PostController@editPostView']);
  Route::post('/post/edit/{id}',['uses' => 'PostController@editPost']);

  Route::get('/vote/{id}/{votestatus}',['as' => 'vote','uses' => 'PostController@vote'])->before('auth');
});

Route::group(['domain' => '{subtitle}.acikteknoloji.com'],function()
{
  Route::get('/',['as' => 'subtitle','uses' => 'SubtitleController@showSubtitle']);
  Route::get('post/create',['as' => 'post.create','uses' => 'PostController@createPostView'])->before('auth');
  Route::post('post/create',['uses' => 'PostController@createPost'])->before('auth');
  Route::get('p/{id}',['as' => 'post.view','uses' => 'PostController@showPost']);
  Route::post('p/{id}',['as' => 'post.comment','uses' => 'PostController@makeComment'])->before('auth');
});
