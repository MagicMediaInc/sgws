<?php

/**
 * ProjetoSubtipoGasto form base class.
 *
 * @method ProjetoSubtipoGasto getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseProjetoSubtipoGastoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'id_projeto' => new sfWidgetFormInputText(),
      'id_subtipo' => new sfWidgetFormInputText(),
      'valor'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'ProjetoSubtipoGasto', 'column' => 'id', 'required' => false)),
      'id_projeto' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_subtipo' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'valor'      => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('projeto_subtipo_gasto[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProjetoSubtipoGasto';
  }


}
