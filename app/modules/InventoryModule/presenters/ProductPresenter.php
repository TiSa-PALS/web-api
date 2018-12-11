<?php


namespace TiSa\InventoryModule;


use Component\Control\Product;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Database\Context;
use TiSa\Components\Grid\ItemsGrid;
use TiSa\Components\Grid\ProductGrid;
use Ublaboo\DataGrid\DataGrid;

class ProductPresenter extends EntityPresenter {

    public function __construct(Context $database) {
        parent::__construct($database);

    }

    public function getProducers() {
        $rows = $this->database->table(\DBTable::TABLE_PRODUCER);
        $producers = [];
        foreach ($rows as $row) {
            $producers[$row->producer_id] = $row->name;
        }
        return $producers;
    }

    public function getTypes() {
        $rows = $this->database->table(\DBTable::TABLE_TYPE);
        $items = [];
        foreach ($rows as $row) {
            $items[$row->type_id] = '(' . $row->label . ') ' . $row->name;
        }
        return $items;
    }

    public function createForm() {
        $form = new Form();

        $form->addSelect('producer_id', 'Producer')->setItems($this->getProducers())->setPrompt('Select producer'); // FIXME

        $form->addSelect('type_id', 'Type')->setItems($this->getTypes())->setPrompt('Select Type'); // FIXME
        $form->addText('order_number', 'Order number');
        $form->addText('spec', 'Spec');
        $form->addText('datasheet', 'Datasheet');
        $form->addText('size', 'Size');
        $form->addText('size_diameter', 'Diameter')->setAttribute('list', 'size_diameter_list')->setRequired(false)->addRule(Form::FLOAT);
        $sizeDiameterList = new \DataListField('size_diameter_list');
        $sizeDiameterList->setItems([25.4, 50.8, 222]);
        $form->addComponent($sizeDiameterList, 'size_diameter_list');
        $form->addText('thickness', 'thickness')->setRequired(false)->addRule(Form::FLOAT);
        $form->addText('coating', 'Coating');
        $form->addText('material', 'Material');

        $form->addText('surface_type', 'Surface type');
        $form->addText('surface', 'surface');
        $form->addText('surface_scratch_dig', 'Surface scratch-dig');
        $form->addText('surface_flatness', 'Surface flatness')->setOption('description', '@633');;

        $form->addInteger('wavelength_from', 'Wavelength from')->setOption('description', 'in nm');;
        $form->addInteger('wavelength_to', 'Wavelength to')->setOption('description', 'in nm');;
        $form->addText('wavelength_note', 'Wavelength note');

        $form->addText('incidence_angle', 'Incidence angle');

        $form->addText('length_difference', 'Length difference');
        $form->addText('transmission_wavelength', 'Transmission wavelength');
        $form->addText('transmission', 'transmission');
        $form->addText('optical_density', 'Optical density');
        $form->addText('angle', 'angle');
        $form->addText('angle_tolerance', 'Angle tolerance');
        $form->addText('reflectivity', 'reflectivity');
        $form->addInteger('focus', 'Focus')->setOption('description', 'in mm');
        $form->addText('polarization', 'Polarization');

        $form->addTextArea('note', 'note');

        return $form;
    }


    protected function getTable() {
        return $this->database->table(\DBTable::TABLE_PRODUCT);
    }

    /**
     * @return string
     * @throws BadRequestException
     */
    protected function titleEdit() {
        return \sprintf('Edit product %s', $this->getEntity()->order_number);
    }

    /**
     * @return string
     */
    protected function titleCreate() {
        return \sprintf('Create new product');
    }

    /**
     * @return string
     * @throws BadRequestException
     */
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
        $control = new ItemsGrid();
        $control->setDataSource($this->database->table(\DBTable::TABLE_ITEM)->where('product_id', $this->id));
        return $control;
    }

    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGrid() {
        $control = new ProductGrid();
        $control->setDataSource($this->getTable());
        return $control;
    }

}
