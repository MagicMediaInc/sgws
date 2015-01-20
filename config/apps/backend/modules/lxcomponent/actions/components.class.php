<?php

class lxComponentComponents extends sfComponents
{
  
  public function executeLauncher(){}

  public function executeStadistic(sfWebRequest $request){
     
     if($this->getUser()->getAttribute('analyticsLogin') and $this->getUser()->getAttribute('analyticsPassword')){
        $this->loginAnalytics = $this->getUser()->getAttribute('analyticsLogin');
        $this->passwordAnalytics = $this->getUser()->getAttribute('analyticsPassword');
        $this->getResponse()->addJavascript('/js/extjs/component/googleAnalyticsLogin');
     }else{
        $this->loginAnalytics = "";
        $this->passwordAnalytics = "";
        $this->getResponse()->addJavascript('/js/extjs/component/googleAnalyticsLogin');
     }
  }

  public function executeLastContent(){
      
  }

}
?>