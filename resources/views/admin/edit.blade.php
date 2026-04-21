@extends('core::admin.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-event', $model->id))->addClass('form') !!}
    {!! BootForm::bind($model) !!}
    @include('events::admin._form')
    {!! BootForm::close() !!}
@endsection
