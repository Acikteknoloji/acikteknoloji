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
		$posts = null;
		if(Auth::check())
		{
			$posts = Post::whereIn('subtitle_id',Auth::user()->subtitles()->lists('subtitle_id'))->where('publish',1)->where('isComment',0)->orderBy('created_at','DESC')->paginate(30);
		}
		else {
			$posts = Post::Where('isComment',0)->where('publish',1)->orderBy('created_at','DESC')->paginate(30);
		}
		return View::make('hello')->with(['posts' => $posts]);
	}

	public function notifs($last)
	{
		return Response::json(Notification::where('user_id',Auth::user()->id)->where('id','>',$last)->get())->setCallback(Input::get('callback'));
	}

	public function markAsRead($id)
	{
		if(Notification::where('user_id',Auth::user()->id)->where('id',$id)->exists())
		{
			$noty = Notification::find($id);
			$noty->isRead = 1;
			$noty->save();
		}
	}

	public function deleteNotify($id)
	{
		if(Notification::where('user_id',Auth::user()->id)->where('id',$id)->exists())
		{
			$noty = Notification::find($id);
			$noty->delete();
		}
	}

	public function notifCount()
	{
		return Response::json(["unread" => Auth::user()->unreadNotifs()])->setCallback(Input::get('callback'));
	}

	public function search()
	{
		$term = Request::input('q');
		$where = Request::input('where');
		$query = null;
		if($where == "subtitles")
		{
			$query = Subtitle::where('name','like','%'.$term.'%')->orWhere('description','like','%'.$term.'%')->paginate(30);
		}
		else {
			$query = Post::where('title','like','%'.$term.'%')->orWhere('content','like','%'.$term.'%')->where('publish',1)->paginate(30);
		}

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
