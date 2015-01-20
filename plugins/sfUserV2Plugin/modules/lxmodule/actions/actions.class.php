<?php

/**
 * lxmodule actions.
 *
 * @package    lynx4
 * @subpackage lxmodule
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class lxmoduleActions extends sfActions {
    public function executeIndex(sfWebRequest $request) {
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' module - Lynx Cms');
        if (!$this->getRequestParameter('buscador')) {
            $this->buscador = '';
        }else {
            $this->buscador = $this->getRequestParameter('buscador');
        }
        if(!$this->getRequestParameter('by')) {
            $this->by = 'desc';               // Variable para el orden de los registros
            $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $this->sort = 'name_module';      // Nombre del campo que por defecto se ordenara
        }
        //Criterios de busqueda
        $c = new Criteria();
        if($this->getRequestParameter('sort')) {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {

                case 'desc':
                    $c->addDescendingOrderByColumn(LxModulePeer::$this->getRequestParameter('sort'));
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $c->addAscendingOrderByColumn(LxModulePeer::$this->getRequestParameter('sort'));
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
        }else {
            $c->addAscendingOrderByColumn($this->sort);
        }
        if($this->getRequestParameter('buscador')) {
            sfConfig::set('sf_escaping_strategy', false);
            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
            $criterio = $c->getNewCriterion(LxModulePeer::NAME_MODULE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(LxModulePeer::SF_MODULE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(LxModulePeer::CREDENTIAL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
        }else {
            $buscador = "";
            $this->bus_pagi = "";
        }

        $pager = new sfPropelPager('LxModule',100);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page',1));
        $pager->init();
        $this->LxModules = $pager;
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_lxmodule','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->LxModules->getPage());

    }

    public function executeNew(sfWebRequest $request) {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' module - Lynx Cms');
        $this->form = new LxModuleForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    }

    public function executeCreate(sfWebRequest $request) {
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' module - Lynx Cms');
        if (!$request->isMethod('post')) {
            $this->redirect("lxmodule/new");
        }


        $this->form = new LxModuleForm();
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->processForm($request, $this->form);
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' module - Lynx Cms');
        $this->forward404Unless($LxModule = LxModulePeer::retrieveByPk($request->getParameter('id_module')), sprintf('Object LxModule does not exist (%s).', $request->getParameter('id_module')));
        $this->form = new LxModuleForm($LxModule);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    }

    public function executeUpdate(sfWebRequest $request) {

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($LxModule = LxModulePeer::retrieveByPk($request->getParameter('id_module')), sprintf('Object LxModule does not exist (%s).', $request->getParameter('id_module')));
        $this->form = new LxModuleForm($LxModule);

        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($LxModule = LxModulePeer::retrieveByPk($request->getParameter('id_module')), sprintf('Object LxModule does not exist (%s).', $request->getParameter('id_module')));
        //$this->forward404If($LxModule->getDelete()); // No se pueden borrar los modulos marcados para no borrar
        //Elimina los hijos si se elimina un modulo padre
        if(!$LxModule->getIdParent()) {

            $lxModuleParents = LxModulePeer::getModulesChildrenXSelect($request->getParameter('id_module'));
            foreach ($lxModuleParents as $lxModuleParent) {
                $this->forward404If($lxModuleParent->getDelete()); // No se pueden borrar los modulos marcados para no borrar
                //Elimina las credenciales de los modulos hijos
                if($this->getUser()->hasCredential($lxModuleParent->getCredential().'_view')) {
                    //$this->getUser()->removeCredential($lxModuleParent->getCredential());
                    $this->getUser()->removeCredential($lxModuleParent->getCredential().'_view');
                    $this->getUser()->removeCredential($lxModuleParent->getCredential().'_insert');
                    $this->getUser()->removeCredential($lxModuleParent->getCredential().'_update');
                    $this->getUser()->removeCredential($lxModuleParent->getCredential().'_delete');
                }
                $lxModuleParent->delete();
            }
        }
        $LxModule->delete();
        //Elimina la credencial si el usuario la esta usando

        if($this->getUser()->hasCredential($LxModule->getCredential().'_view')) {
            //$this->getUser()->removeCredential($LxModule->getCredential());
            $this->getUser()->removeCredential($LxModule->getCredential().'_view');
            $this->getUser()->removeCredential($LxModule->getCredential().'_insert');
            $this->getUser()->removeCredential($LxModule->getCredential().'_update');
            $this->getUser()->removeCredential($LxModule->getCredential().'_delete');
        }
        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('lxmodule/index');
    }
    public function executeDeleteAll(sfWebRequest $request) {
        if ($this->getRequestParameter('chk')) {
            foreach ($this->getRequestParameter('chk') as $gr => $val) {

                $LxModule = LxModulePeer::retrieveByPk($val);
                $this->forward404If($LxModule->getDelete()); // No se pueden borrar los modulos marcados para no borrar
                $this->redirectUnless($LxModule,'lxmodule/index');
                //Elimina los hijos si se elimina un modulo padre
                if(!$LxModule->getIdParent()) {
                    $lxModuleParents = LxModulePeer::getModulesChildrenXSelect($val);
                    foreach ($lxModuleParents as $lxModuleParent) {
                        //Elimina las credenciales de los modulos hijos
                        if($this->getUser()->hasCredential($lxModuleParent->getCredential().'_view')) {
                            //$this->getUser()->removeCredential($lxModuleParent->getCredential());
                            $this->getUser()->removeCredential($lxModuleParent->getCredential().'_view');
                            $this->getUser()->removeCredential($lxModuleParent->getCredential().'_insert');
                            $this->getUser()->removeCredential($lxModuleParent->getCredential().'_update');
                            $this->getUser()->removeCredential($lxModuleParent->getCredential().'_delete');
                        }
                        $lxModuleParent->delete();
                    }
                }
                $LxModule->delete();
                //Elimina la credencial si el usuario la esta usando
                if($this->getUser()->hasCredential($LxModule->getCredential().'_view')) {
                    //$this->getUser()->removeCredential($LxModule->getCredential());
                    $this->getUser()->removeCredential($LxModule->getCredential().'_view');
                    $this->getUser()->removeCredential($LxModule->getCredential().'_insert');
                    $this->getUser()->removeCredential($LxModule->getCredential().'_update');
                    $this->getUser()->removeCredential($LxModule->getCredential().'_delete');
                }
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

        }
        return $this->redirect('lxmodule/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        //print_r($request->getParameter($form->getName()));
        //  exit();
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {

            $LxModule = $form->save();

            //Relaciona el perfil del administrador con el modulo registrado
            if (!$form->getValue('id_module')) {
                for($i=1;$i<5;$i++) {
                    $lxUseModule = new LxProfileModule();
                    $lxUseModule->setIdPrivilege($i);
                    $lxUseModule->setIdProfile(1);
                    $lxUseModule->setIdModule($LxModule->getIdModule());
                    $lxUseModule->save();
                }
            }
            //Asigna las credencial del modulo solo si esta activo
            if($form->getValue('status')) {
                $this->getUser()->addCredential($form->getValue('credential').'_view');
                $this->getUser()->addCredential($form->getValue('credential').'_insert');
                $this->getUser()->addCredential($form->getValue('credential').'_update');
                $this->getUser()->addCredential($form->getValue('credential').'_delete');
            }else {
                //Elimina la credencial si el usuario la esta usando
                if($this->getUser()->hasCredential($form->getValue('credential').'_view')) {
                    $this->getUser()->removeCredential($form->getValue('credential').'_view');
                    $this->getUser()->removeCredential($form->getValue('credential').'_insert');
                    $this->getUser()->removeCredential($form->getValue('credential').'_update');
                    $this->getUser()->removeCredential($form->getValue('credential').'_delete');
                }
            }
        }
        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
        if($request->getParameter('id_module')) {
            return $this->redirect('@default?module=lxmodule&action=index&'.$this->getUser()->getAttribute('uri_lxmodule'));
        }else {
            return $this->redirect('lxmodule/index');
        }

    }


    /**
     * Building Sections Tree
     * @param sfWebRequest $request
     */
    public function executeTreeSections(sfWebRequest $request) {
        $this->setLayout(false);
        $this->nodes = array();
        // retrieve all children of $parent
        $node = $this->getRequestParameter('node');
        if ($node == 0) {
            $node = 0; // Initial node.
        }
        $result = LxModulePeer::displayModules($node);

        if($result) {
            foreach ($result as $row) {
                // Response parameters.
                $path['text']		= $row['name_module'];
                $path['id']             = $row['id_module'];
                $path['position']	= $row['position'];
                if(!$row['status']) {
                    $path['disabled']	= true;
                }else {
                    $path['disabled']	= false;
                }

                //$path['href'] = '/lxmodule/edit/id_module/'.$row['id_module'];
                $path['href'] = '#';
                // Check if node is a leaf or a folder.
                $cCount = LxModulePeer::countSections($row['id_module']);
                //$cCount = count($cCount);
                if($cCount > 0) {
                    $path['leaf']	= false;
                    $path['cls']	= 'folder';
                    $path['nextSibling'] = false;
                }else {
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
    public function executeListenerMove(sfWebRequest $request) {
        $id_modulo = $this->getRequestParameter('id_module');
        $padre_antes = $this->getRequestParameter('padre_antes');
        $padre_nuevo = $this->getRequestParameter('padre_nuevo');
        $posicion = $this->getRequestParameter('posicion');
        /*****************************************************************/
        $posicion_actual = LxModulePeer::positionSection($id_modulo);
        $posicion_actual = $posicion_actual['posicion'];
        if ($padre_antes==$padre_nuevo) {
            if ($posicion < $posicion_actual) {
                for($i=$posicion_actual;$i>=$posicion;$i--) {
                    $nueva_pos=$i+1;
                    if($nueva_pos==0) {
                        $nueva_pos = 1;
                    }
                    LxModulePeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }else {
                for($i=$posicion_actual;$i<=$posicion;$i++) {
                    $nueva_pos=$i-1;
                    if($nueva_pos==0) {
                        $nueva_pos = 1;
                    }
                    LxModulePeer::updatePosition($nueva_pos,$padre_antes,$i);
                }
            }
            LxModulePeer::updatePrincipalPosition($posicion,$id_modulo);
        }else {
            $result = LxModulePeer::displayModules($padre_nuevo);
            $total = count($result);
            if ($total==0) {
                LxModulePeer::updatePaternSection($padre_nuevo,$id_modulo);
            }else {
                if($result) {
                    foreach ($result as $row) {
                        if($row['position']>=$posicion) {
                            $pos_nueva=$row['position']+1;
                            LxModulePeer::updatePrincipalPosition($pos_nueva,$row['id']);
                        }
                        if ($posicion>$total) {
                            LxModulePeer::updatePrincipalPosition($posicion,$id_modulo);
                        }
                    }
                }
            }
            // Lee las siguientes secciones a partir de la posicion de la seccion seleccionada
            $siguientes = LxModulePeer::sectionsNext($padre_antes,$posicion_actual);
            if(count($siguientes)) {
                $posicion_actual = $posicion_actual - 1;
                if($siguientes) {
                    foreach ($siguientes as $dato_seccion) {
                        $posicion_actual++;
                        LxModulePeer::updatePrincipalPosition($posicion_actual,$dato_seccion['id']);
                    }
                }
            }
            LxModulePeer::updatePaternSectionPosition($padre_nuevo,$posicion,$id_modulo);
            // Verifica si queda un solo padre para inicializarle la posicion
            $verifica = LxModulePeer::checkExistPaterns(0);
            if(count($verifica)==1) {
                LxModulePeer::updatePrincipalPosition(1,$verifica['id']);
            }
        }
    }

}
