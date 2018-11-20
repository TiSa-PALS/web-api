<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Tracy\Debugger;

class TablePresenter extends Nette\Application\UI\Presenter {

    /** @var Nette\Database\Context */
    private $database;

    public function __construct(Nette\Database\Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function createComponentExperimentSelect() {

        $form = new Form();
        $form->addSelect('experiment', 'Experiment', $this->getExperimentsItems())->setRequired();
        $this->addChannels($form);
        $form->addSubmit('submit', 'Select');
        $form->onSuccess[] = function (Form $f) {
            $values = $f->getValues();
            Debugger::barDump($values);
            $this->redirect('this', ['e' => $values->experiment]);
        };

        return $form;
    }

    private function getExperimentsItems() {
        $exps = $this->database->query('SELECT * from experiment');
        $experimentsItems = [];
        foreach ($exps as $ex) {
            $experimentsItems[$ex->experiment_id] = $ex->name;
        }
        return $experimentsItems;
    }

    private function addChannels(Form &$form) {
        $channels = $this->database->query('SELECT * from channel');
        foreach ($channels as $channel) {
            $form->addCheckbox('channel_' . $channel->channel_id, $channel->allias);
        }
    }


}
