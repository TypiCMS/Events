@extends('core::public.master')

@section('title', $model->title.' – '.__('Events').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image(1200, 630))
@section('bodyClass', 'body-events body-event-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

<article class="place">
    <header class="place-header">
        <div class="place-header-container">
            <div class="place-header-navigator">
                @include('core::public._items-navigator', ['module' => 'Events', 'model' => $model])
            </div>
            <h1 class="event-title">{{ $model->title }}</h1>
            <div class="event-date">{!! $model->present()->dateFromTo !!} <br>{!! $model->present()->timeFromTo !!}</div>
            <a class="btn btn-light btn-xs" href="{{ route($lang.'::event-ics', $model->slug) }}">
                <span class="fa fa-calendar"></span> @lang('Add to calendar')
            </a>
            <div class="event-location">
                <span class="event-venue">{{ $model->venue }}</span>
                <div class="event-address">{!! nl2br($model->address) !!}</div>
            </div>
            @empty(!$model->url)
            <div class="event-url"><a href="{{ $model->url }}" target="_blank" rel="noopener noreferrer">{{ parse_url($model->url, PHP_URL_HOST) }}</a></div>
            @endempty
        </div>
    </header>
    <div class="event-body">
        @include('events::public._json-ld', ['event' => $model])
        @empty(!$model->summary)
        <p class="event-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @include('events::public._social-links')
        @empty(!$model->image)
        <picture class="event-picture">
            <img class="event-picture-image" src="{!! $model->present()->image(2000, 1000) !!}" alt="">
            @empty(!$model->image->description)
            <legend class="event-picture-legend">{{ $model->image->description }}</legend>
            @endempty
        </picture>
        @endempty
        @empty(!$model->body)
        <div class="rich-content">{!! $model->present()->body !!}</div>
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </div>
</article>

@endsection
