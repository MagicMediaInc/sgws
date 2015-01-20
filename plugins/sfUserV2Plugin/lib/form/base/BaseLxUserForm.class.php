<?php

/**
 * LxUser form base class.
 *
 * @method LxUser getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_user'          => new sfWidgetFormInputHidden(),
      'codigo_velhio'    => new sfWidgetFormInputText(),
      'id_profile'       => new sfWidgetFormInputText(),
      'id_tipo_cadastro' => new sfWidgetFormInputText(),
      'id_tipo_usuario'  => new sfWidgetFormPropelChoice(array('model' => 'TipoUsuario', 'add_empty' => false)),
      'codigo'           => new sfWidgetFormInputText(),
      'name'             => new sfWidgetFormInputText(),
      'login'            => new sfWidgetFormInputText(),
      'password'         => new sfWidgetFormTextarea(),
      'email'            => new sfWidgetFormInputText(),
      'photo'            => new sfWidgetFormInputText(),
      'last_access'      => new sfWidgetFormDateTime(),
      'status'           => new sfWidgetFormInputText(),
      'preco_hora'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_user'          => new sfValidatorPropelChoice(array('model' => 'LxUser', 'column' => 'id_user', 'required' => false)),
      'codigo_velhio'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_profile'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'id_tipo_cadastro' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_tipo_usuario'  => new sfValidatorPropelChoice(array('model' => 'TipoUsuario', 'column' => 'id_tipo_usuario')),
      'codigo'           => new sfValidatorString(array('max_length' => 20)),
      'name'             => new sfValidatorString(array('max_length' => 100)),
      'login'            => new sfValidatorString(array('max_length' => 20)),
      'password'         => new sfValidatorString(array('required' => false)),
      'email'            => new sfValidatorString(array('max_length' => 70)),
      'photo'            => new sfValidatorString(array('max_length' => 100)),
      'last_access'      => new sfValidatorDateTime(array('required' => false)),
      'status'           => new sfValidatorString(array('required' => false)),
      'preco_hora'       => new sfValidatorNumber(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lx_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxUser';
  }


}
