<?php

/**
 * HorasBillability form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class HorasBillabilityForm extends BaseHorasBillabilityForm
{
  public function configure()
  {
      $range  = range(date('Y')-1, date('Y'));
      $years = array_combine($range,$range);
      
      $this->widgetSchema['Ano'] = new sfWidgetFormChoice(array('choices'  => $years,'expanded' => false));
      
      //Validadores Post-Envio
        $this->validatorSchema->setPostValidator(
                new sfValidatorAnd(
                array(
                    //Verificacon
                    new sfValidatorCallback(array('callback' => array($this, 'validacionPost')))
        )));
  }
  
  public function validacionPost($validator, $values) {
        
       $request =  sfContext::getInstance()->getRequest();
       
        $check = HorasBillabilityPeer::getCheckAno($values['codigo'], $values['Ano']);
        if($check)
        {
             $error = new sfValidatorError($validator, 'Ano já está registrado');
             throw new sfValidatorErrorSchema($validator, array('Ano' => $error));
        }
       

       return $values;
    }
}
