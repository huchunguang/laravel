<?php
namespace App\Http\Middleware;

use Closure;
class Oldmiddware{
	public function handle($request,Closure $next)
	{
		if ($request->input('age')>20) 
		{
//			return 'stop brower';
			return redirect()->route('refuse');
		}
		return $next($request);
	}
}