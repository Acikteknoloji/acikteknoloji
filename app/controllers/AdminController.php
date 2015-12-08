<?php

class AdminController extends BaseController {

  public function showHome()
  {
    return View::make('admin.home');
  }

  public function listSubtitles()
  {
    $subtitles = Subtitle::paginate(30);
    return View::make('admin.subtitles')->with(['subtitles' => $subtitles]);
  }

  public function listInactiveSubtitles()
  {
    $subtitles = Subtitle::where('active',0)->paginate(30);
    return View::make('admin.inactive-subtitles')->with(['subtitles' => $subtitles]);
  }

  public function activateSubtitle($slug)
  {
    if(Subtitle::where('slug',$slug)->where('active',0)->exists())
    {
      $subtitle = Subtitle::where('slug',$slug)->first();
      $subtitle->active = 1;
      $subtitle->save();
      return Redirect::route('admin.inactive.subtitles');
    }
    App::abort(404); //TODO: Add Error Message(There is no subtitle found by given subtitle slug)
  }

  public function deleteSubtitle($slug)
  {
    if(Subtitle::where('slug',$slug)->exists())
    {
      $subtitle = Subtitle::where('slug',$slug)->first();
      $subtitle->delete();
      return Redirect::route('admin.home');
    }
    App::abort(404); //TODO: Add Error Message(There is no subtitle found by given subtitle slug)
  }

  public function users()
  {
    $users = User::paginate(30);
    return View::make('admin.users')->with(['users' => $users]);
  }

  public function editUserView($username)
  {
    if(User::where('username',$username)->exists())
    {
      $roles = Role::lists('name','id');
      $user = User::where('username',$username)->first();
      return View::make('admin.edituser')->with(['user' => $user,'roles' => $roles]);
    }
    App::abort(404); //TODO: Add Error Message(There is no user found by given username)
  }

  public function editUser($username)
  {
    if(User::where('username',$username)->exists())
    {
      $user = User::where('username',$username)->first();
      if(Input::has('role_ids'))
      {
        $user->roles()->sync(Input::get('role_ids'));
      }
      else {
        $alladmins = DB::Table('assigned_roles')->where('role_id',1)->count();
        if($alladmins <= 1)
        {
          return Redirect::route('admin.user.edit',$username); //TODO: Add error message
        }
        $user->roles()->sync([]);
      }
      return Redirect::route('admin.user.edit',$username);
    }
    App::abort(404); //TODO: Add Error Message(There is no user found by given username)
  }

}
