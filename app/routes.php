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
Route::group(['domain' => Config::get('app.domain')],function()
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


  Route::group(['prefix' => 'admin'],function()
  {
    Route::get('/',['as' => 'admin.home','uses' => 'AdminController@showHome']);
    Route::get('/subtitles',['as' => 'admin.subtitles','uses' => 'AdminController@listSubtitles']);
    Route::get('/inactive/subtitles',['as' => 'admin.inactive.subtitles','uses' => 'AdminController@listInactiveSubtitles']);
    Route::get('/activate/subtitle/{slug}',['as' => 'admin.activate.subtitle','uses' => 'AdminController@activateSubtitle']);
    Route::get('/edit/subtitle/{slug}',['as' => 'admin.edit.subtitle','uses' => 'AdminController@editSubtitleView']);
    Route::post('/edit/subtitle/{slug}',['uses' => 'AdminController@editSubtitle']);
    Route::get('/delete/subtitle/{slug}',['as' => 'admin.delete.subtitle','uses' => 'AdminController@deleteSubtitle']);
    Route::get('/users',['as' => 'admin.users', 'uses' => 'AdminController@users']);
    Route::get('/user/edit/{username}',['as' => 'admin.user.edit','uses' => 'AdminController@editUserView']);
    Route::post('/user/edit/{username}',['as' => 'admin.user.update','uses' => 'AdminController@editUser']);
  });

  Entrust::routeNeedsRole( 'admin*', 'admin' );
});

Route::group(['domain' => '{subtitle}.'.Config::get('app.domain')],function()
{
  Route::get('/',['as' => 'subtitle','uses' => 'SubtitleController@showSubtitle']);
  Route::get('/signup',['as' => 'subtitle.signup','uses' => 'SubtitleController@signup'])->before('auth');
  Route::get('/signout',['as' => 'subtitle.signout','uses' => 'SubtitleController@signout'])->before('auth');
  Route::get('post/create',['as' => 'post.create','uses' => 'PostController@createPostView'])->before('auth');
  Route::post('post/create',['uses' => 'PostController@createPost'])->before('auth');
  Route::get('p/{id}',['as' => 'post.view','uses' => 'PostController@showPost']);
  Route::post('p/{id}',['as' => 'post.comment','uses' => 'PostController@makeComment'])->before('auth');
  Route::get('/login',function(){
    return Redirect::route('login');
  });
  Route::group(['prefix' => 'admin','before' => 'auth'],function(){
    Route::get('/',['as' => 'subadmin.home','uses' => 'SubtitleController@showAdmin']);
    Route::get('/users',['as' => 'subadmin.users','uses' => 'SubtitleController@adminUsers']);
    Route::get('/upgrade/{id}',['as' => 'subadmin.makemod','uses' => 'SubtitleController@adminMakeMod']);
    Route::get('/downgrade/{id}',['as' => 'subadmin.makeuser','uses' => 'SubtitleController@adminMakeUser']);
  });
});
