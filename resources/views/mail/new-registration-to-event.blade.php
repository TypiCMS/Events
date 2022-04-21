@component('mail::message')
# @lang('New registration to an event')

@lang('A new registration to') [{{ $event->title }}]({{ route(app()->getLocale().'::event', $event->slug) }}) @lang('was requested by') {{ $registration->title }} {{ $registration->first_name }} {{ $registration->last_name }}.

@component('mail::table')
|                                |                    |
| ------------------------------ | ------------------ |
| **@lang('Event')**             | [{{ $event->title }}]({{ route(app()->getLocale().'::event', $event->slug) }})
| **@lang('Name')**              | {{ $registration->first_name }} {{ $registration->last_name }}
| **@lang('Email')**             | [{{ $registration->email }}](mailto:{{ $registration->email }})
| **@lang('Number of people')**  | {{ $registration->number_of_people }}
| **@lang('Message')**           | {{ $registration->message }}
@endcomponent

@component('mail::button', ['url' => route('admin::edit-registration', [$event->id, $registration->id])])
@lang('See online')
@endcomponent

{{ config('app.name') }}
@endcomponent
