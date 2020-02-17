@extends('core::public.master')

@section('title', $model->title.' – '.__('Events').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-events body-event-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Events', 'model' => $model])

    @include('events::public._json-ld', ['event' => $model])

    <article class="event">
        <h1 class="event-title">{{ $model->title }}</h1>
        <div class="event-date">{!! $model->present()->dateFromTo !!} <br>{!! $model->present()->timeFromTo !!}</div>
        <div class="event-location">
            <span class="event-venue">{{ $model->venue }}</span>
            <div class="event-address">{!! nl2br($model->address) !!}</div>
        </div>
        @empty(!$model->summary)
        <p class="event-summary">{!! nl2br($model->summary) !!}</p>
        @endempty
        @empty(!$model->url)
        <div class="event-url"><a href="{{ $model->url }}" target="_blank" rel="noopener noreferrer">{{ parse_url($model->url, PHP_URL_HOST) }}</a></div>
        @endempty
        <a class="btn btn-light btn-xs" href="{{ route($lang.'::event-ics', $model->slug) }}">
            <span class="fa fa-calendar"></span> @lang('db.Add to calendar')
        </a>
        @empty(!$model->body)
        <div class="event-body">{!! $model->present()->body !!}</div>
        @endempty
        @empty(!$model->image)
        <img class="event-image" src="{!! $model->present()->image(null, 1000) !!}" alt="">
        @endempty
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
