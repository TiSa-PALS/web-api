<?php

namespace TiSa\ORM\Models;

class ModelType {

    public static function getUIClassName(\Nette\Database\Table\ActiveRow $row) {
        return 'badge badge-' . $row->label;
    }
}
