<?php

/**
 * SfSectionI18n form base class.
 *
 * @method SfSectionI18n getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfSectionI18nForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'name_section'     => new sfWidgetFormInputText(),
      'descrip_section'  => new sfWidgetFormTextarea(),
      'meta_title'       => new sfWidgetFormInputText(),
      'meta_keyword'     => new sfWidgetFormInputText(),
      'meta_description' => new sfWidgetFormInputText(),
      'id'               => new sfWidgetFormInputHidden(),
      'language'         => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'name_section'     => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'descrip_section'  => new sfValidatorString(),
      'meta_title'       => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'meta_keyword'     => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'meta_description' => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'id'               => new sfValidatorPropelChoice(array('model' => 'SfSectionI18n', 'column' => 'id', 'required' => false)),
      'language'         => new sfValidatorPropelChoice(array('model' => 'SfSectionI18n', 'column' => 'language', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_section_i18n[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfSectionI18n';
  }


}
