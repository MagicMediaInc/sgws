<?php

/**
 * HorasBillability form base class.
 *
 * @method HorasBillability getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseHorasBillabilityForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigo' => new sfWidgetFormInputHidden(),
      'Ano'    => new sfWidgetFormInputText(),
      'Mes1'   => new sfWidgetFormInputText(),
      'Mes2'   => new sfWidgetFormInputText(),
      'Mes3'   => new sfWidgetFormInputText(),
      'Mes4'   => new sfWidgetFormInputText(),
      'Mes5'   => new sfWidgetFormInputText(),
      'Mes6'   => new sfWidgetFormInputText(),
      'Mes7'   => new sfWidgetFormInputText(),
      'Mes8'   => new sfWidgetFormInputText(),
      'Mes9'   => new sfWidgetFormInputText(),
      'Mes10'  => new sfWidgetFormInputText(),
      'Mes11'  => new sfWidgetFormInputText(),
      'Mes12'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'codigo' => new sfValidatorPropelChoice(array('model' => 'HorasBillability', 'column' => 'codigo', 'required' => false)),
      'Ano'    => new sfValidatorString(array('max_length' => 4, 'required' => false)),
      'Mes1'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes2'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes3'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes4'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes5'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes6'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes7'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes8'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes9'   => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes10'  => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes11'  => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'Mes12'  => new sfValidatorString(array('max_length' => 5, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('horas_billability[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'HorasBillability';
  }


}
