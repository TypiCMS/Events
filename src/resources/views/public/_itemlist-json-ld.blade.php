<script type="application/ld+json">
{
    "@context":"https://schema.org",
    "@type":"ItemList",
    "itemListElement":[
        @foreach ($items as $item)
        {
            "@type":"ListItem",
            "position":{{ $loop->index+1 }},
            "url":"{{ $item->uri() }}"
        }@if (!$loop->last),@endif
        @endforeach
    ]
}
</script>
