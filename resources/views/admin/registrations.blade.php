@extends('core::admin.master')

@section('title', 'Registrations > '.$event->title)

@section('content')

<item-list
    url-base="/api/events/{{ $event->id }}/registrations"
    locale="{{ config('typicms.content_locale') }}"
    fields="id,event_id,created_at,first_name,last_name,email,locale,number_of_people,message"
    table="registrations"
    title="registrations"
    :show-title="false"
    :exportable="true"
    :publishable="false"
    :multilingual="false"
    :searchable="['created_at,first_name,last_name,email,locale,number_of_people,message']"
    :sorting="['-created_at']">

    <template slot="back-button">
        @include('core::admin._button-back', ['url' => $event->indexUrl(), 'title' => __('Events')])
    </template>

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="checkbox"></item-list-column-header>
        <item-list-column-header name="edit"></item-list-column-header>
        <item-list-column-header name="created_at" sortable :sort-array="sortArray" :label="$t('Date')"></item-list-column-header>
        <item-list-column-header name="number_of_people" sortable :sort-array="sortArray" :label="$t('# people')"></item-list-column-header>
        <item-list-column-header name="first_name" sortable :sort-array="sortArray" :label="$t('First name')"></item-list-column-header>
        <item-list-column-header name="last_name" sortable :sort-array="sortArray" :label="$t('Last name')"></item-list-column-header>
        <item-list-column-header name="email" sortable :sort-array="sortArray" :label="$t('Email')"></item-list-column-header>
        <item-list-column-header name="locale" sortable :sort-array="sortArray" :label="$t('Lang')"></item-list-column-header>
        <item-list-column-header name="message" sortable :sort-array="sortArray" :label="$t('Message')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td class="checkbox"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>
        <td>
            @can ('update-registration')
            <a class="btn btn-secondary btn-xs" :href="'/admin/events/'+model.event_id+'/registrations/'+model.id+'/edit'">@lang('Edit')</a>
            @endcan
        </td>
        <td><small class="text-muted text-norap">@{{ model.created_at | datetime }}</small></td>
        <td>@{{ model.number_of_people }}</td>
        <td>@{{ model.first_name }}</td>
        <td>@{{ model.last_name }}</td>
        <td><a :href="'mailto:'+model.email">@{{ model.email }}</a></td>
        <td><span class="badge bg-secondary text-body">@{{ model.locale.toUpperCase() }}</span></td>
        <td>@{{ model.message }}</td>
    </template>

</item-list>

@endsection
