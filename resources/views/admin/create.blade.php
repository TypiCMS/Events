@extends('core::admin.master')

@section('title', __('New event'))

@section('content')

    {!! BootForm::open()->action(route('admin::index-events'))->multipart()->role('form') !!}
        @include('events::admin._form')
    {!! BootForm::close() !!}

@endsection
