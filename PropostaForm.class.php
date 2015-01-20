<?php

/**
 * Proposta form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class PropostaForm extends BasePropostaForm
{
  public function configure()
  {
      $negociacao = NegociacaoPeer::getListSelect();
      $projetoTipo = ProjetotipoPeer::getListTipos();
      $projetoCentro = CentroPeer::getListChoices();
      $status = StatusPeer::getListStatus($this->getObject()->getIdStatusProposta());
      $status_proposta = StatusPropostaPeer::getListStatus();
      $prioridade = PrioridadePeer::getListPrioridad();
      $clientes = CadastroJuridicaPeer::getListClientes();
      
      $visualizacion = array('0' => 'Público', '1' => 'Restrito');
      $apr = array('' => '','0' => 'Sim', '1' => 'Não');
      $satisfacao_cliente = array('0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10');
      // Un gerente puede ser un Administrador , Un Gerente o un Socio
      $gerente = LxUserPeer::getGerentesYAdmnistradoresYSocios();
      
      $this->widgetSchema['valor']->setAttributes(array('class' => 'validate[required]','size' => '10','maxlength' => '30'));
      $this->widgetSchema['valor_prev_hh']->setAttributes(array('class' => '','size' => '10','maxlength' => '30'));
      $this->widgetSchema['nao_conformidade']->setAttributes(array('class' => '','size' => '10','maxlength' => '6'));
      $this->widgetSchema['codigo_sgws']->setAttributes(array('class' => 'validate[required]','size' => '5','maxlength' => '30'));
      if($this->getObject()->isNew())
      {
          $this->widgetSchema['codigo_sgws_projeto'] = new sfWidgetFormInputHidden();
      }else{
          $this->widgetSchema['codigo_sgws_projeto']->setAttributes(array('readonly' => false,  'class' => '','size' => '5','maxlength' => '30'));
      }
      
      $this->widgetSchema['horas_vendidas']->setAttributes(array('class' => 'validate[required, custom[onlyNumber]]','size' => '5','maxlength' => '30'));
      $this->widgetSchema['horas_trabajadas']->setAttributes(array('class' => '','size' => '5','maxlength' => '30','readonly' => true));
      $this->widgetSchema['nome_proposta']->setAttributes(array('class' => 'validate[required]','size' => '65','maxlength' => '100'));
      $this->widgetSchema['gerente'] = new sfWidgetFormChoice(array('choices'  => $gerente,'expanded' => false), array('style' => 'width:400px;'));
      $this->widgetSchema['cliente'] = new sfWidgetFormChoice(array('choices'  => $clientes,'expanded' => false), array('style' => 'width:400px;'));
      $this->widgetSchema['id_negociacao'] = new sfWidgetFormChoice(array('choices'  => $negociacao,'expanded' => false));
      $this->widgetSchema['codigo_tipo'] = new sfWidgetFormChoice(array('choices'  => $projetoTipo,'expanded' => false));
      $this->widgetSchema['codigo_centro'] = new sfWidgetFormChoice(array('choices'  => $projetoCentro,'expanded' => false));
      $this->widgetSchema['id_prioridade'] = new sfWidgetFormChoice(array('choices'  => $prioridade,'expanded' => false));
      $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices'  => $status,'expanded' => false));
      $this->widgetSchema['visualizacion'] = new sfWidgetFormChoice(array('choices'  => $visualizacion,'expanded' => false));
      $this->widgetSchema['apr'] = new sfWidgetFormChoice(array('choices'  => $apr,'expanded' => false));
      $this->widgetSchema['satisfacao_cliente'] = new sfWidgetFormChoice(array('choices'  => $satisfacao_cliente,'expanded' => false));
      $this->widgetSchema['id_status_proposta'] = new sfWidgetFormChoice(array('choices'  => $status_proposta,'expanded' => false));
      
      //$this->widgetSchema['gerente'] = new sfWidgetFormInputHidden(array(), array('value' => sfContext::getInstance()->getUser()->getAttribute('idUserPanel')));
      
      
      $this->widgetSchema['data_inicio'] = new sfWidgetFormInputText();
      $this->widgetSchema['data_ir_projeto'] = new sfWidgetFormInputText();
      $this->widgetSchema['data_fr_projeto'] = new sfWidgetFormInputText();
      $this->widgetSchema['proposta'] = new sfWidgetFormTextarea(array(), array('cols' => '50', 'rows' => '9'));
      
      // Valida
      $this->validatorSchema['horas_vendidas']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['valor']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['valor_prev_hh']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['horas_trabajadas']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['coeficiente']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['proposta']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['data_ir_projeto']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['data_fr_projeto']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['codigo_sgws_projeto']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['satisfacao_cliente']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['nao_conformidade']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['apr']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['codigo_centro']  = new sfValidatorString(array('required' => false, 'trim' => true));
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'codigo_sgws'            => 'Código:',
        'nome_proposta'          => 'Nome:',
        'cliente'               => 'Cliente:',
        'data_inicio'            => 'Data Proposta',
        'data_ir_projeto'            => 'Data aprovação da PP/inicio PJ',
        'data_fr_projeto'        => 'Data final do projeto:',
        'status'                => 'Status:',
        'id_negociacao'          => 'Funil de Vendas:',
        'codigo_tipo'            => 'Tipo de Projeto:',
        'codigo_centro'            => 'Categoria do Projeto:',
        'id_status_proposta'      => 'Proposta:',
        'proposta'              => 'Descrição:',
        'horas_vendidas'         => 'Horas Vendidas:',
        'horas_trabajadas'       => 'Horas Trabalhadas:',
        'id_prioridade'         => 'Prioridade:',
        'coeficiente'           => 'Coeficiente WIP:',
        'visualizacion'         => 'Visualização:',
        'satisfacao_cliente'         => 'Satisfação do Cliente:',
        'nao_conformidade'         => 'Não Conformidades:',
        'valor_prev_hh'         => 'Valor Prev. HH:',
        'apr'         => 'APR',
        
      ));
      // Agrega un post validador personalizado
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
      );
      unset($this['codigo_velhio'],$this['codigo_projeto'], $this['data_final'], $this['flag_projeto'], $this['tipo'], $this['status_analisis']);
  }
  
  public function validatePost($validator, $values)
  {
      $values['valor'] = aplication_system::convierteDecimalFormat($values['valor']);
      $values['horas_vendidas'] = aplication_system::convierteDecimalFormat($values['horas_vendidas']);
      $values['coeficiente'] = aplication_system::convierteDecimalFormat($values['coeficiente']);
      if(!$this->getObject()->isNew())
      {
        // Valida codigo de la proposta
        if(PropostaPeer::checkCodigoProposta($values['codigo_sgws'],$values['codigo_proposta']))
        {
            $error = new sfValidatorError($validator, 'Código Proposta já está registrado');
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));
        }
        if($values['codigo_sgws_projeto'] && PropostaPeer::checkCodigoProjeto($values['codigo_sgws_projeto'],$values['codigo_proposta']))
        {
            $error = new sfValidatorError($validator, 'Código Projeto já está registrado');
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));
        }
      }
      return $values;
  }
}
