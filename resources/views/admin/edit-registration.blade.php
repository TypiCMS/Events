@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-registration', [$event->id, $model->id]))->addClass('main-content') !!}
    {!! BootForm::bind($model) !!}
    @include('events::admin._form-registration')
    {!! BootForm::close() !!}
@endsection
