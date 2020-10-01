<?php

namespace TypiCMS\Modules\Events\Exports;

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

class Export implements WithColumnFormatting, ShouldAutoSize, FromCollection, WithHeadings, WithMapping
{
    protected $collection;

    public function __construct($request)
    {
        $this->collection = QueryBuilder::for(Event::class)
            ->selectFields('created_at,updated_at,status,start_date,end_date,venue,address,website,title,summary,body')
            ->allowedSorts(['status_translated', 'start_date', 'end_date', 'title_translated'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->get();
    }

    public function map($model): array
    {
        return [
            Date::dateTimeToExcel($model->created_at),
            Date::dateTimeToExcel($model->updated_at),
            $model->status_translated,
            Date::dateTimeToExcel($model->start_date),
            Date::dateTimeToExcel($model->end_date),
            $model->venue_translated,
            $model->address_translated,
            $model->website_translated,
            $model->title_translated,
            $model->summary_translated,
            $model->body_translated,
        ];
    }

    public function headings(): array
    {
        return [
            'created_at',
            'updated_at',
            'published',
            'start_date',
            'end_date',
            'venue',
            'address',
            'website',
            'title',
            'summary',
            'body',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DATETIME,
            'B' => NumberFormat::FORMAT_DATE_DATETIME,
            'D' => NumberFormat::FORMAT_DATE_DMYSLASH,
            'E' => NumberFormat::FORMAT_DATE_DMYSLASH,
        ];
    }

    public function collection()
    {
        return $this->collection;
    }
}
