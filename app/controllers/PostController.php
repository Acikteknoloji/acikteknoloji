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
				$post = Post::where('id',$id)->first();
				return View::make('post')->with(['subtitle' => $subtitle,'post' => $post]);
			}
			App::abort(404);
		}
		App::abort(404);
	}

	public function editPostView($id)
	{
		if(Post::where('id',$id)->where('user_id',Auth::user()->id)->exists())
		{
			$post = Post::find($id);
			return View::make('editpost')->with(['post' => $post]);
		}
		App::abort(404);
	}

	public function editPost($id)
	{
		if(Post::where('id',$id)->where('user_id',Auth::user()->id)->exists())
		{
			$post = Post::find($id);
			$post->content = Input::get('content');
			$post->save();
			return Redirect::to('/s/'.$post->subtitle->slug.'/p/'.$post->id);
		}
		App::abort(404);
	}

	public function createPostView($subtitle)
	{
		if(Subtitle::where('slug',$subtitle)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			return View::make('createpost')->with(['subtitle' => $subtitle]);
		}
		App::abort(404);
	}

	public function createPost($subtitle)
	{
		if(Subtitle::where('slug',$subtitle)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
			$rules = ["title" => "required|min:9","content" => "required"];
			$inputs = Input::all();
			$validator = Validator::make($inputs,$rules);
			if($validator->passes())
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
				$post->subtitle_id = $subtitle->id;
				$post->user_id = Auth::user()->id;
				$post->save();
				return Redirect::to('/s/'.$subtitle->slug."/p/".$post->id);
			}
			return Redirect::back()->withErrors($validator);
		}
		App::abort(404);
	}

	public function makeComment($subtitle,$id)
	{
		if(Subtitle::where('slug',$subtitle)->exists() && Post::where('id',$id)->exists())
		{
			$subtitle = Subtitle::where('slug',$subtitle)->first();
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
				$post->user_id = Auth::user()->id;
				$post->save();
				if(Session::has('comment_id'))
					Session::remove('comment_id');
				return Redirect::to('/s/'.$subtitle->slug."/p/".$id."#post-".$post->id);
			}
			return Redirect::back()->withErrors($validator);
		}
		App::abort(404);
	}

	public function pickComment($id)
	{
		if(Post::where('id',$id)->exists())
		{
			Session::put('comment_id',$id);
			return Redirect::back();
		}
		return Redirect::back();
	}

	public function removeComment()
	{
		if(Session::has('comment_id'))
			Session::remove('comment_id');

		return Redirect::back();
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
		if(Post::where('id',$id)->where('user_id',Auth::user()->id)->exists())
		{
			$post = Post::find($id);
			foreach($post->children()->get() as $children)
			{
				$children->destroy($children->id);
			}
			$post->destroy($id);
		}
		return Redirect::back();
	}

}
