@push('js')
    <script type="module" src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script type="module" src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

<div class="header">
    @include('core::admin._button-back', ['url' => $model->indexUrl(), 'title' => __('Events')])
    @include('core::admin._title', ['default' => __('New event')])
    @component('core::admin._buttons-form', ['model' => $model])
    @endcomponent
</div>

<div class="content">
    @include('core::admin._form-errors')

    <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
    <file-field type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
    <file-field type="image" field="og_image_id" :init-file="{{ $model->ogImage ?? 'null' }}" label="Open Graph image"></file-field>
    <files-field :init-files="{{ $model->files }}"></files-field>

    @include('core::form._title-and-slug')
    <div class="mb-3">
        {!! TranslatableBootForm::hidden('status')->value(0) !!}
        {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        {!! BootForm::hidden('registration_form')->value(0) !!}
        {!! BootForm::checkbox(__('Registration form'), 'registration_form') !!}
    </div>

    <div class="row gx-3">
        <div class="col-sm-6">
            {!! BootForm::date(__('Start date'), 'start_date')->value(old('start_date') ?: $model->present()->dateOrNow('start_date'))->required() !!}
        </div>
        <div class="col-sm-6">
            {!! BootForm::date(__('End date'), 'end_date')->value(old('end_date') ?: $model->present()->dateOrNow('end_date'))->required() !!}
        </div>
    </div>

    {!! TranslatableBootForm::text(__('Venue'), 'venue') !!}
    {!! TranslatableBootForm::textarea(__('Address'), 'address')->rows(3) !!}
    {!! TranslatableBootForm::text(__('Website'), 'website')->type('url')->placeholder('https://') !!}
    {!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
    {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
</div>
