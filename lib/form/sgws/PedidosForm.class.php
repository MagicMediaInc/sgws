<?php

/**
 * Pedidos form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class PedidosForm extends BasePedidosForm
{
  public function configure()
  {
      
      //$status = array('1' => 'En Andamento', '2' => 'Cancelado' , '3' => 'Aguardando Pagamento', '4' => 'Pagamento Confirmado');
      $status = array('1' => 'En Andamento', '2' => 'Cancelado' , '4' => 'Pedido Entregue');
      
      $pagamento = array('transferência' => 'Transferência', 'boleto' => 'Boleto Bancário' , 'dinheiro' => 'Dinheiro', 'cartão' => 'Cartão');
      
      $this->widgetSchema['numero_pedido'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['data'] = new sfWidgetFormInputText();
      $this->widgetSchema['id_cliente'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['id_projeto'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices'  => $status,'expanded' => false));
      
      $this->widgetSchema['forma_pagamento'] = new sfWidgetFormChoice(array('choices'  => $pagamento,'expanded' => false));
      
      // Validaciones
      $this->validatorSchema['valor']  = new sfValidatorString(array('required' => true, 'trim' => true));
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'id_cliente'            => 'Cliente:',
        'id_projeto'          => 'Código Projeto:',
        'numero_pedido'               => 'Número Pedido:',
        'status'                => 'Status:',
        
      ));
      // Agrega un post validador personalizado
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
      );
      unset($this['peso'], $this['desconto'], $this['cartao'], $this['num_cartao'], $this['venc_cartao'], $this['nome_cartao'],$this['cods_cartao'],$this['parcelas'],$this['data_pag'] );
  }
  
  public function validatePost($validator, $values)
  {
      $values['valor'] = aplication_system::convierteDecimalFormat($values['valor']);
      
      
      return $values;
  }
}
