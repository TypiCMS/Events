@extends('core::admin.master')

@section('title', $model->present()->title)

@section('main')

    @include('core::admin._button-back', ['module' => 'events'])
    <h1 class="@if(!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('core::global.Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-event', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('events::admin._form')
    {!! BootForm::close() !!}

@endsection
