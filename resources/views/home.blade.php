@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You are logged in!
					@foreach ($data as $key=>$value)
					{{$value}}
					@endforeach
					@if($data['name'])
					{{$data['name'].'fasfs'.$data['age']}}
					@endif
					{{$data['age'] or '无年龄'}}
					{{{'<html >this is a html docs</html>'}}}
					{{csrf_token()}}
					@if($data['age'])
					{{$data['age']}}
					@else
					{{'不知道你叫什么'}}
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
