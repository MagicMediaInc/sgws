<?php



/**

 * lxuser actions.

 *

 * @package    SoloLar

 * @subpackage lxuser

 * @author     Henry Vallenilla <henryvallenilla@gmail.com>

 */

class lxuserActions extends sfActions {

    public function preExecute() {

        $this->log = new sfLogActivities();

//        echo md5('123456');

    }

    

    public function executeLoadFormCadastro(sfWebRequest $request)

    {

        $this->setLayout(false);

        switch ($request->getParameter('type')) {

            case 2:

                // Pessoa Fisica

                $this->form = new CadastroFisicaForm();

                break;

            case 3:

                // Pessoa Juridica

                $this->form = new CadastroJuridicaForm();

                break;

        }

    }



    public function executeIndex(sfWebRequest $request) {

        $this->rs = new lynxValida();

        $this->log->registerLog();

        $this->getUser()->setAttribute('new_user', 0);

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista usuários').' - '.sfConfig::get('app_name_app'));

        if (!$this->getRequestParameter('buscador')) {

            $this->buscador = '';

        }else {

            $this->buscador = $this->getRequestParameter('buscador');

        }

        

        if(!$this->getRequestParameter('by')) {

            $this->by = 'desc';               // Variable para el orden de los registros

            $this->by_page = "asc";           // Variable para el paginador y las flechas de orden



            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO

            $this->sort = 'name';      // Nombre del campo que por defecto se ordenara

        }

        //Criterios de busqueda

        

        if($this->getRequestParameter('radio-cad') == 2 || $this->getRequestParameter('radio-cad') == 3)

        {

            $c = new Criteria();

            if($this->getRequestParameter('by_status'))

            {

                $this->status = $this->getRequestParameter('by_status') != 99 ? $this->getRequestParameter('by_status') : '';
                if($this->status)

                {

                    $this->status = $this->getRequestParameter('by_status') == 2 ? '0' : $this->getRequestParameter('by_status');

                    $c->add(CadastroJuridicaPeer::STATUS, $this->status, Criteria::EQUAL);

                }

            }else{

                $this->status = '1'; // Activos por defecto

                $c->add(CadastroJuridicaPeer::STATUS, $this->status, Criteria::EQUAL);

            }

            

            $this->getUser()->setAttribute('tc_empresa', $this->getRequestParameter('radio-cad'));

            switch ($this->getRequestParameter('radio-cad')) {

                case 2:

                    $c->add(CadastroJuridicaPeer::TIPO_CADASTRO, 'Cliente', Criteria::EQUAL);
                    break;

                case 3:

                    $c->add(CadastroJuridicaPeer::TIPO_CADASTRO, 'Fornecedor', Criteria::EQUAL);
                    break;

            }

            if($this->getRequestParameter('buscador')) {
                sfConfig::set('sf_escaping_strategy', false);

                $criterio = $c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::CODIGO_CLIENTE, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::RAZAO_SOCIAL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::CNPJ, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::ENDERECO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::COMPLEMENTO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::CEP, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $c->add($criterio);

                $buscador = "&buscador=".$this->buscador;

                $this->bus_pagi = "&buscador=".$this->buscador;

            }else {

                $buscador = "";

                $this->bus_pagi = "";

            }

            $c->addAscendingOrderByColumn(CadastroJuridicaPeer::CODIGO_CLIENTE);

            $pager = new sfPropelPager('CadastroJuridica',20);

            $pager->setCriteria($c);

            $pager->setPage($this->getRequestParameter('page',1));

            $pager->setPeerMethod('doSelect');

            $pager->init();

            $this->LxUsers = $pager;

            $this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro('all');

            $this->setTemplate('indexCliente');

            

        }else{

            

            $c = new Criteria();

            $this->getUser()->setAttribute('tc_empresa', null);

            $c->add(LxUserPeer::ID_USER, '2', Criteria::GREATER_THAN);

            //Filtra por tipo de cadastro

            if($this->getRequestParameter('by_status'))

            {

                $this->status = $this->getRequestParameter('by_status') != 99 ? $this->getRequestParameter('by_status') : '';

                if($this->status)

                {

                    $this->status = $this->getRequestParameter('by_status') == 2 ? '0' : $this->getRequestParameter('by_status');

                    $c->add(LxUserPeer::STATUS, $this->status, Criteria::EQUAL);

                }

            }else{

                $this->status = '1'; // Activos por defecto

                $c->add(LxUserPeer::STATUS, $this->status, Criteria::EQUAL);

            }

            

            if($this->getRequestParameter('sort')) {

                $this->sort = $this->getRequestParameter('sort');

                switch ($this->getRequestParameter('by')) {



                    case 'desc':

                        $c->addDescendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));

                        $this->by = "asc";

                        $this->by_page = "desc";

                        break;

                    default:

                        $c->addAscendingOrderByColumn(LxUserPeer::$this->getRequestParameter('sort'));

                        $this->by = "desc";

                        $this->by_page = "asc";

                        break;

                }

            }else {

                $c->addAscendingOrderByColumn($this->sort);

            }

