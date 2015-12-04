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
		if($validator->passes())
		{
			$subtitle = new Subtitle();
			$subtitle->name = Input::get('name');
			$subtitle->slug = Input::get('slug');
			$subtitle->description = Input::get('description');
			$subtitle->unvalidcustomcss = Input::get('css');
			$subtitle->save();
			DB::Table('user_subtitle')->insert(['user_id' => Auth::user()->id,'subtitle_id' => $subtitle->id,'isAdmin' => 1]);
			return Redirect::route('subtitle',$subtitle->slug);
		}
		return Redirect::back()->withErrors($validator);
	}

	public function showSubtitle($slug)
	{
		if(Subtitle::where('slug',$slug)->exists())
		{
			$subtitle = Subtitle::where('slug',$slug)->first();
			return View::make('subtitle')->with(['subtitle' => $subtitle]);
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

}
