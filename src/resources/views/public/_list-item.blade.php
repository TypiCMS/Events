<li class="event">
    <a href="{{ route($lang . '.events.slug', $event->slug) }}">
        <div class="event-image">
            {!! $event->present()->thumb(540, 400) !!}
        </div>
        <div class="event-info">
            <div class="event-title">{{ $event->title }}</div>
            <div class="event-price">{{ $event->price }} {{ $event->currency }}</div>
            <div class="event-location">{{ $event->location }}</div>
            <div class="event-summary">{{ $event->summary }}</div>
            <div class="event-date">{!! $event->present()->dateFromTo !!}</div>
        </div>
    </a>
</li>
