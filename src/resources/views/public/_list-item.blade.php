<li class="event" itemscope itemtype="http://schema.org/Event">
    <a href="{{ route($lang . '.events.slug', $event->slug) }}" itemprop="url">
        <meta itemprop="startDate" content="{{ $event->start_date->toIso8601String() }}">
        <meta itemprop="endDate" content="{{ $event->end_date->toIso8601String() }}">
        <meta itemprop="image" content="{{ $event->present()->thumbAbsoluteSrc() }}">
        <div class="event-image">
            {!! $event->present()->thumb(540, 400) !!}
        </div>
        <div class="event-info">
            <div class="event-date">{!! $event->present()->dateFromTo !!}</div>
            <div class="event-title" itemprop="name">{{ $event->title }}</div>
            <div class="event-venue" itemprop="location">
                <span itemprop="name">{{ $event->location }}</span>
                <div class="address" itemprop="address">{{ nl2br($event->address) }}</div>
            </div>
            <div class="event-summary" itemprop="description">{{ $event->summary }}</div>
        </div>
    </a>
</li>
