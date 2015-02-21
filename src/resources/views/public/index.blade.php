@extends('core::public.master')

@section('title', trans('events::global.name') . ' – ' . $websiteTitle)
@section('ogTitle', trans('events::global.name'))
@section('bodyClass', 'body-events')

@section('main')

    <h2>@lang('events::global.name')</h2>

    @if ($models->count())
    <ul>
        @foreach ($models as $model)
        <li>
            <strong>{{ $model->title }}</strong>
            <div class="date">{!! $model->present()->dateFromTo !!} <br>{!! $model->present()->timeFromTo !!}</div>
            <a href="{{ route($lang.'.events.slug', $model->slug) }}">@lang('db.More')</a>
            <a class="btn btn-default btn-xs" href="{{ route($lang.'.events.slug.ics', $model->slug) }}">
                <span class="fa fa-calendar"></span> @lang('db.Add to calendar')
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    {!! $models->appends(Input::except('page'))->render() !!}

@stop
