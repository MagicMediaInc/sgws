<?php

/**
 * AnalisisRevision form base class.
 *
 * @method AnalisisRevision getObject() Returns the current form's model object
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseAnalisisRevisionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'id_analisis'             => new sfWidgetFormPropelChoice(array('model' => 'Analisis', 'add_empty' => false)),
      'descricao'               => new sfWidgetFormTextarea(),
      'plazo'                   => new sfWidgetFormInputText(),
      'viabilidade_tecnica'     => new sfWidgetFormInputText(),
      'equipamento_apropiado'   => new sfWidgetFormInputText(),
      'metodologia_validada'    => new sfWidgetFormInputText(),
      'quantidade_amostra'      => new sfWidgetFormInputText(),
      'viabilidade_operacional' => new sfWidgetFormInputText(),
      'tecnico_habilitado'      => new sfWidgetFormInputText(),
      'mano_obra'               => new sfWidgetFormInputText(),
      'plazo_exequivel'         => new sfWidgetFormInputText(),
      'viabilidade_financiera'  => new sfWidgetFormInputText(),
      'valor_adecuado'          => new sfWidgetFormInputText(),
      'plazo_pagamento'         => new sfWidgetFormInputText(),
      'tercerizado'             => new sfWidgetFormInputText(),
      'id_fornecedor'           => new sfWidgetFormInputText(),
      'valor_proposta'          => new sfWidgetFormInputText(),
      'aprobacion_cliente'      => new sfWidgetFormInputText(),
      'responsable_comercial'   => new sfWidgetFormInputText(),
      'responsable_tecnico'     => new sfWidgetFormInputText(),
      'aprobacion_proposta'     => new sfWidgetFormInputText(),
      'codigo_proposta_final'   => new sfWidgetFormInputText(),
      'validade_proposta'       => new sfWidgetFormInputText(),
      'data_aprobacion'         => new sfWidgetFormDate(),
      'forma_aprobacion'        => new sfWidgetFormInputText(),
      'precio'                  => new sfWidgetFormInputText(),
      'forma_pagamento'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorPropelChoice(array('model' => 'AnalisisRevision', 'column' => 'id', 'required' => false)),
      'id_analisis'             => new sfValidatorPropelChoice(array('model' => 'Analisis', 'column' => 'id')),
      'descricao'               => new sfValidatorString(),
      'plazo'                   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'viabilidade_tecnica'     => new sfValidatorString(),
      'equipamento_apropiado'   => new sfValidatorString(),
      'metodologia_validada'    => new sfValidatorString(),
      'quantidade_amostra'      => new sfValidatorString(),
      'viabilidade_operacional' => new sfValidatorString(),
      'tecnico_habilitado'      => new sfValidatorString(),
      'mano_obra'               => new sfValidatorString(),
      'plazo_exequivel'         => new sfValidatorString(),
      'viabilidade_financiera'  => new sfValidatorString(),
      'valor_adecuado'          => new sfValidatorString(),
      'plazo_pagamento'         => new sfValidatorString(),
      'tercerizado'             => new sfValidatorString(),
      'id_fornecedor'           => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'valor_proposta'          => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'aprobacion_cliente'      => new sfValidatorString(),
      'responsable_comercial'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'responsable_tecnico'     => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'aprobacion_proposta'     => new sfValidatorString(),
      'codigo_proposta_final'   => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'validade_proposta'       => new sfValidatorString(array('max_length' => 20)),
      'data_aprobacion'         => new sfValidatorDate(),
      'forma_aprobacion'        => new sfValidatorString(array('max_length' => 20)),
      'precio'                  => new sfValidatorNumber(),
      'forma_pagamento'         => new sfValidatorString(array('max_length' => 15)),
    ));

    $this->widgetSchema->setNameFormat('analisis_revision[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AnalisisRevision';
  }


}
