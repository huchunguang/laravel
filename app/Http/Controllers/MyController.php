<?php
namespace App\Http\Controllers;
class MyController extends Controller
{
	function index()
	{	
		$data=['name'=>null,'age'=>'23'];
		$people=['1','2','3','4','5'];
		return view('my',compact('people'));
	}
}
?>