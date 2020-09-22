@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
<file-field type="image" field="image_id" :init-file="{{ $model->image }}"></file-field>
<files-field :init-files="{{ $model->files }}"></files-field>

@include('core::form._title-and-slug')
<div class="form-group">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>

<div class="form-row">
    <div class="col-sm-6">
        {!! BootForm::date(__('Start date'), 'start_date')->value(old('start_date') ? : $model->present()->dateOrNow('start_date'))->required() !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::date(__('End date'), 'end_date')->value(old('end_date') ? : $model->present()->dateOrNow('end_date'))->required() !!}
    </div>
</div>

{!! TranslatableBootForm::text(__('Venue'), 'venue') !!}
{!! TranslatableBootForm::textarea(__('Address'), 'address')->rows(3) !!}
{!! TranslatableBootForm::text(__('Website'), 'website')->type('url')->placeholder('https://') !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
