<?php

namespace TiSa\InventoryModule;

use Nette\Application\UI\Form;
use Nette\NotImplementedException;
use Nette\Utils\Html;
use TiSa\Components\Grid\BaseGrid;
use TiSa\ORM\Models\ModelType;
use Ublaboo\DataGrid\DataGrid;
use Ublaboo\DataGrid\Exception\DataGridException;

class ProducerPresenter extends EntityPresenter {

    protected function titleEdit() {
        return \sprintf('Edit producer %s', $this->getEntity()->name);
    }

    protected function titleCreate() {
        return \sprintf('Create new producer');
    }

    protected function titleDetail() {
        return \sprintf('Producer detail %s', $this->getEntity()->name);
    }

    protected function titleList() {
        return \sprintf('List of producer.');
    }

    protected function getTable() {
        return $this->database->table(\DBTable::TABLE_PRODUCER);
    }

    /**
     * @return DataGrid
     * @throws DataGridException
     */
    public function createComponentGrid() {
        $control = new BaseGrid();
        $control->setPrimaryKey('producer_id');
        $control->setDataSource($this->database->table('producer'));

        $control->addColumnNumber('producer_id', '#');
        $control->addColumnText('name', 'Name');
        $control->addColumnText('detail', 'Detail')->setRenderer(function ($row) {
            return Html::el('a')
                ->addAttributes([
                    'href' => $this->link('detail', [
                        'id' => $row->producer_id,
                    ]),
                    'class' => 'btn btn-sm btn-primary',
                ])->addText('Detail');
        });
        //   $control->addColumnLink('edit', 'Edit', 'edit', '', ['id' => 'producer_id']);
        return $control;
    }

    /**
     * @return DataGrid
     * @throws DataGridException
     */
    public function createComponentProducerItemsGrid() {
        $control = new BaseGrid();
        $control->setPrimaryKey('product_id');
        $control->setDataSource($this->database->table('product')->where('producer_id', $this->id));


        $control->addColumnNumber('order_number', 'Order number');
        $control->addColumnNumber('type_id', 'Type')->setRenderer(function ($row) {
            $className = ModelType::getUIClassName($row->type);

            return Html::el('span')
                ->addAttributes([
                    'class' => $className
                ])->addText($row->type->name);
        });
        $control->addColumnText('detail', 'Detail')->setRenderer(function ($row) {
            return Html::el('a')
                ->addAttributes([
                    'href' => $this->link('Product:detail', [
                        'id' => $row->product_id,
                    ]),
                    'class' => 'btn btn-sm btn-primary',
                ])->addText('Detail');
        });
        //   $control->addColumnLink('edit', 'Edit', 'edit', '', ['id' => 'producer_id']);
        return $control;
    }

    protected function createForm() {
        $form = new Form();
        $form->addText('name', 'Name')->setRequired(true);
        return $form;
    }

    public function createComponentDetail() {
        throw new NotImplementedException();
    }

    /**
     * @throws \Nette\Application\AbortException
     */
    public function actionEdit() {
        if (!$this->id) {
            $this->flashMessage('Id is required', 'danger');
            $this->redirect('list');
        }
    }
}
