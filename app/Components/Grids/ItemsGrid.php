<?php


namespace TiSa\Components\Grid;


use Nette\NotImplementedException;
use Nette\Utils\Html;
use TiSa\ORM\Models\ModelItem;
use TiSa\ORM\Models\ModelType;

class ItemsGrid extends BaseGrid {
    /**
     * ItemsGrid constructor.
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */

    public function __construct() {
        parent::__construct();
        $this->configure();
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    protected function configure() {

        $this->setPrimaryKey('item_id');
        $this->addColumnText('inv_id', 'Id')->setRenderer(function ($row) {
            return Html::el('span')->addAttributes(['class' => ModelType::getUIClassName($row->product->type)])->addText(ModelItem::createId($row));
        });
        $this->addColumnLink('product', 'Product')->setRenderer(function ($row) {
            return $row->product->order_number;
        });
        $this->addColumnText('producer', 'Producer')->setRenderer(function ($row) {
            return $row->product->producer->name;
        });

        $this->addColumnText('has_box', 'Box')->setRenderer(function ($row) {
            return Html::el('span')->addAttributes(['class' => $row->has_box ? 'badge badge-success' : 'badge badge-danger'])->setText(isset($row->has_box) ? ($row->has_box ? 'Y' : 'N') : 'undefined');
        });
        $this->addColumnText('exist', 'Exist')->setRenderer(function ($row) {
            return Html::el('span')->addAttributes(['class' => $row->exist ? 'badge badge-success' : 'badge badge-danger'])->setText(isset($row->exist) ? ($row->exist ? 'Y' : 'N') : 'undefined');
        });
        $this->addColumnText('placement', 'Placement');
        $this->addColumnText('state', 'state')->setRenderer(function ($row) {
            return Html::el('span')->addAttributes(['class' => ModelItem::getStateUIClass($row)])->setText($row->state ?: 'undefined');
        });
        $this->addAction('edit_item', 'Edit item', 'Item:edit', ['id' => 'item_id'])->setClass('btn btn-warning btn-sm');
        $this->addAction('item_detail', 'Item detail', 'Item:detail', ['id' => 'item_id'])->setClass('btn btn-info btn-sm');;
        $this->addAction('edit_product', 'Edit product', 'Product:edit', ['id' => 'product_id'])->setClass('btn btn-warning btn-sm');;
        $this->addAction('product_detail', 'Product detail', 'Product:detail', ['id' => 'product_id'])->setClass('btn btn-info btn-sm');;
    }

    /**
     * @param array $keys
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    public function createColumns(array $keys) {
        foreach ($keys as $key) {
            $this->createColumn($key);
        }
    }

    /**
     * @param $key
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     *
     */
    private function createColumn($key) {
        switch ($key) {
            case 'filter_thickness':
                $this->addColumnFilterThickness();
                break;
            case 'size':
                $this->addColumnSize();
                break;
            case 'producer':
                $this->addColumnProducer();
                break;
            case 'order_number':
                $this->addColumnOrderNumber();
                break;
            case 'focus':
                $this->addColumnFocus();
                break;
            case 'coating':
                $this->addColumnCoating();
                break;
            case 'material':
                $this->addColumnMaterial();
                break;
            case 'thickness':
                $this->addColumnThickness();
                break;
            case 'surface':
                $this->addColumnSurface();
                break;
            case 'polarization':
                $this->addColumnPolarization();
                break;
            case 'reflectivity':
                $this->addColumnReflectivity();
                break;
            case 'angle_tolerance':
                $this->addColumnAngleTolerance();
                break;
            case 'transmission':
                $this->addColumnTransmission();
                break;
            case 'reflectivity_transmission':
                $this->addColumnReflectivityTransmission();
                break;
            case 'incidence_angle':
                $this->addColumnIncidenceAngle();
                break;
            case 'wavelength':
                $this->addColumnWavelength();
                break;
            case 'length_difference':
                $this->addColumnLengthDifference();
                break;
            case 'product_note':
                $this->addColumnProductNote();
                break;
            case 'item_note':
                $this->addColumnItemNote();
                break;
            case 'surface_type':
                $this->addColumnSurfaceType();
                break;
            case 'grant':
                $this->addColumnGrant();
                break;
            default:
                throw new NotImplementedException($key);
        }
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnFilterThickness() {
        $this->addColumnText('filter_thickness', 'Filter thickness')->setRenderer(function ($row) {
            return $row->product->filter_thickness ? $row->product->filter_thickness . ' nm' : null;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnGrant() {
        $this->addColumnText('grant', 'Grant')->setRenderer(function ($row) {
            return $row->grant->name;
        });
    }

    /**
     *
     */
    protected function addColumnOrderNumber() {
        $this->addColumnText('order_number', 'Order number');
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnProducer() {
        $this->addColumnText('producer_id', 'Producer')->setRenderer(function ($row) {
            return $row->product->producer->name;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnSize() {
        $this->addColumnText('size', 'Size')->setRenderer(function ($row) {
            if ($row->product->size_diameter) {
                return 'D=' . $row->product->size_diameter . ' mm';
            }
            return $row->product->size;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnFocus() {
        $this->addColumnText('focus', 'Focus')->setRenderer(function ($row) {
            if ($row->product->focus) {
                return Html::el('span')->addAttributes(['class' => ($row->product->focus > 0) ? 'badge badge-success' : 'badge badge-warning'])->addText($row->product->focus . ' mm');
            } else {
                return Html::el('span')->addAttributes(['class' => 'badge badge-danger'])->addHtml('&#8734;');
            }
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnCoating() {
        $this->addColumnText('coating', 'coating')->setRenderer(function ($row) {
            return $row->product->coating;
        });
    }

    private function addColumnMaterial() {
        $this->addColumnText('material', 'Material')->setRenderer(function ($row) {
            return $row->product->material;
        });;
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnThickness() {
        $this->addColumnText('thickness', 'Thickness')->setRenderer(function ($row) {
            return $row->product->thickness . ' mm';
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnSurfaceType() {
        $this->addColumnText('surface_type', 'Surface type')->setRenderer(function ($row) {
            return $row->product->surface_type;
        });;
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnLengthDifference() {
        $this->addColumnText('length_difference', 'Length difference')->setRenderer(function ($row) {
            return $row->product->length_difference . ' λ';
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnProductNote() {
        $this->addColumnText('product_note', 'Product note')->setRenderer(function ($row) {
            return $row->product->note;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnItemNote() {
        $this->addColumnText('item_note', 'Item note')->setRenderer(function ($row) {
            return $row->note;
        });
    }


    private function addColumnSpec() {
        $this->addColumnText('spec', 'spec');
        //   `spec`                    VARCHAR(256)   NULL     DEFAULT NULL,
    }


    private function addColumnDatasheet() {
        $this->addColumnText('datasheet', 'Datasheet');
        //`datasheet`               VARCHAR(256)   NULL     DEFAULT NULL,
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnWavelength() {
        $this->addColumnText('wavelength', 'Wavelength')->setRenderer(function ($row) {
            $text = '';
            if ($row->product->wavelength_from && $row->product->wavelength_to) {
                if ($row->product->wavelength_from === $row->product->wavelength_from) {
                    $text .= $row->product->wavelength_from . ' nm';
                } else {
                    $text .= $row->product->wavelength_from . '-' . $row->product->wavelength_from . ' nm';
                }

            }
            if ($row->product->wavelength_note) {
                $text .= ' ' . $row->product->wavelength_note;
            }
            return $text;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnIncidenceAngle() {
        $this->addColumnText('incidence_angle', 'Incidence Angle')->setRenderer(function ($row) {
            if ($row->product->incidence_angle) {
                return $row->product->incidence_angle . ' °';
            }
            return '-';

        });
    }

    private function addColumnTransmissionWavelength() {
        $this->addColumnText('transmission_wavelength', 'Transmission wavelength');
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnTransmission() {
        $this->addColumnText('transmission', 'Transmission')->setRenderer(function ($row) {
            return $row->transmission . ' %';
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnOpticalDensity() {
        $this->addColumnText('optical_density', 'Optical density')->setRenderer(function ($row) {
            return 'OD=' . $row->optical_density;
        });
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnAngle() {
        $this->addColumnText('angle', 'angle')->setRenderer(function ($row) {
            return $row->angle . ' °';
        });
    }

    private function addColumnAngleTolerance() {
        $this->addColumnText('angle_tolerance', 'Angle tolerance');
    }

    /**
     * @throws \Ublaboo\DataGrid\Exception\DataGridException
     */
    private function addColumnReflectivity() {
        $this->addColumnText('reflectivity', 'Reflectivity')->setRenderer(function ($row) {
            return $row->reflectivity . ' %';
        });
    }

    private function addColumnPolarization() {
        $this->addColumnText('polarization', 'Polarization');
    }

    //`surface`                 VARCHAR(256)   NULL     DEFAULT NULL,
    private function addColumnSurface() {
    }

    private function addColumnReflectivityTransmission() {
        $this->addColumnText('reflectivity_transmission', 'R/T')->setRenderer(function ($row) {
            return $row->product->reflectivity . 'R/' . $row->product->transmission . 'T';
        });
    }


//protected function addColumn
//protected function addColumn
//protected function addColumn

}
