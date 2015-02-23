<?php

/**
 * subtipo actions.
 *
 * @package    sgws
 * @subpackage subtipo
 * @author     Your name here
 */
class subtipoActions extends sfActions
{
  public function preExecute() {
        $this->log = new sfLogActivities();
  }

  public function executeIndex(sfWebRequest $request)
  {
  
  $this->log->registerLog();
  $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' subtipo - Lynx Cms');
	if (!$this->getRequestParameter('buscador')){
			$this->buscador = '';
		}else{
			$this->buscador = $this->getRequestParameter('buscador');
		}
		if(!$this->getRequestParameter('by'))
		{
			$this->by = 'desc';               // Variable para el orden de los registros
			$this->by_page = "asc";           // Variable para el paginador y las flechas de orden
			$sortTemp =  SubtipoUserPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
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
					$c->addDescendingOrderByColumn(SubtipoUserPeer::$this->getRequestParameter('sort'));
					$this->by = "asc";
					$this->by_page = "desc";
					break;
				default:
					$c->addAscendingOrderByColumn(SubtipoUserPeer::$this->getRequestParameter('sort'));
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
                		                                    $criterio = $c->getNewCriterion(SubtipoUserPeer::ID_SUBTIPO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
                                		                                    $criterio->addOr($c->getNewCriterion(SubtipoUserPeer::ID_TIPO_CADASTRO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SubtipoUserPeer::ID_PARENT, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SubtipoUserPeer::POSITION, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                		                                    $criterio->addOr($c->getNewCriterion(SubtipoUserPeer::SUBTIPO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
                                					$c->add($criterio);
			$buscador = "&buscador=".$this->buscador;
			$this->bus_pagi = "&buscador=".$this->buscador;
		}else{
			$buscador = "";
			$this->bus_pagi = "";
		}
			
		$pager = new sfPropelPager('SubtipoUser',10);
		$pager->setCriteria($c);
		$pager->setPage($this->getRequestParameter('page',1));
		$pager->init();
		$this->SubtipoUsers = $pager;                
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_subtipo','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->SubtipoUsers->getPage());
        // Lista de Tipos de Cadastros para la busqueda
        $this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro('all');
  }

  public function executeNew(sfWebRequest $request)
  {
    sfConfig::set('sf_escaping_strategy', false);
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' subtipo - Lynx Cms');
    $this->form = new SubtipoUserForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' subtipo - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("subtipo/new");
    }
    

    $this->form = new SubtipoUserForm();
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
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' subtipo - Lynx Cms');
    $this->forward404Unless($SubtipoUser = SubtipoUserPeer::retrieveByPk($request->getParameter('id_subtipo')), sprintf('Object SubtipoUser does not exist (%s).', $request->getParameter('id_subtipo')));
    $this->form = new SubtipoUserForm($SubtipoUser);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($SubtipoUser = SubtipoUserPeer::retrieveByPk($request->getParameter('id_subtipo')), sprintf('Object SubtipoUser does not exist (%s).', $request->getParameter('id_subtipo')));
    $this->form = new SubtipoUserForm($SubtipoUser);

    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($SubtipoUser = SubtipoUserPeer::retrieveByPk($request->getParameter('id_subtipo')), sprintf('Object SubtipoUser does not exist (%s).', $request->getParameter('id_subtipo')));
    $SubtipoUser->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('subtipo/index');
  }



public function executeDeleteAll(sfWebRequest $request)
{
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($SubtipoUser = SubtipoUserPeer::retrieveByPk($val), sprintf('Object SubtipoUser does not exist (%s).', $request->getParameter('id_subtipo')));
                    $SubtipoUser->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('subtipo/index');
}

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $SubtipoUser = $form->save();
      $idParent = $form->getValue('id_parent');
      // Ahora verifica la ultima posicion del id_padre
      $position = SubtipoUserPeer::identifiesPosition($idParent);
      if (!$form->getValue('id_subtipo'))
      {
        $languagePrincipal = SfLanguagePeer::getLanguagePrincipal();
        $SubTipo = SubtipoUserPeer::retrieveByPK($SubtipoUser->getIdSubtipo());
        $SubTipo->setIdParent($idParent);
        $SubTipo->setPosition($position['position']+1);
        $SubTipo->save();        
      }
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($request->getParameter('id_subtipo')){
        return $this->redirect('@default?module=subtipo&action=index&'.$this->getUser()->getAttribute('uri_subtipo'));
      }else{
        return $this->redirect('subtipo/index');
      }
    }
  }
  
  /**
     * Building Sections Tree
     * @param sfWebRequest $request 
     */
  public function executeTreeSections(sfWebRequest $request)
  {
  	$this->nodes = array();
        $this->tipoCadastro = 3;
  	// retrieve all children of $parent
	$node = $this->getRequestParameter('node');
	if (  $node == 0){
		$node = 0; // Initial node.
	}
        
	$result = SubtipoUserPeer::displaySubTipos($node, $this->tipoCadastro);
	// display each child
        if($result){
            foreach ($result as $row) {
                // Response parameters.
                $path['text']		= $row['subtipo'];
                $path['id']             = $row['id'];
                $path['position']	= $row['position'];
                if($row['home'])
                {
                        $path['disabled']	= true;
                }else{
                        $path['disabled']	= false;
                }                
                $server = "http://".$_SERVER['HTTP_HOST'].'/backend_dev.php/';
                $path['href']	    = $server.'subtipo/edit/id_subtipo/'.$row['id'];
                // Check if node is a leaf or a folder.
                $cCount = SubtipoUserPeer::countSubTipos($row['id']);
                //$cCount = count($cCount);
                if($cCount > 0){
                        $path['leaf']	= false;
                        $path['cls']	= 'folder';
                        $path['nextSibling'] = false;
                }else{
                        $path['leaf']	= false;
                        $path['cls']	= 'folder';
                        $path['nextSibling'] = false;
                }
                // call this function again to display this
                // child's children
                $this->nodes[] = $path;
            }
        }
  }
  
  /**
    * Funcion que actualiza la posicion de una seccion al detectar que cambio de posicion
    *
    */
   public function executeListenerMove(sfWebRequest $request)
   { 
        $id_subtipo = $this->getRequestParameter('id_subtipo');
        $padre_antes = $this->getRequestParameter('padre_antes');
        $padre_nuevo = $this->getRequestParameter('padre_nuevo');
        $id_tipo_cadastro = 3;
        $posicion = $this->getRequestParameter('posicion');        
        /*****************************************************************/
        $posicion_actual = SubtipoUserPeer::positionSubTipo($id_subtipo);
        $posicion_actual = $posicion_actual['posicion'];
        if ($padre_antes==$padre_nuevo)
        {
            if ($posicion < $posicion_actual)
            {
                for($i=$posicion_actual;$i>=$posicion;$i--)
                {
                    $nueva_pos=$i+1;
                    if($nueva_pos==0)
                    {
                        $nueva_pos = 1;
                    }
                    SubtipoUserPeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }else{
                for($i=$posicion_actual;$i<=$posicion;$i++)
                {
                    $nueva_pos=$i-1;
                    if($nueva_pos==0)
                    {
                            $nueva_pos = 1;
                    }
                    SubtipoUserPeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }
            SubtipoUserPeer::updatePrincipalPosition($posicion,$id_subtipo);
        }else{
            $result = SubtipoUserPeer::displaySubTipos($padre_nuevo, $id_tipo_cadastro);
            $total = count($result);
            if ($total==0)
            {
                SubtipoUserPeer::updatePaternSubTipo($padre_nuevo,$id_subtipo);
            }else{
                if($result){
                    foreach ($result as $row)
                    {
                        if($row['position']>=$posicion)
                        {
                                $pos_nueva=$row['position']+1;
                                SubtipoUserPeer::updatePrincipalPosition($pos_nueva,$row['id']);
                        }
                        if ($posicion>$total)
                        {
                                SubtipoUserPeer::updatePrincipalPosition($posicion,$id_subtipo);
                        }
                    }
                }
            }
            // Lee las siguientes secciones a partir de la posicion de la seccion seleccionada
            $siguientes = SubtipoUserPeer::subTiposNext($padre_antes,$posicion_actual);
            if(count($siguientes))
            {
                $posicion_actual = $posicion_actual - 1;
                if($siguientes)
                {
                    foreach ($siguientes as $dato_seccion) {
                        $posicion_actual++;
                        SubtipoUserPeer::updatePrincipalPosition($posicion_actual,$dato_seccion['id']);
                    }
                }
            }
            SubtipoUserPeer::updatePaternSubTipoPosition($padre_nuevo,$posicion,$id_subtipo);
            // Verifica si queda un solo padre para inicializarle la posicion
            $verifica = SubtipoUserPeer::checkExistPaterns(0);
            if(count($verifica)==1)
            {
                SubtipoUserPeer::updatePrincipalPosition(1,$verifica['id']);
            }
        }
   }

   
   public function executeListaSubTipos(sfWebRequest $request)
   {
       $this->id = $request->getParameter('id_tipo_cadastro');
       $this->tipo_cadastro = TipoCadastroPeer::retrieveByPK($this->id);
       $this->subtipos = TipoCadastroPeer::listSubTiposPaiByTC($this->id);
       $server = "http://".$_SERVER['HTTP_HOST'].'/backend_dev.php/';
       if($this->subtipos)
       {
            $this->html.= '<ul class="files-directory">';
            foreach ($this->subtipos as $file) {
                $this->html.= '<li>';
                $this->html.= '<img src="/images/li.png" width="8" style="margin-right: 5px;"  />
                    <a href="'.$server.'subtipo/edit/id_subtipo/'.$file['id_subtipo'].'">'.$file['subtipo']."<br>";
                $this->html.= '</li>';
                $this->html.= '<li>';
                $this->html.= $this->findSubTiposHijos($file['id_subtipo'],"&nbsp;",$this->id);
                $this->html.= '</li>';
                
            }
            $this->html.= '</ul>';
       }
   }
   
   function findSubTiposHijos($id_subtipo_pai=0 , $tab = "", $id_tipo_cadastro)
   {
     
     $hijos =  SubtipoUserPeer::listSubTiposPaiByTC($id_tipo_cadastro, $id_subtipo_pai);
     $server = "http://".$_SERVER['HTTP_HOST'].'/backend_dev.php/';
     $tab.= "&nbsp;&nbsp;&nbsp;&nbsp;";
     if($hijos)
     {
         $this->html.= '<ul>';
         foreach ($hijos as $fil) {
            $this->html.= '<li>';
            $this->html.= $tab.'<img src="/images/li.png" width="8" style="margin-right: 5px;" />
                <a href="'.$server.'subtipo/edit/id_subtipo/'.$fil['id_subtipo'].'">'.$fil['subtipo']."<br>";
            $this->html.= '</li>';
            $this->html.= '<li>';
            $this->findSubTiposHijos($fil['id_subtipo'],$tab, $id_tipo_cadastro);
            $this->html.= '</li>';
         }
         $this->html.= '</ul>';
     }
   }
}
