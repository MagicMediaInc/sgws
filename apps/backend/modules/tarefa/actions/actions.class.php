<?php

/**
 * tarefa actions.
 *
 * @package    sgws
 * @subpackage tarefa
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 */
class tarefaActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {

        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('List') . ' Tarefa - Lynx Cms');
        $this->tarefas = TarefaPeer::getMinhasTarefas($this->getUser()->getAttribute('idUserPanel'));
        // Crea sesion de la uri al momento
        $this->getUser()->setAttribute('uri_tarefa', 'sort=' . $this->sort . '&by=' . $this->by_page . $buscador);
    }
    
    public function executeNew(sfWebRequest $request) {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list
        sfConfig::set('sf_escaping_strategy', false);
        $this->edit = true;
        $this->setLayout('layoutSimple');
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Add new') . ' tarefa - Lynx Cms');
        $this->form = new TarefaForm();
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->codigoProjeto = PropostaPeer::getCodSgwsProjeto($request->getParameter('codigo_projeto'));
        $this->arrayProjeto = TarefaPeer::getVerifieProjecto($request->getParameter('codigo_projeto'));

    }

    public function executeCreate(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $this->edit = true;
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit') . ' tarefa - Lynx Cms');
        if (!$request->isMethod('post')) {
            $this->redirect("tarefa/new");
        }
        $this->form = new TarefaForm();
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->codigoProjeto = PropostaPeer::getCodSgwsProjeto($request->getParameter('codigo_projeto'));
        $this->arrayProjeto = TarefaPeer::getVerifieProjecto($request->getParameter('codigo_projeto'));
        $this->processForm($request, $this->form);
        //$this->redirect("tarefa/new");
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request) {
        //Desactiva temporalmente el metodo de escape para que funcione el link Back to list

        sfConfig::set('sf_escaping_strategy', false);
        $this->setLayout('layoutSimple');
        $this->edit = true;
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit') . ' tarefa - Lynx Cms');
        $this->forward404Unless($Tarefa = TarefaPeer::retrieveByPk($request->getParameter('codigotarefa')), sprintf('Object Tarefa does not exist (%s).', $request->getParameter('codigotarefa')));
        $this->form = new TarefaForm($Tarefa);


        if (!aplication_system::compareUserVsResponsable($Tarefa->getResponsavel())):
            $this->edit = false;
            if (aplication_system::esSocio()) {
                $this->edit = true;
            }
        endif;
        $projeto = PropostaPeer::retrieveByPK($Tarefa->getCodigoprojeto());
        if (aplication_system::compareUserVsResponsable($projeto->getGerente())):
            $this->edit = true;
        endif;

        if (!$request->getParameter('codigo_projeto')) {
            $this->codigoProjeto = PropostaPeer::getCodSgwsProjeto($Tarefa->getCodigoprojeto());
        } else {
            $this->codigoProjeto = PropostaPeer::getCodSgwsProjeto($request->getParameter('codigo_projeto'));
        }

        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->arrayProjeto = TarefaPeer::getVerifieProjecto($request->getParameter('codigo_projeto'));
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
    }

    public function executeUpdate(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $this->edit = true;
        $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($Tarefa = TarefaPeer::retrieveByPk($request->getParameter('codigotarefa')), sprintf('Object Tarefa does not exist (%s).', $request->getParameter('codigotarefa')));
        $this->form = new TarefaForm($Tarefa);
        if (!aplication_system::compareUserVsResponsable($Tarefa->getResponsavel())):
            $this->edit = false;
            if (aplication_system::esSocio()) {
                $this->edit = true;
            }
        endif;
        $projeto = PropostaPeer::retrieveByPK($Tarefa->getCodigoprojeto());
        if (aplication_system::compareUserVsResponsable($projeto->getCliente())):
            $this->edit = true;
        endif;
        $this->processForm($request, $this->form);
        //Identifica el modulo padre
        $idParentModule = LxModulePeer::getParentIdXSfModule($this->getModuleName());
        $this->arrayProjeto = TarefaPeer::getVerifieProjecto($request->getParameter('codigo_projeto'));
        $this->moduleParent = LxModulePeer::getParentNameXParentId($idParentModule['parent_id']);
        $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request) {
        $this->forward404Unless($Tarefa = TarefaPeer::retrieveByPk($request->getParameter('codigotarefa')), sprintf('Object Tarefa does not exist (%s).', $request->getParameter('codigotarefa')));
        // Elimina las actividades de la tarefa
        TempotarefaPeer::deleitaActividadesTarefa($request->getParameter('codigotarefa'));
        // Elimina el equipo de la tarefa
        EquipeTarefaPeer::deleitaEquipe($request->getParameter('codigotarefa'));

        $Tarefa->delete();


        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        echo '
         <script type="text/javascript"> 
            parent.location.reload();
            parent.jQuery.fancybox.close();
        </script> 
       ';
        return sfView::NONE;
    }

    public function executeDeleteAll(sfWebRequest $request) {
        if ($this->getRequestParameter('chk')) {
            foreach ($this->getRequestParameter('chk') as $gr => $val) {

                $this->forward404Unless($Tarefa = TarefaPeer::retrieveByPk($val), sprintf('Object Tarefa does not exist (%s).', $request->getParameter('codigotarefa')));
                $Tarefa->delete();
            }
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        }
        return $this->redirect('tarefa/index');
    }

    protected function processForm(sfWebRequest $request, sfForm $form) {
        // die($request->getParameter('codigotarefa'));
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $Tarefa = $form->save();
            $fun = $request->getParameter('select2');
            // Agrega equipo a la tarea
            if ($fun) {
                EquipeTarefaPeer::deleitaEquipe($Tarefa->getCodigotarefa());
                for ($i = 0; $i < count($fun); $i++) {
                    // Agrega funcionario a tarea
                    $nvo = new EquipeTarefa();
                    $nvo->setCodigotarefa($Tarefa->getCodigotarefa());
                    $nvo->setCodigofuncionario($fun[$i]);
                    $nvo->save();
                }
            }

            $tarefa = TarefaPeer::retrieveByPK($Tarefa->getCodigotarefa());
            $projeto = PropostaPeer::retrieveByPK($tarefa->getCodigoprojeto());
            $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_save_confir')));
//      if($request->getParameter('codigotarefa')){
//
////        return $this->redirect('@default?module=tarefa&action=edit&codigotarefa='.$request->getParameter('codigotarefa').
////                '&status_projeto='.$projeto->getStatus().'&codigo_projeto='.$tarefa->getCodigoprojeto());
//          return $this->redirect('projeto/index');
//      }else{
////       return $this->redirect('@default?module=tarefa&action=edit&codigotarefa='.$Tarefa->getCodigotarefa().
////                '&status_projeto='.$projeto->getStatus().'&codigo_projeto='.$tarefa->getCodigoprojeto());
//       return $this->redirect('projeto/index');
//      }
            echo '
         <script type="text/javascript"> 
            parent.location.reload();
            parent.jQuery.fancybox.close();
        </script> 
       ';
        }
    }

    public function executeEquipe(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $this->tarefa = TarefaPeer::retrieveByPK($request->getParameter('codigotarefa'));
        $this->codigoProjeto = PropostaPeer::getCodSgwsProjeto($this->tarefa->getCodigoProjeto());
        $this->descricao = TarefadescricaoPeer::retrieveByPK($this->tarefa->getDescricao());
        $this->equipo = EquipeTarefaPeer::getEquipeTarefa($request->getParameter('codigotarefa'));
    }

    public function executeListActivity(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $this->tarefa = TarefaPeer::retrieveByPK($request->getParameter('codigotarefa'));
        $this->descricao = TarefadescricaoPeer::retrieveByPK($this->tarefa->getDescricao());
        $this->lista = TempotarefaPeer::getLista($request->getParameter('codigotarefa'));
        $this->valida = new lynxValida();
        $this->gerenteProyecto = PropostaPeer::getGerenteProjeto($this->tarefa->getCodigoprojeto());
    }

    public function executeAutorizaActividad(sfWebRequest $request) {
        $this->forward404Unless($this->Reg = TempotarefaPeer::retrieveByPk($request->getParameter('id_actividad')), sprintf('Object Tempo does not exist (%s).', $request->getParameter('id_actividad')));
        $projeto = TarefaPeer::getCodProjetoByCodTarefa($this->Reg->getCodigotarefa());
        // Obtiene Objeto de Proyecto
        $infoProjeto = globalFunctions::getCodigoProjeto($projeto['cod_projeto']);

        $horas = $this->Reg->getTempogasto();

        if ($request->getParameter('status')) {
            $this->Reg->setAutorizado(0);
            $infoProjeto->setHorasTrabajadas($infoProjeto->getHorasTrabajadas() - $horas);
        } else {
            $this->Reg->setAutorizado(1);
            $infoProjeto->setHorasTrabajadas($infoProjeto->getHorasTrabajadas() + $horas);
            // Valido si el funcionario esta en el Rate del Proyecto
            if (!RatePeer::getRateFuncionarioProjeto($this->Reg->getCodigofuncionario(), $projeto['cod_projeto'])) {
                /**
                 * Busco el rate base del funcionario (Projeto = 0)
                 * y lo asigno al proyecto de la actividad
                 */
                $rateBaseFuncionario = RatePeer::getRateFuncionarioProjeto($this->Reg->getCodigofuncionario(), 0);
                if ($rateBaseFuncionario) {
                    $nvoRate = new Rate();
                    $nvoRate->setCodigoprojeto($projeto['cod_projeto']);
                    $nvoRate->setFuncionario($this->Reg->getCodigofuncionario());
                    $nvoRate->setRate($rateBaseFuncionario->getRate());
                    $nvoRate->setCargo($rateBaseFuncionario->getCargo());
                    $nvoRate->save();
                }
            }
        }
        $infoProjeto->setHorasTrabajadas(aplication_system::convierteDecimalFormat($infoProjeto->getHorasTrabajadas()));

        $infoProjeto->save();
        $this->Reg->save();
    }

    public function executeActivity(sfWebRequest $request) {
        $this->setLayout('layoutSimple');
        $this->edit = false;
        $actividad = TempotarefaPeer::retrieveByPK($request->getParameter('id_actividad'));
        $this->tarefa = TarefaPeer::retrieveByPK($request->getParameter('codigotarefa'));
        $this->descricao = TarefadescricaoPeer::retrieveByPK($this->tarefa->getDescricao());
        if ($actividad) {
            if ((aplication_system::compareUserVsResponsable($actividad->getCodigoFuncionario()) && !$actividad->getAutorizado() ) || aplication_system::isAllAction()):
                $this->edit = true;
            endif;
        }
        $this->edit = true;

        $this->dataActividad = $actividad ? $actividad->getDatareal("d-m-Y") : '';
        $this->form = new ActivityForm();
    }

    public function executeRegActivity(sfWebRequest $request) {
        $this->edit = true;
        $this->setLayout('layoutSimple');
        $this->getResponse()->setTitle($this->getContext()->getI18N()->__('Edit') . ' tarefa - Lynx Cms');
        $this->tarefa = TarefaPeer::retrieveByPK($request->getParameter('codigotarefa'));
        $this->descricao = TarefadescricaoPeer::retrieveByPK($this->tarefa->getDescricao());
        if (!$request->isMethod('post')) {
            $this->redirect("tarefa/activity?codigotarefa=" . $request->getParameter('codigotarefa'));
        }

        $this->form = new ActivityForm();

        //Identifica el modulo padre
        $this->form->bind($request->getParameter($this->form->getName()));

        if ($this->form->isValid()) {
            $act = $this->form;

            if ($act->getValue('id_actividad')) {
                $newActivity = TempotarefaPeer::retrieveByPK($act->getValue('id_actividad'));
            } else {
                $newActivity = new Tempotarefa();
            }
            $newActivity->setCodigotarefa($act->getValue('codigo_tarefa'));
            $newActivity->setCodigofuncionario($act->getValue('funcionario'));
            $newActivity->setDatareal($act->getValue('data'));
            $newActivity->setTempogasto($act->getValue('horas_trabajadas'));
            $newActivity->setObservacoes($act->getValue('descricao'));
            $newActivity->save();
            $this->redirect('tarefa/listActivity?codigotarefa=' . $act->getValue('codigo_tarefa'));
        } else {
            $this->setTemplate('activity');
        }
    }

    public function executeDeleteActivity(sfWebRequest $request) {
        $request->checkCSRFProtection();
        $this->forward404Unless($activity = TempotarefaPeer::retrieveByPk($request->getParameter('id_actividad')), sprintf('Object Tarefa does not exist (%s).', $request->getParameter('id_actividad')));
        $activity->delete();
        $this->getUser()->setFlash('listo', $this->getContext()->getI18N()->__(sfConfig::get('app_msn_delete_confir')));
        return $this->redirect('tarefa/listActivity?codigotarefa=' . $activity->getCodigotarefa());
    }

    public function executeTimeSheet(sfWebRequest $request) {
        $numeroSemana = date("W");
        $this->filas = $request->getParameter('carga_filas') ? $request->getParameter('carga_filas') : 1;
        $this->valor = $request->getParameter('val');
        if ($this->valor) {
            $dato = explode('_', $this->valor);
            $this->accion = $dato[0];
            $this->fechaInicio = $dato[1];
            switch ($this->accion) {
                case 'inc':
                    $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio + 7 day"));
                    break;
                case 'dec':
                    $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio - 7 day"));
                    break;
                default:
                    $nva_fecha = $this->valor;
                    break;
            }
            $date = strtotime($nva_fecha);
        } else {
            $date = strtotime(date('Y-m-d'));
        }
        // Find the start of the week, working backwards
        $start = $date;
        while (date('w', $start) > 1) {
            $start -= 86400; // One day
        }
        // End of the week is simply 6 days from the start
        $this->end = date('Y-m-d', $start + ( 6 * 86400 ));
        $start = date('Y-m-d', $start);
        $this->start = $start;

        // Busca ultima fecha en que el usuario actualizo actvidades en la semana
        $this->dateWeek = TempotarefaPeer::getLastDateWeek($this->getUser()->getAttribute('idUserPanel'), $this->start, $this->end);
        $this->dateWeek = $this->dateWeek ? $this->dateWeek->getLastUpdate() : date('Y-m-d');
        $this->projetosUsuario = TarefaPeer::getProjetosDeFuncionarioPorTarefa($this->getUser()->getAttribute('idUserPanel'), $this->start);
    }

    public function executeBuscaActividad(sfWebRequest $request) {
        //$this->setLayout(false);
        $this->start = $request->getParameter('fecha');
        $this->fila = $request->getParameter('fila');
        $this->primerdia = TempotarefaPeer::getHorasTrabajadasDia($request->getParameter('cod_tarefa'), $this->start);
    }

    public function executeHorasTarefas(sfWebRequest $request) {
        //$this->setLayout('layoutSimple');
        $this->projetos = TarefaPeer::getProjetosDeFuncionarioPorTarefa($this->getUser()->getAttribute('idUserPanel'), $this->start);
            $numeroSemana = date("W");

            $this->valor = $request->getParameter('val');
            if ($this->valor) {
                $dato = explode('_', $this->valor);
                $this->accion = $dato[0];
                $this->fechaInicio = $dato[1];
                switch ($this->accion) {
                    case 'inc':
                        $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio + 7 day"));
                        break;
                    case 'dec':
                        $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio - 7 day"));
                        break;
                    default:
                        $nva_fecha = $this->valor;
                        break;
                }
                $date = strtotime($nva_fecha);
            } else {
                $date = strtotime(date('Y-m-d'));
            }
            // Find the start of the week, working backwards
            $start = $date;
            while (date('w', $start) > 1) {
                $start -= 86400; // One day
            }

            // End of the week is simply 6 days from the start
            $this->end = date('Y-m-d', $start + ( 6 * 86400 ));
            $start = date('Y-m-d', $start);
            $this->start = $start;
            $this->valida = new lynxValida();
            $this->tarefas = TempotarefaPeer::getTarefasForUserTrabajadas($this->start, $this->end);
        //$this->gerenteProyecto = PropostaPeer::getGerenteProjeto($this->tarefa->getCodigoprojeto());
        //$this->tarefas = TempotarefaPeer::getTotalTareasSemana($this->getUser()->getAttribute('idUserPanel'), $this->start, $this->end);
    }
    
    
     public function executeFiltroTimeSheet(sfWebRequest $request) {
        //$this->setLayout('layoutSimple');
        //$this->setLayout(false);
        $this->projetos = TarefaPeer::getProjetosDeFuncionarioPorTarefa($this->getUser()->getAttribute('idUserPanel'), $this->start);
        $this->projeto = $this->getRequestParameter('projeto');

        $this->start = date("Y-m-d", strtotime($this->getRequestParameter('from_date')));
        $this->end = date("Y-m-d", strtotime($this->getRequestParameter('to_date')));
        if( $this->projeto == ""){
            
            // End of the week is simply 6 days from the start
            $this->valida = new lynxValida();
            $this->tarefas = TempotarefaPeer::getTarefasForUserTrabajadas($this->start, $this->end );
            $this->filas = $request->getParameter('carga_filas') ? $request->getParameter('carga_filas') : 1;
            $this->projetosUsuario = TarefaPeer::getProjetosDeFuncionarioPorTarefa($this->getUser()->getAttribute('idUserPanel'), $this->start);
            //$this->redirect("tarefa/horasTarefas");
        }else{
            $projetoTarefas = array();
  
            $projetoTarefas = TarefaPeer::getTarefasByProjeto($this->projeto);   
            $this->projetoTarefas = $projetoTarefas;
            $arrayTarefas = array();

            foreach ($projetoTarefas as $value) {
                $arrayTarefas[] = $value->getCodigoTarefa();
            }
           // End of the week is simply 6 days from the start
            $this->valida = new lynxValida();
            $this->tarefas = TempotarefaPeer::getTarefasForProjeto($this->start, $this->end  ,$arrayTarefas);
            $this->filas = $request->getParameter('carga_filas') ? $request->getParameter('carga_filas') : 1;
            $this->projetosUsuario = TarefaPeer::getProjetosDeFuncionarioPorTarefa($this->getUser()->getAttribute('idUserPanel'), $this->start);
        }
    }


    public function executeCalculaSemana(sfWebRequest $request) {
        $this->setLayout(false);
        $this->valor = $request->getParameter('val');
        $dato = explode('_', $this->valor);
        $this->accion = $dato[0];
        $this->fechaInicio = $dato[1];

        switch ($this->accion) {
            case 'inc':
                $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio + 7 day"));

                break;
            default:
                $nva_fecha = date("Y-m-d", strtotime("$this->fechaInicio - 7 day"));

                break;
        }
        $date = strtotime($nva_fecha);
        $start = $date;
        while (date('w', $start) > 1) {
            $start -= 86400; // One day
        }

        // End of the week is simply 6 days from the start
        $this->end = date('Y-m-d', $start + ( 6 * 86400 ));
        $this->start = date('Y-m-d', $start);
    }

    public function executeGetTarefas(sfWebRequest $request) {

        $id = $request->getParameter('id_projeto');
        $projeto = PropostaPeer::retrieveByPK($id);
        $this->gerente = $projeto->getGerente();
        $this->items = null;
        $this->items = TarefaPeer::getTarefasProjetoHidrat($id);
    }

    public function executeCalendar(sfWebRequest $request) {
        $numeroSemana = date("W");
        $user = $this->getUser()->getAttribute('idUserPanel');
        $date = strtotime(date('Y-m-d'));
        // Obtiene dia de inicio y fin de la semana, dada la fecha
        $semana = globalFunctions::getInicioFimSemana($date);
        $this->inicio = $semana[0]['inicio'];
        $this->fin = $semana[0]['fin'];
        $this->lista = TempotarefaPeer::getTotalTareasSemana($user, $this->inicio, $this->fin);
        $this->filas = count($this->lista);

        TempotarefaPeer::getActividadesSemana($user, $this->inicio, $this->fin);
    }

    public function executeRegistraTimeSheet(sfWebRequest $request) {
        $cod_projeto = $request->getParameter('cod_projeto');
        $cod_tarefa = $request->getParameter('cod_tarea');
        $data = $request->getParameter('fecha');
        $horas = $request->getParameter('horas');
        $info = $request->getParameter('des');
        if ($horas) {
            if ($cod_projeto && $cod_tarefa) {
                $rs = TempotarefaPeer::getHorasTrabajadasDia($cod_tarefa, $data);
                if (isset($rs['id'])) {
                    $up = TempotarefaPeer::retrieveByPK($rs['id']);
                    if (!$horas) {
                        $up->delete();
                    } else {
                        $up->setTempogasto($horas);
                        $up->setObservacoes($info);
                        $up->setAutorizado(0);
                        $up->setLastUpdate(date("Y-m-d"));
                        $up->save();
                    }
                } else {
                    if ($horas > 0) {
                        $nv = new Tempotarefa();
                        $nv->setCodigotarefa($cod_tarefa);
                        $nv->setCodigofuncionario($this->getUser()->getAttribute('idUserPanel'));
                        $nv->setDatareal($data);
                        $nv->setTempogasto($horas);
                        $nv->setObservacoes($info);
                        $nv->setAutorizado(0);
                        $nv->setLastUpdate(date("Y-m-d"));
                        $nv->save();
                    }
                }
            }
        }


        return sfView::NONE;
    }

    public function week_bounds($date) {
        $date = strtotime($date);
        // Find the start of the week, working backwards
        $start = $date;
        while (date('w', $start) > 1) {
            $start -= 86400; // One day
        }
        // End of the week is simply 6 days from the start
        $end = date('Y-m-d', $start + ( 6 * 86400 ));
        $start = date('Y-m-d', $start);
        echo "<br> " . $start . '-------------' . $end;
        $calculo = $start;
        for ($i = 1; $i <= 6; $i++) {
            $calculo = date("Y-m-d", strtotime("$calculo + 1 day"));
            echo "<br>mas un dia " . $calculo;
        }
    }

}
