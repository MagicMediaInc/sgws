<?php

/**
 * SubtipoUser form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class SubtipoUserForm extends BaseSubtipoUserForm
{
  public function configure()
  {
      $id_tipo_cadastro = $this->getObject()->getIdTipoCadastro();
      $idSubtipo = sfContext::getInstance()->getRequest()->getParameter('id');
      $tiposCadastro = TipoCadastroPeer::getHydrateList();
      $subtiposPaterns = SubtipoUserPeer::findSubTiposByTC($id_tipo_cadastro, $idSubtipo);
      
      $this->widgetSchema['id_tipo_cadastro'] = new sfWidgetFormChoice(array('choices'  => $tiposCadastro,'expanded' => false),array('size' => '10','class' => 'validate[required]'));
      $this->widgetSchema['id_parent'] = new sfWidgetFormChoice(array('choices'  => $subtiposPaterns,'expanded' => false),array('class' => 'validate[required]','size' => '10', 'id' => 'subtipo_parent','style' => 'width: 200px;'));
      $this->widgetSchema['subtipo'] = new sfWidgetFormInput(array(),array('size' => '45','maxlength' => '50','class' => 'validate[required]'));
      $this->widgetSchema['position'] = new sfWidgetFormInputHidden();
      
      //Validadores
      //$this->validatorSchema['id_parent']  = new sfValidatorChoice(array('choices' => array_keys($subtiposPaterns)));
      //Etiquetas
      $this->widgetSchema->setLabels(array(
        'id_tipo_cadastro'  => 'Tipo de Cadastro <span class="required">*</span>',
        'id_parent'         => 'SubTipo Pai <span class="required">*</span>',
        'subtipo'         => 'Nome SubTipo <span class="required">*</span>',
      ));
  }
}
