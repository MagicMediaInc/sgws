<?php

/**
 * producto actions.
 *
 * @package    sgws
 * @subpackage producto
 * @author     Henry Vallenilla <henryvallenilla@gmai.com>
 */
class productoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
        $c = new Criteria();
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' producto - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{   $this->loja = 1;
                    if( !$this->getRequestParameter('loja') ){
                        
                        $c->add(ProductosPeer::LOJA, $this->loja, Criteria::EQUAL);
                    }else{
                        $this->loja = $this->getRequestParameter('loja');
                        $c->add(ProductosPeer::LOJA, $this->loja, Criteria::EQUAL);
                    }//die("1");
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  ProductosPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
                     //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
                     $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		
                if($this->getRequestParameter('categoria'))
                {//die('2');
                    $this->loja = $this->getRequestParameter('loja');
                    $c->add(ProductosPeer::ID_CATEGORIA, $this->getRequestParameter('categoria'), Criteria::EQUAL);
                    $c->addAnd(ProductosPeer::LOJA, $this->loja, Criteria::EQUAL);
                    $categoria = "&cate=".$this->getRequestParameter('categoria');
                    $this->bus_cat = "&cate=".$this->getRequestParameter('categoria');
                }else{
                    $categoria = '';
                    $this->bus_cat = '';
                }
		if($this->getRequestParameter('sort'))
                    
		{       $this->loja = $this->getRequestParameter('loja');
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {

				case 'desc':
                                   // die('3');
					$c->addDescendingOrderByColumn(ProductosPeer::$this->getRequestParameter('sort'));
                                        $c->addAnd(ProductosPeer::LOJA, $this->loja , Criteria::EQUAL);
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
                                   // die('4');
					$c->addAscendingOrderByColumn(ProductosPeer::$this->getRequestParameter('sort'));
                                        $c->addAnd(ProductosPeer::LOJA, $this->loja, Criteria::EQUAL);
					$this->by = "desc";
					$this->by_page = "asc";
					break;
			}
		}else{
			$c->addAscendingOrderByColumn($this->sort);
		}
		if($this->getRequestParameter('buscador'))
		{
                //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
                sfConfig::set('sf_escaping_strategy', false);
                //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
                        $criterio = $c->getNewCriterion(ProductosPeer::ID, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::CODIGO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::DESTAQUE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::NOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::ANO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::ID_CATEGORIA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::ESCALA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::COR, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::PRECO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::ESTOQUE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addOr($c->getNewCriterion(ProductosPeer::MIN_ESTOQUE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                        $criterio->addAnd($c->getNewCriterion(ProductosPeer::LOJA, $this->loja, Criteria::EQUAL));
                        $c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('Productos',20);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->Productoss = $pager;
                if($this->getUser()->getAttribute('loja')){
                $this->restring = $this->getUser()->getAttribute('loja');
                }
                $this->categorias = CategoriaProductoPeer::getLista();
                // Crea sesion de la uri al momento
                $this->getUser()->setAttribute('uri_producto','sort='.$this->sort.'&by='.$this->by_page.$buscador.$categoria.
                        '&page='.$this->Productoss->getPage().'&loj='.$this->getRequestParameter('loja'));

  }

  public function executeNew(sfWebRequest $request)
  {
      //die('producto new')
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' producto - Lynx Cms');
    $this->form = new ProductosForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' producto - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("producto/new");
    }
    

    $this->form = new ProductosForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' producto - Lynx Cms');
    $this->forward404Unless($Productos = ProductosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Productos does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProductosForm($Productos);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Productos = ProductosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Productos does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProductosForm($Productos);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Productos = ProductosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Productos does not exist (%s).', $request->getParameter('id')));
    $Productos->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('producto/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Productos = ProductosPeer::retrieveByPk($val), sprintf('Object Productos does not exist (%s).', $request->getParameter('id')));
                    $Productos->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('producto/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
       //echo $form->getValue('loja'); die();
      $Productos = $form->save();
      $Productos->setCodigo($form->getValue('codigo'));
      $Productos->setDestaque($form->getValue('destaque'));
      $Productos->setNome($form->getValue('nome'));
      $Productos->setAno($form->getValue('ano'));
      $Productos->setIdCategoria($form->getValue('id_categoria'));
      $Productos->setPreco($form->getValue('preco'));
      $Productos->setEstoque($form->getValue('estoque'));
      $Productos->setMinEstoque($form->getValue('min_estoque'));
      $Productos->setComprimento($form->getValue('comprimento'));
      $Productos->setObservacoes($form->getValue('observacoes'));
      $Productos->setLoja($form->getValue('loja'));
      $Productos->save();
      $loja = $form->getValue('loja');
      $dir = sfConfig::get('sf_upload_dir').'/productos/';
      if($form->getValue('foto'))
      {
        $valida = new lynxValida();
        $file = $form->getValue('foto');
        // Aqui cargo la imagen con la funcion loadFiles de mi Helper
        sfProjectConfiguration::getActive()->loadHelpers('upload');
        
        $fileUploaded = loadFile($file->getOriginalName(), $file->getTempname(), 0, sfConfig::get('sf_upload_dir').'/productos/', 'f1_'.$Productos->getId(), false, true);
        transform($dir, $fileUploaded, 'big_', 392, 251);
        // Elimino imagen original
        //unlink($fileUploaded);
        $Productos->setFoto($fileUploaded);
        $Productos->save();
      }

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id')){
        return $this->redirect('@default?module=producto&action=index&'.$this->getUser()->getAttribute('uri_producto').'&loj='.$loja);
      }else{
        return $this->redirect('producto/index/&loj='.$loja);
      }
    }
  }
  
  public function executeDeleteImage(sfWebRequest $request)
  {
    $this->forward404Unless($Model = ProductoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Model does not exist (%s).', $request->getParameter('id')));
    //Delete images process
    if ($Model->getFoto())
    {
      $appYml = sfConfig::get('app_upload_images_producto');
      $uploadDir = sfConfig::get('sf_upload_dir').'/productos/';
      for($i=1;$i<=$appYml['copies'];$i++)
      {
        //Delete images from uploads directory
        if(is_file($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getFoto()))
        {

          unlink($uploadDir.$appYml['size_'.$i]['pref_'.$i].'_'.$Model->getFoto());
        }
      }
    }
    $Model->setFoto('');
    $Model->save();
  }
  
  public function executeDetalhe(sfWebRequest $request)
  { $this->loja = $this->getRequestParameter('loja');
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Detalhe').' do produto ');
    $this->forward404Unless($this->producto = ProductosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Productos does not exist (%s).', $request->getParameter('id')));
    $this->categoria = CategoriaProductoPeer::retrieveByPK($this->producto->getIdCategoria());
  }
  
  
  
  
  
  
}
