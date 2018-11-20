<?php

namespace TiSa;

use App\Presenters\BasePresenter;
use Component\Control\Product;
use Component\Control\Size;
use Nette;
use Nette\Application\UI\Form;
use TiSa\Components\Form\Control\GrantField\GrantField;
use TiSa\Components\Form\Control\GrantField\ProducerField;
use TiSa\Components\Form\Control\GrantField\TypeField;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class OpticPresenter extends BasePresenter {
    protected $item;


    /** @var Nette\Database\Context */
    private $database;
    /**
     * @var integer
     * @persistent
     */
    public $id;

    public function __construct(Nette\Database\Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function getTitle() {
        switch ($this->getAction()) {
            case 'list':
                return 'List of items';
            case 'edit':
                return 'Edit item';
            default:
                return 'Insert a new item';
        }
    }

    public function createComponentProduct() {
        $control = new Product($this->database);
        $control->setId($this->getItem()->product_id);
        return $control;
    }

    public function createComponentSize() {
        $control = new Size($this->database);
        $control->setId($this->getItem()->size_id);
        return $control;
    }

    public function renderDefault() {
        $this->template->item = $this->getItem();
    }

    public function getItem() {
        if (!$this->item) {
            $this->item = $this->database->query('SELECT * FROM item where item_id=1')->fetch();
        }
        return $this->item;
    }

    public function renderList() {
        $this->template->items = $this->database->query('Select * from item');
    }

    public function createComponentProducersGrid() {
        $control = new DataGrid();
        $control->setPrimaryKey('producer_id');
        $control->setDataSource($this->database->table('producer'));

        $control->addColumnNumber('producer_id', '#');
        $control->addColumnText('name', 'Name');
        return $control;
    }

    public function actionEdit() {

        $row = $this->database->query('SELECT * from item where item_id=?', $this->id)->fetch();
        Debugger::barDump($row);
        $this['editForm']->setDefaults($row);
    }

    private function createForm() {
        $form = new Form();
        // $form->setRenderer(new \BootstrapRenderer());
        $form->addComponent(new TypeField(), 'type');
        $form->addInteger('id', 'Id')->setRequired(true);
        $form->addCheckbox('has_box', 'Has box?');
        $form->addCheckbox('exist', 'Exist?');
        $form->addSelect('state', 'State', [
            'new' => 'New',
            'used' => 'Used',
            'pd' => 'Partially destroyed',
            'cd' => 'Completely destroyed',
            'scratch' => 'Scratch',
        ])->setPrompt('Select state');
        $form->addComponent(new GrantField(), 'grant');
        $form->addComponent(new ProducerField(), 'producer');
        return $form;
    }

    public function createComponentEditForm() {
        $form = $this->createForm();

        $form->onSuccess[] = function (Form $form) {
            $values = $form->getValues();
            // $values->exist = ($values->state === 'new');
            $this->database->query('UPDATE item SET ? WHERE item_id=?', $values, $this->id);
            $this->flashMessage('Item updated "' . $values->type . $values->id . '".', 'success');
            $this->redirect('list');
        };
        $form->addSubmit('submit', 'Update');
        return $form;
    }

    public function createComponentInsertForm() {
        $form = $this->createForm();
        $form->onSuccess[] = function (Form $form) {
            $values = $form->getValues();
            // $values->exist = ($values->state === 'new');
            $this->database->query('INSERT INTO item ?', $values);
            $this->flashMessage('Item inserted "' . $values->type . $values->id . '".', 'success');
            $this->redirect('this');
        };
        $form->addSubmit('submit', 'Insert');
        return $form;
    }
}

