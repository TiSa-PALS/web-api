<?php

namespace Component\Control;

use Nette\Application\UI\Control;
use Nette\Database\Context;

class Size extends Control {

    private $sizeId;
    /** @var Context */
    private $database;

    public function __construct(Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function setId($id) {
        $this->sizeId = $id;
    }

    public function render() {
        $this->template->setFile(__DIR__ . '/Size.latte');
        $size = $this->database->query('SELECT * FROM size where size_id=?', $this->sizeId)->fetch();

        $this->template->size = $size;
        \Tracy\Debugger::barDump($size);
        $this->template->render();
    }
}
