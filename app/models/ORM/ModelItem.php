<?php


namespace TiSa\ORM\Models;


use Nette\Database\Table\ActiveRow;

class ModelItem {
    public static function getStateUIClass(ActiveRow $row) {
        switch ($row->state) {
            case 'new':
                return 'badge badge-success';
            case 'used':
                return 'badge badge-warning';
            case 'pd':
                return 'badge badge-secondary';
            case'cd':
                return 'badge badge-dark';
            default:
                return 'badge badge-danger';
        }

    }
}
