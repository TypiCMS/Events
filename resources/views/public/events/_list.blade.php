<ul class="event-list-list">
    @foreach ($items as $event)
        @include('public::events._list-item')
    @endforeach
</ul>
