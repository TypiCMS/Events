@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
@endsection

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::form._title-and-slug')
{!! TranslatableBootForm::hidden('status')->value(0) !!}
{!! TranslatableBootForm::checkbox(__('validation.attributes.online'), 'status') !!}

<div class="row">
    <div class="col-sm-6">
        {!! BootForm::text(__('validation.attributes.start_date'), 'start_date')->value(old('start_date') ? : $model->present()->datetimeOrNow('start_date'))->addClass('datetimepicker') !!}
    </div>
    <div class="col-sm-6">
        {!! BootForm::text(__('validation.attributes.end_date'), 'end_date')->value(old('end_date') ? : $model->present()->datetimeOrNow('end_date'))->addClass('datetimepicker') !!}
    </div>
</div>

{!! TranslatableBootForm::text(__('validation.attributes.venue'), 'venue') !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.address'), 'address')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.summary'), 'summary')->rows(4) !!}
{!! TranslatableBootForm::textarea(__('validation.attributes.body'), 'body')->addClass('ckeditor') !!}
