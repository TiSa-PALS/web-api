<?php


namespace TiSa\Components\Grid;


use Nette\Database\Table\ActiveRow;
use Nette\Utils\Html;
use TiSa\ORM\Models\ModelType;

class ProductGrid extends BaseGrid {
    /**
     * ProductGrid constructor.
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function __construct() {
        parent::__construct();
        $this->setPrimaryKey('product_id');
        $this->configure();
    }

    /**
     * @return $this
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function configure() {

        $this->addColumnNumber('type_id', 'Type')->setRenderer(function ($row) {
            $className = ModelType::getUIClassName($row->type);
            return Html::el('span')
                ->addAttributes([
                    'class' => $className
                ])->addText($row->type->name);
        });

        $this->addColumnText('order_number', 'Order number');
        $this->addColumnText('producer_id', 'Producer')->setRenderer(function ($row) {
            return $row->producer->name;
        });

        $this->addColumnText('size', 'Size')->setRenderer(function ($row) {
            if ($row->size_diameter) {
                return 'D=' . $row->size_diameter . ' mm';
            }
            return $row->size;
        });
        $this->addColumnText('focus', 'Focus')->setRenderer(function ($row) {
            if ($row->focus) {
                return Html::el('span')->addAttributes(['class' => ($row->focus > 0) ? 'badge badge-success' : 'badge badge-warning'])->addText($row->focus . ' mm');
            } else {
                return Html::el('span')->addAttributes(['class' => 'badge badge-danger'])->addHtml('&#8734;');
            }
        });

        $this->addColumnText('numbers', 'Count T/N/U')->setRenderer(function (ActiveRow $row) {
            $rows = $row->related(\DBTable::TABLE_ITEM);
            return (clone $rows)->count() . '/' .
                (clone $rows)->where('state', 'new')->count() . '/' .
                (clone $rows)->where('state', 'used')->count();

        });
        $this->addAction('detail', 'Detail', 'Product:detail', ['id' => 'product_id']);
        $this->addAction('edit', 'Edit', 'Product:edit', ['id' => 'product_id']);
        return $this;
    }


}
