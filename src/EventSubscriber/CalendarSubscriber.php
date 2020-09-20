<?php


namespace App\EventSubscriber;
use App\Repository\SeanceRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{

    private $seanceRepository;
    private $router;

    public function __construct(
        SeanceRepository $seanceRepository,
        UrlGeneratorInterface $router
    ) {
        $this->seanceRepository = $seanceRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $seances = $this->seanceRepository
            ->createQueryBuilder('seance')
            ->where('seance.h_debut BETWEEN :start and :end OR seance.h_fin BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($seances as $seance) {
            // this create the events with your data (here booking data) to fill calendar
            $seanceEvent = new Event(
                $seance->getTitle(),
                $seance->getBeginAt(),
                $seance->getEndAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $seanceEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $seanceEvent->addOption(
                'url',
                $this->router->generate('seance_show', [
                    'id' => $seance->getIdSeance(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($seanceEvent);
        }
    }
}