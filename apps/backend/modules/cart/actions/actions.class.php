<?php

/**
 * cart actions.
 *
 * @package    stocksys
 * @subpackage cart
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cartActions extends sfActions
{
  
 public function preExecute() {
    $this->i18n = sfContext::getInstance()->getI18N();        
 }

    /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $shopping_cart       = $this->getUser()->getShoppingCart(); //Session
    $this->shopping_cart = $shopping_cart;
    $this->items         = $shopping_cart->getItems();
    $this->nbArticles = $shopping_cart->getTotalArticles();
    $this->nbPiezas = $shopping_cart->getNbItems();
    if($this->nbArticles < 1){
        $this->getUser()->setAttribute('loja','');
    }
  }
  
  /**
     * Add a item to cart, if item exist, then increse one per item.
     *
     * @param sfWebRequest $request
     */
  public function executeAgregar(sfWebRequest $request)
  { 
    if($request->getParameter('loja') == $this->getUser()->getAttribute('loja') || $this->getUser()->getAttribute('loja') ==""){
        if($request->hasParameter('id'))
        {
            //Get product data
            $product = ProductosPeer::retrieveByPK($request->getParameter('id'));
            //Get price
            $precio = $product->getPreco();
            //Add item
            $item = new sfShoppingCartItem('Produto', $request->getParameter('id'));
            $item->setQuantity('1');
            $item->setPrice($precio);
            $item->setParameter('id', $product->getId());
            $item->setParameter('description', $product->getNome());
            $item->setParameter('peso', $product->getPeso());
            $item->setParameter('desconto', $product->getDesconto());
            $item->setParameter('desconto_boleto', $product->getDescontoBoleto());
            $item->setParameter('color', $product->getCor());
            $item->setParameter('referencia', $request->getParameter('id'));
            $item->setParameter('foto', $product->getFoto());
            $shopping_cart = $this->getUser()->getShoppingCart(); //Session
            $shopping_cart->addItem($item);
            if(count($shopping_cart) == 1){
             $this->getUser()->setAttribute('loja', $request->getParameter('loja'));
            }
         }
     }else{
         $this->notTienda =  "debe seleccionar la misma tienda";
         //return $this->redirect('@cart',array('noTienda'=>$this->notTienda));
     }
//  var_dump($shopping_cart);
//  die();
     //Show cart
     //$this->forward('cart', 'index',  array('id'));
     return $this->redirect('@cart');
  }
  
  /**
     * Update quantities per item
     *
     * @param sfWebRequest $request
     */
  public function executeActualizar(sfWebRequest $request)
  {
        $shopping_cart = $this->getUser()->getShoppingCart(); //Session

        foreach ($shopping_cart->getItems() as $item)
        {
            if($request->hasParameter('cantidad_'.$item->getId()))
            {
                $item->setQuantity($request->getParameter('cantidad_'.$item->getId()));
            }
        }
        //Show cart
        return $this->redirect('@cart');
  }

  /**
     * Delete a product item
     *
     * @param sfWebRequest $request
     */
  public function executeEliminar(sfWebRequest $request)
  {
        if($request->hasParameter('id'))
        {
            $shopping_cart = $this->getUser()->getShoppingCart();
            $item = $shopping_cart->getItem('Produto', $request->getParameter('id'));
            $shopping_cart->deleteItem('Produto', $request->getParameter('id'));
        }
        
        //Show cart
        return $this->redirect('@cart');
  }
  
  /**
     * Empty shopping cart
     * 
     * @param sfWebRequest $request
     */
  public function executeVaciar(sfWebRequest $request)
  {
      
    $shopping_cart      = $this->getUser()->getShoppingCart(); //Session
    $this->getUser()->getShoppingCart()->clear();
    var_dump($shopping_cart);
    die();
    //Show cart
    return $this->redirect('@cart');
  }
  
  /**
     * Show shipping's template
     * 
     * @param sfWebRequest $request
     */
  public function executeEnvio(sfWebRequest $request)
  {
    $shopping_cart       = $this->getUser()->getShoppingCart(); //Session
    $this->shopping_cart = $shopping_cart;
    $this->meusProjetos = PropostaPeer::getMeusProjetos(aplication_system::getUser());
    
    if($request->isMethod('post'))
    {
        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
        $this->getUser()->setAttribute('id_projeto', $request->getParameter('id_projeto'));
        return $this->redirect('@cart'); 
    }
  }
  
  /**
   *
   * @param sfWebRequest $request 
   */
  public function executeProcessOrder(sfWebRequest $request)
  {
     $descricao = ''; 
     $this->forwardIf(!$this->getUser()->getAttribute('id_projeto'),'cart','index');
     $shopping_cart       = $this->getUser()->getShoppingCart(); //Session
     $this->shopping_cart = $shopping_cart;
     $this->nbItemsCart = $shopping_cart->getNbItems();
     
     if($this->nbItemsCart > 0)
     {
         $dateOrder = date("Y-m-d");
         //Session Shopping
         $shopping_cart     = $this->getUser()->getShoppingCart(); 
         $this->items         = $shopping_cart->getItems();
         $this->nbArticles = $shopping_cart->getTotalArticles();
         $this->nbPiezas = $shopping_cart->getNbItems();
         // Total Order
         $this->totalShoppingCart = $shopping_cart->getTotal();
         // Genera Cabecera de la orden
         $this->newOrder = new Pedidos();         
         $this->newOrder->setIdCliente(aplication_system::getUser());
         $this->newOrder->setIdProjeto($this->getUser()->getAttribute('id_projeto'));
         $this->newOrder->setData($dateOrder);
         $this->newOrder->setStatus('1');
         $this->newOrder->setValor($this->totalShoppingCart);
         $this->newOrder->setLoja($this->getUser()->getAttribute('loja'));
         $this->newOrder->save();
         $this->newOrder->setNumeroPedido($this->newOrder->getId(). "." .date("H") . substr(date("i"),0,1));
         $this->newOrder->save();
         // Genera detalles de la orden
         foreach ($shopping_cart->getItems() as $item)
         {
             $detailOrder = new PedidoItems();
             $detailOrder->setIdPedido($this->newOrder->getId());
             $detailOrder->setIdProducto($item->getParameter('id'));
             $detailOrder->setNumeroPedido($this->newOrder->getNumeroPedido());
             $detailOrder->setNome($item->getParameter('description'));
             $detailOrder->setQt($item->getQuantity());
             $detailOrder->setPreco($item->getPrice());
             $detailOrder->setPrecoBoleto($item->getPrice() * $item->getQuantity());
             $detailOrder->setDesconto($item->getParameter('desconto'));
             $detailOrder->setDescontoBoleto($item->getParameter('desconto_boleto'));
             // Descricaco para la Salida Contable
             $descricao .= $item->getQuantity(). ' '. $item->getParameter('description')."<br />";
             $detailOrder->save();
         }
         
//         // Busco la empresa enviromaq
//         $env = CadastroJuridicaPeer::getCodigoCliente('env2014');
//         // Ahora crea salida contable
//         $contavle = new Saidas();
//         $contavle->setIdPedido($this->newOrder->getId());
//         $contavle->setCentro('projeto');
//         $contavle->setOperacao('s');
//         $contavle->setTipo('v');
//         $contavle->setCodigoprojeto($this->getUser()->getAttribute('id_projeto'));
//         $contavle->setCodigocadastro($env->getIdEmpresa());
//         $contavle->setCodigofuncionario(aplication_system::getUser());
//         $contavle->setSaidas($this->totalShoppingCart);
//         $contavle->setSaidaprevista($this->totalShoppingCart);
//         $contavle->setDatareal($dateOrder);
//         $contavle->setDescricaosaida($descricao);
//         $contavle->setBaixa(0);
//         $contavle->setConfirmacao(0);
//         $contavle->setConfirmadopor(0);
//         $contavle->save();
         
         $this->getUser()->getShoppingCart()->clear();
         $this->getUser()->setAttribute('id_projeto', NULL);
         $this->getUser()->setAttribute('lastOrder', $this->newOrder->getId());
         $this->getUser()->setAttribute('lastNumOrder', $this->newOrder->getNumeroPedido());
         $this->getUser()->setAttribute('loja','');
         $this->getUser()->getAttributeHolder()->remove('loja');
     }     
     // Datos de la orden para ser mostrados
     $this->infoPedido = PedidosPeer::getInfoPedido($this->newOrder->getId());
     $this->detailsOrder = PedidoItemsPeer::getOrderDetails($this->getUser()->getAttribute('lastOrder'));
  }
  
  
    
}
