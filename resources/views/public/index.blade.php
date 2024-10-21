@extends('pages::public.master')

@section('bodyClass', 'body-events body-events-index body-page body-page-' . $page->id)

@section('page')
    @include('events::public._itemlist-json-ld', ['items' => $models])
    <div class="page-body">
        <div class="page-body-container">
            @include('pages::public._main-content', ['page' => $page])
            @include('files::public._document-list', ['model' => $page])
            @include('files::public._image-list', ['model' => $page])
            
            @includeWhen($models->count() > 0, 'events::public._list', ['items' => $models])

            {!! $models->appends(Request::except('page'))->links() !!}

            <div class="text-center">
                <a href="{{ route($lang . '::past-events') }}" class="btn btn-light">@lang('Past events')</a>
            </div>
        </div>
    </div>
@endsection
