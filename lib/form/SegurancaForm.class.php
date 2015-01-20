<?php

/**
 * Seguranca form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class SegurancaForm extends sfForm
{
  public function configure()
  {
    $years = range(2012, 2013);
    $this->widgetSchema['from_date'] = new sfWidgetFormInput(array(),array('size' => '8'));
    $this->widgetSchema['to_date'] = new sfWidgetFormInput(array(),array('size' => '8'));
    
    $this->widgetSchema->setNameFormat('seguranca[%s]');
    
    $this->widgetSchema->setLabels(array(
      'from_date'     => 'Data de Início',
      'to_date'     => 'Data de Fim',     
    ));   
    //Validadores Post-Envio
    
    $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'checkUserAndPassword')))
    );
    
    /*$this->validatorSchema->setPostValidator( new sfValidatorOr( array (
        new sfValidatorAnd( array (
          new sfValidatorSchemaCompare ('from_date', sfValidatorSchemaCompare::NOT_EQUAL, null ), 
          new sfValidatorSchemaCompare ('to_date', sfValidatorSchemaCompare::EQUAL, null )
        )) ,
        new sfValidatorSchemaCompare('from_date', sfValidatorSchemaCompare::LESS_THAN_EQUAL, 'to_date',array('throw_global_error' => false), array('invalid' => 'The start date ("%left_field%") must be before the end date ("%right_field%")' ))
    )));*/
  }
  
  public function checkUserAndPassword($validator, $values) 
  {
      //echo $values['from_date'];exit();
    /*if (!empty($values['login']) && !empty($values['password'])) {
        $this->dataUser = LxUserPeer::validateUserPanel($values['login'], md5($values['password']));
        if($this->dataUser) {
            $this->dataUser->setLastaccess(date('Y-m-d H:i:s'));
            $this->dataUser->save();
        }else {
            $error = new sfValidatorError($validator, sfContext::getInstance()->getI18N()->__('Incorreta combinação de usuário / senha'));
            throw new sfValidatorErrorSchema($validator, array('Error' => $error));
        }
    }*/
    return $values;
  }
  
}