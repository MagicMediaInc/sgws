<?php

/**
 * Banco form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class BancoForm extends BaseBancoForm
{
  public function configure()
  {
      
      $sexo = array('0' => 'Desativo', '1' => 'Activo');
      $this->widgetSchema['nombre_banco']->setAttributes(array('class' => 'validate[required]','size' => '35','maxlength' => '50'));
      $this->widgetSchema['status'] = new sfWidgetFormSelect(array('choices' => $sexo));
      
      //Etiquetas
      $this->widgetSchema->setLabels(array(
        'nombre_banco'  => 'Nome Banco<span class="required">*</span>',        
      ));
  }
}
