<?php
/**
 * Log of Activities
 * 
 * Permite saber que actividad esta realizando el usuario
 *
 * @link http://www.henryvallenilla.com
 * @author Henry Vallenilla <henryvallenilla@gmail.com>
 * 
 * @version 0.1
 */
class sfLogActivities {
  var $_sUser;
  var $_sfModule;
  var $_sfAction;
  
  /**
    * Public constructor
    * 
    * @param string $sUser
    * @param string $sPass
    * @return analytics
    */
  public function __construct(){
    $this->_sUser = sfContext::getInstance()->getUser()->getAttribute('idUserPanel');
    $this->_sfModule = sfContext::getInstance()->getModuleName();
    $this->_sfAction = sfContext::getInstance()->getActionName();
  }
  /**
   * Register Activity
   * 
   * @param string $logMessage 
   */
  public function registerLog()
  {
    $valida = new lynxValida();  
    $newLog = new LogActividades();
    $newLog->setIdUser($this->_sUser);
    $newLog->setIp($valida->getRealIP());
    $newLog->setModulo($this->_sfModule.'/'.$this->_sfAction);
    $newLog->setFecha(date("Y-m-d"));
    $newLog->setHora($valida->getHoraActual());
    $newLog->save();
  }

}

?>
