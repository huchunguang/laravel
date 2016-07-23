<?php
namespace App\Http\Controllers;
class UserController extends Controller
{	
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function showProfile($id){
		echo Route::currentRouteAction();die;
		echo action('UserController@showProfile');die;
		echo $id;die;
		return view('user.profile',['user_id'=>$id]);
	}
}