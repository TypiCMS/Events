<ul class="list-events">
    @foreach ($items as $event)
    @include('events::public._list-item')
    @endforeach
</ul>
