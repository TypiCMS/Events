@extends('core::admin.master')

@section('title', __('events::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'events'])
    <h1>
        @lang('events::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-events'))->multipart()->role('form') !!}
        @include('events::admin._form')
    {!! BootForm::close() !!}

@endsection
