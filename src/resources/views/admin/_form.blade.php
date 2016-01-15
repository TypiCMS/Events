@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(trans('validation.attributes.online'), 'status') !!}

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(trans('validation.attributes.start_date'), 'start_date')->value(old('start_date') ? : $model->present()->datetimeOrNow('start_date'))->addClass('datetimepicker') !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::text(trans('validation.attributes.end_date'), 'end_date')->value(old('end_date') ? : $model->present()->datetimeOrNow('end_date'))->addClass('datetimepicker') !!}
    </div>
</div>

{!! TranslatableBootForm::text(trans('validation.attributes.venue'), 'venue') !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.address'), 'address')->rows(4) !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(trans('validation.attributes.body'), 'body')->addClass('ckeditor') !!}
