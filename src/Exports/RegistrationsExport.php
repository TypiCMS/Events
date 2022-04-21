<?php

namespace TypiCMS\Modules\Events\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Events\Filters\FilterRegistrations;
use TypiCMS\Modules\Events\Models\Event;
use TypiCMS\Modules\Events\Models\Registration;

class RegistrationsExport implements ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Registration::class)
            ->selectFields($request->input('fields.registrations'))
            ->allowedSorts(['created_at', 'first_name', 'last_name', 'email', 'locale', 'number_of_people', 'message'])
            ->where('event_id', $request->route()->parameter('event')->id)
            ->allowedFilters([
                AllowedFilter::custom('created_at,first_name,last_name,email,locale,number_of_people,message', new FilterRegistrations()),
            ])
            ->addSelect([
                'event_name' => Event::select(column('title'))
                    ->whereColumn('event_id', 'events.id')
                    ->limit(1),
            ])
            ->get();
    }

    public function map($registration): array
    {
        return [
            $registration->created_at,
            $registration->event_name,
            $registration->number_of_people,
            $registration->first_name,
            $registration->last_name,
            $registration->email,
            $registration->locale,
            $registration->message,
        ];
    }

    public function headings(): array
    {
        return [
            __('Date'),
            __('Event'),
            __('Number of people'),
            __('First name'),
            __('Last name'),
            __('Email'),
            __('Language'),
            __('Message'),
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
