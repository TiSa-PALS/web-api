<?php

namespace Component\Control;

use Nette\Application\UI\Control;
use Nette\Database\Table\ActiveRow;

class Product extends Control {

    private $item;

    public function __construct(ActiveRow $item) {
        parent::__construct();
        $this->item = $item;
    }

    public function render() {
        $this->template->setFile(__DIR__ . '/Product.latte');
        $this->template->item = $this->item;
        \Tracy\Debugger::barDump($this->item);
        $this->template->render();
    }
}
