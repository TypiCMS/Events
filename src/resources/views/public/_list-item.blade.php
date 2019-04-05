<li class="event-list-item" itemscope itemtype="http://schema.org/Event">
    <a class="event-list-item-link" href="{{ $event->uri() }}" itemprop="url">
        <meta itemprop="startDate" content="{{ $event->start_date->toIso8601String() }}">
        <meta itemprop="endDate" content="{{ $event->end_date->toIso8601String() }}">
        <meta itemprop="image" content="{{ $event->present()->thumbUrl() }}">
        <div class="event-list-item-image">
            {!! $event->present()->thumb(540, 400) !!}
        </div>
        <div class="event-list-item-info">
            <div class="event-list-item-date">{!! $event->present()->dateFromTo !!}</div>
            <div class="event-list-item-title" itemprop="name">{{ $event->title }}</div>
            <div class="event-list-item-location" itemprop="location">
                <span itemprop="name">{{ $event->venue }}</span>
                <div class="address" itemprop="address">{{ nl2br($event->address) }}</div>
            </div>
            <div class="event-list-item-summary" itemprop="description">{{ $event->summary }}</div>
        </div>
    </a>
</li>
