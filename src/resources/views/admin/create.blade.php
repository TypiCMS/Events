@extends('core::admin.master')

@section('title', __('New event'))

@section('content')

    @include('core::admin._button-back', ['module' => 'events'])
    <h1>
        @lang('New event')
    </h1>

    {!! BootForm::open()->action(route('admin::index-events'))->multipart()->role('form') !!}
        @include('events::admin._form')
    {!! BootForm::close() !!}

@endsection
