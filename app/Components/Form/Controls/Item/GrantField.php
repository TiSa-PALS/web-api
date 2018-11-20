<?php

namespace TiSa\Components\Form\Control\GrantField;

use Nette\Forms\Controls\SelectBox;

class GrantField extends SelectBox {
    public function __construct() {
        parent::__construct('Grant');
        $this->setItems([
            'T' => 'TiSa',
            'E' => 'Eli',
            'P' => 'PALS',
            'S' => 'Sofia',
            'B' => 'Betatron',
            'X' => 'XRL',
        ]);
        $this->setPrompt('Select grant');
    }
}
