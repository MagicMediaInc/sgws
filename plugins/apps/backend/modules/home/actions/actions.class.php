<?php

/**
 * home actions.
 *
 * @package    sgws
 * @subpackage home
 * @author     Henry Vallenila <henryvallenilla@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    if(!$this->getUser()->hasCredential('backend_activo')){
      $this->redirect('@homepage');
    }
    
    
    
    $this->notis =  NotificacionesDestinatariosPeer::getNewsNotificacionUser($this->getUser()->getAttribute('idUserPanel'));
    $this->lastUpdateTimeSheet = TempotarefaPeer::getLastUpdateTimeSheet(aplication_system::getUser());
    
    $this->meusProjetos = PropostaPeer::getNumMeusProjetos(aplication_system::getUser()) + EquipeTarefaPeer::getTotalProjetosDeFuncionario(aplication_system::getUser());
    $tentradas = SaidasPeer::getTotalByOperacionUsuario(aplication_system::getUser(), 'e' , true);
    $tsalidas = SaidasPeer::getTotalByOperacionUsuario(aplication_system::getUser(), 's', false);
    //$this->minhasDespesas = SaidasPeer::getNumMeusProjetos(aplicauation_system::getUser());
    $this->minhasDespesas = $tentradas - $tsalidas;
    
    $this->alertaDespesa = SaidasPeer::getAlertaDespesasPorAprobar();
    $this->alertaFaturamentos = SaidasPeer::getAlertaFaturamentos();
    
    // Billability
    $horasBilability = HorasBillabilityPeer::getAnoHorasMes(date("Y"));
    $getMes = 'getMes'.date('n');
    // Horas bilability del mes
    $this->horasBilabilityMes = $horasBilability->$getMes();
    
    $this->meta = LxUserPeer::getMetaByBilability(aplication_system::getUser());
    
    // Recorro por meses y analizo de acuerdo al status
    $ano = date('Y');
    $mesActual =  date('n');
    
    $totalHorasBilability = 0;
    $HorasTrabajadasMedia = 0;
    $media = 0;
    for($i =  1; $i <= 12; $i++)
    {
        $nMes = globalFunctions::zerofill($i,2);
        $valor = TempotarefaPeer::getHorasTrabajadasFuncionario($ano,$nMes,  aplication_system::getUser(), 1); 
        $getMes = 'getMes'.$i;
        // Horas bilability del mes
        $horasBilabilityMes = $horasBilability->$getMes();
        // Total horas bilability
        if($i <= $mesActual)
        {
            $totalHorasBilability = $totalHorasBilability + $horasBilabilityMes;
            $HorasTrabajadasMedia = $HorasTrabajadasMedia + $valor;
        }
        
        if($i == 12)
        {
            $this->mediaAnual = $totalHorasBilability / $mesActual;
            $this->mediaHoras = $HorasTrabajadasMedia / $mesActual;

        }
        
    }
    
    
    
  }
}
