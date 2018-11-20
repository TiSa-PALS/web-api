<?php

namespace TiSa\Components\Form\Control\GrantField;

use Nette\Forms\Controls\SelectBox;

class TypeField extends SelectBox {
    public function __construct() {
        parent::__construct('Type');
        $this->setItems([
            'L' => '(L) Lens',
            'M' => '(M) Mirror',
            'S' => '(S) Splitter',
            'O' => '(O) Other',
            'E' => '(E) Wedge',
            'WP' => '(WP) Wave plate',
            'P' => '(P) Pollarizer',
            'W' => '(W) Windows',
            'F' => '(F) Filter',
            'Pr' => '(Pr) Prism',
        ]);
        $this->setPrompt('Select type');
        $this->setRequired(true);;
    }
}
