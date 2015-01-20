<?php

/**
 * contas actions.
 *
 * @package    sgws
 * @subpackage contas
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class contasActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      
      
      $id_proyecto = null;
      $c = new Criteria();
      
      $c->add(SaidasPeer::CODIGOFUNCIONARIO, aplication_system::getUser(), Criteria::EQUAL);
      
      // Si se selecciono proyecto o tarefa
      if($request->getParameter('id_projeto'))
      {
            $c->add(SaidasPeer::CODIGOPROJETO, $request->getParameter('id_projeto'), Criteria::EQUAL);
            $id_proyecto = $request->getParameter('id_projeto');
      }
      
      if ($request->isMethod('post'))
      {
        if($request->getParameter('status') < 2)
        {
            $c->add(SaidasPeer::CONFIRMACAO, $request->getParameter('status'), Criteria::EQUAL);
        }else{
            $c->add(SaidasPeer::FOR_PRINT, 1, Criteria::EQUAL);
            $c->add(SaidasPeer::CONFIRMACAO, 0, Criteria::EQUAL);
            
        }
        $st = $request->getParameter('status');
        
      }else{
        if(!$request->getParameter('status'))
        {
            $request->setParameter('status',0);    
            $st = 0;
        }
        $c->add(SaidasPeer::CONFIRMACAO, 0, Criteria::EQUAL);
      }
      
      if($this->getRequestParameter('from_date'))
        {
            $from = $this->getRequestParameter('from_date');
            $dt = explode('-', $from) ;
            $from = $dt[2].'-'.$dt[1].'-'.$dt[0];
            $to = $this->getRequestParameter('to_date');
            $dt = explode('-', $to) ;
            $to = $dt[2].'-'.$dt[1].'-'.$dt[0];
        }else{
            if (aplication_system::isAllAction() || aplication_system::esContable())
            {
                $from = date('Y-m-01');
                $to = date('Y-m-30');
            }else{
                $from = date('Y-m-01');
                $to = date('Y-m-30');
            }            
        }
        $this->from = date("d-m-Y", strtotime($from));
        $this->to = date("d-m-Y", strtotime($to));
        if($from)
      {
        $cFecha = $c->getNewCriterion(SaidasPeer::DATAREAL, $from,Criteria::GREATER_EQUAL);
        $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAREAL, $to, Criteria::LESS_EQUAL));
        $c->add($cFecha);
      }
      if($this->getRequestParameter('buscador'))
      {
            //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
            sfConfig::set('sf_escaping_strategy', false);
            $c->addJoin(SaidasPeer::CODIGOPROJETO, PropostaPeer::CODIGO_PROJETO, Criteria::INNER_JOIN);
            $c->addJoin(SaidasPeer::CODIGOFUNCIONARIO, LxUserPeer::ID_USER, Criteria::INNER_JOIN);
            $c->addJoin(SaidasPeer::CODIGOCADASTRO, CadastroJuridicaPeer::ID_EMPRESA, Criteria::INNER_JOIN);
            
            $criterio = $c->getNewCriterion(SaidasPeer::CODIGO_SAIDA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SaidasPeer::CENTRO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SaidasPeer::FORMAPAGAMENTO, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SaidasPeer::DESCRICAOSAIDA, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=".$this->buscador;
            $this->bus_pagi = "&buscador=".$this->buscador;
      }else{
            $buscador = "";
            $this->bus_pagi = "";
      }
      /**
       * 24 Enero 2014
       * En la Prestacion de Contas no deben de salir las compras por Enviromaq
       */
      //$c->add(SaidasPeer::ID_PEDIDO, '0', Criteria::LESS_EQUAL);
      // Si es Entrada que solo sean Adiantamentos
      $criterio = $c->getNewCriterion(SaidasPeer::OPERACAO, 'e', Criteria::EQUAL);
      $criterio->addAnd($c->getNewCriterion(SaidasPeer::CENTRO, 'adiantamento' , Criteria::EQUAL));
      $criterio->addOr($c->getNewCriterion(SaidasPeer::OPERACAO, 's' , Criteria::EQUAL));
      $c->add($criterio);
      
      
      $c->add(SaidasPeer::DATAREAL, '2014-01-01', Criteria::GREATER_EQUAL);
      $this->result = SaidasPeer::doSelect($c);
      
      $this->total_global = SaidasPeer::getTotalPrestacaoContasUsuario(aplication_system::getUser(), $id_proyecto, $st);
      $this->total_global = $this->total_global['totalS'] - $this->total_global['totalE'];
      
      
  }
  
  public function executeEditFinanciero(sfWebRequest $request)
  {
      // ID de la Despesa
      $id = $request->getParameter('id');
      $this->despesa = SaidasPeer::retrieveByPK($id);
      $this->form = new DespesaFinacieroForm($this->despesa);
  }

  public function executeEdit(sfWebRequest $request)
  {
      // ID de la Despesa
      $id = $request->getParameter('id');
      $this->despesa = SaidasPeer::retrieveByPK($id);
      $this->form = new DespesaForm($this->despesa);
  }
  
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Despesa does not exist (%s).', $request->getParameter('id')));
    $this->form = new DespesaForm($Despesa);
    
    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('edit');
  }
  
  public function executeUpdateFinanciero(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Despesa does not exist (%s).', $request->getParameter('id')));
    $this->form = new DespesaFinacieroForm($Despesa);
    
    $this->processForm($request, $this->form);
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->setTemplate('editFinanciero');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Despesa = $form->save();
      if(!$form->getValue('codigofuncionario'))
      {
          $Despesa->setConfirmadopor(aplication_system::getUser());
          $Despesa->save();
      }
      
      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      $this->redirect('contas/index');  
    }
  }
  
  public function executeMarcaConta(sfWebRequest $request)
  {
      if ($this->getRequestParameter('chk'))
      {
            foreach ($this->getRequestParameter('chk') as $gr => $val)
            {
                    
                    $this->forward404Unless($Conta = SaidasPeer::retrieveByPk($val), sprintf('Object Formulario does not exist (%s).', $val));
                    $Conta->setForPrint(1);
                    $Conta->setDataPrint(date('Y-m-d'));
                    $Conta->save();
            }
            $this->getUser()->setFlash('listo', 'Dados processados com sucesso');

      }
      $request->setParameter('status','2');    
      $this->redirect('@default?module=contas&action=index');  
  }
  
}
