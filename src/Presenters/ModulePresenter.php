<?php

namespace TypiCMS\Modules\Events\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class ModulePresenter extends Presenter
{
    private $dateFormat = '%e %B %Y';

    /**
     * Return formatted start_date.
     */
    public function startDate(): string
    {
        return $this->entity->start_date->formatLocalized($this->dateFormat);
    }

    /**
     * Return formatted end_date.
     */
    public function endDate(): string
    {
        return $this->entity->end_date->formatLocalized($this->dateFormat);
    }

    /**
     * Format start and end date without repeating
     * month and year if they are the same.
     */
    public function dateFromTo(): string
    {
        $startDate = $this->entity->start_date;
        $endDate = $this->entity->end_date;
        $startDateFormat = $this->dateFormat;
        if ($startDate->eq($endDate)) {
            return ucfirst(__('on')).' '.
                $startDate->formatLocalized($startDateFormat);
        }
        if ($startDate->format('Y') === $endDate->format('Y')) {
            $startDateFormat = '%e %B';
            if ($startDate->format('m') === $endDate->format('m')) {
                $startDateFormat = '%e';
            }
        }

        $dateFromTo = ucfirst(__('from')).' ';
        $dateFromTo .= $startDate->formatLocalized($startDateFormat);
        $dateFromTo .= ' '.__('to').' ';
        $dateFromTo .= $endDate->formatLocalized($this->dateFormat);

        return $dateFromTo;
    }
}
