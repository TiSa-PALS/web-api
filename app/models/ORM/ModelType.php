<?php

namespace TiSa\ORM\Models;

class ModelType {

    public static function getUIClassName(\Nette\Database\Table\ActiveRow $row) {
        $className = 'badge ';
        switch ($row->type_id) {
            case 1:
            case 5:
                $className .= 'badge-danger';
                break;

            case 2:
                $className .= 'badge-primary';
                break;
            case 6:
                $className .= 'badge-dark';
                break;
            case 3:
            case 7:
                $className .= 'badge-warning';
                break;
            case 8:
                $className .= 'badge-success';
                break;
            case 4:
                $className .= 'badge-light';
                break;

            default:
                $className .= 'badge-secondary';
        }
        return $className;
    }
}
