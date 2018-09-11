@push('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

{{-- @include('files::admin._files-selector') --}}

@include('core::form._title-and-slug')
<div class="form-group">
    {!! TranslatableBootForm::hidden('status')->value(0) !!}
    {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
</div>

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(__('Start date'), 'start_date')->value(old('start_date') ? : $model->present()->datetimeOrNow('start_date'))->addClass('datetimepicker')->required() !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::text(__('End date'), 'end_date')->value(old('end_date') ? : $model->present()->datetimeOrNow('end_date'))->addClass('datetimepicker')->required() !!}
    </div>
</div>

{!! TranslatableBootForm::text(__('Venue'), 'venue') !!}
{!! TranslatableBootForm::textarea(__('Address'), 'address')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor') !!}
