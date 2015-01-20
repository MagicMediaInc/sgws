<?php

/**
 * DespesaFinaciero form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class DespesaFinacieroForm extends BaseSaidasForm
{
  public function configure()
  {
      
      $projetos = PropostaPeer::getComboProjetosFinanciero();
      
      if($this->getObject()->getCodigoprojeto())
      {
          $funcionarios = EquipeTarefaPeer::getFuncionariosProyecto($this->getObject()->getCodigoprojeto());
      }else{
          //$funcionarios = array('' => 'Selecione');
          $funcionarios = LxUserPeer::getComboUsuariosFuncionarios();          
      }
      $clientes = CadastroJuridicaPeer::getClientsNameJuridico();
      $status  = array('0' => 'Não', '1' => 'Sim');
      $operacao = array('e' => 'Entrada', 's' => 'Saída');
      $tipo = array('v' => 'Variável', 'f' => 'Fixa');
      $pagamento     = sfConfig::get('app_despesa_pagamento');
      if ($this->getObject()->getOperacao())
         $centro = ($this->getObject()->getOperacao() == 'e')? sfConfig::get('app_despesa_centroE'):
                                                               sfConfig::get('app_despesa_centroS');
      else $centro = sfConfig::get('app_despesa_centroE');
      
      // Widgets
      $this->widgetSchema['codigoprojeto'] = new sfWidgetFormChoice(array('choices' => $projetos), array('style' => 'width:440px;'));
      $this->widgetSchema['documentos'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required]', 'size'=>'10'));
      $this->widgetSchema['dataprevista'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required] data-despesa', 'size'=>'10'));
      //$this->widgetSchema['datareal'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
      $this->widgetSchema['dataemissao'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
      $this->widgetSchema['datarecebimentopre'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
      $this->widgetSchema['descricaosaida'] = new sfWidgetFormTextarea(array(), array('cols' => '50', 'rows'=>'5'));
      
      if(aplication_system::esUsuarioRoot())
      {
          $this->widgetSchema['confirmacao']  = new sfWidgetFormChoice(array('choices' => $status));
          $this->widgetSchema['baixa']  = new sfWidgetFormInputHidden();
      }else{
          $this->widgetSchema['confirmacao']  = new sfWidgetFormInputHidden();
          $this->widgetSchema['baixa']  = new sfWidgetFormChoice(array('choices' => $status));
      }
      
        if(aplication_system::esAdministrador() || aplication_system::esSocio()):
           $this->widgetSchema['impostos']->setAttributes(array('class' => '', 'maxlength' => '8','size'=>'8'));
           $this->widgetSchema['saidas']->setAttributes(array('class' => '', 'maxlength' => '14','size'=>'14'));
           $this->widgetSchema['datareal'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
           $this->widgetSchema['dataemissao'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10'));
       else:
          $this->widgetSchema['impostos']->setAttributes(array('class' => '', 'maxlength' => '8','size'=>'8','disabled'=>true));
          $this->widgetSchema['saidas']->setAttributes(array('class' => '', 'maxlength' => '14','size'=>'14','disabled'=>true));
          $this->widgetSchema['datareal'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10','disabled'=>true));
          $this->widgetSchema['dataemissao'] = new sfWidgetFormInputText(array(), array('class' => 'data-despesa',  'readonly' => true, 'size'=>'10','disabled'=>true));
       endif;
       
      $this->widgetSchema['centro'] = new sfWidgetFormChoice(array('choices' => $centro));
      $this->widgetSchema['formapagamento'] = new sfWidgetFormChoice(array('choices' => $pagamento));
      $this->widgetSchema['operacao'] = new sfWidgetFormChoice(array('choices' => $operacao));
      $this->widgetSchema['tipo'] = new sfWidgetFormChoice(array('choices' => $tipo));
      $this->widgetSchema['saidaprevista']->setAttributes(array('class' => '', 'maxlength' => '14','size'=>'14'));
      
      $this->widgetSchema['codigofuncionario'] = new sfWidgetFormChoice(array('choices' => $funcionarios), array('id' => 'funcionario'));
      
      //$this->widgetSchema['confirmacao'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['confirmadopor'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['codigo_tipo'] = new sfWidgetFormChoice(array('choices' => array('' => 'Selecione')),array('class' => 'tipos'));
      $this->widgetSchema['codigo_subtipo'] = new sfWidgetFormChoice(array('choices' => array('' => 'Selecione')),array('id' => 'subtipo'));
      $this->widgetSchema['codigocadastro'] = new sfWidgetFormChoice(array('choices' => $clientes),array('id' => 'fornecedor'));
      
      // Validators
      $this->validatorSchema['saidaprevista']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['saidas']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['impostos']  = new sfValidatorString(array('required' => false, 'trim' => true));
      
      // Labels
      $this->widgetSchema->setLabels(array(
            'documentos'     => 'Nro. Documento',
            'codigoprojeto'     => 'Projeto',
            'codigotarefa'     => 'Tarefa',
            'dataprevista'     => 'Data Prev. Fatura',
            'datareal'         => 'Data Recebimento',
            'dataemissao'         => 'Data Faturamento',
            'datarecebimentopre'   => 'Data Prev. Recebimento',
            'descricaosaida'    => 'Descrição',
            'baixa'             => 'Aprovado GP',
            'confirmacao'             => 'Aprovado ADM',
            'formapagamento'     => 'Tipo de Pagamento',
            'operacao'          => 'Registro',
            'saidaprevista'      => 'Valor Previsto',
            'saidas'            => 'Valor Real ',
            'codigo_tipo'       => 'Tipo',
            'codigo_subtipo'       => 'Subtipo',
            'codigocadastro'       => 'Cliente',
            'tipo'                  => 'Frequencia',
            'codigofuncionario'       => 'Funcionario',            
        ));
        // Agrega un post validador personalizado
        $this->validatorSchema->setPostValidator(
          new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
        );
      
        unset($this['id_pedido'],$this['id_compensacao']);
      
  }
  
  public function validatePost($validator, $values)
  {
      
      $values['saidaprevista'] = aplication_system::convierteDecimalFormat($values['saidaprevista']);
      $values['saidas'] = aplication_system::convierteDecimalFormat($values['saidas']);
      $values['impostos'] = aplication_system::convierteDecimalFormat($values['impostos']);
      /**
       * Valida: Si es Andamento, marcar a 1 campo confirmacao y confirmacao_por
       */
      if($values['centro'] == 'adiantamento')
      {
//          $values['confirmacao'] = '1';
//          $values['confirmadopor'] = aplication_system::getUser();
      }
      
      return $values;
  }
}
