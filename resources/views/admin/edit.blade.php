@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    {!! BootForm::open()->put()->action(route('admin::update-event', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
    @include('events::admin._form')
    {!! BootForm::close() !!}

@endsection
