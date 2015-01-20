<?php

/**
 * LxPrivilege form.
 *
 * @package    lynx4
 * @subpackage form
 * @author     Your name here
 */
class LxPrivilegeForm extends BaseLxPrivilegeForm
{
  public function configure()
  {
      // widgets
      $this->widgetSchema['privilege_name']->setAttributes(array('class' => 'validate[required]','size' => '40','maxlength' => '30'));
      $this->widgetSchema['sf_privilege']->setAttributes(array('class' => 'validate[required]','size' => '20','maxlength' => '15'));
      $this->widgetSchema['privilege_description']->setAttributes(array('size' => '40','maxlength' => '30'));
  }
}
