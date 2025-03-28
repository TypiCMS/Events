<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Event",
    "location": {
        "@type": "Place",
        "name": "{{ $event->venue }}",
        "address": "{{ $event->address }}"
    },
    "name": "{{ $event->title }}",
    "startDate": "{{ $event->start_date->format('c') }}",
    "endDate": "{{ $event->end_date->format('c') }}",
    "description": "{{ $event->summary !== '' ? $event->summary : strip_tags($event->body) }}",
    "image": [
        "{{ $event->present()->image() }}"
    ],
    @if(!empty($event->website))
        "url": "{{ $event->website }}",
    @endif
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $event->url() }}"
    }
}
</script>
