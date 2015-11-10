<?php

namespace Balance\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

/**
 * Controladora de Configurações
 */
class Configs extends AbstractActionController
{
    /**
     * Apresentar Configurações
     *
     * @return JsonModel Modelo de Visualização
     */
    public function indexAction()
    {
        // Capturar Configurações
        $configs = array();
        // Inicialização
        $view = new JsonModel($configs);
        // Configurar Caminho Base
        $view->setVariable('basePath', $this->getRequest()->getBaseUrl());
        // Configurar Variável
        $view->setJsonpCallback('$.application.setConfigs');
        // Apresentação
        return $view;
    }
}