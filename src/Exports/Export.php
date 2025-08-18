<?php

namespace TypiCMS\Modules\Events\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Events\Models\Event;

/**
 * @implements WithMapping<mixed>
 */
class Export implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    /** @return Collection<int, Event> */
    public function collection(): Collection
    {
        return QueryBuilder::for(Event::class)
            ->allowedSorts(['status_translated', 'start_date', 'end_date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    /** @return array<int, mixed> */
    public function map(mixed $row): array
    {
        return [
            Date::dateTimeToExcel($row->created_at),
            Date::dateTimeToExcel($row->updated_at),
            $row->status,
            Date::dateTimeToExcel($row->start_date),
            Date::dateTimeToExcel($row->end_date),
            $row->venue,
            $row->address,
            $row->website,
            $row->title,
            $row->summary,
            $row->body,
        ];
    }

    /** @return string[] */
    public function headings(): array
    {
        return [
            __('Created at'),
            __('Updated at'),
            __('Published'),
            __('Start date'),
            __('End date'),
            __('Venue'),
            __('Address'),
            __('Website'),
            __('Title'),
            __('Summary'),
            __('Body'),
        ];
    }

    /** @return array<string, string> */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'D' => NumberFormat::FORMAT_DATE_DMYSLASH,
            'E' => NumberFormat::FORMAT_DATE_DMYSLASH,
        ];
    }
}
