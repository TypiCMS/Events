@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<div class="row">
    <div class="col-sm-4">
        {!! BootForm::text(trans('validation.attributes.start_date'), 'start_date')->value($model->present()->datetimeOrNow('start_date'))->addClass('datetimepicker') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        {!! BootForm::text(trans('validation.attributes.end_date'), 'end_date')->value($model->present()->datetimeOrNow('end_date'))->addClass('datetimepicker') !!}
    </div>
</div>

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::form._title-and-slug')
        <input type="hidden" name="{{ $lang }}[status]" value="0">
        {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
        {!! BootForm::text(trans('validation.attributes.location'), $lang.'[location]') !!}
        {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
        {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
    </div>

    @endforeach

</div>
