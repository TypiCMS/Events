<ul class="event-list-list">
    @foreach ($items as $event)
        @include('events::public._list-item')
    @endforeach
</ul>
