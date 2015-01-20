<?php

/**
 * Productos form.
 *
 * @package    sgws
 * @subpackage form
 * @author     Your name here
 */
class ProductosForm extends BaseProductosForm
{
  public function configure()
  {
      $categorias = CategoriaProductoPeer::getListSelect();
      $destauqe = array('S' => 'Sim', 'N' => 'Não');
      $lojas = array(1 => 'SGWS', 2 => 'Enviromaq');
      $unidadeDimensional = array('Diária' => 'Diária', 'Unidade' => 'Unidade', 'Litro' => 'Litro', 'Caixa' => 'Caixa', 'Metro' => 'Metro', 'Pacote' => 'Pacote');
      
      $this->widgetSchema['destaque'] = new sfWidgetFormChoice(array('choices'  => $destauqe,'expanded' => false));
      $this->widgetSchema['id_categoria'] = new sfWidgetFormChoice(array('choices'  => $categorias,'expanded' => false));
      $this->widgetSchema['comprimento'] = new sfWidgetFormChoice(array('choices'  => $unidadeDimensional,'expanded' => false));
      $this->widgetSchema['observacoes'] = new sfWidgetFormTextarea(array(), array('cols'  => 50,'rows' => 8));
      $this->widgetSchema['loja'] = new sfWidgetFormChoice(array('choices'  => $lojas,'expanded' => false));
      
      $this->widgetSchema['foto'] = new sfWidgetFormInputFileEditable(array(
        'file_src' => sfConfig::get('sf_upload_dir').'/producto/galeria/'.$this->getObject()->getFoto(),
        'is_image'  => true,
        'edit_mode' => !$this->isNew(),
        'template'      => '<div>%file%<br />%input%<br /></div>',
      ));
      
      $this->validatorSchema['foto'] = new sfValidatorFile(array(
        'required'   => false,
        'max_size'   => sfConfig::get('app_image_size'),
        'mime_types' => array('image/jpeg','image/pjpeg','image/png','image/gif'),
      ));
      $this->validatorSchema['preco']  = new sfValidatorString(array('required' => true, 'trim' => true));
      $this->validatorSchema['foto'] = new sfImageFileValidator(array(
            'required'      => false,
            'mime_types'    => array('image/jpeg', 'image/png', 'image/gif', 'image/pjpeg'),
            'max_size'      => sfConfig::get('app_image_size'),
            'min_height'    => '251',
            'min_width'     => '392',
            'path'          => false,
        ), array(
            'required'      => "La imagen principal es requerida",
            'max_width'     => "A largura da imagem é muito longo (o máximo é de %min_width%px, tem %width%px ).",
            'min_width'     => "A largura da imagem é muito curta (o mínimo é %min_width%px, tem %width%px ).",
            'max_height'    => "A altura da imagem deve ser 251px.",
            'min_height'    => "A altura da imagem deve ser 251px."
      ));      
      // Agrega un post validador personalizado
      $this->validatorSchema->setPostValidator(
        new sfValidatorCallback(array('callback' => array($this, 'validatePost')))
      );

      //Mensajes de ayuda
      $this->widgetSchema->setHelps(array(
          'foto'     => 'A imagem deve ser JPEG, JPG, PNG ou GIF<br />As dimensões da imagem devem ser 392px x 251px',
      ));
      
      unset($this['escala'], $this['peso'], $this['largura'], $this['altura'], $this['cor'], $this['desconto'], $this['desconto_boleto'], $this['max_parcelas'], $this['credito'], $this['data_cad']);
  }
  
  public function validatePost($validator, $values)
  {
      $values['preco'] = aplication_system::convierteDecimalFormat($values['preco']);
      
      return $values;
  }
  
  protected function doSave($con = null)
  {
      $module = 'productos';
      $appYml = sfConfig::get('app_upload_images_producto');
      // Si hay un nuevo archivo por subir y ya mi registro tiene un archivo asociado entonces,
      if ($this->getObject()->getFoto() && $this->getValue('foto'))
      {
          // recorro y elimino
          for($i=1;$i<=$appYml['copies'];$i++)
          {
              // Elimino las fotos de la carpeta
              if(is_file(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getFoto()))
              {
                unlink(sfConfig::get('sf_upload_dir').'/'.$module.'/'.$appYml['size_'.$i]['pref_'.$i].'_'.$this->getObject()->getFoto());
              }
          }
      } 
  }
}
