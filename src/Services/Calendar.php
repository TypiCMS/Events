<?php

namespace TypiCMS\Modules\Events\Services;

use DateTimeZone as PhpDateTimeZone;
use Eluceo\iCal\Domain\Entity\Calendar as ICalendar;
use Eluceo\iCal\Domain\Entity\Event as IEvent;
use Eluceo\iCal\Domain\Entity\TimeZone;
use Eluceo\iCal\Domain\ValueObject\Date;
use Eluceo\iCal\Domain\ValueObject\DateTime;
use Eluceo\iCal\Domain\ValueObject\Location;
use Eluceo\iCal\Domain\ValueObject\MultiDay;
use Eluceo\iCal\Domain\ValueObject\SingleDay;
use Eluceo\iCal\Domain\ValueObject\TimeSpan;
use Eluceo\iCal\Presentation\Factory\CalendarFactory;
use Illuminate\Support\Carbon;
use TypiCMS\Modules\Events\Models\Event;

class Calendar
{
    protected $iCalendar;

    public function __construct(ICalendar $iCalendar)
    {
        $this->iCalendar = $iCalendar;
    }

    /**
     * Add an event to the calendar.
     */
    public function add(Event $model): void
    {
        if (!empty($model->start_time) && !empty($model->end_time)) {
            $start = new DateTime(Carbon::createFromFormat('Y-m-d H:i:s', $model->start_date . ' ' . $model->start_time . ':00'), false);
            $end = new DateTime(Carbon::createFromFormat('Y-m-d H:i:s', $model->end_date . ' ' . $model->end_time . ':00'), false);
            $occurrence = new TimeSpan($start, $end);
        } elseif ($model->start_date === $model->end_date) {
            $date = new Date(Carbon::createFromFormat('Y-m-d', $model->start_date));
            $occurrence = new SingleDay($date);
        } else {
            $firstDay = new Date($model->start_date);
            $lastDay = new Date($model->end_date);
            $occurrence = new MultiDay($firstDay, $lastDay);
        }
        // fill event
        $iEvent = new IEvent();
        $iEvent->setOccurrence($occurrence)
            ->setSummary($model->title)
            ->setDescription($model->summary)
            ->setLocation(new Location($model->address, $model->venue));
        // add it to the calendar
        $this->iCalendar->addEvent($iEvent);
        // $this->iCalendar->addTimeZone(TimeZone::createFromPhpDateTimeZone(new PhpDateTimeZone(config('app.timezone'))));
    }

    /**
     * Render .ics content.
     */
    public function render(): string
    {
        return (new CalendarFactory())->createCalendar($this->iCalendar);
    }
}
