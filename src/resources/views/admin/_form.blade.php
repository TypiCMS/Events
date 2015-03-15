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
        <div class="form-group">
            <label class="control-label" for="start_date">@lang('validation.attributes.start_date')</label>
            <input class="form-control" type="datetime-local" name="start_date" value="{{ Input::old('start_date', $model->present()->datetimeOrNow('start_date')) }}" id="start_date">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label" for="end_date">@lang('validation.attributes.end_date')</label>
            <input class="form-control" type="datetime-local" name="end_date" value="{{ Input::old('end_date', $model->present()->datetimeOrNow('end_date')) }}" id="end_date">
        </div>
    </div>
</div>

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::form._title-and-slug')
        <input type="hidden" name="{{ $lang }}[status]" value="0">
        {!! BootForm::checkbox(trans('validation.attributes.online'), $lang.'[status]') !!}
        {!! BootForm::textarea(trans('validation.attributes.summary'), $lang.'[summary]')->rows(4) !!}
        {!! BootForm::textarea(trans('validation.attributes.body'), $lang.'[body]')->addClass('ckeditor') !!}
    </div>

    @endforeach

</div>
