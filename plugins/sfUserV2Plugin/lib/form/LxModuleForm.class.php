<?php

/**
 * LxModule form.
 *
 * @package    lynx
 * @subpackage form
 * @author     Your name here
 */
class LxModuleForm extends BaseLxModuleForm
{
  
    
  public function configure()
  {
    // Obtengo el Id de la seccion, si es que existe !!
    $idModule = sfContext::getInstance()->getRequest()->getParameter('id_module');
    
    //Busca los modulos padres 
    $modules = LxModulePeer::findModulesPaterns($idModule);

    $this->widgetSchema['name_module'] = new sfWidgetFormInput(array(),array('class' => 'validate[required]','size' => '50','maxlength' => '70'));
    $this->widgetSchema['sf_module'] = new sfWidgetFormInput(array(),array('size' => '25','maxlength' => '30'));
    $this->widgetSchema['credential'] = new sfWidgetFormInput(array(),array('size' => '25','maxlength' => '30'));
    $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Enable', '0' => 'Disable')));
    $this->widgetSchema['id_parent'] = new sfWidgetFormChoice(array('choices'  => $modules,'expanded' => false),array('size' => '10'));
    $this->widgetSchema['delete'] = new sfWidgetFormChoice(array('choices' => array('1' => 'SI', '0' => 'No')));
    
    
    /**
     * Labels
     */
    $this->widgetSchema->setLabels(array(
      'name_module'    => 'Nome Módulo <span class="required">*</span>',
      'id_parent'      => 'Pai',
      'credential'     => 'Credencial',
      'delete'     => 'Eliminar',
    ));

    $this->validatorSchema['name_module'] = new sfValidatorString(array('required' => true, 'trim' => true));
    $this->validatorSchema['sf_module'] = new sfValidatorString(array('required' => false, 'trim' => true));
    $this->validatorSchema['credential'] = new sfValidatorString(array('required' => false,'trim' => true));
    $this->validatorSchema['id_parent']  = new sfValidatorChoice(array('choices' => array_keys($modules)));
  }
  


}

