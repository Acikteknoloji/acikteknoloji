<?php

class PostController extends BaseController {

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

	public function showPost($subtitle,$id)
	{
		if(Subtitle::where('slug',$subtitle)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			if(Post::where('id',$id)->where('isComment','0')->exists())
			{
				if($subtitle->active == 1 || Auth::user()->hasRole('admin'))
				{
					$post = Post::where('id',$id)->first();
					return View::make('post')->with(['subtitle' => $subtitle,'post' => $post]);
				}
				App::abort(404);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function editPostView($id)
	{
		if(Post::where('id',$id)->exists())
		{
			$post = Post::find($id);
			$subtitle = $post->subtitle;
			if($post->user_id == Auth::user()->id || DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',Auth::user()->id)->where('isAdmin','!=',0)->exists())
			{
				return View::make('editpost')->with(['post' => $post,'subtitle' => $subtitle]);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function editPost($id)
	{
		if(Post::where('id',$id)->exists())
		{
			$post = Post::find($id);
			$subtitle = $post->subtitle;
			if($post->user_id == Auth::user()->id || DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',Auth::user()->id)->where('isAdmin','!=',0)->exists())
			{
				$post->content = Input::get('content');
				$post->save();
			}
			return Redirect::route('post.view',[$subtitle->slug,$post->id]);
		}
		App::abort(404);
	}

	public function createPostView($subtitle)
	{
		if(Subtitle::where('slug',$subtitle)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			if($subtitle->active == 1 || Auth::user()->hasRole('admin'))
			{
				if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->exists())
				{
					return View::make('createpost')->with(['subtitle' => $subtitle]);
				}
				return Redirect::route('subtitle',$subtitle->slug);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function createPost($subtitle)
	{
		$errorMessages = new Illuminate\Support\MessageBag;
		if(Subtitle::where('slug',$subtitle)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			if($subtitle->active == 1 || Auth::user()->hasRole('admin'))
			{
				if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id)->exists())
				{
					$rules = ["title" => "required|min:9","link" => "url"];
					$inputs = Input::all();
					$validator = Validator::make($inputs,$rules);
					if($validator->passes() && (Input::has('link') || Input::has('content')))
					{
						$link = null;
						$post = new Post();
						$post->title = Input::get('title');
						$post->content = Input::get('content');
						if(Input::get('link') != null && filter_var(Input::get('link'),FILTER_VALIDATE_URL))
						{
							$link = Input::get('link');
						}
						$post->isLink = $link;
						$post->isComment = 0;
						if(DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',Auth::user()->id)->where('isAdmin','!=',0)->exists())
						{
							$post->publish = 1;
						}
						else {
							$post->publish = 0;
							Event::fire('new_post',[$subtitle->id,Auth::user()->username,Input::get('title')]);
						}
						$post->subtitle_id = $subtitle->id;
						$post->user_id = Auth::user()->id;
						$post->save();
						return Redirect::route('subtitle',$subtitle->slug);
					}
					if(!(Input::has('link') || Input::has('content')))
					{
						$errorMessages->add("required","Link veya İçerik boş bırakılamaz.Lütfen ikisinden birini doldurunuz!");
					}
					if($validator->fails())
					{
						$errorMessages->merge($validator->errors()->toArray());
					}
					return Redirect::back()->with(['errors' =>  $errorMessages])->withInput();
				}
				return Redirect::route('subtitle',$subtitle->slug);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function makeComment($subtitle,$id)
	{
		if(Subtitle::where('slug',$subtitle)->exists() && Post::where('id',$id)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			if($subtitle->active == 1 || Auth::user()->hasRole('admin'))
			{
				if(DB::Table('user_subtitle')->where('user_id',Auth::user()->id)->where('subtitle_id',$subtitle->id))
				{
					$rules = ["content" => "required"];
					$inputs = Input::all();
					$validator = Validator::make($inputs,$rules);
					if($validator->passes())
					{
						$comment = $id;
						$post = new Post();
						$post->content = Input::get('content');
						$comment = Input::get('comment_id');
						$post->isComment = $comment;
						$post->subtitle_id = $subtitle->id;
						$post->publish = 1;
						$post->user_id = Auth::user()->id;
						$post->save();
						if(Session::has('comment_id'))
							Session::remove('comment_id');
						return Redirect::back();
					}
					return Redirect::back()->withErrors($validator);
				}
				return Redirect::route('subtitle',$subtitle->slug);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function vote($id,$votestatus)
	{
		if(Post::where('id',$id)->exists() && ($votestatus == 1 || $votestatus == 0))
		{
			$post = Post::where('id',$id)->first();
			if(Vote::where('post_id',$id)->where('user_id',Auth::user()->id)->exists())
			{
				return Redirect::back();
			}
			if($post->user_id == Auth::user()->id)
			{
				return Redirect::back();
			}
			$vote = new Vote();
			$vote->user_id = Auth::user()->id;
			$vote->post_id = $id;
			$vote->vote = $votestatus;
			$vote->save();
		}
		return Redirect::back();
	}

	public function deletePost($id)
	{
		if(Post::where('id',$id)->exists())
		{
			$post = Post::find($id);
			$subtitle = Subtitle::where('id',$post->subtitle_id)->first();
			if($post->user_id == Auth::user()->id || DB::Table('user_subtitle')->where('subtitle_id',$subtitle->id)->where('user_id',Auth::user()->id)->where('isAdmin','!=',0)->exists())
			{
				foreach($post->children()->get() as $children)
				{
					$children->destroy($children->id);
				}
				$post->destroy($id);
			}
			return Redirect::back();
		}
		return Redirect::back();
	}

}