            if($this->getRequestParameter('radio-cad'))

            {



                //$c->addJoin(LxUserPeer::ID_USER, VinculoUserTipoCadastroPeer::ID_USER, Criteria::LEFT_JOIN);

                //$c->add(VinculoUserTipoCadastroPeer::ID_TIPO_CADASTRO, $this->getRequestParameter('radio-cad'), Criteria::EQUAL);

                //$c->addGroupByColumn(VinculoUserTipoCadastroPeer::ID_USER);

            }

            if($this->getRequestParameter('buscador')) {

                sfConfig::set('sf_escaping_strategy', false);

                $c->addJoin(LxUserPeer::ID_USER, CadastroFisicaPeer::ID_USER, Criteria::LEFT_JOIN);

                $c->addJoin(LxUserPeer::ID_USER, CadastroJuridicaPeer::ID_USER, Criteria::LEFT_JOIN);



                $criterio = $c->getNewCriterion(LxUserPeer::LOGIN, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);

                $criterio->addOr($c->getNewCriterion(CadastroFisicaPeer::NOME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(LxUserPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));

                $c->add($criterio);

                $buscador = "&buscador=".$this->buscador;

                $this->bus_pagi = "&buscador=".$this->buscador;

            }else {

                $buscador = "";

                $this->bus_pagi = "";

            }

            $c->addAscendingOrderByColumn(LxUserPeer::STATUS);

            

            $pager = new sfPropelPager('LxUser',20);

            $pager->setCriteria($c);

            

            $pager->setPage($this->getRequestParameter('page',1));

            $pager->setPeerMethod('doSelect');

            $pager->init();

            $this->LxUsers = $pager;

            //echo count($this->LxUsers);die();

            

            $this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro('all');

        }

        $this->tipoR = "&radio-cad=".$this->getRequestParameter('radio-cad');	

        $this->bus_TC = 'radio-cad='.$this->getRequestParameter('radio-cad');

        // Lista de Tipos de Cadastros para la busqueda

        

        // Crea sesion de la uri al momento

        $this->getUser()->setAttribute('uri_lxuser','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->LxUsers->getPage());

	

    }



    public function executeNew(sfWebRequest $request) {

        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list

        sfConfig::set('sf_escaping_strategy', false);

        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Adicionar novo Usuário').' - '.sfConfig::get('app_name_app'));

        

        $this->form = new CadastroFisicaForm();

        

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        

        $subtipos = SubtipoUserPeer::displayListSubTipos();

        $this->html = "";

        foreach ($subtipos as $st) :

            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';

            $this->html.= $st['subtipo'].'<br />';

            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");

        endforeach;  

    }

    

