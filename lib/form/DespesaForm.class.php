<?php

/**
 * Despesa form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class DespesaForm extends BaseSaidasForm
{
  public function configure()
  {
      $projetos = EquipeTarefaPeer::getComboProjetosUsuario(aplication_system::getUser());
      if(!$this->getObject()->isNew() && $this->getObject()->getCodigoprojeto())
      {
          $tarefa = TarefaPeer::getSelectTarefasByProjeto($this->getObject()->getCodigoprojeto());
      }else{
          $tarefa = array('' => '');
      }
      $status  = array('0' => 'Não', '1' => 'Sim');
      $tipo  = array('e' => 'Entrada', 's' => 'Saída');
      $pagamento     = sfConfig::get('app_despesa_pagamento');
      // Widgets
      $this->widgetSchema['codigoprojeto'] = new sfWidgetFormChoice(array('choices' => $projetos), array('style' => 'width:200px;'));
      $this->widgetSchema['codigotarefa'] = new sfWidgetFormChoice(array('choices' => $tarefa));      
      $this->widgetSchema['datareal'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
      $this->widgetSchema['descricaosaida'] = new sfWidgetFormTextarea(array(), array('cols' => '50', 'rows'=>'5'));
      $this->widgetSchema['formapagamento'] = new sfWidgetFormChoice(array('choices' => $pagamento));
      if(!aplication_system::esFuncionario())
      {
          $this->widgetSchema['operacao'] = new sfWidgetFormChoice(array('choices' => $tipo));
          $this->widgetSchema['dataprevista'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required] data-despesa', 'size'=>'10'));
          $this->widgetSchema['saidaprevista']->setAttributes(array('class' => '', 'maxlength' => '14','size'=>'14'));
      }else{
          $this->widgetSchema['operacao'] = new sfWidgetFormInputHidden();
          $this->widgetSchema['dataprevista'] = new sfWidgetFormInputHidden();
          $this->widgetSchema['saidaprevista'] = new sfWidgetFormInputHidden();
      }
      
      
      $this->widgetSchema['saidas']->setAttributes(array('class' => '', 'maxlength' => '14','size'=>'14'));
      $this->validatorSchema['saidaprevista']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['saidas']  = new sfValidatorString(array('required' => true, 'trim' => true));
      
      $this->widgetSchema['centro'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['baixa'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['codigofuncionario'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['confirmacao'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['confirmadopor'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['tipo'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['codigo_tipo'] = new sfWidgetFormChoice(array('choices' => array()),array('class' => 'tipos'));
      $this->widgetSchema['codigo_subtipo'] = new sfWidgetFormChoice(array('choices' => array()),array('id' => 'subtipo'));
      $this->widgetSchema['codigocadastro'] = new sfWidgetFormChoice(array('choices' => array()),array('id' => 'fornecedor'));
      
      // Validators
      
      // Labels
      $this->widgetSchema->setLabels(array(
            'codigoprojeto'     => 'Projeto',
            'codigotarefa'     => 'Tarefa',
            'dataprevista'     => 'Data Prevista',
            'datareal'         => 'Data Real',
            'descricaosaida'    => 'Descrição',
            'baixa'             => 'Baixa',
            'formapagamento'     => 'Forma de Pagamento',
            'operacao'          => 'Operação',
            'saidaprevista'      => 'Valor Saída Prevista',
            'saidas'            => 'Valor Saída Real ',
            'codigo_tipo'       => 'Tipo',
            'codigo_subtipo'       => 'Subtipo',
            'codigocadastro'       => 'Fornecedor',
            
        ));
      // Agrega un post validador personalizado
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
      );
      
      unset($this['id_pedido'], $this['id_compensacao']);
  }
  
  public function validatePost($validator, $values)
  {
      
      $values['saidaprevista'] = aplication_system::convierteDecimalFormat($values['saidaprevista']);
      $values['saidas'] = aplication_system::convierteDecimalFormat($values['saidas']);
      
      return $values;
  }
}
