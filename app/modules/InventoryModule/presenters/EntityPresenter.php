<?php


namespace TiSa\InventoryModule;


use App\Presenters\BasePresenter;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;
use TiSa\Components\Grid\BaseGrid;

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
            default:
                return '';//parent::getTitle();
        }
    }

    /**
     * @throws BadRequestException
     */
    public function actionEdit() {

        $this['editForm']->setDefaults($this->getEntity());
    }

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
     * @return false|\Nette\Database\Table\ActiveRow
     * @throws BadRequestException
     */
    protected function getEntity() {
        $row = $this->getTable()->wherePrimary($this->id)->fetch();
        if ($row) {
            return $row;
        }
        throw new BadRequestException('Entity neexistuje');
    }

    /**
     * @param Form $form
     * @throws \Nette\Application\AbortException
     */
    protected function handleCreate(Form $form) {
        $values = $form->getValues();

        $this->getTable()->insert(self::emptyStrToNull($values));
        $this->flashMessage($this->getMessageCreateSuccess());
        $this->redirect('this');
    }

    public static function emptyStrToNull(ArrayHash $values) {
        $results = [];
        foreach ($values as $key => $value) {
            $results[$key] = ($value === '') ? null : $value;
        }
        return $results;
    }

    protected function getMessageCreateSuccess() {
        return 'Entity inserted';
    }

    /**
     * @param Form $form
     * @throws \Nette\Application\AbortException
     */
    protected function handleEdit(Form $form) {
        $values = $form->getValues();
        $this->getTable()->wherePrimary($this->id)->update(self::emptyStrToNull($values));
        $this->flashMessage('Entity updated');
        $this->redirect('list');
    }

    /**
     * @return string
     */
    abstract protected function titleEdit();

    /**
     * @return string
     */
    abstract protected function titleCreate();

    /**
     * @return string
     */
    abstract protected function titleDetail();

    /**
     * @return string
     */
    abstract protected function titleList();

    /**
     * @return Control
     */
    abstract public function createComponentDetail();

    /**
     * @return BaseGrid
     */
    abstract public function createComponentGrid();

    /**
     * @return Selection
     */
    abstract protected function getTable();

    /**
     * @return Form
     */
    abstract protected function createForm();
}
