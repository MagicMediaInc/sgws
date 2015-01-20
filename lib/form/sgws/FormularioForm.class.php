<?php

/**
 * Formulario form.
 *
 * @package    Geografia
 * @subpackage form
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class FormularioForm extends BaseFormularioForm
{
  public function configure()
  {
      $this->widgetSchema['nome']->setAttributes(array('class' => 'validate[required]','size' => '70','maxlength' => '100'));
      $this->widgetSchema['conteudo'] = new sfWidgetFormTextarea(array(),array('cols' => '70', 'rows' => '6'));
      $this->widgetSchema['arquivo']        = new sfWidgetFormInputFileEditable(array(
            'file_src' => '',
            'is_image'  => false,            
            'with_delete' => false,
        ));
      $this->widgetSchema['status']   = new sfWidgetFormChoice(array('choices' => array('1' => 'Ativo', '0' => 'Desativo')));
      // Validators
      $this->validatorSchema['nome'] = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['conteudo'] = new sfValidatorString(array('required' => false, 'trim' => true));
      $this->validatorSchema['arquivo'] = new sfValidatorFile(array(
        'required'   => false,
        'max_size'   => '5145728',
        'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif', 'application/vnd.ms-excel', 'text/plain', 'application/vnd.ms-powerpoint', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ),
        )); 
      
      // Labels              
      $this->widgetSchema->setLabels(array(
        'nome'         => 'Nome:',
        'conteudo'     => 'Descrição:',
        'status'       => 'Status:',
        'arquivo'      => 'Arquivo:',
      ));
      
      //Mensajes de ayuda
      $this->widgetSchema->setHelps(array(
          'arquivo'     => 'O arquivo deve ter no máximo 5MB',
      ));
  }
  
  protected function doSave($con = null)
  {
      $module = 'formulario';
      if ($this->getObject()->getArquivo() && $this->getValue('arquivo'))
      {
        if(is_file(sfConfig::get('sf_upload_dir').'/'.$module.'/form_'.$this->getObject()->getArquivo()))
        {
          unlink(sfConfig::get('sf_upload_dir').'/'.$module.'/form_'.$this->getObject()->getArquivo());
        }
      }      
            
      return parent::doSave($con);
  }
}
