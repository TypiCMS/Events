<div class="header">
    @include('core::admin._button-back', ['module' => 'registrations', 'url' => route('admin::index-registrations', $event->id)])
    <h1 class="header-title @if (!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('Untitled') }}
    </h1>
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">

    @include('core::admin._form-errors')

    {!! BootForm::text(__('Event'), 'event')->value($model->event->title)->readOnly() !!}
    {!! Bootform::number(__('Number of people'), 'number_of_people')->min(1)->required() !!}
    {!! Bootform::textarea(__('Message'), 'message')->rows(3) !!}
    {!! BootForm::hidden('my_time')->value(Crypt::encrypt(time()-60)) !!}

</div>
