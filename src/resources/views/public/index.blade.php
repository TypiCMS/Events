@extends('core::public.master')

@section('title', trans('events::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('events::global.name'))
@section('bodyClass', 'body-events')

@section('main')

    <h2>@lang('events::global.name')</h2>

    @if ($models->count())
    @include('events::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
