<?php

/**
 * PropostaAnexo form base class.
 *
 * @method PropostaAnexo getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BasePropostaAnexoForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'id_proposta'    => new sfWidgetFormInputText(),
      'id_responsable' => new sfWidgetFormInputText(),
      'descricao'      => new sfWidgetFormTextarea(),
      'data'           => new sfWidgetFormDate(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'PropostaAnexo', 'column' => 'id', 'required' => false)),
      'id_proposta'    => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_responsable' => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'descricao'      => new sfValidatorString(),
      'data'           => new sfValidatorDate(),
    ));

    $this->widgetSchema->setNameFormat('proposta_anexo[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PropostaAnexo';
  }


}
