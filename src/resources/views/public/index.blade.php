@extends('pages::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._files', ['model' => $page])

    @includeWhen($models->count() > 0, 'events::public._list', ['items' => $models])

    {!! $models->appends(Request::except('page'))->links() !!}

@endsection
