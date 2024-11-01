<li class="event-list-item">
    <a class="event-list-item-link" href="{{ $event->uri() }}">
        <div class="event-list-item-image-wrapper">
            <img class="event-list-item-image" src="{{ $event->present()->image(800, 600) }}" width="400" height="300" alt="{{ $event->image?->alt_attribute }}" />
        </div>
        <div class="event-list-item-info">
            <div class="event-list-item-date">{{ $event->present()->dateFromTo }}</div>
            <div class="event-list-item-title">{{ $event->title }}</div>
            <div class="event-list-item-location">
                <span class="event-list-item-venue">{{ $event->venue }}</span>
                <div class="event-list-item-address">{!! nl2br($event->address) !!}</div>
            </div>
            @if(!empty($event->summary))
                <div class="event-list-item-summary">{{ $event->summary }}</div>
            @endif

            @if(!empty($event->url))
                <div class="event-list-item-url">
                    <a href="{{ $event->url }}" target="_blank" rel="noopener noreferrer">
                        {{ parse_url($event->url, PHP_URL_HOST) }}
                    </a>
                </div>
            @endif
        </div>
    </a>
</li>
