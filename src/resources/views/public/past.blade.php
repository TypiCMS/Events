@extends('core::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-'.$page->id)

@section('content')

    <div class="container-fluid">

        <h1>@lang('Past events')</h1>

        @includeWhen($models->count() > 0, 'events::public._list', ['items' => $models])

        {!! $models->appends(Request::except('page'))->links() !!}

        <div class="text-center">
            <a href="{{ route($lang.'::index-events') }}" class="btn btn-light">Upcoming events</a>
        </div>

    </div>

@endsection
