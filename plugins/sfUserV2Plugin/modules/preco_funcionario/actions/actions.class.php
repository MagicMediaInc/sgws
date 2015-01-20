<?php
/**
 * lxlogin actions.
 *
 * @package    lynx4
 * @subpackage preco_funcionario
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class preco_funcionarioActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->funcionarios = LxUserPeer::getListaFuncionarios();
    }
    
    public function executeSalvaPrecio(sfWebRequest $request)
    {
      $user = RatePeer::getRateFuncionarioBase($request->getParameter('id'));
      $preco = aplication_system::convierteDecimalFormat($request->getParameter('preco'));
      $user->setRate($preco);
      $user->save();
      echo "R$ ". aplication_system::monedaFormat($preco);
      return sfView::NONE;
    }
	
}