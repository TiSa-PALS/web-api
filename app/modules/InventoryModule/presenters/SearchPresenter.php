<?php


namespace TiSa\InventoryModule;

use TiSa\Components\Grid\ItemsGrid;
use Tracy\Debugger;
use Ublaboo\DataGrid\DataGrid;

class SearchPresenter extends ItemPresenter {


    protected function getFieldDefinition($type) {
        Debugger::barDump($type);
        switch ($type) {
            case 'WP':
                return ['grant','size', 'length_difference', 'wavelength', 'item_note', 'product_note']; // OK
            case 'C':
                return ['size', 'thickness', 'coating', 'material', 'incidence_angle', 'surface_type', 'wavelength', 'item_note', 'product_note']; //OK
            case 'XF':
                return ['filter_thickness', 'size', 'item_note', 'product_note'];
            case 'L':
                return ['size', 'focus'];
            case 'S':
                return ['reflectivity_transmission'];
            case 'W':
                return ['size', 'coating'];
            case 'M':
                return ['size', 'coating', 'incidence_angle', 'material', 'wavelength', 'thickness'];

            default:
                return [];
        }
    }


    /*
    Lens
    L

    Mirror
    M

    Splitter
    S

    Windows
    W

    Wedge
    E

    Filter
    F

    Polarizer
    P

    Wave-plate
    WP

    Other
    O

    Gratings
    G

    Cristals
    C

    XR Filter

    U undefined
    */
    /**
     * @return DataGrid
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createComponentGrid() {
        $control = new ItemsGrid();

        $control->setOuterFilterRendering();
        //    $control->addFilterSelect('producer_id', 'Producer', $this->getProducers())->setPrompt('Select');

        $control->setDataSource($this->getTable()->where('product.type.label', $this->getActionToType()));
        $control->createColumns($this->getFieldDefinition($this->getActionToType()));


        return $control;
    }


    public function beforeRender() {
        parent::beforeRender();
        if ($this->getAction() !== 'default') {
            $this->setView('view');
        }
    }


    private function getActionToType() {
        switch ($this->getAction()) {
            case 'filter':
                return 'F';
            case 'xFilter':
                return 'XF';
            case 'lens':
                return 'L';
            case 'mirror':
                return 'M';
            case 'splitter':
                return 'S';
            case 'windows':
                return 'W';
            case 'wedge':
                return 'E';
            case 'polarizer';
                return 'P';
            case 'wavePlate':
                return 'WP';
            case 'other':
                return 'O';
            case 'gratings':
                return 'G';
            case 'cristals':
                return 'C';
            case 'undefined':
                return 'U';
        }
    }
}
