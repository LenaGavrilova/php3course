<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar/{month}", name="calendar_default")
     */
    public function default($month): Response
    {
        $currentMonth = date('n');

        if ($month) {
            $currentMonth = $month;
        }

        $calendar = $this->generateCalendarData($currentMonth);
        $name = $this->getMonth($currentMonth);

        return $this->render('calendar.html.twig', [
            'calendar' => $calendar, 'name'=>$name]);
    }

    /**
     * @Route("/calendar/weekends/{month}", name="calendar_weekends")
     */
    public function weekends($month): Response
    {
        $currentMonth = date('n');

        if ($month) {
            $currentMonth = $month;
        }

        $calendar = $this->generateCalendarData($currentMonth);
        $name = $this->getMonth($currentMonth);

        return $this->render('weekend.html.twig', [
            'calendar' => $calendar, 'name'=>$name]);
    }

    /**
     * @Route("/calendar/table/{month}", name="calendar_table")
     */
    public function table($month): Response
    {
        $currentMonth = date('n');

        if ($month) {
            $currentMonth = $month;
        }

        $calendar = $this->generateCalendarData($currentMonth);
        $name = $this->getMonth($currentMonth);

        return $this->render('table.html.twig', [
            'calendar' => $calendar, 'name'=>$name]);
    }

    private function generateCalendarData($month): array
    {
        $firstDay = new \DateTime(date('Y') . '-' . $month . '-01');
        $lastDay = new \DateTime(date('Y') . '-' . $month . '-' . $firstDay->format('t'));
        $dayOfWeek = $firstDay->format('N');

        $calendar = [];
        $week = [];

        for ($i = 1; $i < $dayOfWeek; $i++) {
            $week[] = null;
        }

        for ($day = 1; $day <= $lastDay->format('j'); $day++) {
            $date = new \DateTime(date('Y') . '-' . $month . '-' . $day);
            $week[] = ['day' => $day, 'isWeekend' => in_array($date->format('N'), [6, 7]),
                'dayOfWeek' => $date->format('N')];

            if ($date->format('N') == 7) {
                $calendar[] = $week;
                $week = [];
            }
        }

        $calendar[] = $week;

        return $calendar;
    }

    private function getMonth($month): string{
        $name = new \DateTime(date('Y') . '-' . $month . '-' . '01');
        return $name->format('F');
    }

}
