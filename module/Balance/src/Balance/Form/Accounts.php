<?php

namespace Balance\Form;

use Zend\Form\Element;
use Zend\Form\Form;

/**
 * Formulário de Contas
 */
class Accounts extends Form
{
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        // Chave Primária
        $this->add(new Element\Hidden('id'));

        // Nome
        $this->add(new Element\Text('name'));

        // Tipo
        $input = (new Element\Select('type'))
            ->setValueOptions(array(
                'ACTIVE'  => 'Ativo',
                'PASSIVE' => 'Passivo',
            ));
        $this->add($input);

        // Descrição
        $this->add(new Element\Textarea('description'));
    }
}
