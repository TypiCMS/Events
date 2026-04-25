@extends('admin::core.master')

@section('title', __('New event'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-events'))->addClass('form') !!}
    @include('admin::events._form')
    {!! BootForm::close() !!}
@endsection
