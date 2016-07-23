<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Cache;

class PostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts=Cache::get('posts',[]);
		if (!$posts) 
		{
			exit('Nothing ');
		}
		$html='<ul>';
		foreach ($posts as $key=>$post)
		{
			$html.='<li><a href="'.route('post.show',['post'=>$key]).'">'.$post['title'].'</a></li>';
		}
		$html.='</ul>';
		return $html;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$postUrl=route('post.store');
		//echo $postUrl;die;
		$csrf_token=csrf_token();
		$html=<<<CREATE
		<form action="$postUrl" method="post">
				$csrf_token
				<input type="hidden" name="_token" value="{$csrf_token}"/>
				<input type="text" name="title" id="" />
				<textarea name="content" id="" cols="30" rows="10"></textarea><br />
				<input type="submit" value="提交" />
		</form>
CREATE;
		return $html;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$title=$request->input('title');
		$content=$request->input('content');
		$post=['title'=>trim($title),'content'=>trim($content)];
		$posts=Cache::get('posts',[]);
		if (!Cache::get('post_id')) 
		{
			Cache::add('post_id',1,60);
		}
		else
		{
			Cache::increment('post_id',1);
		}
		$posts[Cache::get('post_id')]=$post;
		Cache::put('posts',$posts,60);
		return redirect()->route('post.show',['post'=>Cache::get('post_id')]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$posts=Cache::get('posts',[]);
		if (!$posts || empty($posts[$id])) 
		{
			exit('nothing not found');
		}
		$post=$posts[$id];
		$editUrl=route('post.edit',['post'=>$id]);
		$html=<<<DETAIL
		<h3>{$post['title']}</h3>
		<p>{$post['content']}</p>
		<p>
				<a href="{$editUrl}">编辑</a></p>
DETAIL;
		return $html;
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id        	
	 * @return Response
	 */
	public function edit($id) {
		$posts = Cache::get ( 'posts', [ ] );
		if (! $posts || ! $posts [$id])
			exit ( 'Nothing Found！' );
		$post = $posts [$id];
		
		$postUrl = route ( 'post.update', [ 
				'post' => $id 
		] );
		$csrf_field = csrf_token ();
		$html = <<<UPDATE
        <form action="$postUrl" method="POST">
            $csrf_field
            <input type="hidden" name="_method" value="PUT"/>
            <input type="hidden" name="_token" value="$csrf_field" />
            <input type="text" name="title" value="{$post['title']}"><br/><br/>
            <textarea name="content" cols="50" rows="5">{$post['content']}</textarea><br/><br/>
            <input type="submit" value="提交"/>
        </form>
UPDATE;
    return $html;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$posts=Cache::get('posts',[]);
		if (!$posts || empty($posts[$id])) 
		{
			exit('nothing not found');
		}
		$title=$request->input('title');
		$content=$request->input('content');
		$posts[$id]['title']=trim($title);
		$posts[$id]['content']=trim($content);
		Cache::put('posts',$posts,60);
		return redirect()->route('post.show',['post'=>$id]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$posts=Cache::get('posts',[]);
		if (!$posts || empty($posts)) 
		{
			exit('nothings not found');
		}
		unset($posts[$id]);
		Cache::decrement('post_id',1);
		return redirect()->route('post.index');
	}

}
