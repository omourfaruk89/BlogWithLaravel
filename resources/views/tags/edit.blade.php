
@extends('main')

@section('title', '| Edit Tag')

@section('content')

	{!! Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PUT']) !!}
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name', null, ['class' => 'form-control']) }}
		
		{{ Form::submit('Save', array('class' => 'btn btn-primary form-spacing-top', 'style' => 'width:200px;')) }}

	{!! Form::close() !!}

@endsection