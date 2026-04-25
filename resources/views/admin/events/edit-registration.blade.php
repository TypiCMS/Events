@extends('admin::core.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-registration', [$event->id, $model->id]))->addClass('form') !!}
    {!! BootForm::bind($model) !!}
    @include('admin::events._form-registration')
    {!! BootForm::close() !!}
@endsection
