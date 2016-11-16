<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Entity\Member;
Route::get('member',function(){
	return Member::all();
});
Route::get('/',function(){
    xdebug_disable();
    echo '4556';die;
    return '123123';
	return view('master');
});
Route::get('testmodel',function(){
	$user=new App\User();
	return $user->userTest();
});
Route::get('components/{num}',function($num){
	return view('compon'.$num);
	
});
Route::get('alipay',['as'=>'paytest','uses'=>'PayController@alipay']);
Route::get('testResponse',function (){
	$content='hello laravel';
	$status=200;
	$value='text/html;charset=utf-8';
	return response()->json(['username'=>'huchunguang','age'=>'23','city'=>'shanghai','address'=>'江苏淮安']);
	//return response()->json()->setCallback(request()->input('callback'));
// 	return response()
// 		   	->view('hello',['message'=>'hello message'])
// 			->header('Content-Type',$value);
	//return response($content,$status)->header('Content-Type',$value);
});
Route::get('testResponseDownload',function (){
	return response()->download(realpath(public_path('images/door1.png')),'testDownload.png');
});
Route::get('dashboard',function (){
	return redirect('testResponse');
	
});
Route::get('asname',function (){
	return redirect()->route('refuse');
});
Route::get('gethome',function (){
	return redirect()->action('WelcomeController@index');	
});
Route::controller('request','RequestController');
Route::resource('post','PostController');
Route::get('/age/refuse/',['as'=>'refuse',function(){
	return "18岁以上男子才能访问！";
}]);
Route::get('testViewHello',function(){
	return view('hello');
});
Route::get('testViewHome',function(){
	return view('home');
});
Route::get('/testpost',function (){
	$return = <<<FORM
	<form action="/testpost" method="post">
			
			<input type="text" name="" id="" value="fasdf"/>
			<input type="text" name="" id="" class="username" />
			<input type="submit" value="提交" />
	</form>
FORM;
	return $return;
});
Route::post('/testpost',function (){
	return 'Success';
});
Route::get('/viewhome',function (){
	$data=array();
	$data=array(
		'name'=>'胡春光',
		'age'=>null,
		'test'=>'this is a test'
	);
	return view('home',compact('data'));
});
/*personal test for debug  Route*/
Route::get('home',['as'=>'home','uses'=>'UserController@showProfile']);
Route::group(array('prefix'=>'owntest','middleware'=>'test'),function (){
	Route::get('age/{num?}',['as'=>'test',function ($num){
		return 'this middware'.$num.'';
	}]);
	Route::get('showprofile/{id}', 'UserController@showProfile');
	Route::get('/test','MyController@index');
	Route::get('/404',function (){
		abort('404');
	});
	Route::post('post',function(){
		return 'this is a post';
	});

	Route::match(['post','get'],'/username/{user_id}',function ($id){
		return 'this is a username'.$id.'';
	});
	Route::get('identi/{age}/{username}',function ($age,$username){
		return $age.'---'.$username;
	})->where(['age'=>'[0-9]+','username'=>'[a-zA-Z]+']);
	Route::match(['post','get'],'group/{groupname?}',['as'=>'testgroup',function ($groupname='testgroupname'){
		return $groupname;
	}]);
});


#Route::get('home', 'HomeController@index');
#
#Route::controllers([
#	'auth' => 'Auth\AuthController',
#	'password' => 'Auth\PasswordController',
#]);
