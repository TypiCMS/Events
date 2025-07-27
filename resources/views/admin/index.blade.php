@extends('core::admin.master')

@section('title', __('Events'))

@section('content')
    <item-list url-base="/api/events" fields="id,image_id,start_date,end_date,status,title" table="events" title="events" include="image" :exportable="true" :duplicable="false" :searchable="['title']" :sorting="['-end_date']">
        <template #add-button v-if="$can('create events')">
            @include('core::admin._button-create', ['module' => 'events'])
        </template>

        <template #columns="{ sortArray }">
            <item-list-column-header name="checkbox" v-if="$can('update events')||$can('delete events')"></item-list-column-header>
            <item-list-column-header name="edit" v-if="$can('update events')"></item-list-column-header>
            <item-list-column-header name="registrations" v-if="$can('read registrations')"></item-list-column-header>
            <item-list-column-header name="status_translated" sortable :sort-array="sortArray" :label="$t('Status')"></item-list-column-header>
            <item-list-column-header name="image" :label="$t('Image')"></item-list-column-header>
            <item-list-column-header name="start_date" sortable :sort-array="sortArray" :label="$t('Start date')"></item-list-column-header>
            <item-list-column-header name="end_date" sortable :sort-array="sortArray" :label="$t('End date')"></item-list-column-header>
            <item-list-column-header name="title_translated" sortable :sort-array="sortArray" :label="$t('Title')"></item-list-column-header>
        </template>

        <template #table-row="{ model, checkedModels, loading }">
            <td class="checkbox" v-if="$can('update events')||$can('delete events')">
                <item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox>
            </td>
            <td v-if="$can('update events')">
                <item-list-edit-button :url="'/admin/events/' + model.id + '/edit'"></item-list-edit-button>
            </td>
            <td v-if="$can('read registrations')">
                <a class="btn btn-xs btn-secondary text-nowrap" v-if="model.registration_count > 0" :href="'/admin/events/' + model.id + '/registrations'">
                    @{{ $t('# registrations', model.registration_count) }}
                </a>
            </td>
            <td>
                <item-list-status-button :model="model"></item-list-status-button>
            </td>
            <td><img :src="model.thumb" alt="" height="27" /></td>
            <td>@{{ formatDate(model.start_date) }}</td>
            <td>@{{ formatDate(model.end_date) }}</td>
            <td v-html="model.title_translated"></td>
        </template>
    </item-list>
@endsection
