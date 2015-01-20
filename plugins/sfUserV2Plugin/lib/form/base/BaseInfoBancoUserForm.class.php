<?php

/**
 * InfoBancoUser form base class.
 *
 * @method InfoBancoUser getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseInfoBancoUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_info_banco' => new sfWidgetFormInputHidden(),
      'id_user'       => new sfWidgetFormPropelChoice(array('model' => 'LxUser', 'add_empty' => false)),
      'id_banco'      => new sfWidgetFormPropelChoice(array('model' => 'Banco', 'add_empty' => false)),
      'titular'       => new sfWidgetFormInputText(),
      'agencia'       => new sfWidgetFormInputText(),
      'numero_conta'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_info_banco' => new sfValidatorPropelChoice(array('model' => 'InfoBancoUser', 'column' => 'id_info_banco', 'required' => false)),
      'id_user'       => new sfValidatorPropelChoice(array('model' => 'LxUser', 'column' => 'id_user')),
      'id_banco'      => new sfValidatorPropelChoice(array('model' => 'Banco', 'column' => 'id_banco')),
      'titular'       => new sfValidatorString(array('max_length' => 30)),
      'agencia'       => new sfValidatorString(array('max_length' => 30)),
      'numero_conta'  => new sfValidatorString(array('max_length' => 30)),
    ));

    $this->widgetSchema->setNameFormat('info_banco_user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'InfoBancoUser';
  }


}
