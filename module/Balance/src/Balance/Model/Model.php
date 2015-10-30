<?php

namespace Balance\Model;

use Balance\Model\Persistence\PersistenceInterface;
use Zend\Form\Form;
use Zend\Stdlib\Parameters;

/**
 * Camada de Modelo
 *
 * Estrutura utilizada como padrão para processamento de informações apresentadas pela camada de controle durante o
 * fluxo de processamento do aplicativo. Centraliza a configuração de objetos de formulário e persistência de dados.
 */
class Model
{
    /**
     * Formulário
     * @type Form
     */
    private $form;

    /**
     * Formulário de Pesquisa
     * @type Form
     */
    private $searchForm;

    /**
     * Persistência de Dados
     * @type PersistenceInterface
     */
    private $persistence;

    /**
     * Construtor Padrão
     *
     * @param Form                 $form        Formulário
     * @param Form                 $searchForm  Formulário de Pesquisa
     * @param PersistenceInterface $persistence Persistência de Dados
     */
    public function __construct(Form $form, Form $searchForm, PersistenceInterface $persistence)
    {
        $this
            ->setForm($form)
            ->setSearchForm($searchForm)
            ->setPersistence($persistence);
    }

    /**
     * Configuração de Formulário
     *
     * @param  Form  $form Elemento para Configuração
     * @return Model Próprio Objeto para Encadeamento
     */
    protected function setForm(Form $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * Apresentação de Formulário
     *
     * @return Form Elemento Solicitado
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Configuração de Formulário de Pesquisa
     *
     * @param  Form  $searchForm Elemento para Configuração
     * @return Model Próprio Objeto para Encadeamento
     */
    protected function setSearchForm(Form $searchForm)
    {
        $this->searchForm = $searchForm;
        return $this;
    }

    /**
     * Apresentação de Formulário de Pesquisa
     *
     * @return Form Elemento Solicitado
     */
    public function getSearchForm()
    {
        return $this->searchForm;
    }

    /**
     * Configuração de Persistência de Dados
     *
     * @param  PersistenceInterface $persistence Elemento para Configuração
     * @return Model                Próprio Objeto para Encadeamento
     */
    protected function setPersistence(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
        return $this;
    }

    /**
     * Apresentação de Persistência de Dados
     *
     * @return PersistenceInterface Elemento Solicitado
     */
    public function getPersistence()
    {
        return $this->persistence;
    }

    /**
     * Consulta de Elementos
     *
     * @param  Parameters $params Parâmetros de Execução
     * @return array      Conjunto de Informações Encontradas
     */
    public function fetch(Parameters $params)
    {
        // Formulário de Pesquisa
        $form = $this->getSearchForm();
        // Preencher Formulário
        $form->setData($params);
        // Consulta de Elementos
        return $this->getPersistence()->fetch($params);
    }

    /**
     * Carregar Elemento
     *
     * @param  Parameters $params Parâmetros de Execução
     * @return array      Conjunto de Informações Encontradas
     */
    public function load(Parameters $params)
    {
        // Carregar Elementos
        $element = $this->getPersistence()->find($params);
        // Encontrado?
        if (! $element) {
            throw new ModelException('Unknown Element');
        }
        // Preencher Formulário
        $this->getForm()->setData($element);
        // Apresentação
        return $element;
    }

    /**
     * Salvar Elemento
     *
     * @param  Parameters     $data Dados para Salvamento
     * @throws ModelException Dados Inválidos
     * @return Model          Próprio Objeto para Encadeamento
     */
    public function save(Parameters $data)
    {
        // Formulário
        $form = $this->getForm();
        // Configurar Dados
        $form->setData($data);
        // Dados Válidos?
        if (! $form->isValid()) {
            throw new ModelException('Invalid Data');
        }
        // Capturar Valores
        $values = $form->getData();
        // Salvar Dados
        $this->getPersistence()->save(new Parameters($values));
        // Encadeamento
        return $this;
    }

    /**
     * Remover Elemento
     *
     * @param  Parameters     $params Parâmetros de Execução
     * @throws ModelException Problema na Remoção do Elemento
     * @return Model          Próprio Objeto para Encadeamento
     */
    public function remove(Parameters $params)
    {
        // Remover Elemento
        $this->getPersistence()->remove($params);
        // Encadeamento
        return $this;
    }
}
