<?php

/**
 * LxAnalytics form base class.
 *
 * @method LxAnalytics getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseLxAnalyticsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id_analytics' => new sfWidgetFormInputHidden(),
      'send_report'  => new sfWidgetFormInputText(),
      'email'        => new sfWidgetFormInputText(),
      'password'     => new sfWidgetFormInputText(),
      'connected'    => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id_analytics' => new sfValidatorPropelChoice(array('model' => 'LxAnalytics', 'column' => 'id_analytics', 'required' => false)),
      'send_report'  => new sfValidatorString(array('max_length' => 20, 'required' => false)),
      'email'        => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'password'     => new sfValidatorString(array('max_length' => 150, 'required' => false)),
      'connected'    => new sfValidatorString(),
    ));

    $this->widgetSchema->setNameFormat('lx_analytics[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'LxAnalytics';
  }


}
