

<?php



/**
**
 * projetoRate actions.
**
 *
**
 * @package    sgws
**
 * @subpackage projeto
**
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
**
 */

class projetoRateActions extends sfActions

{

    public function executeIndex(sfWebRequest $request)

    {

        $this->setLayout('layoutSimple');

        $id = $request->getParameter('id_projeto');

        $this->projeto = PropostaPeer::retrieveByPK($id);

        /*var_dump($id);*/

        $this->funcionarios = TempotarefaPeer::getFuncionariosProjeto($id);

        

        

    }

    

}    

?>

