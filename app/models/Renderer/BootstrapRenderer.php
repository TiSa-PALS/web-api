<?php

class BootstrapRenderer implements \Nette\Forms\IFormRenderer {
    public function render(\Nette\Forms\Form $form) {
        $template = new \Nette\Bridges\ApplicationLatte\Template(new \Latte\Engine());
        $template->setFile(__DIR__ . '/form.latte');
        $template->form = $form;
        $template->render();
    }
}
