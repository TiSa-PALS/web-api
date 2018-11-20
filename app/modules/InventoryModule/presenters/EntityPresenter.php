<?php


namespace TiSa\InventoryModule;


use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Database\Context;

abstract class EntityPresenter extends BasePresenter {

    /** @var Context */
    protected $database;
    /**
     * @var integer
     * @persistent
     */
    public $id;


    public function __construct(Context $database) {
        parent::__construct();
        $this->database = $database;
    }

    public function getTitle() {
        switch ($this->getAction()) {
            case 'edit':
                return $this->titleEdit();
            case 'create':
                return $this->titleCreate();
            case 'list':
                return $this->titleList();
            case 'detail':
                return $this->titleDetail();
        }
    }

    public function actionEdit() {

        $this['editForm']->setDefaults($this->getEntity());
    }

    /**
     * @return Form
     */
    abstract protected function createForm();

    public function createComponentEditForm() {
        $form = $this->createForm();
        $form->addSubmit('update', 'Save');
        $form->onSuccess[] = function (Form $form) {
            $this->handleEdit($form);
        };
        return $form;
    }

    public function createComponentCreateForm() {
        $form = $this->createForm();
        $form->addSubmit('update', 'Create');
        $form->onSuccess[] = function (Form $form) {
            $this->handleCreate($form);
        };
        return $form;
    }

    /**
     * @return \Nette\Database\Table\ActiveRow
     */
    abstract protected function getEntity();

    abstract protected function handleCreate(Form $form);

    abstract protected function handleEdit(Form $form);

    abstract protected function titleEdit();

    abstract protected function titleCreate();

    abstract protected function titleDetail();

    abstract protected function titleList();

    abstract public function createComponentDetail();
    abstract public function createComponentGrid();
}
