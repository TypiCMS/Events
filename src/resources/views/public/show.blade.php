@extends('core::public.master')

@section('title', $model->title.' – '.__('Events').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-events body-event-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Events', 'model' => $model])

    <article class="event" itemscope itemtype="http://schema.org/Event">
        <link itemprop="url" href="{{ route($lang.'::event', $model->slug) }}">
        <meta itemprop="startDate" content="{{ $model->start_date->toIso8601String() }}">
        <meta itemprop="endDate" content="{{ $model->end_date->toIso8601String() }}">
        <meta itemprop="image" content="{{ $model->present()->image() }}">
        <h1 class="event-title" itemprop="name">{{ $model->title }}</h1>
        <div class="event-date">{!! $model->present()->dateFromTo !!} <br>{!! $model->present()->timeFromTo !!}</div>
        <div class="event-location" itemprop="location">
            <span itemprop="name">{{ $model->venue }}</span>
            <div class="address" itemprop="address">{!! nl2br($model->address) !!}</div>
        </div>
        <p class="event-summary" itemprop="description">{!! nl2br($model->summary) !!}</p>
        <a class="btn btn-light btn-xs" href="{{ route($lang.'::event-ics', $model->slug) }}">
            <span class="fa fa-calendar"></span> @lang('db.Add to calendar')
        </a>
        <div class="event-body">{!! $model->present()->body !!}</div>
        <img src="{!! $model->present()->image(2000) !!}" alt="">
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
