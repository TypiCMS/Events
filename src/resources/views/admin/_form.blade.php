@section('js')
    <script src="{{ asset('components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<div class="row">
    <div class="col-sm-4">
        {!! BootForm::date(trans('validation.attributes.start_date'), 'start_date')->value($model->present()->dateOrNow('start_date'))->placeholder(trans('validation.attributes.DDMMYYYY'))->addClass('datepicker') !!}
    </div>
    <div class="col-sm-3">
        {!! BootForm::text(trans('validation.attributes.start_time'), 'start_time')->placeholder(trans('validation.attributes.HH:MM'))->addClass('timepicker') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        {!! BootForm::date(trans('validation.attributes.end_date'), 'end_date')->value($model->present()->dateOrNow('end_date'))->placeholder(trans('validation.attributes.DDMMYYYY'))->addClass('datepicker') !!}
    </div>
    <div class="col-sm-3">
        {!! BootForm::text(trans('validation.attributes.end_time'), 'end_time')->placeholder(trans('validation.attributes.HH:MM'))->addClass('timepicker') !!}
    </div>
</div>

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::form._title-and-slug')
        {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
        {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
        {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
    </div>

    @endforeach

</div>
