@extends('pages::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-'.$page->id)

@section('content')

    {!! $page->present()->body !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('events::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'events::public._list', ['items' => $models])

    {!! $models->appends(Request::except('page'))->links() !!}

    <div class="text-center">
        <a href="{{ route($lang.'::past-events') }}" class="btn btn-light">@lang('Past events')</a>
    </div>

@endsection
