<?php

/**
 * Tempotarefa form base class.
 *
 * @method Tempotarefa getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseTempotarefaForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'codigoregistro'    => new sfWidgetFormInputHidden(),
      'CodigoTarefa'      => new sfWidgetFormInputText(),
      'CodigoFuncionario' => new sfWidgetFormInputText(),
      'DataPrevista'      => new sfWidgetFormDateTime(),
      'DataReal'          => new sfWidgetFormDate(),
      'TempoPrevisto'     => new sfWidgetFormInputText(),
      'TempoGasto'        => new sfWidgetFormInputText(),
      'Observacoes'       => new sfWidgetFormTextarea(),
      'autorizado'        => new sfWidgetFormInputText(),
      'autorizadopor'     => new sfWidgetFormInputText(),
      'cronograma'        => new sfWidgetFormInputText(),
      'last_update'       => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'codigoregistro'    => new sfValidatorPropelChoice(array('model' => 'Tempotarefa', 'column' => 'codigoregistro', 'required' => false)),
      'CodigoTarefa'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'CodigoFuncionario' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'DataPrevista'      => new sfValidatorDateTime(array('required' => false)),
      'DataReal'          => new sfValidatorDate(array('required' => false)),
      'TempoPrevisto'     => new sfValidatorNumber(array('required' => false)),
      'TempoGasto'        => new sfValidatorNumber(array('required' => false)),
      'Observacoes'       => new sfValidatorString(array('required' => false)),
      'autorizado'        => new sfValidatorInteger(array('min' => -128, 'max' => 127, 'required' => false)),
      'autorizadopor'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'cronograma'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'last_update'       => new sfValidatorDate(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tempotarefa[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tempotarefa';
  }


}
