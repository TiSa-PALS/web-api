<?php

namespace TiSa\Components\Grid;

use Ublaboo\DataGrid\DataGrid;

class BaseGrid extends DataGrid {
    public function __construct() {
        parent::__construct();
        $this->setPagination(false);
        $this->strict_session_filter_values = false;
        //   $this->configure();
    }

    //  abstract protected function configure();
}
