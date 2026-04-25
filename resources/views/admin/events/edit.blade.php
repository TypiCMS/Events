@extends('admin::core.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-event', $model->id))->addClass('form') !!}
    {!! BootForm::bind($model) !!}
    @include('admin::events._form')
    {!! BootForm::close() !!}
@endsection
