<?php

/**
 * negociacao actions.
 *
 * @package    sgws
 * @subpackage negociacao
 * @author     Your name here
 */
class negociacaoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' negociacao - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  NegociacaoPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
					$c->addDescendingOrderByColumn(NegociacaoPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(NegociacaoPeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(NegociacaoPeer::ID_NEGOCIACAO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(NegociacaoPeer::NOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(NegociacaoPeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('Negociacao',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->Negociacaos = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_negociacao','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->Negociacaos->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' negociacao - Lynx Cms');
    $this->form = new NegociacaoForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' negociacao - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("negociacao/new");
    }
    

    $this->form = new NegociacaoForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' negociacao - Lynx Cms');
    $this->forward404Unless($Negociacao = NegociacaoPeer::retrieveByPk($request->getParameter('id_negociacao')), sprintf('Object Negociacao does not exist (%s).', $request->getParameter('id_negociacao')));
    $this->form = new NegociacaoForm($Negociacao);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Negociacao = NegociacaoPeer::retrieveByPk($request->getParameter('id_negociacao')), sprintf('Object Negociacao does not exist (%s).', $request->getParameter('id_negociacao')));
    $this->form = new NegociacaoForm($Negociacao);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($Negociacao = NegociacaoPeer::retrieveByPk($request->getParameter('id_negociacao')), sprintf('Object Negociacao does not exist (%s).', $request->getParameter('id_negociacao')));
    $Negociacao->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('negociacao/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Negociacao = NegociacaoPeer::retrieveByPk($val), sprintf('Object Negociacao does not exist (%s).', $request->getParameter('id_negociacao')));
                    $Negociacao->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('negociacao/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Negociacao = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_negociacao')){
        return $this->redirect('@default?module=negociacao&action=index&'.$this->getUser()->getAttribute('uri_negociacao'));
      }else{
        return $this->redirect('negociacao/index');
      }
    }
  }
}
