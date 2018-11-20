<?php

namespace Component\Control;

use Nette\Application\UI\Control;
use Nette\Database\Context;

class Producer extends Control {

    private $producerId;
    /** @var Context */
    private $database;

    public function __construct(Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function setId($id) {
        $this->producerId = $id;
    }

    public function render() {
        $this->template->setFile(__DIR__ . '/Producer.latte');
        $producer = $this->database->query('SELECT * FROM producer where producer_id=?', $this->producerId)->fetch();

        $this->template->producer = $producer;
        \Tracy\Debugger::barDump($producer);
        $this->template->render();
    }
}
