<?php

/**
 * LxProfile form.
 *
 * @package    lynx
 * @subpackage form
 * @author     Your name here
 */
class LxProfileForm extends BaseLxProfileForm
{
  public function configure()
  {
      // Widget
      $this->widgetSchema['name_profile']->setAttributes(array('class' => 'validate[required]','size' => '40','maxlength' => '30'));
      $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array('1' => 'Ativo', '0' => 'Inativo')));
      //Validores
      $this->validatorSchema['name_profile']->setOption('required', true);

      //Labels
        $this->widgetSchema->setLabels(array(
                'name_profile'      => 'Nome Núcleo',
                'status'            => 'Status',

        ));
      
        unset($this['permalink']);
  }
}
