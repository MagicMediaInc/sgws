<?php

/**
 * Tarefa form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class TarefaForm extends BaseTarefaForm
{
  public function configure()
  {
      $visualizacion = array('0' => 'Público', '1' => 'Restrito');
      $request = sfContext::getInstance()->getRequest();
      $id_projeto = $request->getParameter('codigo_projeto');
      
      // Busca las tareas padre del proyecto
      $parent = TarefaPeer::getTarefasParentByProjeto($id_projeto, $this->getObject()->getCodigotarefa());
      
      
      $user = sfContext::getInstance()->getUser()->getAttribute('idUserPanel');
      $status_projeto = $request->getParameter('status_projeto');
      $descricao = TarefadescricaoPeer::getList();
      
      $status = StatusPeer::getListStatus($status_projeto);
      $prioridade = PrioridadePeer::getListPrioridad();
      
      $this->widgetSchema['tarefa_parent'] = new sfWidgetFormChoice(array('choices'  => $parent,'expanded' => false));
      $this->widgetSchema['Status'] = new sfWidgetFormChoice(array('choices'  => $status,'expanded' => false));
      $this->widgetSchema['Descricao'] = new sfWidgetFormChoice(array('choices'  =>$descricao,'expanded' => false));
      //$this->widgetSchema['tipo_tarefa'] = new sfWidgetFormChoice(array('choices'  => $descricao,'expanded' => false));
      $this->widgetSchema['id_prioridade'] = new sfWidgetFormChoice(array('choices'  => $prioridade,'expanded' => false));
      $this->widgetSchema['CodigoProjeto'] = new sfWidgetFormInputHidden();
      if($this->getObject()->isNew())
      {
          $this->setDefault('CodigoProjeto', $id_projeto);
      }
      //$this->widgetSchema['DespesaPrevista'] = new sfWidgetFormInputText(array(), array('size' => '10'));
      $this->widgetSchema['HorasPrevistas'] = new sfWidgetFormInputText(array(), array('class' => 'validate[required, custom[onlyNumber]]', 'size' => '10'));
      $this->widgetSchema['DataIRTarefa'] = new sfWidgetFormInputText(array(), array('size' => '10'));
      $this->widgetSchema['DataFRTarefa'] = new sfWidgetFormInputText(array(), array('size' => '10'));
      $this->widgetSchema['Responsavel'] = new sfWidgetFormInputHidden(array(), array('value' => $user));
      //$this->widgetSchema['observacoes'] = new sfWidgetFormTextarea(array(), array('cols' => '55', 'rows' => '9'));
      $this->widgetSchema['informacoes'] = new sfWidgetFormTextarea(array(), array('cols' => '75', 'rows' => '9'));
      $this->widgetSchema['visualizacao'] = new sfWidgetFormChoice(array('choices'  => $visualizacion,'expanded' => false));
      $this->validatorSchema['tarefa_parent']  = new sfValidatorString(array('required' => false, 'trim' => true));
      
      
      //$this->validatorSchema['DespesaPrevista']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['HorasPrevistas']  = new sfValidatorString(array('required' => true, 'trim' => true));
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'tipo_tarefa'         => 'Tipo de Tarefa:',
        'tarefa_parent'           => 'Tarefa Mãe:',
        'Descricao'           => 'Tipo:',
        'DataIRTarefa'        => 'Data Início',
        'DataFRTarefa'        => 'Data de Término:',
        'status'             => 'Status:',
        'DespesaPrevista'     => 'Orçamento:',
        'proposta'           => 'Descrição:',
        'HorasPrevistas'      => 'Horas:',
        'id_prioridade'       => 'Prioridade:',
        'observacoes'         => 'Observações:',
        'informacoes'         => 'Informações:',
        'visualizacao'       => 'Visualização:',
      ));
      // Agrega un post validador personalizado
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
      );
      unset($this['observacoes'], $this['tipo_tarefa'], $this['DespesaPrevista']);
      
  }
  
  public function validatePost($validator, $values)
  {
      /**
       * 02 Abril 2014
       * Ocultar DespesaPrevista
       */
      
      //$values['DespesaPrevista'] = aplication_system::convierteDecimalFormat($values['DespesaPrevista']);
      $values['HorasPrevistas'] = aplication_system::convierteDecimalFormat($values['HorasPrevistas']);
      
      return $values;
  }
  
  
}
