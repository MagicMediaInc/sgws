<?php

/**
 * prioridade actions.
 *
 * @package    sgws
 * @subpackage prioridade
 * @author     Your name here
 */
class prioridadeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' prioridade - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  PrioridadePeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
					$c->addDescendingOrderByColumn(PrioridadePeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(PrioridadePeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(PrioridadePeer::ID_PRIORIDADE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(PrioridadePeer::NOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('Prioridade',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->Prioridades = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_prioridade','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->Prioridades->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' prioridade - Lynx Cms');
    $this->form = new PrioridadeForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' prioridade - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("prioridade/new");
    }
    

    $this->form = new PrioridadeForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' prioridade - Lynx Cms');
    $this->forward404Unless($Prioridade = PrioridadePeer::retrieveByPk($request->getParameter('id_prioridade')), sprintf('Object Prioridade does not exist (%s).', $request->getParameter('id_prioridade')));
    $this->form = new PrioridadeForm($Prioridade);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Prioridade = PrioridadePeer::retrieveByPk($request->getParameter('id_prioridade')), sprintf('Object Prioridade does not exist (%s).', $request->getParameter('id_prioridade')));
    $this->form = new PrioridadeForm($Prioridade);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Prioridade = PrioridadePeer::retrieveByPk($request->getParameter('id_prioridade')), sprintf('Object Prioridade does not exist (%s).', $request->getParameter('id_prioridade')));
    $Prioridade->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('prioridade/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Prioridade = PrioridadePeer::retrieveByPk($val), sprintf('Object Prioridade does not exist (%s).', $request->getParameter('id_prioridade')));
                    $Prioridade->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('prioridade/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Prioridade = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_prioridade')){
        return $this->redirect('@default?module=prioridade&action=index&'.$this->getUser()->getAttribute('uri_prioridade'));
      }else{
        return $this->redirect('prioridade/index');
      }
    }
  }
}
