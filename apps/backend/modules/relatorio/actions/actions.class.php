<?php

/**
 * relatorio actions.
 *
 * @package    sgws
 * @subpackage relatorio
 * @author     Henry Vallenilla <henryvallenilla@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class relatorioActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->ano = $request->getParameter('ano') ? $request->getParameter('ano') : date('Y');
    $range  = range(date('Y') - 1, date('Y'));
    $this->years = array_combine($range,$range);
  }
  
  public function executeWip(sfWebRequest $request)
  {
    $this->status = StatusPeer::getListStatusFilter();
    if (!$request->isMethod('post'))
    {
        $this->statusSelected = 4; // En andamento por defecto
    }else{
        $this->statusSelected = $request->getParameter('proposta_status');
    }
    $this->result = PropostaPeer::getAllProjetos($this->statusSelected, $request->getParameter('buscador'));
  }
  
  public function executeConsolidadoProjeto(sfWebRequest $request)
  {
      if (!$request->isMethod('post'))
        {
            $this->statusSelected = 4; // En andamento por defecto
            $request->setAttribute('proposta_status', 4);
        }else{
            $this->statusSelected = $request->getParameter('proposta_status');
            $request->setAttribute('proposta_status', 4);
        }
      $this->result = PropostaPeer::getConsolidadoProjetos($this->statusSelected, $request->getParameter('buscador'));
      $this->status = StatusPeer::getListStatusFilter();
  }
  
  public function executeFluxo(sfWebRequest $request)
  {
      $this->data = PropostaPeer::retrieveByPK($request['id']);
      $this->despesa = SaidasPeer::getSaidaPerProjeto($request['id']);
  }
  
  public function executeFinanciero(sfWebRequest $request)
  {
      
  }
  
  public function executeBilability(sfWebRequest $request)
  {
      $this->setLayout('layoutTotalAncho');
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      
      $this->ano = $ano;
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';               // Variable para el orden de los registros
        $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
        $this->sort = 'name';      // Nombre del campo que por defecto se ordenara
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      
      $funcionarios = LxUserPeer::getFuncionariosByBilability($this->sort, $this->by);
      $horasBilability = HorasBillabilityPeer::getAnoHorasMes($ano);
      $mesActual = date('m');
      
        foreach ($funcionarios as $funcionario) 
        {
            
            // Recorro por meses y analizo de acuerdo al status
            $totalHorasBilability = 0;
            $HorasTrabajadasMedia = 0;
            $media = 0;
            for($i =  1; $i <=12; $i++)
            {
                $nMes = globalFunctions::zerofill($i,2);
                $nombreMes = lynxValida::nombreMes($nMes);
                
                $valor = TempotarefaPeer::getHorasTrabajadasFuncionario($ano,$nMes,$funcionario['id'], 1); 
                $getMes = 'getMes'.$i;
                // Horas bilability del mes
                $horasBilabilityMes = $horasBilability->$getMes();
                // Total horas bilability
                if($i <= $mesActual)
                {
                    $totalHorasBilability = $totalHorasBilability + $horasBilabilityMes;
                    $HorasTrabajadasMedia = $HorasTrabajadasMedia + $valor;
                }
                
                // porcentaje de las horas trabajadas del funcionario en el mes
                $porcentajeMesFuncionario = $valor * 100 / $horasBilabilityMes;
                //$r[$funcionario['nome']][$funcionario['cargo']][$nombreMes.' '.$horasBilability->$getMes()] = $valor;
                $r[$funcionario['nome']][$funcionario['cargo']][$nMes] = array($valor,$porcentajeMesFuncionario);
                if($i == 12)
                {
                    $this->media = $totalHorasBilability / $mesActual;
                    $this->mediaHoras = $HorasTrabajadasMedia / $mesActual;
                    
                    
                    $r[$funcionario['nome']][$funcionario['cargo']]['Media'] = array($HorasTrabajadasMedia,$this->mediaHoras);
                    $r[$funcionario['nome']][$funcionario['cargo']]['Meta'] = $funcionario['meta'];
                    $r[$funcionario['nome']][$funcionario['cargo']]['M. Atingida?'] = 0;
                }
            }  
          
            
          
        }
        $this->result = $r;
//      echo "<pre>";
//      print_r($r);
//      echo "</pre>";
//      die();
  }
  
  public function executeNbilability(sfWebRequest $request)
  {
      $this->setLayout('layoutTotalAncho');
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      
      $this->ano = $ano;
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';               // Variable para el orden de los registros
        $this->by_page = "asc";           // Variable para el paginador y las flechas de orden
        $this->sort = 'name';      // Nombre del campo que por defecto se ordenara
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      $funcionarios = LxUserPeer::getFuncionariosByBilability($this->sort, $this->by);
      $horasBilability = HorasBillabilityPeer::getAnoHorasMes($ano);
      $mesActual = date('m');
      
        foreach ($funcionarios as $funcionario) 
        {
            
            // Recorro por meses y analizo de acuerdo al status
            $totalHorasBilability = 0;
            $HorasTrabajadasMedia = 0;
            $media = 0;
            for($i =  1; $i <=12; $i++)
            {
                $nMes = globalFunctions::zerofill($i,2);
                $nombreMes = lynxValida::nombreMes($nMes);
                
                $valor = TempotarefaPeer::getHorasTrabajadasFuncionario($ano,$nMes,$funcionario['id'], 2); 
                $getMes = 'getMes'.$i;
                // Horas bilability del mes
                $horasBilabilityMes = $horasBilability->$getMes();
                // Total horas bilability
                if($i <= $mesActual)
                {
                    $totalHorasBilability = $totalHorasBilability + $horasBilabilityMes;
                    $HorasTrabajadasMedia = $HorasTrabajadasMedia + $valor;
                }
                
                // porcentaje de las horas trabajadas del funcionario en el mes
                $porcentajeMesFuncionario = $valor * 100 / $horasBilabilityMes;
                //$r[$funcionario['nome']][$funcionario['cargo']][$nombreMes.' '.$horasBilability->$getMes()] = $valor;
                $r[$funcionario['nome']][$funcionario['cargo']][$nMes] = array($valor,$porcentajeMesFuncionario);
                if($i == 12)
                {
                    $this->media = $totalHorasBilability / $mesActual;
                    $this->mediaHoras = $HorasTrabajadasMedia / $mesActual;
                    
                    $r[$funcionario['nome']][$funcionario['cargo']]['Media'] = array($HorasTrabajadasMedia,$this->mediaHoras);
                    $r[$funcionario['nome']][$funcionario['cargo']]['Meta'] = $funcionario['meta'];
                    $r[$funcionario['nome']][$funcionario['cargo']]['M. Atingida?'] = 0;
                }
            }  
          
            
          
        }
        $this->result = $r;
//      echo "<pre>";
//      print_r($r);
//      echo "</pre>";
//      die();
  }

  public function executeFaturamentos(sfWebRequest $request)
  {
      $t = array('1' => 'Faturamento Realizado', '2' => 'Previsão de Faturamento', '3' => 'Total');
      $r = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      
      foreach ($t as $status => $valorStatus) {
          // Recorro por meses y analizo de acuerdo al status
          $total = 0;
          for($i =  1; $i <=12; $i++)
          {
              $nMes = globalFunctions::zerofill($i,2);
              
              if($status == 1)
              {
                  $valor = SaidasPeer::getFaturamentosRealizados($ano,$nMes);
              }elseif ($status == 2){
                  $valor = SaidasPeer::getFaturamentosPrevistos($ano,$nMes);
              }
              
              //echo $nMes.'--'.$valor."<br>";
              $total = $total + $valor;
              // Grabo en array
              if($status < 3)
              {
                  $r[$valorStatus][$nMes] = aplication_system::monedaFormat($valor);
                  $tt['total'.$status][$i] = $total;
              }else{
                  //$r[$valorStatus][$nMes] = aplication_system::monedaFormat($total);
              }
              $total = 0;
          }
      }
      for($i =  1; $i <=12; $i++)
      {
          $nMes = globalFunctions::zerofill($i,2);
          $ttotalFile = $tt['total1'][$i] + $tt['total2'][$i];
          $r['Total'][$nMes] = aplication_system::monedaFormat($ttotalFile);
          unset($ttotalFile);
      }
//      echo "<pre>";
//      //print_r($tt);
//      print_r($r);
//      echo "</pre>";
//      die();
      $this->result = $r;
      
  }
  
  public function executeDespesas(sfWebRequest $request)
  {
      $this->titulo = 'Despesas';
      $this->variables = array('0' => 'Despesas Previstas', '1' => 'Despesas Realizadas');
      $r = array();
      $this->totales = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      
      foreach ($this->variables as $status => $valorStatus) {
            // Recorro por meses y analizo de acuerdo al status
            for($i =  1; $i <=12; $i++)
            {
                $nMes = globalFunctions::zerofill($i,2);
                $valor = SaidasPeer::getDespesasRealizadosPerCentro($ano,$nMes,$status); 
                $r[$status][$nMes] = $valor;
            }   
      }
      for($i =  1; $i <=12; $i++)
      {
          $nMes = globalFunctions::zerofill($i,2);
          $tMes =  $r[0][$nMes] + $r[1][$nMes];
          $this->totales[$nMes] = $tMes;
      }
      $this->result = $r;
//      echo "<pre>";
//      print_r($r);
//      print_r($this->totales);
//      echo "</pre>";
//      die();
  }
  
  public function executePagamentosEmAtraso(sfWebRequest $request)
  {
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';               
        $this->by_page = "asc";           
        $this->sort = 'CODIGO_SGWS_PROJETO';      
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      $this->result = SaidasPeer::getPagamentosEmAtraso($this->sort, $this->by);
  }
  
  public function executeFluxoCaixa(sfWebRequest $request)
  {
      
      $this->titulo = 'Fluxo de Caixa';
      $this->variables = array(
          '1' => 'Faturamentos'
//          '2' => 'Imposto', 
//          '3' => 'Despesas PJ', 
//          '4' => 'Despesas ADM',
//          '5' => 'Despesas Comerciais',
//          '6' => 'Despesas Terceiros',
//          '7' => 'Despesas Comerciais',
//          '8' => 'Despesas Treinamento'
      );
      $r = array();
      $this->totales = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      foreach ($this->variables as $status => $valorStatus) {
            // Recorro por meses y analizo de acuerdo al status
            for($i =  1; $i <=12; $i++)
            {
                $nMes = globalFunctions::zerofill($i,2);
                $valor = SaidasPeer::getDespesasRealizadosPerCentro($ano,$nMes,$status); 
                $r[$status][$nMes] = $valor;
            }   
      }
      
      $this->result = $r;
  }
  
  public function executeVendas(sfWebRequest $request)
  {
      
  }
  
  public function executeConsolidadoVendas(sfWebRequest $request)
  {
      //$this->setLayout('layoutSimple');
      $r = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      $this->ano = $ano;
//      echo "<pre>";
      for($i =  1; $i <=12; $i++)
      {
            $nMes = globalFunctions::zerofill($i,2);
            $nombreMes = lynxValida::nombreMes($nMes).'<br>';
            // busco las propuestas emitidas
            $propostasEmitidas = PropostaPeer::getPropostasEmitidas($ano, $nMes);
            $propostasVendidas = PropostaPeer::getPropostasVendidas($ano, $nMes);
            $r[$nMes] = array(
                  'propostas_emitidas'     => $propostasEmitidas['cantidad'],
                  'total_emitido'         => 'R$ '.aplication_system::monedaFormat($propostasEmitidas['total']),
                  'valor_medio_emitido'    => 'R$ '.aplication_system::monedaFormat($propostasEmitidas['valor_medio_emitido']),
                  'propostas_vendidas'    => $propostasVendidas['cantidad'],
                  'total_vendido'       => 'R$ '. aplication_system::monedaFormat($propostasVendidas['total']),
                  'valor_medio_vendido'    => 'R$ '.aplication_system::monedaFormat($propostasVendidas['valor_medio_vendido'])
              );
            //$r[$nombreMes]['servicio'] = array();
      }
      $this->result = $r;
//      print_r($r);
//      echo "</pre>";    
//      die();
  }
  
  public function executeFunilVendas(sfWebRequest $request)
  {
      $r = array();
      $data = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';        // Variable para el orden de los registros
        $this->by_page = "asc";    // Variable para el paginador y las flechas de orden
        $this->sort = 'CODIGO_SGWS_PROJETO';      // Nombre del campo que por defecto se ordenara
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      
      $projetos = PropostaPeer::getFunilVendasProjetos($ano, $this->sort, $this->by);

      
      $this->result =  $projetos;
      
  }
  
  public function executeEmNegociacao(sfWebRequest $request)
  {
      $r = array();
      $data = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';        // Variable para el orden de los registros
        $this->by_page = "asc";    // Variable para el paginador y las flechas de orden
        $this->sort = 'CODIGO_SGWS';      // Nombre del campo que por defecto se ordenara
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      $propostas = PropostaPeer::getPropostasEnNegociacao($ano, $this->sort, $this->by);
      $this->result =  $propostas;
  }
  
  public function executeHot(sfWebRequest $request)
  {
      
      $r = array();
      $data = array();
      $this->anos = array(2013 => 2013, 2014 => 2014);
      if (!$request->isMethod('post'))
      {
        $this->anoSelected = 2014; 
        $ano = 2014;
      }else{
        $this->anoSelected = $request->getParameter('ano');
        $ano = $request->getParameter('ano');
      }
      if(!$this->getRequestParameter('by'))
      {
        $this->by = 'desc';        // Variable para el orden de los registros
        $this->by_page = "asc";    // Variable para el paginador y las flechas de orden
        $this->sort = 'CODIGO_SGWS';      // Nombre del campo que por defecto se ordenara
      }
      if($this->getRequestParameter('sort'))
      {
            $this->sort = $this->getRequestParameter('sort');
            switch ($this->getRequestParameter('by')) {
                case 'desc':
                    $this->by = "asc";
                    $this->by_page = "desc";
                    break;
                default:
                    $this->by = "desc";
                    $this->by_page = "asc";
                    break;
            }
      }
      $this->result = PropostaPeer::getPropostasHot($this->sort, $this->by);
      
  }
  
  
  
  
  
  
  
}
