
<?php

/**
 * projeto actions.
 *
 * @package    sgws
 * @subpackage projeto
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class projetoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
        $this->val = new lynxValida();
        $limit = 20;
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List').' projeto - Lynx Cms');
        $sortTemp =  PropostaPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        if ($this->getRequestParameter('q')=="prop"){
            $this->sort = $sortTemp[0];      // Nombre del campo que por defecto se ordenara
        }else{
            $this->sort = $sortTemp[3];
        }
        if (!$this->getRequestParameter('buscador')){
                $this->buscador = '';
        }else{
                $this->buscador = $this->getRequestParameter('buscador');
        }
        if(!$this->getRequestParameter('by'))
        {
                $this->by = 'desc';               // Variable para el orden de los registros
                $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
        }
       // echo "h".$this->getRequestParameter('by');
		//Criterios de busqueda
		$c = new Criteria();
                //$c->add(PropostaPeer::STATUS, '4', Criteria::EQUAL);
                
//                if(aplication_system::esFuncionario())
//                {
//                    // Si es funcionario solo visualiza los projetos y propostas publicos
//                    //$c->add(PropostaPeer::VISUALIZACION, '0', Criteria::EQUAL);
//                }
		if($this->getRequestParameter('sort'))
		{
                    $this->sort = $this->getRequestParameter('sort');
                    switch ($this->getRequestParameter('by')) {
                        case 'desc':
                                $c->addDescendingOrderByColumn(PropostaPeer::$this->getRequestParameter('sort'));
                                $this->by = "asc";
                                $this->by_page = "desc";
                                break;
                        default:
                                $c->addAscendingOrderByColumn(PropostaPeer::$this->getRequestParameter('sort'));
                                $this->by = "desc";
                                $this->by_page = "asc";
                                break;
                    }
		}else{
                    $c->addDescendingOrderByColumn($this->sort);
                    
		}
                $c->addDescendingOrderByColumn($this->sort);
        //$c->addDescendingOrderByColumn(PropostaPeer::CODIGO_PROPOSTA);
        $this->statusFilter = array();
        $this->bus_ps = '';
        if($request->getParameter('q'))
        {
            $this->bus_q = "&q=".$request->getParameter('q');
        }else{
            $this->bus_q = "";
        }

                
        $this->bus_tipo_reg = '';
        if($this->getRequestParameter('tipo_reg') != 'all')
        {

            if($this->getRequestParameter('tipo_reg'))
            {
                $c->add(PropostaPeer::ID_STATUS_PROPOSTA, $this->getRequestParameter('tipo_reg'), Criteria::EQUAL);
            }else{

                // Inicia con listado de projetos
                if(!$request->getParameter('proposta_status'))
                {
                   $c->add(PropostaPeer::ID_STATUS_PROPOSTA, '2', Criteria::EQUAL);
                    $request->setParameter('tipo_reg', 2);
                }
            }
            $this->statusFilter = StatusPeer::getListStatus($request->getParameter('tipo_reg'));

        }else{
            $this->bus_q = '';

        }
        if($this->getRequestParameter('tipo_reg'))
        {
            $this->bus_tipo_reg = "&tipo_reg=".$this->getRequestParameter('tipo_reg');
        }


        if($request->getParameter('q') == 'prop')
        {
            $c->add(PropostaPeer::ID_STATUS_PROPOSTA, 1, Criteria::EQUAL);
            $this->statusFilter = StatusPeer::getListStatus(1);
        }
        if($request->getParameter('q') == 'pj')
        {
            //echo $this->getUser()->getAttribute('idUserPanel');
            //$c->addJoin(PropostaPeer::CODIGO_PROPOSTA, TarefaPeer::CODIGOPROJETO, Criteria::INNER_JOIN);
            //$c->addJoin(TarefaPeer::CODIGOTAREFA, EquipeTarefaPeer::CODIGOTAREFA, Criteria::INNER_JOIN);
            $c->add(EquipeTarefaPeer::CODIGOFUNCIONARIO, $this->getUser()->getAttribute('idUserPanel'), Criteria::EQUAL);
            $c->addOr(PropostaPeer::GERENTE, $this->getUser()->getAttribute('idUserPanel') , Criteria::EQUAL);
            $c->addAnd(PropostaPeer::ID_STATUS_PROPOSTA, '2' , Criteria::EQUAL);
            //$c->add($cPj);
            $c->addGroupByColumn(PropostaPeer::CODIGO_PROPOSTA);
           //die($c);
        }
        if(aplication_system::esFuncionario() && $request->getParameter('q') != 'pj')
        {

        }
                
        if($request->getParameter('proposta_status'))
        {
            $c->add(PropostaPeer::STATUS, $request->getParameter('proposta_status'), Criteria::EQUAL);
            $this->bus_ps = "&proposta_status=".$request->getParameter('proposta_status');
        }

                
        if($this->getRequestParameter('buscador'))
        {
            //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
            sfConfig::set('sf_escaping_strategy', false);
            //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
         
            $criterio = $c->getNewCriterion(PropostaPeer::CODIGO_PROPOSTA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::ID_NEGOCIACAO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_TIPO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::DATA_INICIO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::DATA_FINAL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::DATA_IR_PROJETO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::DATA_FR_PROJETO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::NOME_PROPOSTA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            
           $this->clients = CadastroJuridicaPeer::getListClientsNames($request->getParameter('buscador'));
                  $arryIdClient = array();
                  foreach ($this->clients as $idClient){
                        $arryIdClient[] = $idClient->getIdEmpresa();
                    }
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CLIENTE, $arryIdClient, Criteria::IN));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::STATUS, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::ID_STATUS_PROPOSTA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::PROPOSTA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::VALOR, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::FLAG_PROJETO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(PropostaPeer::TIPO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $request->getParameter('buscador');
            $this->users = LxUserPeer::getListUserNames($request->getParameter('buscador'));
            $arryIdUser = array();
            foreach ($this->users as $idUser){
                $arryIdUser[] = $idUser->getIdUser();
                }
            $criterio->addOr($c->getNewCriterion(PropostaPeer::GERENTE,$arryIdUser, Criteria::IN));
            $c->add($criterio);
            $c->addGroupByColumn(PropostaPeer::CODIGO_PROPOSTA);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
        }else{
            $buscador = "";
            $this->bus_pagi = "";
        }
			
        $pager = new sfPropelPager('Proposta',$limit);
        $pager->setCriteria($c);
        $pager->setPage($this->getRequestParameter('page',1));
        $pager->init();
        $this->Propostas = $pager;  
       //echo "fff" .count($this->Propostas);
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_projeto','sort='.$this->sort.'&by='.$this->by_page.$buscador.'&page='.$this->Propostas->getPage());
  
  }

  
  public function executeAnalisisCritico(sfWebRequest $request)
  {
      $this->setLayout('layoutSimple');
      $this->clientes = CadastroJuridicaPeer::getListClientes('Cliente');
      $this->fornecedor = CadastroJuridicaPeer::getListClientes('Fornecedor');
      $this->funcionarios = LxUserPeer::getGerentesYFinancieroYSocios();
      $this->responsable = LxUserPeer::getGerentesResponsable();
  }
  
  public function executeEditAnalisisCritico(sfWebRequest $request)
  {
      $this->setLayout('layoutSimple');
      
      if($request->getParameter('id_analisis'))
      {
          $this->Analisis = AnalisisPeer::retrieveByPK($request->getParameter('id_analisis'));
          if($this->Analisis->getIdProposta())
          {
              $this->proposta_final = PropostaPeer::retrieveByPK($this->Analisis->getIdProposta());
              $this->proposta_final = $this->proposta_final ? $this->proposta_final->getCodigoSgws() : 0;
          }else{
              $this->proposta_final = 0;
          }
      }
      $this->clientes = CadastroJuridicaPeer::getListClientes('Cliente');
      $this->fornecedor = CadastroJuridicaPeer::getListClientes('Fornecedor');
      $this->funcionarios = LxUserPeer::getGerentesYFinancieroYSocios();
      $this->responsable = LxUserPeer::getGerentesResponsable();
  }

  public function executeCreateAnalisis(sfWebRequest $request)
  {
      //echo $request->getParameter('nome');die('chao');
      $status_analisis = true;
      $this->setLayout('layoutSimple');
      if ($request->isMethod('post'))
      {
           if($request->getParameter('id_analisis'))
           {
               $newAnalisis = AnalisisPeer::retrieveByPK($request->getParameter('id_analisis'));
           }else{
               $newAnalisis = new Analisis();
               $newAnalisis->setAnalisisPpal(1);
           }
           
           $status_analisis = !$request->getParameter('viabilidade_tecnica') ? false : true;
           $status_analisis = !$request->getParameter('equipamento_apropiado') ? false : true;
           $status_analisis = !$request->getParameter('metodologia_validada') ? false : true;
           $status_analisis = !$request->getParameter('quantidade_amostra') ? false : true;
           $status_analisis = !$request->getParameter('viabilidade_operacional') ? false : true;
           $status_analisis = !$request->getParameter('tecnico_habilitado') ? false : true;
           $status_analisis = !$request->getParameter('viabilidade_operacional') ? false : true;
           $status_analisis = !$request->getParameter('mano_obra') ? false : true;
           $status_analisis = !$request->getParameter('plazo_exequivel') ? false : true;
           $status_analisis = !$request->getParameter('viabilidade_financiera') ? false : true;
           $status_analisis = !$request->getParameter('valor_adecuado') ? false : true;
           $status_analisis = !$request->getParameter('plazo_pagamento') ? false : true;
           
           $newAnalisis->setIdCliente($request->getParameter('id_cliente'));
           $newAnalisis->setDescricao($request->getParameter('descricao'));
           $newAnalisis->setPlazo($request->getParameter('plazo'));
           $newAnalisis->setViabilidadeTecnica($request->getParameter('viabilidade_tecnica'));
           $newAnalisis->setEquipamentoApropiado($request->getParameter('equipamento_apropiado'));
           $newAnalisis->setMetodologiaValidada($request->getParameter('metodologia_validada'));
           $newAnalisis->setQuantidadeAmostra($request->getParameter('quantidade_amostra'));
           $newAnalisis->setViabilidadeOperacional($request->getParameter('viabilidade_operacional'));
           $newAnalisis->setTecnicoHabilitado($request->getParameter('tecnico_habilitado'));
           $newAnalisis->setManoObra($request->getParameter('mano_obra'));
           $newAnalisis->setPlazoExequivel($request->getParameter('plazo_exequivel'));
           $newAnalisis->setViabilidadeFinanciera($request->getParameter('viabilidade_financiera'));
           $newAnalisis->setValorAdecuado($request->getParameter('valor_adecuado'));
           $newAnalisis->setPlazoPagamento($request->getParameter('plazo_pagamento'));
           $newAnalisis->setTercerizado($request->getParameter('tercerizado'));
           $newAnalisis->setIdFornecedor($request->getParameter('id_fornecedor'));
           $newAnalisis->setValorProposta($request->getParameter('valor_proposta'));
           $newAnalisis->setAprobacionCliente($request->getParameter('aprobacion_cliente'));
           $newAnalisis->setResponsableComercial($request->getParameter('responsable_comercial'));
           $newAnalisis->setAprobadoResponsableComercial($request->getParameter('aprobado_rc'));
           $newAnalisis->setResponsableTecnico($request->getParameter('responsable_tecnico'));
           $newAnalisis->setAprobadoResponsableTecnico($request->getParameter('aprobado_rt'));
           $newAnalisis->setNome($request->getParameter('nome'));
           // Responsavel
           $newAnalisis->setIdResponsavel($request->getParameter('responsable_tecnico'));
           $newAnalisis->setAprobacionProposta($request->getParameter('aprobacion_proposta'));
           $newAnalisis->setCodigoPropostaFinal($request->getParameter('codigo_proposta_final'));
           $newAnalisis->setValidadeProposta($request->getParameter('validade_proposta'));
           $newAnalisis->setDataAprobacion($request->getParameter('data_aprobacion'));
           $newAnalisis->setFormaAprobacion($request->getParameter(''));
           $precio = aplication_system::convierteDecimalFormat($request->getParameter('precio'));
           $newAnalisis->setPrecio($precio);
           $newAnalisis->setFormaPagamento($request->getParameter('forma_pagamento'));
           $newAnalisis->setStatus($status_analisis);
           $newAnalisis->setDataCreacion(date("Y-m-d"));
           $newAnalisis->save();
           
           /**
            * Si todas las opciones de AMOSTRAGEM IN LOCO estan correctas y el responsable técnico
            * aprueba es cuando se crea la propuesta
            * 
            */
           //if($status_analisis && $request->getParameter('aprobado_rt')) // Crea la propuesta
           $status_analisis = true;
           /**
            * Reunión 16 enero 2014
            * Se crea la propuesta sin validación y redirecciono al detalle de la propuesta
            */
           
           if($status_analisis) // Crea la propuesta
           {
               if($request->getParameter('id_proposta'))
               {
                   $newProposta = PropostaPeer::retrieveByPK($request->getParameter('id_proposta'));
                   $this->codigo_sgws_proposta = $newProposta->getCodigoSgws();
                   $this->getUser()->setFlash('listo','Foi atualizada a Proposta Código '.$this->codigo_sgws_proposta);
               }else{
                   $newProposta = new Proposta();
                   $newProposta->setIdStatusProposta(1);
                   $newProposta->setIdNegociacao(3);
                   $newProposta->setStatusAnalisis(1);
                   $newProposta->setDataInicio($newAnalisis->getDataCreacion()); 
                   $newProposta->setDataIrProjeto($newAnalisis->getDataAprobacion()); 
                   $newProposta->setStatus(4); // En Andamento
                   $newProposta->setNomeProposta($request->getParameter('nome'));
                   $newProposta->setGerente(aplication_system::getUser()); // Vendida
                   $this->ultimaProposta = PropostaPeer::lastProposta();
                   $resultado = explode("PP", $this->ultimaProposta); 
                   $this->ultimaProposta =  $resultado[1] + 1;
                   $this->codigo_sgws_proposta = 'PP'.$this->ultimaProposta;
                   $newAnalisis->setCodigoPropostaFinal($this->codigo_sgws_proposta);
                   $this->getUser()->setFlash('listo','Foi criada a Proposta Código '.$this->codigo_sgws_proposta);
               }
               
               $newProposta->setCodigoSgws($this->codigo_sgws_proposta);
               $newProposta->setCliente($newAnalisis->getIdCliente());
               
               $newProposta->save();
               
               $newAnalisis->setIdProposta($newProposta->getCodigoProposta());
               $newAnalisis->save();
               if(!$request->getParameter('id_analisis'))
               {
                   echo '
                        <script type="text/javascript"> 
                           parent.location.reload();
                       </script> 
                      ';
                   $this->redirect('@default?module=projeto&action=edit&codigo_proposta='.$newProposta->getCodigoProposta().'&id_analisis='.$newAnalisis->getId());
               }else{
                   echo '
                        <script type="text/javascript"> 
                           parent.location.reload();
                           parent.jQuery.fancybox.close();
                        </script> 
                      ';
               }
               
               
               
           }else{
               if($request->getParameter('id_analisis'))
               {
                   $this->getUser()->setFlash('listo','foi atualizada la revisão #'.$request->getParameter('id_analisis'));
               }else{
                   $this->getUser()->setFlash('listo','foi criada uma nova proposta para revisão');
               }
               
           }
           
      }
  }
  
  public function executeUpdateAnalisis(sfWebRequest $request)
  {
      $this->forward('projeto', 'createAnalisis');
  }

  public function executeCreaAnalisisProposta(sfWebRequest $request)
  {
      
      if ($request->isMethod('post'))
      {
        // Crea el anexo
        $anexo = new PropostaAnexo();
        $anexo->setIdProposta($request->getParameter('codigo_proposta'));
        $anexo->setIdResponsable($request->getParameter('responsavel'));
        $anexo->setDescricao($request->getParameter('descricao_rev'));
        $anexo->setData($request->getParameter('data_rev'));
        $anexo->save();
        
        // Crea el analisis del anexo
        $newAnalisis = new Analisis();
        $newAnalisis->setAnalisisPpal(0);
        $newAnalisis->setIdPropostaAnexo($anexo->getId());
        $newAnalisis->setIdProposta($request->getParameter('codigo_proposta'));
        $newAnalisis->setIdResponsavel($request->getParameter('responsavel'));
        $newAnalisis->setDataCreacion(date("Y-m-d"));
        $newAnalisis->setIdCliente($request->getParameter('cliente'));
        $newAnalisis->setDescricao($request->getParameter('descricao_rev'));
        $newAnalisis->setStatus(0);
        $newAnalisis->save();
        $this->redirect('@default?module=projeto&action=edit&codigo_proposta='.$request->getParameter('codigo_proposta').
                '&id_analisis='.$newAnalisis->getId());   
//        echo '
//            <script type="text/javascript"> 
//               parent.location.reload();
//               parent.jQuery.fancybox.close();
//           </script> 
//          ';
//        return sfView::NONE;
      }
  }
  
  public function executeListaAnalisis(sfWebRequest $request)
  {
    if ($request->isMethod('post'))
    {
        $request->getParameter('buscador');
        $tipo = $request->getParameter('tipo_busqueda');
        if($request->getParameter('tipo_busqueda') == 2){
            $this->users = CadastroJuridicaPeer::getListClientsNames($request->getParameter('buscador'));
        $arryIdUser = array();
        foreach ($this->users as $idUser){
            $arryIdUser[] = $idUser->getIdEmpresa();
        }
        }else{
        $this->users = LxUserPeer::getListUserNames($request->getParameter('buscador'));
        $arryIdUser = array();
        foreach ($this->users as $idUser){
            $arryIdUser[] = $idUser->getIdUser();
        }
        }
        $this->revisiones = AnalisisPeer::getAnalisisNameUser($arryIdUser,$tipo);
        
    }else{
      $this->revisiones = AnalisisPeer::getListaRevisiones();
    }
  }

  public function executeEditAnexo(sfWebRequest $request)
  {
      $this->setLayout('layoutSimple');
      $this->anexo = PropostaAnexoPeer::retrieveByPK($request->getParameter('id'));
      $this->form = new PropostaAnexoForm($this->anexo);
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    //$this->forward('projeto', 'analisisCritico');  
    sfConfig::set('sf_escaping_strategy', false);
    $this->edit = true;
    
    $this->setLayout('layoutSimple');
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' projeto - Lynx Cms');
    $this->form = new PropostaForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    
    $this->responsables = LxUserPeer::getGerentesYFinancieroYSocios();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->setLayout('layoutSimple');
    $this->edit = true;
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' projeto - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("projeto/new");
    }
    
    $this->form = new PropostaForm();
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
    $this->edit = true;
    $this->setLayout('layoutSimple');
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' projeto - Lynx Cms');
    $this->forward404Unless($Proposta = PropostaPeer::retrieveByPk($request->getParameter('codigo_proposta')), sprintf('Object Proposta does not exist (%s).', $request->getParameter('codigo_proposta')));
    $this->form = new PropostaForm($Proposta);
    if(!aplication_system::compareUserVsResponsable($Proposta->getGerente()) ):
        $this->edit = false;
        if(aplication_system::esSocio() || aplication_system::esGerenteComercial() ||  aplication_system::esUsuarioRoot()  )
        {
            $this->edit = true;
        }
    endif;
    if($Proposta->getIdStatusProposta() == 1)
    {
        $this->tit = $Proposta->getCodigoSgws(); // es proposta
    }else{
        $this->tit = $Proposta->getCodigoSgwsProjeto(); // es projeto
    }
   if($request->getParameter('id_analisis')== 'null'){
       // die('null');
        $this->analisis = array(); 
        $this->responsableComercial = "";
        $this->responsable = LxUserPeer::getGerentesYFinancieroYSocios();
   }else{
       //die('true');
        $this->analisis = AnalisisPeer::retrieveByPK($request->getParameter('id_analisis'));
        $this->analisis->getIdResponsavel();
        $this->responsableComercial = $this->analisis->getResponsableComercial();
        $this->responsable = LxUserPeer::getGerentesYFinancieroYSocios();
   }
   $c = new Criteria();
   $this->ultimo = PropostaPeer::getProjetoUltimo();
   $this->codigoUltimo = substr($this->ultimo->getCodigoSgwsProjeto(),2);
   $this->setTemplate('edit');
  }

  public function executeUpdateProposta(sfWebRequest $request)
  {
    $this->setLayout('layoutSimple');
//    echo $request->getParameter('codigo_proposta');
//    die();
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Proposta = PropostaPeer::retrieveByPk($request->getParameter('codigo_proposta')), sprintf('Object Proposta does not exist (%s).', $request->getParameter('codigo_proposta')));
    $this->form = new PropostaForm($Proposta);
    $this->edit = true;
    if(!aplication_system::compareUserVsResponsable($Proposta->getGerente()) ):
        $this->edit = false;
        if(aplication_system::esSocio() )
        {
            $this->edit = true;
        }
    endif;
       if($request->getParameter('id_analisis')== 'null'){
       // die('null');
        $this->analisis = array(); 
        $this->responsableComercial = "";
        $this->responsable = LxUserPeer::getGerentesYFinancieroYSocios();
   }else{
       //die('true');
        $this->analisis = AnalisisPeer::retrieveByPK($request->getParameter('id_analisis'));
        $this->analisis->getIdResponsavel();
        $this->responsableComercial = $this->analisis->getResponsableComercial();
        $this->responsable = LxUserPeer::getGerentesYFinancieroYSocios();
   }
