<?php

/**
 * remember actions.
 *
 * @package    sgws
 * @subpackage remember
 * @author     Your name here
 */
class rememberActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' remember - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  ChangeMailPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
					$c->addDescendingOrderByColumn(ChangeMailPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(ChangeMailPeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(ChangeMailPeer::ID_CHANGE_MAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(ChangeMailPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('changeMail',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->changeMails = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_remember','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->changeMails->getPage());
  
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' remember - Lynx Cms');
    $this->form = new changeMailForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' remember - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("remember/new");
    }
    

    $this->form = new changeMailForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' remember - Lynx Cms');
    $this->forward404Unless($changeMail = ChangeMailPeer::retrieveByPk($request->getParameter('id_change_mail')), sprintf('Object changeMail does not exist (%s).', $request->getParameter('id_change_mail')));
    $this->form = new changeMailForm($changeMail);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($changeMail = ChangeMailPeer::retrieveByPk($request->getParameter('id_change_mail')), sprintf('Object changeMail does not exist (%s).', $request->getParameter('id_change_mail')));
    $this->form = new changeMailForm($changeMail);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $lyx = new lynxValida();
    $nueva = $lyx->generadorClave();
    $this->forward404Unless($changeMail = ChangeMailPeer::retrieveByPk($request->getParameter('id_change_mail')), sprintf('Object changeMail does not exist (%s).', $request->getParameter('id_change_mail')));
    $assoc = AsociadosPeer::validateEmailAsociado($changeMail->getEmail());
    $updateSenha = AsociadosPeer::retrieveByPK($assoc->getIdAsociado());
    $updateSenha->setSenha(md5($nueva));
    $updateSenha->save();
    $mail = new sendMail();
    $mail->mailNewSenha($changeMail->getEmail(), $assoc->getNombre(), $nueva);
    
    $changeMail->delete();
    $this->getUser()->setFlash('listo', 'Tem gerado uma nova senha para o usuário');
    return $this->redirect('remember/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($changeMail = ChangeMailPeer::retrieveByPk($val), sprintf('Object changeMail does not exist (%s).', $request->getParameter('id_change_mail')));
                    $changeMail->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('remember/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $changeMail = $form->save();

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_change_mail')){
        return $this->redirect('@default?module=remember&action=index&'.$this->getUser()->getAttribute('uri_remember'));
      }else{
        return $this->redirect('remember/index');
      }
    }
  }
}