    public function executeNewJuridico(sfWebRequest $request) {

        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list

        sfConfig::set('sf_escaping_strategy', false);

        $this->forward404Unless($request->getParameter('tcad') > 1 && $request->getParameter('tcad') < 4 );

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Adicionar novo Usuário Jurídico').' - '.sfConfig::get('app_name_app'));

        

        $this->form = new CadastroJuridicaForm();

        

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->getUser()->setAttribute('tc_empresa', $request->getParameter('tcad'));

        $subtipos = SubtipoUserPeer::displayListSubTipos();

        $this->html = "";

        foreach ($subtipos as $st) :

            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';

            $this->html.= $st['subtipo'].'<br />';

            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");

        endforeach;

        $this->lastCodigoCliente = CadastroJuridicaPeer::lastCodigoCliente();

        $this->lastCodigoCliente = substr($this->lastCodigoCliente,1);

    }

    

    function findSubTiposChildren($id_padre=0,$tab=""){

        $htm = "";

        $tab.="&nbsp;&nbsp;&nbsp;&nbsp;";

        //echo $id_padre;exit();

        $result = SubtipoUserPeer::findSubTiposChildrenEdit($id_padre);

        if($result)

        {

            foreach ($result as $rs) {

                $htm.= $tab;

                $htm.= '<input type="checkbox" id="chk_'.$rs['id'].'" name="chk['.$rs['id'].']" value="'.$rs['id'].'">&nbsp;';

                $htm.= $rs['subtipo']."<br>";

                $htm.= $this->findSubTiposChildren($rs['id'],"&nbsp;");

            }

        }

        return $htm;

    }



    public function executeCreate(sfWebRequest $request) {

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar usuário').' - Lynx Cms');

        if (!$request->isMethod('post')) {

            $this->redirect("lxuser/new");

        }

        

        //$this->form = new LxUserForm();

        $this->form = new CadastroFisicaForm();

        

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->processForm($request, $this->form);

        

        $this->setTemplate('new');

    }

    

    public function executeCreateJuridico(sfWebRequest $request) {

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar usuário Jurídico').' - Lynx Cms');

        if (!$request->isMethod('post')) {

            $this->redirect("lxuser/new");

        }

        //$this->form = new LxUserForm();

        $this->form = new CadastroJuridicaForm();

        

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->processFormJuridico($request, $this->form);

        

        $this->setTemplate('newJuridico');

    }



