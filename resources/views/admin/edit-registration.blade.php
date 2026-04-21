@extends('core::admin.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-registration', [$event->id, $model->id]))->addClass('form') !!}
    {!! BootForm::bind($model) !!}
    @include('events::admin._form-registration')
    {!! BootForm::close() !!}
@endsection
