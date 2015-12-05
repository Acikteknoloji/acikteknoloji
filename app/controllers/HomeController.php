<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		$subtitles = Subtitle::where('active',1)->paginate(15);
		$posts = Post::Where('isComment',0)->where('publish',1)->take(30)->get();
		return View::make('hello')->with(['posts' => $posts,'subtitles' => $subtitles]);
	}

	public function search()
	{
		$term = Request::input('q');
		$query = DB::table('subtitles')
		->leftJoin('posts','subtitles.id','=','posts.subtitle_id')
		->select('posts.*','subtitles.*','subtitles.id as sid','posts.id as pid')
		->Where('subtitles.name','like','%'.$term.'%')
		->orWhere('posts.title','like','%'.$term.'%')
		->orWhere('posts.content','like','%'.$term.'%')
		->orWhere('subtitles.description','like','%'.$term.'%')
		->get();

		return View::make('search')->with(['query' => $query]);
	}

	public function loginView()
	{
		return View::make('login');
	}

	public function registerView()
	{
		return View::make('register');
	}

	public function register()
	{
		$rules = ["username" => "required|min:5|unique:users","password" => "required|min:5","email" => "email|unique:users"];
		$inputs = Input::all();
		$validator = Validator::make($inputs,$rules);
		if($validator->passes())
		{
			$user = new User();
			$user->username = Input::get('username');
			$user->email = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->save();
			return Redirect::to('/login');
		}
		return Redirect::back();
	}

	public function login()
	{
		if (Auth::attempt(['username' => Input::get('username'), 'password' => Input::get('password')], Input::get('remember'))) {
    	return Redirect::to('/');
		}
		return Redirect::back();
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::to('/');
	}

}
