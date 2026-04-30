<x-core::layouts.admin :title="__('New event')">
    {!! BootForm::open()->action(route('admin::index-events'))->addClass('form') !!}
    @include('admin::events._form')
    {!! BootForm::close() !!}
</x-core::layouts.admin>
