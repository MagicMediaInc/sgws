<?php

/**
 * SfSection form base class.
 *
 * @method SfSection getObject() Returns the current form's model object
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
abstract class BaseSfSectionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'id_profile'      => new sfWidgetFormInputText(),
      'id_parent'       => new sfWidgetFormInputText(),
      'position'        => new sfWidgetFormInputText(),
      'control'         => new sfWidgetFormInputText(),
      'sw_menu'         => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'home'            => new sfWidgetFormInputText(),
      'special_page'    => new sfWidgetFormInputText(),
      'show_text'       => new sfWidgetFormInputText(),
      'only_complement' => new sfWidgetFormInputText(),
      'url_externa'     => new sfWidgetFormInputText(),
      'delete'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'SfSection', 'column' => 'id', 'required' => false)),
      'id_profile'      => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647)),
      'id_parent'       => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'position'        => new sfValidatorInteger(array('min' => -2147483648, 'max' => 2147483647, 'required' => false)),
      'control'         => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'sw_menu'         => new sfValidatorString(array('max_length' => 200, 'required' => false)),
      'status'          => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'home'            => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'special_page'    => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'show_text'       => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'only_complement' => new sfValidatorString(array('max_length' => 1, 'required' => false)),
      'url_externa'     => new sfValidatorString(array('max_length' => 150)),
      'delete'          => new sfValidatorString(array('max_length' => 1)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorPropelUnique(array('model' => 'SfSection', 'column' => array('sw_menu')))
    );

    $this->widgetSchema->setNameFormat('sf_section[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SfSection';
  }


}
