@extends('main')

@section('title','Edit Blog Post')

@section('stylesheets')
	
	{!! Html::style('css/select2.min.css') !!}

	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
	<script>
	tinymce.init({
				selector:'textarea',
				plugins: "link code",
				menubar: false,
				browser_spellcheck: true,
				contextmenu: false
				
			});
	</script>

@endsection

@section('content')

	<div class="row">
	{!! Form::model($post,['route'=>['posts.update',$post->id ], 'method'=>'put', 'files'=>true ]) !!}

		<div class="col-md-8">
			{{ Form::label('title','Title:')}}
			{{ Form::text('title',null, ['class'=>'form-control input-lg']) }}

			{{ Form::label('slug','Slug:',['class'=>'form-spacing-top'])}}
			{{ Form::text('slug',null, ['class'=>'form-control ']) }}

			{{ Form::label('category_id', 'Category',['class' =>'form-spacing-top']) }}
			<select name="category_id" class="form-control">
				@foreach ($categories as $category)
					<option value="{{ $category->id }}">{{ $category->name }}</option>
				@endforeach
			</select>

			{{ Form::label('tags', 'Tags',['class' =>'form-spacing-top']) }}
			<select name="tags[]" class="form-control select2-multiple" multiple="multiple">
				@foreach ($tags as $tag)
					<option value="{{ $tag->id }}">{{ $tag->name }}</option>
				@endforeach
			</select>
			
			{{ Form::label('featured_image','Update Featured Image:',['class'=>'form-spacing-top']) }}
			{{ Form::file('featured_image') }}

			{{ Form::label('body','Body:',['class'=>'form-spacing-top'])}}
			{{ Form::textarea('body',null,['class'=>'form-control'])}}
		</div>

		<div class="col-md-4">
			<div class="well">
				<div class="dl-horizontal">
					<dt>Created At:</dt>
					<dd>{{ date('M j,Y h:ia',strtotime($post->created_at)) }}</dd>
				</div><br>
 
				<div class="dl-horizontal">
					<dt>Last Updated:</dt>
					<dd>{{ date('M j,Y  h:ia',strtotime($post->updated_at)) }}</dd>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-6">
						{!! Html::linkRoute('posts.index','Cancel',array($post->id),array('class'=>'btn btn-danger btn-block')) !!}						
					</div>
					<div class="col-sm-6">

						{{ Form::submit('Save Changes',['class'=>'btn btn-success btn-block'])}}
						
					</div>
				</div>
			</div>			
		</div>
		{!! Form::close() !!}
	</div><!--End of .row-->

	

@stop

@section('scripts')
	
	{!! Html::script('js/select2.min.js') !!}

	<script type="text/javascript">
	$(".select2-multiple").select2();
	$(".select2-multiple").select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger("change");

	</script>


@endsection