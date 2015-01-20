<?php

/**
 * SubtipoUser form base class.
 *
 * @method SubtipoUser getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSubtipoUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_subtipo'       => new sfWidgetFormInputHidden(),
      'id_tipo_cadastro' => new sfWidgetFormPropelChoice(array('model' => 'TipoCadastro', 'add_empty' => false)),
      'id_parent'        => new sfWidgetFormInputText(),
      'position'         => new sfWidgetFormInputText(),
      'subtipo'          => new sfWidgetFormInputText(),
      'id_velhio'        => new sfWidgetFormInputText(),
      'codigo'           => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_subtipo'       => new sfValidatorPropelChoice(array('model' => 'SubtipoUser', 'column' => 'id_subtipo', 'required' => false)),
      'id_tipo_cadastro' => new sfValidatorPropelChoice(array('model' => 'TipoCadastro', 'column' => 'id_tipo_cadastro')),
      'id_parent'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'position'         => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'subtipo'          => new sfValidatorString(array('max_length' => 50)),
      'id_velhio'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'codigo'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('subtipo_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SubtipoUser';
  }


}
