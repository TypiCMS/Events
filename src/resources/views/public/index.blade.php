@extends('pages::public.master')
<?php $page = TypiCMS::getPageLinkedToModule('events') ?>

@section('bodyClass', 'body-events body-events-index body-page body-page-' . $page->id)

@section('main')

    {!! $page->body !!}

    @include('galleries::public._galleries', ['model' => $page])

    @if ($models->count())
    @include('events::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
