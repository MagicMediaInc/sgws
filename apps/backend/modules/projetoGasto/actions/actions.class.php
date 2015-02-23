
<?php

/**
 * projetoGasto actions.
 *
 * @package    sgws
 * @subpackage projeto
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class projetoGastoActions extends sfActions
{
    public function executeIndex(sfWebRequest $request)
    {
        $this->setLayout('layoutSimple');
        $id = $request->getParameter('id_projeto');
        $this->projeto = PropostaPeer::retrieveByPK($id);
        $this->tipos = SubtipoUserPeer::getListParentTypeCadastroCliente(3);
        if ($request->isMethod('post'))
        {
            // Elimina los gastos del projeto para agregarlos nuevamente
            ProjetoSubtipoGastoPeer::deleteAllSubtipoProjeto($id);
            $rs = SubtipoUserPeer::getSubTiposFornecedor(3);
            foreach ($rs as $value) {
                $valor = aplication_system::convierteDecimalFormat($request->getParameter('subtipo-'.$value['id']))."<br>";
                if($valor > 0)
                {
                    $n = new ProjetoSubtipoGasto();
                    $n->setIdProjeto($id);
                    $n->setIdSubtipo($value['id']);
                    $n->setValor($valor);
                    $n->save();
                }
            }
            
        }
        
        
        
    }
    
}    
?>
