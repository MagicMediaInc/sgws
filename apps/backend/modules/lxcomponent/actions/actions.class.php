<?php

/**
 * lxComponent actions.
 *
 * @package    lynxcmsv4
 * @subpackage lxComponent
 * @author     David Quiñones - dquinones@aberic.com
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class lxcomponentActions extends sfActions {

    protected $url;
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeAnalyticsLogin(sfWebRequest $request) {

        $this->setLayout(false);
        try {
            if(!$request->getParameter('login') and !$request->getParameter('password')) {
                if($this->getUser()->getAttribute('analyticsLogin') and $this->getUser()->getAttribute('analyticsPassword')) {
                    $login = $this->getUser()->getAttribute('analyticsLogin');
                    $password = $this->getUser()->getAttribute('analyticsPassword');
                }
            }else {
                $login = $request->getParameter('login');
                $password = $request->getParameter('password');

            }

            // construct the class
            $oAnalytics = new analytics($login, $password);
            $this->getUser()->setAttribute('analyticsLogin', $request->getParameter('login'));
            $this->getUser()->setAttribute('analyticsPassword', $request->getParameter('password'));
            // set it up to use caching
            $oAnalytics->useCache();

            // get an array with profiles (profileId => profileName)
            $aProfiles = $oAnalytics->getProfileList();

            $aProfileKeys = array_keys($aProfiles);

            // set the profile tot the first account
            $oAnalytics->setProfileById($aProfileKeys[0]);

            //$oAnalytics->setProfileByName('[Google analytics accountname]');
            // or $oAnalytics->setProfileById('ga:123456');

            // set the date range
            $oAnalytics->setMonth(date('n'), date('Y'));
            // or $oAnalytics->setDateRange('YYYY-MM-DD', 'YYYY-MM-DD');


            // print out visitors for given period
            // echo json_encode($oAnalytics->getVisitors());
            /*
            // print out pageviews for given period
            print_r($oAnalytics->getPageviews());

            // use dimensions and metrics for output
            // see: http://code.google.com/intl/nl/apis/analytics/docs/gdata/gdataReferenceDimensionsMetrics.html
            print_r($oAnalytics->getData(array(   'dimensions' => 'ga:keyword',
                    'metrics'    => 'ga:visits',
                    'sort'       => 'ga:keyword')));*/
            //{"01":"1487","02":"1798","03":"1802","04":"2164","05":"3372","06":"3198","07":"2947","08":"2830","09":"2549","10":"1799","11":"2008","12":"3120","13":"3006","14":"2815","15":"2602","16":"2340","17":"1811","18":"1990","19":"2491","20":"2924","21":"2980","22":"2713","23":"2533","24":"1948","25":"2020","26":"1668","27":"0","28":"0","29":"0","30":"0"}
            foreach ($oAnalytics->getVisitors() as $day => $value) {
                echo date(1);
                exit();
                $datas['name']= date($day);
                $datas['visits']= $value;
                $data[] = $datas;
            }

            //echo json_encode($data);
            $result = "{success: true,
                        data:".
                    json_encode($data)
                    ."
                       }";

        } catch (Exception $e) {
            $result = '{failure: true}';
        }
        echo $result;
    }

    public function executeMenuChildren(sfWebRequest $request) {
        $this->setLayout(false);
        $children = LxModulePeer::getModulesChildren($request->getParameter('parent'),$this->getUser()->getAttribute('idProfile'));
        //Construccion de SubMenu, solo soporta un nivel
        $this->modulesC = '[';
        foreach ($children as $key => $value) {
            $this->modulesC .= '
                     {
                        "text": "'.$value['module_name'].'",
                         "href": "'.$value['module_sf'].'",
                     },';
        }
         $this->modulesC .= ']';
    }
    public function executeMenuParent(sfWebRequest $request) {
        $this->setLayout(false);
        $datos = LxModulePeer::getModulesParentsForMenu($this->getUser()->getAttribute('idProfile'));
        //*****************************************************************************************
        //Se identifican solo los modulos padres
        foreach ($datos as $value) {
            if($value['id_parent'])continue;
            $onlyParent[] = $value;
        }
        if (empty($onlyParent))$this->modulesParent = '{failure: true}';
        $tmpModule = '';
        $modulesP = '[';
        foreach ($onlyParent as $valueNew) {
            //Por cada padre se recorre el agrego completo de modulos para encontrar los hijos
            foreach ($datos as $valueDato) {
                //Valida que tenga hijos
                if($valueNew['id_module']==$valueDato['id_parent']) {
                    //Si ya se agrego el padre al arreglo continua con el otro registro
                    if($tmpModule==$valueNew['name_module'])continue;
                    $tmpModule = $valueNew['name_module'];
                    //Construccion de Menu
                    $modulesP .= '
                     {
                        "text": "'.$valueNew['name_module'].'",
                        "menu": new Ext.ux.menu.StoreMenu({ url: "/'.$this->getUrlEnvironment().'/lxcomponent/menuChildren/parent/'.$valueNew['id_module'].'"})
                     },';
                }
            }
        }
        $modulesP = substr($modulesP, 0, -1);
        $modulesP .= ']';
        $this->modulesParent =  $modulesP;
        //*****************************************************************************************
        if (empty($this->modulesParent))$this->modulesParent = '{failure: true}';
    }

    private function getUrlEnvironment(){
        
        if(sfConfig::get('sf_environment')=='dev'){
           return sfConfig::get('sf_app').'_'.sfConfig::get('sf_environment').'.php';
        }else{
           return sfConfig::get('sf_app').'.php';
        }
        
    }
    
}
