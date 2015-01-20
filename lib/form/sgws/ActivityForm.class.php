<?php

/**
 * Proposta form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class ActivityForm extends sfForm
{
  public function configure()
  {
      $request = sfContext::getInstance()->getRequest();
      $user = sfContext::getInstance()->getUser()->getAttribute('idUserPanel');
      $codigo_tarefa = $request->getParameter('codigotarefa');
            if($request->getParameter('id_actividad')){
            $actividad = TempotarefaPeer::retrieveByPK($request->getParameter('id_actividad')); 
            $usu = LxUserPeer::retrieveByPK($actividad->getCodigofuncionario());
            $equipo = array($user => $usu->getName() );
            }else{
            $equipo = array($user => sfContext::getInstance()->getUser()->getAttribute('nameUser') );
        }

      $this->widgetSchema['horas_trabajadas'] = new sfWidgetFormInputText(array(), array('class' => 'validate[custom[onlyNumber]]','size' => '5','maxlength' => '20'));
      $this->widgetSchema['funcionario'] = new sfWidgetFormChoice(array('choices'  => $equipo,'expanded' => false));
      
      $this->widgetSchema['id_actividad'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['codigo_tarefa'] = new sfWidgetFormInputHidden(array(), array('value' => $codigo_tarefa));
      $this->widgetSchema['data'] = new sfWidgetFormInputText();
      $this->widgetSchema['descricao'] = new sfWidgetFormTextarea(array(), array('cols' => '50', 'rows' => '9'));
      
      $this->widgetSchema->setNameFormat('reg_activity[%s]');
      
      $this->validatorSchema['id_actividad']  = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['data']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['codigo_tarefa']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['horas_trabajadas']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['funcionario']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['descricao']  = new sfValidatorString(array('required' => false, 'trim' => true));
      
      if($request->getParameter('id_actividad'))
      {  
         $actividad = TempotarefaPeer::retrieveByPK($request->getParameter('id_actividad')); 
         $this->setDefault('id_actividad', $request->getParameter('id_actividad'));
         $this->setDefault('codigo_tarefa', $actividad->getCodigotarefa());
         $this->setDefault('data', $actividad->getDatareal());
         $this->setDefault('horas_trabajadas', $actividad->getTempogasto() );
         $this->setDefault('funcionario', $actividad->getCodigofuncionario() );
         $this->setDefault('descricao', $actividad->getObservacoes() );
      }
      
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'horas_trabajadas'   => 'Horas Trabajadas:',
        'funcionario'       => 'Responsável:',
        'descricao'       => 'Descrição:',        
      ));
      
  }
}
