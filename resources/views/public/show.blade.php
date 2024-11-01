@extends('core::public.master')

@section('title', $model->title . ' – ' . __('Events') . ' – ' . $websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('ogImage', $model->present()->ogImage())
@section('bodyClass', 'body-events body-event-' . $model->id . ' body-page body-page-' . $page->id)

@section('content')
    <article class="event">
        <header class="event-header">
            <div class="event-header-container">
                <div class="event-header-navigator">
                    @include('core::public._items-navigator', ['module' => 'Events', 'model' => $model])
                </div>
                <h1 class="event-title">{{ $model->title }}</h1>
                <div class="event-date">{{ $model->present()->dateFromTo }}</div>
                <a class="btn btn-light btn-xs" href="{{ route($lang . '::event-ics', $model->slug) }}">
                    @lang('Add to calendar')
                </a>
                <div class="event-location">
                    <span class="event-venue">{{ $model->venue }}</span>
                    <div class="event-address">{!! nl2br($model->address) !!}</div>
                </div>
                @if(!empty($model->url))
                    <div class="event-url">
                        <a href="{{ $model->url }}" target="_blank" rel="noopener noreferrer">
                            {{ parse_url($model->url, PHP_URL_HOST) }}
                        </a>
                    </div>
                @endif

                @if ($model->registration_form && $model->end_date >= date('Y-m-d'))
                    <div class="event-register">
                        <a class="btn btn-sm btn-success" href="{{ Route::has($lang . '::event-registration') ? route($lang . '::event-registration', ['slug' => $model->slug]) : '/' }}">
                            @lang('Register')
                        </a>
                    </div>
                @endif
            </div>
        </header>
        <div class="event-body">
            @include('events::public._json-ld', ['event' => $model])
            @if(!empty($model->summary))
                <p class="event-summary">{!! nl2br($model->summary) !!}</p>
            @endif

            @include('core::public._share-links')
            @if(!empty($model->image))
                <figure class="event-picture">
                    <img class="event-picture-image" src="{{ $model->present()->image(2000) }}" width="{{ $model->image->width }}" height="{{ $model->image->height }}" alt="" />
                    @if(!empty($model->image->description))
                        <figcaption class="event-picture-legend">{{ $model->image->description }}</figcaption>
                    @endif
                </figure>
            @endif

            @if(!empty($model->body))
                <div class="rich-content">{!! $model->present()->body !!}</div>
            @endif

            @include('files::public._document-list')
            @include('files::public._image-list')
        </div>
    </article>
@endsection
