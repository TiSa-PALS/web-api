<?php


namespace TiSa\InventoryModule;


use Component\Control\Product;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use Nette\Utils\Html;
use TiSa\Components\Grid\BaseGrid;
use TiSa\ORM\Models\ModelItem;
use TiSa\ORM\Models\ModelType;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class ProductPresenter extends EntityPresenter {

    public function __construct(Context $database) {
        parent::__construct($database);

    }

    public function getProducers() {
        $rows = $this->database->table(\DBTable::TABLE_PRODUCER);
        $items = [];
        foreach ($rows as $row) {
            $items[$row->producer_id] = $row->name;
        }
        Debugger::barDump($items);
        return $items;
    }

    public function getTypes() {
        $rows = $this->database->table(\DBTable::TABLE_TYPE);
        $items = [];
        foreach ($rows as $row) {
            $items[$row->type_id] = '(' . $row->label . ') ' . $row->name;
        }
        Debugger::barDump($items);
        return $items;
    }

    public function createForm() {
        $form = new Form();

        $form->addSelect('producer_id', 'Producer')->setItems($this->getProducers())->setPrompt('Select Producer'); // FIXME

        $form->addSelect('type_id', 'Type')->setItems($this->getTypes())->setPrompt('Select Type'); // FIXME
        $form->addText('order_number', 'Order number');
        $form->addText('spec', 'Spec');
        $form->addText('datasheet', 'Datasheet');
        $form->addText('size', 'Size');
        $form->addText('thickness', 'thickness')->setRequired(false)->addRule(Form::FLOAT);
        $form->addText('coating', 'Coating');
        $form->addText('material', 'Material');
        $form->addText('surface_type', 'Surface type');

        $form->addInteger('wavelength_from', 'Wavelength from');
        $form->addInteger('wavelength_to', 'Wavelength to');
        $form->addText('wavelength_note', 'Wavelength note');

        $form->addText('incidence_angle', 'incidence_angle');

        $form->addText('length_difference', 'length_difference');
        $form->addText('transmission_wavelength', 'transmission_wavelength');
        $form->addText('transmission', 'transmission');
        $form->addText('optical_density', 'optical_density');
        $form->addText('angle', 'angle');
        $form->addText('angle_tolerance', 'angle_tolerance');
        $form->addText('reflectivity', 'reflectivity');
        $form->addInteger('focus', 'focus');
        $form->addText('polarization', 'polarization');
        $form->addText('surface', 'surface');
        $form->addTextArea('note', 'note');
        return $form;
    }

    protected function handleCreate(Form $form) {
        // TODO: Implement handleCreate() method.
    }

    protected function handleEdit(Form $form) {
        // TODO: Implement handleEdit() method.
    }

    /**
     * @return \Nette\Database\Table\ActiveRow
     * @throws BadRequestException
     */
    protected function getEntity() {
        $row = $this->database->table(\DBTable::TABLE_PRODUCT)->wherePrimary($this->id)->fetch();
        if ($row) {
            return $row;
        }
        throw new BadRequestException('Item neexistuje');
    }


    protected function titleEdit() {
        return \sprintf('Edit product %s', $this->getEntity()->order_number);
    }

    protected function titleCreate() {
        return \sprintf('Create new product');
    }

    protected function titleDetail() {
        return \sprintf('Product detail %s', $this->getEntity()->order_number);
    }

    protected function titleList() {
        return \sprintf('List of product.');
    }

    /**
     * @return Product
     * @throws BadRequestException
     */
    public function createComponentDetail() {
        return new Product($this->getEntity());
    }

    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentRelatedItems() {
        $control = new BaseGrid();
        $control->setPrimaryKey('item_id');
        $control->setItemsPerPageList([], true);
        $control->setPagination(false);
        $control->setDataSource($this->database->table('item')->where('product_id', $this->id));
        $control->addColumnText('id', 'ID')->setRenderer(function ($row) {
            return $row->product->type->label . $row->id;
        });
        $control->addColumnText('state', 'state')->setRenderer(function ($row) {
            return Html::el('span')->addAttributes(['class' => ModelItem::getStateUIClass($row)])->setText($row->state);
        });
        return $control;
    }

    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGrid() {
        $control = new BaseGrid();

        $control->setPrimaryKey('product_id');
        $control->setDataSource($this->database->table(\DBTable::TABLE_PRODUCT));


        $control->addColumnText('order_number', 'Order number');
        $control->addColumnText('producer', 'Producer')->setRenderer(function ($row) {
            return $row->producer->name;
        });
        $control->addColumnText('size', 'Size');

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
                    'href' => $this->link('detail', [
                        'id' => $row->product_id,
                    ]),
                    'class' => 'btn btn-sm btn-primary',
                ])->addText('Detail');
        });
        $control->addColumnText('edit', 'Edit')->setRenderer(function ($row) {
            return Html::el('a')
                ->addAttributes([
                    'href' => $this->link('edit', [
                        'id' => $row->product_id,
                    ]),
                    'class' => 'btn btn-sm btn-secondary',
                ])->addText('Edit');
        });
        //   $control->addColumnLink('edit', 'Edit', 'edit', '', ['id' => 'producer_id']);
        return $control;
    }

}
