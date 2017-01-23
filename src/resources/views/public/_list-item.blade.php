<li class="events-item" itemscope itemtype="http://schema.org/Event">
    <a href="{{ route($lang.'::event', $event->slug) }}" itemprop="url">
        <meta itemprop="startDate" content="{{ $event->start_date->toIso8601String() }}">
        <meta itemprop="endDate" content="{{ $event->end_date->toIso8601String() }}">
        <meta itemprop="image" content="{{ $event->present()->thumbUrl() }}">
        <div class="events-item-image">
            {!! $event->present()->thumb(540, 400) !!}
        </div>
        <div class="events-item-info">
            <div class="events-item-date">{!! $event->present()->dateFromTo !!}</div>
            <div class="events-item-title" itemprop="name">{{ $event->title }}</div>
            <div class="events-item-location" itemprop="location">
                <span itemprop="name">{{ $event->venue }}</span>
                <div class="address" itemprop="address">{{ nl2br($event->address) }}</div>
            </div>
            <div class="events-item-summary" itemprop="description">{{ $event->summary }}</div>
        </div>
    </a>
</li>
