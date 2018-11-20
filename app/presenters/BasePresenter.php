<?php


namespace App\Presenters;


use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter {

    abstract function getTitle();

    protected function beforeRender() {
        parent::beforeRender();
        $this->template->title = $this->getTitle();
    }
}
