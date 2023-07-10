@extends('pages::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-' . $page->id)
@section('page-header', '')

@section('page')
    <header class="page-header">
        <div class="page-header-container">
            <h1>@lang('Past events')</h1>
        </div>
    </header>

    <div class="page-body">
        <div class="page-body-container">
            @includeWhen($models->count() > 0, 'events::public._list', ['items' => $models])

            {!! $models->appends(Request::except('page'))->links() !!}

            <div class="text-center">
                <a href="{{ route($lang . '::index-events') }}" class="btn btn-light">@lang('Upcoming events')</a>
            </div>
        </div>
    </div>
@endsection
