
@extends('main')

@section('title','| View Post')

@section('content')
	
	<div class="row">

		<div class="col-md-8">
			<img src=" {{ asset('images/'.$post->image) }}" alt="Featured Image" width="750" height="400">
			<h1>{{ $post->title }}</h1>	
			<p class="lead">{!! $post->body !!} </p> {{--comments--}}
			<hr/>
			{{-- Starting of Tag section--}}
			<div class="tags">
				@foreach ($post->tags as $tag)

					<span class="label label-default">{{ $tag->name }}</span>

				@endforeach
			</div>
			{{-- Ending of Tag section--}}

			<div id="backend-comments" style="margin-top:40px;">
				<h3>Comments <small>{{ $post->comments()->count() }} comments</small></h3>

				<table class="table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Comment</th>
							<th width="70px">Edit</th>
							<th>Delete</th>
						</tr>
					</thead>

					<tbody>
					@foreach ($post->comments as $comment)
						<tr>
							<td>{{ $comment->name }}</td>
							<td>{{ $comment->email}}</td>
							<td>{{ $comment->comments}}</td>
							<td>
								<a href="{{ route('comments.edit',$comment->id)}}" class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></a>
							</td>
							<td>
								<a href="{{ route('comments.delete',$comment->id) }}" class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
							</td>
							</tr>
					@endforeach
						
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-md-4">
			<div class="well">
				<div class="dl-horizontal">
					<label>Url:</label>
					<p><a href="{{ route('blog.single',$post->slug) }}">{{route('blog.single',$post->slug)}}</a></p>
				</div><br>

				<div class="dl-horizontal">
					<label>Category:</label>
					<p>{{ $post->category->name }}</p>
				</div><br>

				<div class="dl-horizontal">
					<label>Created At:</label>
					<p>{{ date('M j,Y h:ia',strtotime($post->created_at)) }}</p>
				</div><br>
 
				<div class="dl-horizontal">
					<label>Last Updated:</label>
					<p>{{ date('M j,Y  h:ia',strtotime($post->updated_at)) }}</p>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('posts.edit','Edit',array($post->id),array('class'=>'btn btn-primary btn-block')) !!}						
					</div>
					<div class="col-sm-6">
						{!! Form::open(['route'=>['posts.destroy',$post->id],'method'=>'delete']) !!}

						
						{!! Form::submit('Delete',['class'=>'btn btn-danger btn-block']) !!}

						
						{!! Form::close() !!}
						
					</div>
				</div><hr/>

				<div class="row">
					<div class="col-md-12">
					{!! Html::linkRoute('posts.index','<<See All Posts',[],array('class'=>'btn btn-default btn-block')) !!}

						
					</div>
				</div>

			</div>			
		</div>
	</div>

	


@endsection



