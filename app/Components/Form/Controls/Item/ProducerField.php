<?php


namespace TiSa\Components\Form\Control\GrantField;


use Nette\Forms\Controls\SelectBox;

class ProducerField extends SelectBox {
    public function __construct() {
        parent::__construct('Producer');
        $this->setItems([
            'ThorLabs' => 'ThorLabs',
            'Eksma' => 'Eksma',
            'Lens-optics' => 'Lens-optics',
            'CVI' => 'CVI',
            'Malles Griot' => 'Malles Griot',
            'Edmund opt.' => 'Edmund opt.',
            'Newport' => 'Newport',
        ]);
        $this->setPrompt('Select producer');
    }
}
