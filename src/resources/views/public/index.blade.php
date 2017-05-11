@extends('pages::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    @if ($models->count())
    @include('events::public._list', ['items' => $models])
    @endif

    {!! $models->appends(Request::except('page'))->links() !!}

@endsection