//    $this->analisis = AnalisisPeer::retrieveByPK($request->getParameter('id_analisis'));
//    $this->analisis->getIdResponsavel();
//    $this->responsableComercial = $this->analisis->getResponsableComercial();
//    $this->responsables = LxUserPeer::getGerentesYFinancieroYSocios();
    $this->processForm($request, $this->form,$request->getParameter('responsable'),$this->analisis);
    $this->setTemplate('edit');
  }
  
  public function executeUpdateAnexo(sfWebRequest $request)
  {
    $this->setLayout('layoutSimple');
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Anexo = PropostaAnexoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Proposta Anexo does not exist (%s).', $request->getParameter('id')));
    $this->form = new PropostaAnexoForm($Anexo);
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      $Anexo = $this->form->save();
      
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      $this->redirect('@default?module=projeto&action=edit&codigo_proposta='.$Anexo->getIdProposta());
    }
    
    $this->setTemplate('editAnexo');
  }
  
  public function executeDeleteAnexo(sfWebRequest $request) 
  {
    $this->forward404Unless($Anexo = PropostaAnexoPeer::retrieveByPk($request->getParameter('id')), sprintf('Object anexo does not exist (%s).', $request->getParameter('id')));
    // Elimina los analisis critica del anexo
    AnalisisPeer::deleteAnalisisByAnexo($request->getParameter('id'));
    // Elimino el anexo
    $Anexo->delete();
    return $this->redirect("@default?module=projeto&action=edit&codigo_proposta=".$Anexo->getIdProposta());
  }

  public function executeDelete(sfWebRequest $request)
  {
    
    $this->forward404Unless($Proposta = PropostaPeer::retrieveByPk($request->getParameter('codigo_proposta')), sprintf('Object Proposta does not exist (%s).', $request->getParameter('codigo_proposta')));
    $Proposta->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    echo '
         <script type="text/javascript"> 
            parent.location.reload();
            parent.jQuery.fancybox.close();
        </script> 
       ';
  }

  public function executeDeleteAll(sfWebRequest $request)
  {
    if ($this->getRequestParameter('chk'))
    {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {

                    $this->forward404Unless($Proposta = PropostaPeer::retrieveByPk($val), sprintf('Object Proposta does not exist (%s).', $request->getParameter('codigo_proposta')));
                    $Proposta->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));

    }
    return $this->redirect('projeto/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form, $responsable, $Analisis)
  {

    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid()){
        
        $Proposta = $form->save();
        if(count($Analisis) > 0) {
        $Analisis->setResponsableComercial($responsable);
        $Analisis->save();
        }
//        if ($this->getRequestParameter('chkCentro'))
//        {
//            ProjetoCentroPeer::deleitaCentrosProjeto($Proposta->getCodigoProposta());
//            foreach ($this->getRequestParameter('chkCentro') as $gr => $val)
//            {
//                $newCentroProjeto = new ProjetoCentro();
//                $newCentroProjeto->setIdCentro($val);
//                $newCentroProjeto->setIdProjeto($Proposta->getCodigoProposta());
//                $newCentroProjeto->save();
//               
//            }
//
//        }
      
      // Actualiza Data de Aprobacion del Analisis Critico Principal
      AnalisisPeer::actualizaDataAprobacion($Proposta);
      //if($form->getValue('id_status_proposta') == 2 && !$form->getValue('codigo_sgws_projeto')  ) // Fue vendida (es un projeto ahora)
      if($form->getValue('id_status_proposta') == 2) // Fue vendida (es un projeto ahora)
      {
          
          $Proposta->setCodigoProjeto($Proposta->getCodigoProposta()); 
          if(!$Proposta->getCodigoProposta())
          {
              $Proposta->setCodigoSgwsProjeto('PJ'.$Proposta->getCodigoProposta()); 
          }
          $Proposta->save();
          
          // Si el proyecto no tiene rate
          if(!RatePeer::getRateProjeto($Proposta->getCodigoProposta()))
          {
              // Creo el rate de usuarios para este proyecto
              $rate = RatePeer::getProjetoCero();
              foreach ($rate as $rt) {
                  $nvoRate = new Rate();
                  $nvoRate->setCodigoprojeto($Proposta->getCodigoProposta());
                  $nvoRate->setFuncionario($rt->getFuncionario());
                  $nvoRate->setRate($rt->getRate());
                  $nvoRate->setCargo($rt->getCargo());
                  $nvoRate->save();
              }
          }
      }
      
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      echo '
         <script type="text/javascript"> 
            parent.location.reload();
            parent.jQuery.fancybox.close();
        </script> 
       ';
      
     // return $this->redirect('projeto/index');
    }
//    else{
//          foreach($form->getErrorSchema()->getErrors() as $e) {
//            echo $e;          
//            }
// 
//      }
  }

  
  
}
