@extends('main')

@section('title','| Delete Comment?')

@section('content')
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h1>Delete This Comment?</h1>
			<p>
				<strong>Name:</strong> {{ $comment->name }}<br/>
				<strong>Email:</strong> {{ $comment->email }}<br/>
				<strong>Comment:</strong> {{ $comment->comments }}
			</p>

			{{ Form::open(['route'=>['comments.destroy',$comment->id],'method'=>'DELETE']) }}

				{{ Form::submit('Delete',['class'=>'btn btn-danger btn-block btn-h1-spacing'])}}

			{{ Form::close() }}

			<a href="{{ route('posts.show',$post_id)}}" class="btn btn-success btn-block btn-h1-spacing">Cancel</a>
		</div>
	</div>

@endsection