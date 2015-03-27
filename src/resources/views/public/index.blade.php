@extends('core::public.master')

@section('title', trans('events::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('events::global.name'))
@section('bodyClass', 'body-events')

@section('main')

    <h1>@lang('events::global.name')</h1>

    @if ($models->count())
    @include('events::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
