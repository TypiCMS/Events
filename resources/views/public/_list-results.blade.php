<ul class="event-list-results-list">
    @foreach ($items as $event)
        <li class="event-list-results-item">
            <a class="event-list-results-item-link" href="{{ $event->uri() }}">
                <strong>{{ $event->present()->dateFromTo }}</strong>
                {{ $event->title }}
            </a>
        </li>
    @endforeach
</ul>
