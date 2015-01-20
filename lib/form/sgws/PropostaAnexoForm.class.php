<?php

/**
 * PropostaAnexo form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class PropostaAnexoForm extends BasePropostaAnexoForm
{
  public function configure()
  {
      
      $responsables = LxUserPeer::getGerentesYFinancieroYSocios();
      
      $this->widgetSchema['id_proposta'] = new sfWidgetFormInputHidden();
      $this->widgetSchema['data'] = new sfWidgetFormInputText();
      $this->widgetSchema['id_responsable'] = new sfWidgetFormChoice(array('choices'  => $responsables,'expanded' => false), array('style' => ''));
      $this->widgetSchema['descricao'] = new sfWidgetFormTextarea(array(), array('cols' => '50', 'rows' => '9'));
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'descricao'              => 'Descrição:',
        'id_responsable'         => 'Responsável:',
        
      ));
  }
}
