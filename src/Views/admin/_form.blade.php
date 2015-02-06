@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

<div class="row">
    <div class="col-sm-4 form-group @if($errors->has('start_date'))has-error @endif">
        {{ Form::label('start_date', trans('validation.attributes.start_date'), array('class' => 'control-label')) }}
        {{ Form::text('start_date', $model->present()->dateOrNow('start_date'), array('class' => 'datepicker form-control', 'data-value' => $model->present()->dateOrNow('start_date'), 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 form-group @if($errors->has('start_time'))has-error @endif">
        {{ Form::label('start_time', trans('validation.attributes.start_time'), array('class' => 'control-label')) }}
        {{ Form::text('start_time', $model->present()->startTime, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
        {!! $errors->first('start_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="row">
    <div class="col-sm-4 form-group @if($errors->has('end_date'))has-error @endif">
        {{ Form::label('end_date', trans('validation.attributes.end_date'), array('class' => 'control-label')) }}
        {{ Form::text('end_date', $model->present()->dateOrNow('end_date'), array('class' => 'datepicker form-control', 'data-value' => $model->present()->dateOrNow('end_date'), 'placeholder' => trans('validation.attributes.DDMMYYYY'))) }}
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="col-sm-3 form-group @if($errors->has('end_time'))has-error @endif">
        {{ Form::label('end_time', trans('validation.attributes.end_time'), array('class' => 'control-label')) }}
        {{ Form::text('end_time', $model->present()->endTime, array('class' => 'form-control', 'placeholder' => trans('validation.attributes.HH:MM'))) }}
        {!! $errors->first('end_time', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        <div class="row">
            <div class="col-md-6 form-group">
                {!! BootForm::text(trans('labels.title'), $lang.'[title]') !!}
            </div>
            <div class="col-md-6 form-group @if($errors->has($lang.'.slug'))has-error @endif">
                {{ Form::label($lang.'[slug]', trans('validation.attributes.slug'), array('class' => 'control-label')) }}
                <div class="input-group">
                    {{ Form::text($lang.'[slug]', $model->translate($lang)->slug, array('class' => 'form-control')) }}
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-slug @if($errors->has($lang.'.slug'))btn-danger @endif" type="button">@lang('validation.attributes.generate')</button>
                    </span>
                </div>
                {!! $errors->first($lang.'.slug', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        {!! BootForm::checkbox(trans('labels.online'), $lang.'[status]') !!}
        {!! BootForm::textarea(trans('labels.summary'), $lang.'[summary]')->addClass('editor')->rows(4) !!}
        {!! BootForm::textarea(trans('labels.body'), $lang.'[body]')->addClass('editor') !!}
    </div>

    @endforeach

</div>
