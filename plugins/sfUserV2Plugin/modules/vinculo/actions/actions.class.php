<?php

/**
 * vinculo actions.
 *
 * @package    sgws
 * @subpackage vinculo
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class vinculoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->redirectIf(!$request->getParameter('id_user'), 'lxuser/index');
    $id = $request->getParameter('id_user');
    $tipo = LxUserPeer::getTipoUsuario($id);
    $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Lista usuários').' - '.sfConfig::get('app_name_app'));
      if (!$this->getRequestParameter('buscador')) {
          $this->buscador = '';
      }else {
          $this->buscador = $this->getRequestParameter('buscador');
      }
      if(!$this->getRequestParameter('by')) {
          $this->by = 'desc';               // Variable para el orden de los registros
          $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
          $this->sort = 'email';      // Nombre del campo que por defecto se ordenara
      }
      //Criterios de busqueda
      $c = new Criteria();
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
      if($this->getRequestParameter('buscador')) {
          sfConfig::set('sf_escaping_strategy', false);
          $criterio = $c->getNewCriterion(LxUserPeer::EMAIL, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE);
          $criterio->addOr($c->getNewCriterion(LxUserPeer::LOGIN, '%'.$this->getRequestParameter('buscador').'%', Criteria::LIKE));
          $c->add($criterio);
          $buscador = "&buscador=".$this->buscador;
          $this->bus_pagi = "&buscador=".$this->buscador;
      }else {
          $buscador = "";
          $this->bus_pagi = "";
      }
      
      $c->add(LxUserPeer::ID_USER, $id, Criteria::NOT_EQUAL);
      $c->add(LxUserPeer::ID_USER, '2', Criteria::GREATER_THAN); 
      if($tipo == 2)
      {
          $c->add(LxUserPeer::ID_TIPO_USUARIO, '3', Criteria::EQUAL); 
      }elseif ($tipo == 3) {
          $c->add(LxUserPeer::ID_TIPO_USUARIO, '2', Criteria::EQUAL); 
      }
      $pager = new sfPropelPager('LxUser',20);
      $pager->setCriteria($c);
      $pager->setPage($this->getRequestParameter('page',1));
      $pager->setPeerMethod('doSelect');
      $pager->init();
      $this->LxUsers = $pager;
      // Lista de Tipos de Cadastros para la busqueda
      //$this->tiposCadastro = TipoCadastroPeer::getListTypeCadastro();      
  }
  
  public function executeChangeVinculo(sfWebRequest $request)
  {
      $this->forward404Unless($this->LxUser = LxUserPeer::retrieveByPk($request->getParameter('id_user')), sprintf('Object LxUser does not exist (%s).', $request->getParameter('id_user')));
      $this->forward404If(!$request->getParameter('user_atual'));
      
      if(VinculoUserPeer::getExistVinculo($request->getParameter('user_atual'), $request->getParameter('id_user')))
      {
          VinculoUserPeer::deleteVinculo($request->getParameter('user_atual'), $request->getParameter('id_user'));
      }else{
          $newVinculo = new VinculoUser();
          $newVinculo->setIdUser($request->getParameter('user_atual'));
          $newVinculo->setIdUserVinculo($request->getParameter('id_user'));
          $newVinculo->save();
          // Agrega el vinculo alreves
          $newVinculo = new VinculoUser();
          $newVinculo->setIdUser($request->getParameter('id_user'));
          $newVinculo->setIdUserVinculo($request->getParameter('user_atual'));
          $newVinculo->save();
      }
  }
}
