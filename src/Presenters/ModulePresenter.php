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
        $showYear = false;
        if ($startDate->format('Y') !== date('Y') || $endDate->format('Y') !== date('Y')) {
            $showYear = true;
        }
        $startDateFormat = $format . ($showYear ? ' YYYY' : '');
        $endDateFormat = $format . ($showYear ? ' YYYY' : '');
        if ($startDate->eq($endDate)) {
            return $startDate->isoFormat($startDateFormat);
        }
        if ($startDate->format('Y') === $endDate->format('Y')) {
            $startDateFormat = $format;
            if ($startDate->format('m') === $endDate->format('m')) {
                $startDateFormat = 'D';
            }
        }

        $dateFromTo = $startDate->isoFormat($startDateFormat);
        $dateFromTo .= ' → ';
        $dateFromTo .= $endDate->isoFormat($endDateFormat);

        return $dateFromTo;
    }
}
