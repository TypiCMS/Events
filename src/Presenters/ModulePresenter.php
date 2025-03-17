<?php

namespace TypiCMS\Modules\Events\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    /**
     * Format start and end date without repeating
     * month and year if they are the same.
     */
    public function dateFromTo(string $format = 'D MMMM'): string
    {
        $startDate = $this->entity->start_date;
        $endDate = $this->entity->end_date;

        if ($startDate->eq($endDate)) {
            return $startDate->isoFormat($format . ' YYYY');
        }

        $showYear = $startDate->format('Y') !== date('Y') || $endDate->format('Y') !== date('Y');
        $startFormat = $format . ($showYear ? ' YYYY' : '');
        $endFormat = $format . ' YYYY';

        if ($startDate->format('Y') === $endDate->format('Y')) {
            $startFormat = $format;
            if ($startDate->format('m') === $endDate->format('m')) {
                $startFormat = 'D';
            }
        }

        return $startDate->isoFormat($startFormat) . ' → ' . $endDate->isoFormat($endFormat);
    }
}
