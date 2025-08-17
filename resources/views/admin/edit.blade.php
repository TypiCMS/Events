@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-event', $model->id))->addClass('main-content') !!}
    {!! BootForm::bind($model) !!}
    @include('events::admin._form')
    {!! BootForm::close() !!}
@endsection
