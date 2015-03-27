<li>
    <a href="{{ route($lang . '.events.slug', $event->slug) }}">
        {!! $event->present()->thumb(540, 400) !!}
        <div class="list-news-info">
            <div class="title">{{ $event->title }}</div>
            <div class="summary">{{ $event->summary }}</div>
            <div class="date">{!! $event->present()->dateFromTo !!}</div>
        </div>
    </a>
</li>
