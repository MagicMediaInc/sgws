<?php

/**
 * ajax actions.
 *
 * @package    sgws
 * @subpackage ajax
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ajaxActions extends sfActions
{
  public function executeFormatNumber(sfWebRequest $request)
  {
      $valor = $request->getParameter('numero');
      echo number_format($valor, 2, ',', '.');
      return sfView::NONE;
  }

  public function executeGetTipos(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $operacao = $request->getParameter('operacao');
    $idTipoCadastro = $operacao == 'e' ? 2 : 3 ;
    $this->items = null;
    $this->items = SubtipoUserPeer::getTiposTipoCadastro($idTipoCadastro);
  }
  
  public function executeGetSubTipos(sfWebRequest $request)
  {
    $parent = $request->getParameter('id_tipo');
    $this->items = null;
    $this->items = SubtipoUserPeer::getTiposTipoCadastro(null, $parent);    
    $this->setTemplate('getTipos');
  }
  
  public function executeGetEmpresas(sfWebRequest $request)
  {
    $subtipo = $request->getParameter('subtipo');
    $this->items = null;
    $this->items = FornecedorSubtipoPeer::getEmpresas($subtipo);    
  }
  
  public function executeGetClientes(sfWebRequest $request)
  {
    $codigocadastro = $request->getParameter('codigocadastro');    
    $this->items = null;
    $this->items = CadastroPeer::getClientes($codigocadastro);
  }
  
  public function executeGetClienteProjeto(sfWebRequest $request)
  {
    $codigoprojeto = $request->getParameter('codigoprojeto');    
    $this->items = null;
    $c = PropostaPeer::getDataByCodProjeto($codigoprojeto);
    $this->items = CadastroPeer::getClientes($c->getCliente());
  }
  
  public function executeGetCentros(sfWebRequest $request)
  {
    $operacao = $request->getParameter('operacao');
    $this->items = null;
    $this->items = ($operacao == 'e')? sfConfig::get('app_despesa_centroE'):
                                       sfConfig::get('app_despesa_centroS');
  }
  
  public function executeGetStatusProjeto(sfWebRequest $request)
  {
    $id_status_projeto = $request->getParameter('id_status_projeto');
    $this->items = null;
    $this->items = StatusPeer::getListStatus2($id_status_projeto);    
  }
  
  public function executeGetFuncionarios(sfWebRequest $request)
  {
    $this->items = null;
    $this->items = LxUserPeer::getUsuariosFuncionarios();
  }
  
  public function executeGetAdministradores(sfWebRequest $request)
  {
    $this->items = null;
    $this->items = LxUserPeer::getAdministradores();
    $this->setTemplate('getFuncionarios');
  }
  
  public function executeGetFuncionariosProjeto(sfWebRequest $request)
  {
    $projeto = $request->getParameter('projeto');
    $this->items = null;
    $this->items = EquipeTarefaPeer::getFuncionariosProyecto($projeto);
  }
  
  public function executeGetSubTiposByTipoCadastro(sfWebRequest $request)
  {
    $id = $request->getParameter('id');
    $id_subtipo = intval($request->getParameter('id_subtipo'));
    
    $this->items = null;
    $this->items = SubtipoUserPeer::findSubTiposByTC($id, $id_subtipo);
    
  }
  
  public function executeUpdateRate(sfWebRequest $request)
  {
      $id   = $request->getParameter('id');
      $rate = aplication_system::convierteDecimalFormat($request->getParameter('rate'));
      
      // Actualizo el rate del funcionario
      $update = RatePeer::retrieveByPK($id);
      if($update)
      {
          $update->setRate($rate);
          $update->save();
      }
      
      return sfView::NONE;
  }
}
