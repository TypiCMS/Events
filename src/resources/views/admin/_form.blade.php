@push('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<filepicker related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></filepicker>
<file-field type="image" field="image_id" data="{{ $model->image }}"></file-field>
<files related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></files>

@include('core::form._title-and-slug')
<div class="form-group">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::date(__('Start date'), 'start_date')->type('datetime-local')->value(old('start_date') ? : $model->present()->datetimeOrNow('start_date'))->required() !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::date(__('End date'), 'end_date')->type('datetime-local')->value(old('end_date') ? : $model->present()->datetimeOrNow('end_date'))->required() !!}
    </div>
</div>

{!! TranslatableBootForm::text(__('Venue'), 'venue') !!}
{!! TranslatableBootForm::textarea(__('Address'), 'address')->rows(3) !!}
{!! TranslatableBootForm::text(__('URL'), 'url')->type('url') !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
