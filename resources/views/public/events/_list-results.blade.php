<ul class="event-list-results-list">
    @foreach ($items as $event)
        <li class="event-list-results-item">
            <a class="event-list-results-item-link" href="{{ $event->url() }}">
                <strong><x-core::date-range :start="$event->start_date" :end="$event->end_date" /></strong>
                {{ $event->title }}
            </a>
        </li>
    @endforeach
</ul>
