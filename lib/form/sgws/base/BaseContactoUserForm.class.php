<?php

/**
 * ContactoUser form base class.
 *
 * @method ContactoUser getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseContactoUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'id_user'  => new sfWidgetFormInputText(),
      'nome'     => new sfWidgetFormInputText(),
      'relacion' => new sfWidgetFormInputText(),
      'telefone' => new sfWidgetFormInputText(),
      'celular'  => new sfWidgetFormInputText(),
      'email'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'ContactoUser', 'column' => 'id', 'required' => false)),
      'id_user'  => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'nome'     => new sfValidatorString(array('max_length' => 100)),
      'relacion' => new sfValidatorString(array('max_length' => 50)),
      'telefone' => new sfValidatorString(array('max_length' => 30)),
      'celular'  => new sfValidatorString(array('max_length' => 30)),
      'email'    => new sfValidatorString(array('max_length' => 100)),
    ));

    $this->widgetSchema->setNameFormat('contacto_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ContactoUser';
  }


}
