<?php

class SubtitleController extends BaseController {

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

	public function createSubtitleView()
	{
		return View::make('createsubtitle');
	}

	public function createSubtitle()
	{
		$rules = ["name" => "required|min:3","slug" => "required|min:3|unique:subtitles","description" => "required|min:5"];
		$inputs = ["name" => Input::get('name'),"slug" => Str::slug(Input::get('slug')),"description" => Input::get('description')];
		$validator = Validator::make($inputs,$rules);
		if($inputs['slug'] == 'admin')
		{
			App::abort(404);
		}
		if($validator->passes())
		{
			$subtitle = new Subtitle();
			$subtitle->name = Input::get('name');
			$subtitle->slug = Input::get('slug');
			$subtitle->description = Input::get('description');
			$subtitle->unvalidcustomcss = Input::get('css');
			$subtitle->save();
			Event::fire('new_subtitle',[Auth::user()->username,Input::get('name')]);
			DB::Table('user_subtitle')->insert(['user_id' => Auth::user()->id,'subtitle_id' => $subtitle->id,'isAdmin' => 1]);
			return Redirect::route('home');
		}
		return Redirect::back()->withErrors($validator);
	}

	public function showSubtitle($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if($subtitle->active == 1 || Auth::user()->hasRole('admin'))
			{
				return View::make('subtitle')->with(['subtitle' => $subtitle]);
			}
			else {
				App::abort(404);
			}
		}
		App::abort(404);
	}

	public function deleteSubtitle($id)
	{
		if(Auth::user()->isAdminOn($id))
		{
			$subtitle = Subtitle::find($id);
			$subtitle->destroy($id);
		}
		return Redirect::back();
	}

	public function showAdmin($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			$admin = $subtitle->user()->where('isAdmin',1)->first();
			if(Auth::user()->id == $admin->id || Auth::user()->hasRole('admin'))
			{
				return View::make('subadmin.home')->with(['subtitle' => $subtitle]);
			}
		}
		App::abort(404);
	}

	public function adminUsers($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			$users = DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->paginate(30);
			$admin = $subtitle->user()->where('isAdmin',1)->first();
			if(Auth::user()->id == $admin->id || Auth::user()->hasRole('admin'))
			{
				return View::make('subadmin.users')->with(['subtitle' => $subtitle,'users' => $users]);
			}
		}
		App::abort(404);
	}

	public function adminMakeMod($slug,$id)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			$admin = $subtitle->user()->where('isAdmin',1)->first();
			if(Auth::user()->id == $admin->id || Auth::user()->hasRole('admin'))
			{
				if(DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',$id)->where('isAdmin',0)->exists())
				{
					DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',$id)->where('isAdmin',0)->update(['isAdmin' => 2]);
					return Redirect::back();
				}
				return Redirect::back();
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function adminMakeUser($slug,$id)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			$admin = $subtitle->user()->where('isAdmin',1)->first();
			if(Auth::user()->id == $admin->id || Auth::user()->hasRole('admin'))
			{
				if(DB::Table('user_subtitle')->where('user_id',$id)->where('subtitle_id',$subtitle->id)->where('isAdmin',2)->exists())
				{
					DB::Table('user_subtitle')->where('user_id',$id)->where('subtitle_id',$subtitle->id)->where('isAdmin',2)->update(['isAdmin' => 0]);
				}
				return Redirect::back();
			}
			return Redirect::back();
		}
		App::abort(404);
	}

	public function signup($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if(!DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->exists())
			{
				DB::Table('user_subtitle')->insert(['user_id' => Auth::user()->id,'subtitle_id' => $subtitle->id,'isAdmin' => 0,'status' => 0]);
				return Redirect::back();
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function signout($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->exists())
			{
				DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->where('isAdmin',0)->delete();
				DB::Table('posts')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->delete();
				return Redirect::back();
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function moderation($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->where('isAdmin','!=',0)->exists())
			{
				$posts = Post::where('subtitle_id',$subtitle->id)->where('isComment',0)->orderBy('publish','ASC')->paginate(50);
				return View::make('moderation.home')->with(['subtitle' => $subtitle,'posts' => $posts]);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function publishPost($slug,$id)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->where('isAdmin','!=',0)->exists())
			{
				if(Post::where('id',$id)->where('publish',0)->exists())
				{
					$post = Post::where('id',$id)->first();
					$post->publish = 1;
					$post->save();
					return Redirect::route('moderation.home',$slug);
				}
				App::abort(404);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function draftPost($slug,$id)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->where('isAdmin','!=',0)->exists())
			{
				if(Post::where('id',$id)->where('publish',1)->exists())
				{
					$post = Post::where('id',$id)->first();
					$post->publish = 0;
					$post->save();
					return Redirect::route('moderation.home',$slug);
				}
				App::abort(404);
			}
			App::abort(404);
		}
		App::abort(404);
	}

}
