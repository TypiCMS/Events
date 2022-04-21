<?php

namespace TypiCMS\Modules\Events\Presenters;

use TypiCMS\Modules\Core\Presenters\Presenter;

class RegistrationPresenter extends Presenter
{
    /**
     * Format creation date.
     */
    public function createdAt(): string
    {
        return $this->entity->created_at->format('d.m.Y');
    }

    /**
     * Get title by concatenate title, first_name and last_name.
     */
    public function title(): string
    {
        return __('Reservation of').' '.$this->entity->first_name.' '.$this->entity->last_name;
    }
}
