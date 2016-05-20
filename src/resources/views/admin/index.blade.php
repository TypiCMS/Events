@extends('core::admin.master')

@section('title', trans('events::global.name'))

@section('main')

<div id="table">

    <script>
    var columns = ['id', 'status', 'thumb', 'start_date', 'end_date', 'title'];
    var options = {
        sortable: ['status', 'date', 'title'],
        headings: {},
        orderBy: {
            column: 'date',
            ascending: false
        }
    };
    </script>

    @include('core::admin._table-config')

    @include('core::admin._button-create', ['module' => 'events'])

    <h1>@lang('events::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">
        @include('core::admin._v-server-table', ['url' => route('api::index-events')])
        {{-- For client side filtering: --}}
        {{-- @include('core::admin._v-client-table', ['data' => Events::allFiltered(config('typicms.events.select'))]) --}}
    </div>

</div>

@endsection
