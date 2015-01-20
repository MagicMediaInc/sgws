<?php

/**
 * pedido actions.
 *
 * @package    sgws
 * @subpackage pedido
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class pedidoActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
      $this->status = array('1' => 'En Andamento', '2' => 'Cancelado' , '4' => 'Pedido Entregue');
      $this->getResponse()->setTitle('Meus Pedidos');
      $idGerente = aplication_system::esGerente() ? aplication_system::getUser() : '0';
      $palabra = $request->getParameter('buscador');
      $status = $request->getParameter('status');
      $from_date = $request->getParameter('from_date');
      $to_date = $request->getParameter('to_date');
      $this->pedidos = PedidosPeer::getPedidos($idGerente, $palabra, $status, $from_date, $to_date);
      
      
  }

  public function executeNew(sfWebRequest $request)
  {
    //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
  	$this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new').' pedido - Lynx Cms');
    $this->form = new PedidosForm();
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
  }

  public function executeCreate(sfWebRequest $request)
  {
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' pedido - Lynx Cms');
    if (!$request->isMethod('post'))
    {
        $this->redirect("pedido/new");
    }
    

    $this->form = new PedidosForm();
    //Identifica el modulo padre
    $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
    $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    $this->processForm($request, $this->form);
    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    if(aplication_system::esGerente())
    {
        $this->forward('pedido', 'viewPedido');
    }
    sfConfig::set('sf_escaping_strategy', false);
    //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit').' pedido - Lynx Cms');
    $this->forward404Unless($this->Pedidos = PedidosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Pedidos does not exist (%s).', $request->getParameter('id')));
    $this->form = new PedidosForm($this->Pedidos);
    // Busca pedido en Saidas
    $this->edit = true;
    $saida = SaidasPeer::getSaidaPerPedido($request->getParameter('id'));
    if($saida)
    {
        if($saida->getBaixa() || $saida->getConfirmacao())
        {
            $this->edit = false;
        }
    }
    $this->items = PedidoItemsPeer::getOrderDetails($request->getParameter('id'));
  }

  public function executeUpdate(sfWebRequest $request)
  {
 
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($this->Pedidos = PedidosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Pedidos does not exist (%s).', $request->getParameter('id')));
    $this->form = new PedidosForm($this->Pedidos);
    $this->edit = true;
    $saida = SaidasPeer::getSaidaPerPedido($request->getParameter('id'));
    if($saida)
    {
        if($saida->getBaixa() || $saida->getConfirmacao())
        {
            $this->edit = false;
        }
    }
    $this->items = PedidoItemsPeer::getOrderDetails($request->getParameter('id'));
    
    
    $this->processForm($request, $this->form, $this->items);
    
    
    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    
    $this->forward404Unless($Pedidos = PedidosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Pedidos does not exist (%s).', $request->getParameter('id')));
    PedidoItemsPeer::deleteItems($request->getParameter('id'));
    $Pedidos->delete();

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('pedido/index');
  }
  
  public function executeDeleteItem(sfWebRequest $request)
  {
   

    $Item = PedidoItemsPeer::retrieveByPk($request->getParameter('id'));
    // Datos pedido
    $Pedido = PedidosPeer::retrieveByPK($Item->getIdPedido());
    $id = $Item->getIdPedido();
    $Pedido->setValor($Pedido->getValor() - $Item->getPrecoBoleto());
    $Pedido->save();
    
    // elimina item
    $Item->delete();
    // datos salida
    $saida = SaidasPeer::getSaidaPerPedido($Pedido->getId());
    if($saida)
    {
        $nitems = PedidoItemsPeer::getOrderDetails($id);
        $descricao = '';
        foreach ($nitems as $item)
        {
          $descricao .= $item['qty']. ' '. $item['nome']."<br />";
        }
        
        $saida->setSaidas($Pedido->getValor());
        $saida->setSaidaprevista($Pedido->getValor());
        $saida->setDescricaosaida($descricao);
        $saida->save();
    }

    $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
    return $this->redirect('pedido/edit?id='.$id);
  }


  protected function processForm(sfWebRequest $request, sfForm $form, $items = null)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $Pedidos = $form->save();
      if($items)
      {
          if($form->getValue('status') == 4) // Pagamento Confirmado
          {
                // Descuento del estoque de los productos seleccionados
                foreach ($items as $item)
                {
                   if($request->hasParameter('cantidad_'.$item['id']))
                   {
                       $prod = ProductosPeer::retrieveByPK($item['id_producto']);
                       // busca cantidad del pedido
                       $cantidad = PedidoItemsPeer::retrieveByPK($item['id']);
                      // retorno la cantidad
                      $prod->setEstoque($prod->getEstoque() +  $cantidad->getQt() );
                      $prod->save();
                      // y ahora si descuento del estoque
                      $prod->setEstoque($prod->getEstoque() - $request->getParameter('cantidad_'.$item['id']) );
                      $prod->save();
                   }
                }
                
          }
          
          $total = 0;
          $descricao = '';
          foreach ($items as $item)
            {
              $descricao .= $item['qty']. ' '. $item['nome']."<br />";
              if($request->hasParameter('cantidad_'.$item['id']))
              {
                  // Actualiza item
                  $rs = PedidoItemsPeer::retrieveByPK($item['id']);
                  $rs->setQt($request->getParameter('cantidad_'.$item['id']));
                  $rs->setPrecoBoleto($rs->getPreco() * $request->getParameter('cantidad_'.$item['id']));
                  $rs->save();
                  $total = $total + $rs->getPrecoBoleto();

              }
              $Pedidos->setValor($total);
              $Pedidos->save();
            }
      }
      
      
      if($form->getValue('status') == 4) // Pagamento Confirmado
      { 
         $saida = SaidasPeer::getSaidaPerPedido($Pedidos->getId());
         if(!$saida)
         {
            // Busco la empresa enviromaq
            $env = CadastroJuridicaPeer::getCodigoCliente('env2014');
            // Ahora crea salida contable
            $contavle = new Saidas();
            $contavle->setIdPedido($Pedidos->getId());
            $contavle->setCentro('projeto');
            $contavle->setOperacao('s');
            $contavle->setTipo('v');
            $contavle->setCodigoprojeto($Pedidos->getIdProjeto());
            $contavle->setCodigocadastro($env ? $env->getIdEmpresa() : 0);
            //$contavle->setCodigofuncionario($Pedidos->getIdCliente());
            $contavle->setCodigofuncionario(2);
            $contavle->setSaidas($Pedidos->getValor());
            $contavle->setSaidaprevista($Pedidos->getValor());
            $contavle->setDatareal($Pedidos->getData());
            $contavle->setDescricaosaida($descricao);
            $contavle->setBaixa(0);
            $contavle->setConfirmacao(0);
            $contavle->setConfirmadopor(0);
            $contavle->setFormapagamento($Pedidos->getFormaPagamento());
            $contavle->save();
         }else{
            $saida->setSaidas($Pedidos->getValor());
            $saida->setSaidaprevista($Pedidos->getValor());
            $saida->setDescricaosaida($descricao);
            $saida->setFormapagamento($Pedidos->getFormaPagamento());
            $saida->save(); 
         }
         
         
          
          
      }

      $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
      if($items)
      {
          return $this->redirect('pedido/edit?id='.$Pedidos->getId());
      }else{
          return $this->redirect('pedido/index');
      }
      
      
    }
  }
  
  public function executeViewPedido(sfWebRequest $request)
  {
    $this->status = array('1' => 'En Andamento', '2' => 'Cancelado' , '4' => 'Pedido Entregue');
    $this->forward404Unless($this->Pedidos = PedidosPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Pedidos does not exist (%s).', $request->getParameter('id')));
    $this->items = PedidoItemsPeer::getOrderDetails($request->getParameter('id'));
    $this->infoPedido = PedidosPeer::getInfoPedido($request->getParameter('id'));
  }
}
