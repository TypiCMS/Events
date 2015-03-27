<li>
    <strong>{{ $event->title }}</strong><br>
    <span class="date">{!! $event->present()->dateFromTo !!}</span><br>
    <a href="{{ route($lang . '.events.slug', $event->slug) }}" class="btn btn-default btn-xs">@lang('db.More')</a>
</li>
