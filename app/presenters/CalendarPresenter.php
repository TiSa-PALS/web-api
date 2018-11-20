<?php

namespace App\Presenters;

use Nette;
use Tracy\Debugger;

class CalendarPresenter extends Nette\Application\UI\Presenter {

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function renderDefault() {
        $month = 11;
        $year = 2014;
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        // How many days does this month contain?
        $numberDays = date('t', $firstDayOfMonth);
        $dateMatrix = [];
        $weekIndex = 0;
        for ($i = 1; $i <= $numberDays; $i++) {
            $time = mktime(0, 0, 0, $month, $i, $year);
            $index = date('w', $time);

            $shotsNumber = $this->getShotsForDay(date('Y-m-d', $time))->getRowCount();

            $dateMatrix[$weekIndex][$index] = ['shots' => $shotsNumber, 'index' => $i];
            if ($index == 6) {
                $weekIndex++;
            }

        }
        Debugger::barDump($dateMatrix);
        $this->getShotsForDay();
        $this->template->dateMatrix = $dateMatrix;
    }

    private function getShotsForDay($date = '2014-11-25') {
        return $this->database->query('SELECT * from shot_stat where Date(ShotTime)= ?', $date);
    }
}
