@component('mail::message')
# @lang('Dear'),

@lang('Thank you for your registration to') “[{{ $event->title }}]({{ route(app()->getLocale().'::event', $event->slug) }})”.

@component('mail::table')
|                               |                    |
| ----------------------------- | ------------------ |
| **@lang('Name')**             | {{ $registration->first_name }} {{ $registration->last_name }}
| **@lang('Number of people')** | {{ $registration->number_of_people }}
| **@lang('Message')**          | {{ $registration->message }}
@endcomponent

@lang('If you have any questions leading up to the event, feel free to reply to') {{ config('typicms.webmaster_email') }}

@lang('We look forward to seeing you on:') {{ $event->present()->dateFromTo }}.

{{ config('app.name') }}
@endcomponent
