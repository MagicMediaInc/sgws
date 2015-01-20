<?php

/**
 * formulario actions.
 *
 * @package    geografia
 * @subpackage formulario
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class formularioActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' formulario - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  FormularioPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
      		//PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
		}
		//Criterios de busqueda
		$c = new Criteria();
		if($this->getRequestParameter('sort'))
		{
			$this->sort = $this->getRequestParameter('sort');
			switch ($this->getRequestParameter('by')) {

				case 'desc':
					$c->addDescendingOrderByColumn(FormularioPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(FormularioPeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(FormularioPeer::ID_FORMULARIO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(FormularioPeer::NOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(FormularioPeer::CONTEUDO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(FormularioPeer::ARQUIVO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(FormularioPeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('Formulario',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->Formularios = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_formulario','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->Formularios->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' formulario - Lynx Cms');
    $this->form = new FormularioForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' formulario - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("formulario/new");
    }
    

    $this->form = new FormularioForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' formulario - Lynx Cms');
    $this->forward404Unless($Formulario = FormularioPeer::retrieveByPk($request->getParameter('id_formulario')), sprintf('Object Formulario does not exist (%s).', $request->getParameter('id_formulario')));
    $this->form = new FormularioForm($Formulario);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Formulario = FormularioPeer::retrieveByPk($request->getParameter('id_formulario')), sprintf('Object Formulario does not exist (%s).', $request->getParameter('id_formulario')));
    $this->form = new FormularioForm($Formulario);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Formulario = FormularioPeer::retrieveByPk($request->getParameter('id_formulario')), sprintf('Object Formulario does not exist (%s).', $request->getParameter('id_formulario')));
    $Formulario->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('formulario/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Formulario = FormularioPeer::retrieveByPk($val), sprintf('Object Formulario does not exist (%s).', $request->getParameter('id_formulario')));
                    $Formulario->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('formulario/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Formulario = $form->save();
      if($form->getValue('arquivo'))
      {   
            $file = $this->form->getValue('arquivo');
            $dir_formulario =  sfConfig::get('sf_upload_dir').'/formulario/'.$Formulario->getIdFormulario().'/';
            sfProjectConfiguration::getActive()->loadHelpers('upload');
            $fileUploaded = loadFile($file->getOriginalName(), $file->getTempname(), 0, $dir_formulario , 'form', true);          
            $Formulario->setArquivo($fileUploaded);
            $Formulario->save();
      }
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_formulario')){
        return $this->redirect('@default?module=formulario&action=index&'.$this->getUser()->getAttribute('uri_formulario'));
      }else{
        return $this->redirect('formulario/index');
      }
    }
  }
  
  /**
   * Cambia el status del usuario
   *
   * @param sfWebRequest $request
   */
  public function executeChangeStatus(sfWebRequest $request)
  {
      $this->forward404Unless($this->Formulario = FormularioPeer::retrieveByPk($request->getParameter('id_formulario')), sprintf('Object Form does not exist (%s).', $request->getParameter('id_formulario')));
      if($request->getParameter('status'))
      {
        $this->Formulario->setStatus(0);
      }else{
        $this->Formulario->setStatus(1);
      }
      $this->Formulario->save();
  }
}
