<div class="header">
    <x-core::back-button :url="route('admin::index-registrations', $event->id)" />
    <h1 class="header-title @if (!$model->presentTitle()) text-muted @endif">
        {{ $model->presentTitle() ?: __('Untitled') }}
    </h1>
    <x-core::form-buttons :$model />
</div>

<div class="content">
    <x-core::form-errors />

    {!! BootForm::text(__('Event'), 'event')->value($model->event->title)->readOnly() !!}
    {!! Bootform::number(__('Number of people'), 'number_of_people')->min(1)->required() !!}
    {!! Bootform::textarea(__('Message'), 'message')->rows(3) !!}
</div>
