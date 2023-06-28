<li class="event-list-item">
    <a class="event-list-item-link" href="{{ $event->uri() }}">
        <div class="event-list-item-image-wrapper">
            @empty(! $event->image)
                <img class="event-list-item-image" src="{{ $event->present()->image(600, 400) }}" width="300" height="200" alt="{{ $event->image->alt_attribute }}" />
            @endempty
        </div>
        <div class="event-list-item-info">
            <div class="event-list-item-date">{{ $event->present()->dateFromTo }}</div>
            <div class="event-list-item-title">{{ $event->title }}</div>
            <div class="event-list-item-location">
                <span class="event-list-item-venue">{{ $event->venue }}</span>
                <div class="event-list-item-address">{!! nl2br($event->address) !!}</div>
            </div>
            @empty(! $event->summary)
                <div class="event-list-item-summary">{{ $event->summary }}</div>
            @endempty

            @empty(! $event->url)
                <div class="event-list-item-url">
                    <a href="{{ $event->url }}" target="_blank" rel="noopener noreferrer">
                        {{ parse_url($event->url, PHP_URL_HOST) }}
                    </a>
                </div>
            @endempty
        </div>
    </a>
</li>
