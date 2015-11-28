<ul class="events-list">
    @foreach ($items as $event)
    @include('events::public._list-item')
    @endforeach
</ul>