    public function executeEdit(sfWebRequest $request) {       

        sfConfig::set('sf_escaping_strategy', false);        

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar usuário').' - '.sfConfig::get('app_name_app'));

        // Valida tipo de usuario para evaluar plantilla

        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));

        $this->tipoUser = LxUserPeer::getCurrentPassword($request->getParameter('id_user'));

        switch ($this->tipoUser->getIdTipoUsuario()) {

            case '2':

                // Pessoa fisica

                $this->id_cadastro_fisica = CadastroFisicaPeer::getIdPPal($request->getParameter('id_user'));

                $this->forward404Unless($CadastroFisica = CadastroFisicaPeer::retrieveByPk($this->id_cadastro_fisica['id']), sprintf('Object CadastroFisica does not exist (%s).', $this->id_cadastro_fisica['id']));

                $this->form = new CadastroFisicaForm($CadastroFisica);

                break;

            case '3':

                // Pessoa Juridica

                $this->id_cadastro_juridica = CadastroJuridicaPeer::getIdPPal($request->getParameter('id_user'));

                $this->forward404Unless($CadastroJuridica = CadastroJuridicaPeer::retrieveByPk($this->id_cadastro_juridica['id']), sprintf('Object CadastroJuridica does not exist (%s).', $this->id_cadastro_juridica['id']));

                $this->form = new CadastroJuridicaForm($CadastroJuridica);

                break;

        }

        //Evita que se pueda editar el usuario root y administrador del sistema

        //$this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1);

        $this->forward404If($LxUser->getIdUser() == 2 or $LxUser->getIdUser() == 1);

        $subtipos = SubtipoUserPeer::displayListSubTipos();        

        $this->getUser()->setAttribute('new_user', $request->getParameter('id_user'));

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->html = "";

        foreach ($subtipos as $st) :

            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';

            $this->html.= $st['subtipo'].'<br />';

            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");

        endforeach;

    }

    

    public function executeEditCliente(sfWebRequest $request) {       

        sfConfig::set('sf_escaping_strategy', false);        

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Editar Cliente').' - '.sfConfig::get('app_name_app'));

        // Valida tipo de usuario para evaluar plantilla

        $this->forward404Unless($LxUser = CadastroJuridicaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Empresa does not exist (%s).', $request->getParameter('id')));

        // Pessoa Juridica

        $this->form = new CadastroJuridicaForm($LxUser);

        

        //Evita que se pueda editar el usuario root y administrador del sistema

        //$this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1);

        $this->forward404If($LxUser->getIdUser() == 2 or $LxUser->getIdUser() == 1);

        $subtipos = SubtipoUserPeer::displayListSubTipos();        

        $this->getUser()->setAttribute('new_user', $request->getParameter('id'));

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->html = "";

        foreach ($subtipos as $st) :

            $this->html.= '<input type="checkbox" id="chk_'.$st['id'].'" name="chk['.$st['id'].']" value="'.$st['id'].'">&nbsp;';

            $this->html.= $st['subtipo'].'<br />';

            $this->html.= $this->findSubTiposChildren($st['id'],"&nbsp;");

        endforeach;

    }



    public function executeUpdate(sfWebRequest $request) 

    {

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));   

        

        // Valida tipo de usuario para evaluar plantilla

        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));

        $this->tipoUser = LxUserPeer::getCurrentPassword($request->getParameter('id_user'));

        //Evita que se pueda editar el usuario root y administrador del sistema

        //$this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1);

        $this->forward404If($LxUser->getIdUser() == 2 or $LxUser->getIdUser() == 1);

        switch ($this->tipoUser->getIdTipoUsuario()) {

            case '2':

                // Pessoa fisica

                $this->id_cadastro_fisica = CadastroFisicaPeer::getIdPPal($request->getParameter('id_user'));

                $this->forward404Unless($CadastroFisica = CadastroFisicaPeer::retrieveByPk($this->id_cadastro_fisica['id']), sprintf('Object CadastroFisica does not exist (%s).', $this->id_cadastro_fisica['id']));

                $this->form = new CadastroFisicaForm($CadastroFisica);

                $this->processForm($request, $this->form);

                break;

            case '3':

                // Pessoa Juridica

                $this->id_cadastro_juridica = CadastroJuridicaPeer::getIdPPal($request->getParameter('id_user'));                

                $this->forward404Unless($CadastroJuridica = CadastroJuridicaPeer::retrieveByPk($this->id_cadastro_juridica['id']), sprintf('Object CadastroJuridica does not exist (%s).', $this->id_cadastro_juridica['id']));

                $this->form = new CadastroJuridicaForm($CadastroJuridica);

                $this->processFormJuridico($request, $this->form);

                break;

        }

       

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->setTemplate('edit');

    }

    

    public function executeUpdateCliente(sfWebRequest $request) 

    {

        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));   

        

        // Valida tipo de usuario para evaluar plantilla

        $this->forward404Unless($LxUser = CadastroJuridicaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Cliente does not exist (%s).', $request->getParameter('id')));

        //$this->forward404If($LxUser->getIdUser() == 2 or $LxUser->getIdUser() == 1);

        $this->id_cadastro_juridica = CadastroJuridicaPeer::getIdPPal($request->getParameter('id_user'));                

        $this->form = new CadastroJuridicaForm($LxUser);

        $this->processFormJuridico($request, $this->form);

        //Identifica el modulo padre

        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());

        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);

        $this->setTemplate('editCliente');

    }



    public function executeDelete(sfWebRequest $request) {

        $request->checkCSRFProtection();        

        $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));

        //Evita que se pueda editar el usuario root y administrador del sistema

        $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() <= 2);

        $LxUser->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

        return $this->redirect('lxuser/index');

    }

    

    public function executeDeleteCliente(sfWebRequest $request) {

        $request->checkCSRFProtection();        

        

        $this->forward404Unless($LxUser = CadastroJuridicaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Empresa does not exist (%s).', $request->getParameter('id')));

        

        $LxUser->delete();

        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

        return $this->redirect('lxuser/index?radio-cad='.$request->getParameter('radio-cad'));

    }



    public function executeDeleteAll(sfWebRequest $request) {

        if ($this->getRequestParameter('chk')) {

            foreach ($this->getRequestParameter('chk') as $gr => $val) {

                $this->forward404Unless($LxUser = LxUserPeer::retrieveByPk($val), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));

                //Evita que se pueda editar el usuario root y administrador del sistema

                $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() <= 2);

                $LxUser->delete();

            }

            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

        }

        return $this->redirect('lxuser/index');

    }



    protected function processForm(sfWebRequest $request, sfForm $form) {

        

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())

        {

            $newUser =  $form->save();

            if($request->getParameter('id_user'))

            {

                // Actualizo los datos de acceso del usuario

                $novoUsuario = LxUserPeer::retrieveByPK($request->getParameter('id_user'));

                $novoUsuario->setIdProfile($form->getValue('id_profile'));

                $novoUsuario->setIdTipoUsuario($form->getValue('id_tipo_usuario'));

                $novoUsuario->setLogin($form->getValue('login'));

                $novoUsuario->setEmail($form->getValue('email'));

                $novoUsuario->setPassword($form->getValue('password'));

                $novoUsuario->setStatus(1);

                $novoUsuario->save();

                // Busco el usuario en rate base

                $rateFuncionario = RatePeer::getRateFuncionarioBase($request->getParameter('id_user'));

                $rateFuncionario->setRate(aplication_system::convierteDecimalFormat($form->getValue('rate')));

                $rateFuncionario->save();

            }else{

                // Registro el novo usuario

                $novoUsuario = new LxUser();

                $novoUsuario->setIdProfile($form->getValue('id_profile'));

                $novoUsuario->setIdTipoUsuario($form->getValue('id_tipo_usuario'));

                $novoUsuario->setLogin($form->getValue('login'));

                $novoUsuario->setEmail($form->getValue('email'));

                $novoUsuario->setPassword($form->getValue('password'));

                $novoUsuario->setStatus(1);

                $novoUsuario->save();        

                // Creo el rate base para el funcionario

                $nvoRate = new Rate();

                $nvoRate->setCodigoprojeto(0);

                $nvoRate->setFuncionario($novoUsuario->getIdUser());

                $nvoRate->setRate(aplication_system::convierteDecimalFormat($form->getValue('rate')));

                $nvoRate->setCargo($form->getValue('cargo'));

                $nvoRate->save();

            }

            $id_user = $novoUsuario->getIdUser();

            if ($this->getRequestParameter('chktipo')) {

                // Deleita Vinculo de Usuario con los tipos de cadastros actuales

                VinculoUserTipoCadastroPeer::deleitaVinculoUser($id_user);

                VinculoUserSubtipoPeer::deleitaVinculoUser($id_user);

                foreach ($this->getRequestParameter('chktipo') as $gr => $valTC)

                {

                    $newVinculo = new VinculoUserTipoCadastro();

                    $newVinculo->setIdTipoCadastro($valTC);

                    $newVinculo->setIdUser($id_user);

                    $newVinculo->save();

                    if ($this->getRequestParameter('chk-'.$valTC)) {                        

                        foreach ($this->getRequestParameter('chk-'.$valTC) as $gr => $valST)

                        {

                            $newVinculoST = new VinculoUserSubtipo();

                            $newVinculoST->setIdUser($id_user);

                            $newVinculoST->setIdTipoCadastro($valTC);

                            $newVinculoST->setIdSubtipo($valST);

                            $newVinculoST->save();

                        }                        

                    }

                }

                

            }

            

            

            // Asigna al usuario fisico el id correspondiente            

            $update = CadastroFisicaPeer::retrieveByPK($newUser->getIdCadastroFisica());

            $update->setIdUser($id_user);

            $update->save();

            

            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));

            $this->getUser()->setAttribute('new_user', $request->getParameter('id_user'));

            return $this->redirect('lxuser/index');        

        }

    }

    

    protected function processFormJuridico(sfWebRequest $request, sfForm $form) 

    {   

        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));

        if ($form->isValid())

        {

            

            $Empresa =  $form->save();

            $id_user = $Empresa->getIdEmpresa();

            $Empresa->setStatus(1);

            if ($this->getRequestParameter('chktipo')) {

                // Deleita Vinculo de Usuario con los tipos de cadastros actuales

                FornecedorSubtipoPeer::deleitaVinculoEmpresa($id_user);

                foreach ($this->getRequestParameter('chktipo') as $gr => $valTC)

                {

                    if ($this->getRequestParameter('chk-'.$valTC)) {                        

                        foreach ($this->getRequestParameter('chk-'.$valTC) as $gr => $valST)

                        {

                            $newVinculoST = new FornecedorSubtipo();

                            $newVinculoST->setIdEmpresa($id_user);

                            $newVinculoST->setIdTipo($valTC);

                            $newVinculoST->setIdSubtipo($valST);

                            $newVinculoST->save();

                        }                        

                    }

                }

            }

            

            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));

            $this->getUser()->setAttribute('new_user', $request->getParameter('id_user'));

            return $this->redirect('lxuser/index?radio-cad='.$this->getUser()->getAttribute('tc_empresa'));        

        }

    }

    

    /**

      * Cambia el status del usuario

      *

      * @param sfWebRequest $request

      */

    public function executeChangeStatus(sfWebRequest $request)

    {

      $this->forward404Unless($this->LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));      

      $this->forward404If($this->getUser()->getAttribute('idUserPanel')==$request->getParameter('id_user') or $this->LxUser->getIdUser() == 1);

      if($request->getParameter('status'))

      {

        $this->LxUser->setStatus(0);

      }else{

        $this->LxUser->setStatus(1);

      }

      $this->LxUser->save();

    }

    

    public function executeChangeStatusJuridico(sfWebRequest $request)

    {

      $this->forward404Unless($this->Empresa = CadastroJuridicaPeer::retrieveByPk($request->getParameter('id')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id')));      

      if($request->getParameter('status'))

      {

        $this->Empresa->setStatus(0);

      }else{

        $this->Empresa->setStatus(1);

      }

      $this->Empresa->save();

    }

  



    public function executeUpdateTypeUser(sfWebRequest $request)

    {

      $this->setLayout(false);   

      if(LxUserModulePeer::valPermissionUser($request->getParameter('id_module'), $this->getUser()->getAttribute('new_user')))

      {

          // Si el tipo de permiso es mayor a 2

          if($request->getParameter('type') > 2)

          {

              // Elimina todos los permisos para ese usuario sobre el modulo

              LxUserModulePeer::deleteAllPermissions($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'));

          }else{

              LxUserModulePeer::updateTypeUserModule($this->getUser()->getAttribute('new_user'), $request->getParameter('id_module'), $request->getParameter('type'));

          }

      }

      return sfView::NONE;

    }



    public function executeGetMunicipios(sfWebRequest $request)

    {

      $this->setLayout(false);

      $id = $request->getParameter('id');

      $this->items = null;

      if($id != '') {

        $this->forward404Unless($this->items = MunicipioPeer::getMunicipiosXEstado($id), sprintf('Municipios no encontrados (%s).', $id));

      }

    }

}

