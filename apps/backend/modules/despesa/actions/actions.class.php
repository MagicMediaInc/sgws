<?php

/**
 * despesa actions.
 *
 * @package    sgws
 * @subpackage despesa
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class despesaActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function preExecute() {
        $this->frecuencia = array('v' => 'Variável', 'f' => 'Fixa');
    }

    public function executeIndex(sfWebRequest $request) {

        $this->redirectIf(!$this->getUser()->hasCredential('backend_activo'), '@default_index?module=home');
        $this->frecuencia = array('v' => 'Variável', 'f' => 'Fixa');
        $this->status = array('1' => 'En Andamento', '2' => 'Cancelado', '4' => 'Entregue Confirmado');
        $c = new Criteria();
        // Si se selecciono proyecto o tarefa
        if ($request->getParameter('id_projeto')) {
            // tipos y subtipos con valores del proyecto
            $proje = PropostaPeer::retrieveByCodeProjecto($request->getParameter('id_projeto'));
            $this->tipos_subtipos = ProjetoSubtipoGastoPeer::getValoresProjeto($proje->getCodigoProposta());

            // Para el caso de projetos se muestran solo las salidas
            $c->add(SaidasPeer::OPERACAO, 's', Criteria::EQUAL);
            $this->forward404Unless($this->projeto = PropostaPeer::getDataByCodProjeto($request->getParameter('id_projeto')), sprintf('El projeto no existe', $request->getParameter('id_projeto')));
            $this->tarefas = TarefaPeer::getTarefasProjetoHidrat($request->getParameter('id_projeto'));
            if ($request->getParameter('id_projeto')) {
                $c->add(SaidasPeer::CODIGOPROJETO, $request->getParameter('id_projeto'), Criteria::EQUAL);
                //$c->addAnd(SaidasPeer::CODIGOCADASTRO, 1567, Criteria::NOT_EQUAL);
                //$c->addAnd(SaidasPeer::CODIGOCADASTRO, 1564, Criteria::EQUAL);
                $c->addDescendingOrderByColumn(SaidasPeer::CODIGO_SUBTIPO);
            }
            if ($request->getParameter('id_tarefa')) {
                $c->add(SaidasPeer::CODIGOTAREFA, $request->getParameter('id_tarefa'), Criteria::EQUAL);
                $this->infoTarefa = TarefaPeer::getInfoTarefa($request->getParameter('id_tarefa'));
            }
            $from = null;
            $to = null;
        } else {
            // FLUXO DE CAIXA: Se muestran las entradas y las salidas
            $this->setTemplate('indexContable');
//         $c->add(SaidasPeer::CENTRO, 'adiantamento', Criteria::NOT_EQUAL); 
            if ($request->isMethod('post')) {
                $c->add(SaidasPeer::CONFIRMACAO, $request->getParameter('status'), Criteria::EQUAL);
                $c->addAnd(SaidasPeer::CODIGOCADASTRO, 1730, Criteria::NOT_EQUAL);
            } else {
                $c->add(SaidasPeer::CONFIRMACAO, '1', Criteria::EQUAL);
                $request->setParameter('status', '1');
            }

            if ($this->getRequestParameter('from_date')) {
                $from = date("Y-m-d", strtotime($this->getRequestParameter('from_date')));
                $to = date("Y-m-d", strtotime($this->getRequestParameter('to_date')));
            } else {
                if (!$request->getParameter('status')) {
                    // Si se selecciona pendiente busco los registros de hace 300 dias a la fecha
                    $from = date('Y-m-d', strtotime('-300 day', strtotime(date('Y-m-d'))));
                    $to = date("Y-m-d");
                } else {
                    if (aplication_system::isAllAction() || aplication_system::esContable()) {
                        $from = date('Y-m-01');
                        $to = date('Y-m-30');
                    } else {
                        $from = null;
                        $to = null;
                    }
                }
            }
            $this->from = $from;
            $this->to = $to;
        }
        if ($from) {
            $cFecha = $c->getNewCriterion(SaidasPeer::DATAREAL, $from, Criteria::GREATER_EQUAL);
            $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAREAL, $to, Criteria::LESS_EQUAL));
            $c->add($cFecha);
        }

        if ($this->getRequestParameter('buscador')) {
            //Desactiva temporalmente el metodo de escape para que funcionen los link de la paginacion
            sfConfig::set('sf_escaping_strategy', false);
            $c->addJoin(SaidasPeer::CODIGOPROJETO, PropostaPeer::CODIGO_PROJETO, Criteria::LEFT_JOIN);
            $c->addJoin(SaidasPeer::CODIGOFUNCIONARIO, LxUserPeer::ID_USER, Criteria::LEFT_JOIN);
            $c->addJoin(SaidasPeer::CODIGOCADASTRO, CadastroJuridicaPeer::ID_EMPRESA, Criteria::LEFT_JOIN);

            $criterio = $c->getNewCriterion(SaidasPeer::CODIGO_SAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE);
            $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));

            $criterio->addOr($c->getNewCriterion(SaidasPeer::CENTRO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SaidasPeer::FORMAPAGAMENTO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
            $criterio->addOr($c->getNewCriterion(SaidasPeer::DESCRICAOSAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
            $c->add($criterio);
            $buscador = "&buscador=" . $this->buscador;
            $this->bus_pagi = "&buscador=" . $this->buscador;
        } else {
            $buscador = "";
            $this->bus_pagi = "";
        }

        if ($request->getParameter('prestacao_contas')) {
            // Busca solo adiantamentos y compensaciones
            $criCentro = $c->getNewCriterion(SaidasPeer::CENTRO, 'adiantamento', Criteria::EQUAL);
            $criCentro->addOr($c->getNewCriterion(SaidasPeer::CENTRO, 'compensação', Criteria::EQUAL));
            $c->add($criCentro);
        }
        if ($this->getRequestParameter('funcionario')) {
            $c->add(SaidasPeer::CODIGOFUNCIONARIO, $this->getRequestParameter('funcionario'), Criteria::EQUAL);
//          $c->add(SaidasPeer::OPERACAO, 's', Criteria::EQUAL);
//          $c->add(SaidasPeer::CONFIRMACAO, '0', Criteria::EQUAL);
            //$request->setParameter('status','0');
        }
        $c->addDescendingOrderByColumn(SaidasPeer::DATAREAL);
        $this->from = date("d-m-Y", strtotime($this->from));
        $this->to = date("d-m-Y", strtotime($this->to));
        ;
        $this->result = SaidasPeer::doSelect($c);
        // Si se selecciono proyecto o tarefa
        if ($request->getParameter('id_projeto')) {
            $r = array();
            $i = 1;
            foreach ($this->result as $value) {
                // creo mi array de los subtipos que se ha registrado en la despesa del proyecto
                $r[$i] = trim($value->getCodigoSubtipo());
                $i++;
            }
            // ahora de los subtipos registrados para el proyecto
            // detecto el que no esta en la lista para mostrarlo de ultimo
            foreach ($this->tipos_subtipos as $vals) {
                $sub = $vals->getIdSubtipo();
                $clave = array_search($sub, $r);

                if (!$clave) {
                    $st[] = $sub;
                }
            }

            $this->otrosSubtipos = $st;
        }

        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
    }

    public function executeFaturamento(sfWebRequest $request) {
        $c = new Criteria();
        if ($request->isMethod('post')) {
            if ($this->getRequestParameter('from_date')) {
                $from = date("Y-m-d", strtotime($this->getRequestParameter('from_date')));
                $to = date("Y-m-d", strtotime($this->getRequestParameter('to_date')));
            }
            if ($request->getParameter('status') == 'Faturados') {
                $c->add(SaidasPeer::DATAEMISSAO, '0000-00-00', Criteria::GREATER_THAN);
                if ($from) {
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATAEMISSAO, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAEMISSAO, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            } elseif ($request->getParameter('status') == 'Previstos') {
                $c->add(SaidasPeer::DATAEMISSAO, null, Criteria::EQUAL);
                if ($from) {
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            }
            // Caso seleccion funcionario
            if ($this->getRequestParameter('funcionario')) {
                $c->add(SaidasPeer::CODIGOFUNCIONARIO, $this->getRequestParameter('funcionario'), Criteria::EQUAL);
            }
            // Caso Palabra claves
            if ($this->getRequestParameter('buscador')) {
                // die("buscador");
                $c->addJoin(SaidasPeer::CODIGOPROJETO, PropostaPeer::CODIGO_PROJETO, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOFUNCIONARIO, LxUserPeer::ID_USER, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOCADASTRO, CadastroJuridicaPeer::ID_EMPRESA, Criteria::LEFT_JOIN);
                $criterio = $c->getNewCriterion(SaidasPeer::CODIGO_SAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE);
                $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(SaidasPeer::CENTRO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::FORMAPAGAMENTO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::DESCRICAOSAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $c->add($criterio);
            }
        }
        $c->add($c->getNewCriterion(SaidasPeer::CENTRO, 'compensação', Criteria::NOT_EQUAL));
        $c->add(SaidasPeer::OPERACAO, 'e', Criteria::EQUAL);
        $c->add(SaidasPeer::DATAPREVISTA, '2014-01-01', Criteria::GREATER_EQUAL);
        $sortTemp = SaidasPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        //PERSONALIZAR SEGUN LA NECESIDAD DEL MODULO
        //print_r($sortTemp);
        $this->sort = $sortTemp[18]; 
        $c->addDescendingOrderByColumn($this->sort);
        $this->result = SaidasPeer::doSelect($c);
        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
    }

    public function executeFatu(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $c = new Criteria();
        $id = $this->getRequestParameter('id_projeto');
        $c->add(SaidasPeer::CODIGOPROJETO, $id, Criteria::EQUAL);
        $c->add(SaidasPeer::OPERACAO, 'e', Criteria::EQUAL);
        $sortTemp = SaidasPeer::getFieldNames(BasePeer::TYPE_FIELDNAME);
        $this->sort = $sortTemp[18]; 
        $c->addDescendingOrderByColumn($this->sort);
        $this->result = SaidasPeer::doSelect($c);
        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
        $this->id = $this->getRequestParameter('id_projeto');
    }

    public function executePagamentos(sfWebRequest $request) {

        $c = new Criteria();
        $c->add(SaidasPeer::OPERACAO, 'e', Criteria::EQUAL);
        if ($request->isMethod('post')) {
            if ($this->getRequestParameter('from_date')) {
                $from = date("Y-m-d", strtotime($this->getRequestParameter('from_date')));
                $to = date("Y-m-d", strtotime($this->getRequestParameter('to_date')));
            }
            // var_dump($from);
            // var_dump($to);
            if ($request->getParameter('status') == 'Pagos') {
                // var_dump('pagos');
                $c->add(SaidasPeer::DATAREAL, date("Y-m-d"), Criteria::LESS_THAN);
                if ($from) {
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            } elseif ($request->getParameter('status') == 'Abertos') {
                // var_dump('abertos');
                $c->add(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
                $c->add(SaidasPeer::DATARECEBIMENTOPRE, date("Y-m-d"), Criteria::GREATER_THAN);
                if ($from) {
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            } elseif ($request->getParameter('status') == 'Atrasados') {
                // var_dump('atrasados');
                $c->add(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
                $c->add(SaidasPeer::DATARECEBIMENTOPRE, date("Y-m-d"), Criteria::LESS_THAN);
                if ($from) {
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            }
            /*if ($from) {
                $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                $c->addAnd(SaidasPeer::DATAREAL, '0000-00-00', Criteria::EQUAL);
                $c->add($cFecha);
            } else {

                $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, '0000-00-00', Criteria::GREATER_THAN);
                $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, date("y-m-d"), Criteria::LESS_THAN);
                $c->addAnd(SaidasPeer::DATAREAL, '0000-00-00', Criteria::EQUAL);
            }*/

            // Caso seleccion funcionario
            if ($this->getRequestParameter('funcionario')) {
                $c->add(SaidasPeer::CODIGOFUNCIONARIO, $this->getRequestParameter('funcionario'), Criteria::EQUAL);
            }
            // Caso Palabra claves
            if ($this->getRequestParameter('buscador')) {

                $c->addJoin(SaidasPeer::CODIGOPROJETO, PropostaPeer::CODIGO_PROJETO, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOFUNCIONARIO, LxUserPeer::ID_USER, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOCADASTRO, CadastroJuridicaPeer::ID_EMPRESA, Criteria::LEFT_JOIN);

                $criterio = $c->getNewCriterion(SaidasPeer::CODIGO_SAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE);
                $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(SaidasPeer::CENTRO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::FORMAPAGAMENTO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::DESCRICAOSAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $c->add($criterio);
            }
        } else {
            $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, '0000-00-00', Criteria::GREATER_THAN);
            // $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, date("Y-m-d"), Criteria::LESS_THAN);
            // $c->addAnd(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
        }
        $this->result = SaidasPeer::doSelect($c);
        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
    }

    public function executeSaidas(sfWebRequest $request) {

        $c = new Criteria();
        $c->add(SaidasPeer::OPERACAO, 's', Criteria::EQUAL);
        if ($request->isMethod('post')) {
            if ($this->getRequestParameter('from_date')) {
                $from = date("Y-m-d", strtotime($this->getRequestParameter('from_date')));
                $to = date("Y-m-d", strtotime($this->getRequestParameter('to_date')));
            }
            // var_dump($from);
            // var_dump($to);
            if ($request->getParameter('status') == 'Saidas') {
                $c->add(SaidasPeer::DATAREAL, date("Y-m-d"), Criteria::LESS_THAN);
                if ($from) {
                    // var_dump('saidas');
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            } elseif ($request->getParameter('status') == 'Abertas') {
                $c->add(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
                $c->add(SaidasPeer::DATARECEBIMENTOPRE, date("Y-m-d"), Criteria::GREATER_THAN);
                if ($from) {
                    // var_dump('abertos');
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            } elseif ($request->getParameter('status') == 'Atrasadas') {
                $c->add(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
                $c->add(SaidasPeer::DATARECEBIMENTOPRE, date("Y-m-d"), Criteria::LESS_THAN);
                if ($from) {
                    // var_dump('atrasados');
                    $cFecha = $c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $from, Criteria::GREATER_EQUAL);
                    $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATARECEBIMENTOPRE, $to, Criteria::LESS_EQUAL));
                    $c->add($cFecha);
                }
            }
            /*if ($from) {
                $cFecha = $c->getNewCriterion(SaidasPeer::DATAPREVISTA, $from, Criteria::GREATER_EQUAL);
                $cFecha->addAnd($c->getNewCriterion(SaidasPeer::DATAPREVISTA, $to, Criteria::LESS_EQUAL));
                $c->addAnd(SaidasPeer::DATAREAL, '0000-00-00', Criteria::EQUAL);
                $c->add($cFecha);
            } else {

                $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, '0000-00-00', Criteria::GREATER_THAN);
                $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, date("y-m-d"), Criteria::LESS_THAN);
                $c->addAnd(SaidasPeer::DATAREAL, '0000-00-00', Criteria::EQUAL);
            }*/

            // Caso seleccion funcionario
            if ($this->getRequestParameter('funcionario')) {
                // var_dump("funcionario");
                $c->add(SaidasPeer::CODIGOFUNCIONARIO, $this->getRequestParameter('funcionario'), Criteria::EQUAL);
            }
            // Caso Palabra claves
            if ($this->getRequestParameter('buscador')) {
                // var_dump("buscador");
                $c->addJoin(SaidasPeer::CODIGOPROJETO, PropostaPeer::CODIGO_PROJETO, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOFUNCIONARIO, LxUserPeer::ID_USER, Criteria::LEFT_JOIN);
                $c->addJoin(SaidasPeer::CODIGOCADASTRO, CadastroJuridicaPeer::ID_EMPRESA, Criteria::LEFT_JOIN);

                $criterio = $c->getNewCriterion(SaidasPeer::CODIGO_SAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE);
                $criterio->addOr($c->getNewCriterion(PropostaPeer::CODIGO_SGWS_PROJETO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(LxUserPeer::NAME, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(CadastroJuridicaPeer::NOME_FANTASIA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));

                $criterio->addOr($c->getNewCriterion(SaidasPeer::CENTRO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::FORMAPAGAMENTO, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $criterio->addOr($c->getNewCriterion(SaidasPeer::DESCRICAOSAIDA, '%' . $this->getRequestParameter('buscador') . '%', Criteria::LIKE));
                $c->add($criterio);
            }
        } else {
            // var_dump("not post");
            $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, date('Y-m-01'), Criteria::GREATER_THAN);
            $c->addAnd(SaidasPeer::DATARECEBIMENTOPRE, date('Y-m-t'), Criteria::LESS_THAN);
            // $c->addAnd(SaidasPeer::DATAREAL, null, Criteria::EQUAL);
        }
        $this->result = SaidasPeer::doSelect($c);
        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
    }

    public function executeContas(sfWebRequest $request) {

        $this->funcionarios = LxUserPeer::getUsuariosFuncionarios();
        $result = array();
        foreach ($this->funcionarios as $funcionario):
            # code...
            $prestacoes_funcionario = SaidasPeer::getTotalPrestacaoContasFuncionario($funcionario['id'], null, 1, $request->getParameter('from_date'), $request->getParameter('to_date'));
            // if($funcionario['id'] == 19) var_dump($prestacoes_funcionario);
            $result[] = array(
                'id_user' => $funcionario['id'],
                'funcionario' => $funcionario['nome'],
                'entradas' => $prestacoes_funcionario['totalE'],
                'saidas' => $prestacoes_funcionario['totalS'],
                );
        endforeach;
        $this->result = $result;

    }

    public function executeCompensar(sfWebRequest $request) {
        if ($this->getRequestParameter('chk')) {
            $total = 0;
            // var_dump($this->getRequestParameter('chk'));
            foreach ($this->getRequestParameter('chk') as $gr => $val) {
             // var_dump($gr);
                $saida = SaidasPeer::retrieveByPk($val);
             // var_dump($saida);
                $saida->setConfirmacao(1);
                $saida->setForPrint(0);
                $saida->setConfirmadopor(aplication_system::getUser());
                $saida->save();
                if($saida->getIdCompensacao==null):
                    $total = $total + $saida->getSaidas();
                endif;
            }
            // creo registro de compensación
            $total = aplication_system::convierteDecimalFormat($total);
            if ($total > 0) {
                $funcionario = LxUserPeer::getNomeUser($request->getParameter('cod_funcionario'));

                $despesa = new Saidas();
                $despesa->setCentro('compensação');
                $despesa->setOperacao('e');
                $despesa->setTipo('v');
                $despesa->setDescricaosaida('Compensação Funcionario ' . $funcionario['nome']);
                $despesa->setSaidas($total);
                $despesa->setSaidaprevista($total);
                $despesa->setDatareal(date("Y-m-d"));
                $despesa->setDataprevista(date("Y-m-d"));
                $despesa->setCodigofuncionario($request->getParameter('cod_funcionario'));
                $despesa->setFormapagamento('Transferencia');
                $despesa->setConfirmacao('1');
                // $despesa->setCodigoprojeto(2016);
                // $despesa->setCodigoCadastro(340);
                $despesa->setCodigoCadastro(340);
                $despesa->setCodigoprojeto(2329);
                $despesa->setConfirmadopor(aplication_system::getUser());
                $despesa->save();
            }
            // Looper de nuevo los valores para asociarles el id de la compensacion creada
            foreach ($this->getRequestParameter('chk') as $gr => $val) {
                $saida = SaidasPeer::retrieveByPk($val);
                $saida->setIdCompensacao($despesa->getCodigoSaida());
                $saida->save();
            }

            $this->getUser()->setFlash('listo', 'Compensação com sucesso');
        }

        return $this->redirect('despesa/index');
    }

    public function executeDarBaixa(sfWebRequest $request) {
        $this->forward404Unless($this->Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Despesa does not exist (%s).', $request->getParameter('id')));
        if ($request->getParameter('baixa')) {
            $this->Despesa->setBaixa(0); // No aprobado por GP
        } else {
            $this->Despesa->setBaixa(1); // aprobado por GP
        }
        $this->Despesa->save();
    }

    public function executeConfirmacion(sfWebRequest $request) {
        $this->forward404Unless($this->Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Despesa does not exist (%s).', $request->getParameter('id')));
        if ($request->getParameter('confirmado')) {
            if($this->Despesa->getIdCompensacao != null):
                $compensacao = SaidasPeer::retrieveByPk($this->Despesa->getIdCompensacao);
                $compensacao->setSaidas($compensacao->getSaidas()-$this->Despesa->getSaidas());
                $compensacao->save();
            endif;
            $this->Despesa->setConfirmacao(0);
            // $this->Despesa->setBaixa(0);
            $this->Despesa->setConfirmadopor(0);
        } else {
            // $this->Despesa->setBaixa(1);
            $this->Despesa->setConfirmacao(1);
            $this->Despesa->setConfirmadopor(aplication_system::getUser());
        }
        $this->Despesa->save();
    }

    public function executeNew(sfWebRequest $request) {
        $this->filas = $request->getParameter('carga_filas') ? $request->getParameter('carga_filas') : 1;
        $this->forward404Unless($this->projeto = PropostaPeer::getDataByCodProjeto($request->getParameter('id_projeto')), sprintf('El projeto no existe', $request->getParameter('id_projeto')));
        $this->tarefas = TarefaPeer::getTarefasProjetoHidrat($request->getParameter('id_projeto'));
        if ($request->getParameter('id_tarefa')) {
            $this->infoTarefa = TarefaPeer::getInfoTarefa($request->getParameter('id_tarefa'));
        }
        $this->projetosUsuario = EquipeTarefaPeer::getProjetosDeFuncionario(aplication_system::getUser());
        $this->formaPagamento = sfConfig::get('app_despesa_pagamento');
    }

    public function executeNewFinanciero($request) {

        $this->form = new DespesaFinacieroForm();
    }

    public function executeNewFinancieroEntrada($request) {
        $this->setLayout('layoutSimple');
        $this->id_projeto = $this->getRequestParameter('id_projeto');
        $this->form = new DespesaEntradaForm(array(), array('idProjeto' => $this->id_projeto));
    }

    public function executeCreateFinanciero($request) {
        $this->form = new DespesaFinacieroForm();
        $this->processForm($request, $this->form);
        $this->setTemplate('newFinanciero');
    }

    public function executeCreateFinancieroEntrada($request) {
        $this->setLayout('layoutSimple');
        $this->id_projeto = $this->getRequestParameter('id_projeto');
        $this->form = new DespesaEntradaForm(array(), array('idProjeto' => $this->id_projeto));
        $this->processEntradaForm($request, $this->form);
        $this->setTemplate('newFinancieroEntrada');
    }

    public function executeEditFinanciero(sfWebRequest $request) {
        // ID de la Despesa
        $id = $request->getParameter('id');
        $this->id_projeto = $request->getParameter('id_projeto');
        $this->despesa = SaidasPeer::retrieveByPK($id);
        $this->form = new DespesaFinacieroForm($this->despesa);
    }

    public function executeEditFinancieroEntrada($request) {
        // ID de la Despesa
        $this->setLayout('layoutSimple');
        $id = $this->getRequestParameter('id');
        $this->despesa = SaidasPeer::retrieveByPK($id);
        $this->id_projeto = $this->getRequestParameter('id_projeto');
        $this->form = new DespesaEntradaForm($this->despesa, array('idProjeto' => $this->id_projeto));
    }

    public function executeSaveDespesa(sfWebRequest $request) {
        $filas = $request->getParameter('nFilas');
        $codigo_tarefa = $request->getParameter('codigo_tarefa');
        $codProjeto = $request->getParameter('codigo_projeto');
        for ($i = 1; $i <= $filas; $i++) {
            if ($request->getParameter('data-' . $i)) {
                $despesa = new Saidas();
                $despesa->setCentro('projeto');
                $despesa->setOperacao('s');
                $despesa->setTipo('v');
                $despesa->setDescricaosaida($request->getParameter('des-' . $i));
                $valor = aplication_system::convierteDecimalFormat($request->getParameter('valor-' . $i));
                $despesa->setSaidas($valor);
                $despesa->setSaidaprevista($valor);
                $despesa->setDatareal($request->getParameter('data-' . $i));
                $despesa->setDataprevista($request->getParameter('data-' . $i));
                $despesa->setCodigofuncionario($this->getUser()->getAttribute('idUserPanel'));
                $despesa->setCodigocadastro($request->getParameter('fornecedor-' . $i));
                $despesa->setCodigoprojeto($codProjeto);
                if($codigo_tarefa != ""){
                $despesa->setCodigotarefa($codigo_tarefa);
                }
                $despesa->setCodigoTipo($request->getParameter('tipo-' . $i));
                $despesa->setCodigoSubtipo($request->getParameter('subtipo-' . $i));
                $despesa->setFormapagamento($request->getParameter('pagamento-' . $i));
                $despesa->setBaixa('0');
                $despesa->setConfirmacao('0');
                $despesa->setConfirmadopor('0');
                $despesa->save();
            }
        }
        if (!$codigo_tarefa) {
            $this->redirect('despesa/index?id_projeto=' . $codProjeto);
        } else {
            $this->redirect('despesa/index?id_projeto=' . $codProjeto . '&id_tarefa=' . $codigo_tarefa);
        }
    }

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Object Despesa does not exist (%s).', $request->getParameter('id')));
        if ($Despesa->getIdCompensacao()) {
            $this->getUser()->setFlash('error', sfConfig::get('app_msn_exist_compensacion'));
        } else {
            $Despesa->delete();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        }
        if ($request->getParameter('despro')) {
            return $this->redirect('despesa/index?id_projeto=' . $Despesa->getCodigoprojeto());
        } else {
            return $this->redirect('despesa/index');
        }
    }

    public function executeEdit(sfWebRequest $request) {
        // ID de la Despesa
        $id = $request->getParameter('id');
        $this->despesa = SaidasPeer::retrieveByPK($id);
        $this->form = new DespesaForm($this->despesa);
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Despesa does not exist (%s).', $request->getParameter('id')));
        $this->form = new DespesaForm($Despesa);

        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('edit');
    }

    public function executeUpdateFinanciero(sfWebRequest $request) {
        
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Despesa does not exist (%s).', $request->getParameter('id')));
        $this->form = new DespesaFinacieroForm($Despesa);

        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('editFinanciero');
    }

    public function executeUpdateFinancieroEntrada(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($Despesa = SaidasPeer::retrieveByPk($request->getParameter('id')), sprintf('Despesa does not exist (%s).', $request->getParameter('id')));
        $this->id_projeto = $this->getRequestParameter('id_projeto');
        $this->form = new DespesaEntradaForm($Despesa, array('idProjeto' => $this->id_projeto));
        $this->processEntradaForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('editFinancieroEntrada');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        //die("chao");
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) { 
            $Despesa = $form->save();
            if (!$form->getValue('codigofuncionario')) {
                $Despesa->setConfirmadopor(aplication_system::getUser());
            }
            if (aplication_system::esFuncionario()) {
                $Despesa->setDataprevista($form->getValue('datareal'));
                $Despesa->setSaidaprevista($form->getValue('saidas'));
            }
            if($Despesa->getCentro() == "adiantamento" || $Despesa->getCentro() == "compensação"){
               $Despesa->setCodigocadastro(340);
            }
            //$Despesa->setConfirmacao(0);
            $Despesa->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            if (aplication_system::esFuncionario()) {
                if ($form->getValue('codigoprojeto')) {
                    $this->redirect('despesa/index?id_projeto=' . $form->getValue('codigoprojeto'));
                } else {
                    $this->redirect('contas/index');
                }
            } else {
                if ($request->getParameter('id_projeto')) {
                    $this->redirect('despesa/index?id_projeto=' . $request->getParameter('id_projeto'));
                } else {
                    if ($request->getParameter('referer')) {
                        $this->redirect($request->getParameter('referer') . '/index');
                    }
                    $this->redirect('despesa/index');
                }
            }
        }
    }

    protected function processEntradaForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $Despesa = $form->save();
            $DespesaE = new Saidas();
            
            $Despesa->getConfirmacao();
            if (!$form->getValue('codigofuncionario')) {
                $Despesa->setConfirmadopor(aplication_system::getUser());
            }
            if (aplication_system::esFuncionario()) {
                $Despesa->setDataprevista($form->getValue('datareal'));
                $Despesa->setSaidaprevista($form->getValue('saidas'));
            }
            $Despesa->setCodigocadastro($request->getParameter('cliente'));
            $Despesa->save();
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
            if (aplication_system::esFuncionario()) {
                if ($form->getValue('codigoprojeto')) {
                    //despesa/fatu/id_projeto/2106
                    $this->redirect('despesa/fatu?id_projeto=' . $form->getValue('codigoprojeto'));
                } else {
                    $this->redirect('contas/index');
                }
            } else {

                if ($request->getParameter('id_projeto')) {
                    $this->redirect('despesa/fatu?id_projeto=' . $request->getParameter('id_projeto'));
                } else {

                    if ($request->getParameter('referer')) {
                        $this->redirect($request->getParameter('referer') . '/index');
                    }
                    $this->redirect('despesa/fatu?id_projeto=' . $form->getValue('codigoprojeto'));
                }
            }
        }
    }

    public function executeVerAsocCompensacion(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $id = $request->getParameter('id');
        $this->data = SaidasPeer::retrieveByPK($id);
        $this->result = SaidasPeer::getSaidaPerCompensacion($id);
    }

}
