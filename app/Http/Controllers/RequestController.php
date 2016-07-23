<?php
namespace App\Http\Controllers;

use Illuminate\Auth\Access;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Access as test;
class RequestController extends Controller
{
	public function getBasetest(Request $request)
	{
		//var_dump($request->isMethod('get'));die;
	
		$path=$request->path();
		$url=$request->url();
		echo $path.'<br />'.$url;
		echo '<hr color="red"/>';
		if ($request->has('test')) {
			$input=$request->input('test');
			echo $input;die;
		}
		
	}
	public function getCookie(Request $request)
	{
		$cookies=$request->cookie();
		echo '<xmp>';
		print_r($cookies);die;
	}
	public function getAddCookie()
	{
		$response=new test\Response();
		die;
		$response->withCookie(cookie('website','Laravel website',60));
		$response->withCookie(cookie()->forever('forever','this is a forever cookie'));
		return $response;
	}
	//文件上传表单
	public function getFileupload()
	{
		$postUrl='/request/fileupload';
		$csrf_token=csrf_token();
		$html=<<<CREATE
		<form action="$postUrl" method="post" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="$csrf_token" />
				<input type="file" name="filename" id="" /><br />
				<input type="submit" value="提交" />
		</form>
CREATE;
		return $html;
	}
	//文件上传处理
	public function postFileupload(Request $request)
	{
		if (!$request->hasFile('filename')) 
		{
			exit('上传文件为空!');
		}
		$file=$request->file('filename');
		if (!$file->isValid()) 
		{
			exit('文件上传错误!');
		}
		
		$destpath=realpath(public_path('images'));
		if (!file_exists($destpath)) 
		{
			mkdir($destpath,0755,true);
		}
		$filename=$file->getClientOriginalName();
		if (!$file->move($destpath,$filename))
		{
			exit('文件保存失败!');
		}
		exit('文件上传成功!');
	}
}