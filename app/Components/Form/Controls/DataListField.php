<?php


class DataListField extends \Nette\Application\UI\Control {
    private $items = [];
    private $id;

    public function __construct($id) {
        parent::__construct();
        $this->id = $id;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function render() {
        $this->template->items = $this->items;
        $this->template->id = $this->id;
        $this->template->setFile(__DIR__ . 'DataListField.latte');
        $this->template->render();
    }
}
