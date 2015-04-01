<?php

class homeComponents extends sfComponents {
    
    public function executeMenuTop(sfWebRequest $request) {
        // carrito de compras
        $this->shopping_cart = $this->getUser()->getShoppingCart(); //Session
        $this->notis =  NotificacionesDestinatariosPeer::getNewsNotificacionUser($this->getUser()->getAttribute('idUserPanel'));
        //$modulesParents = LxProfileModulePeer::getParentsMenu($this->getUser()->getAttribute('idProfile'));
        $modulesParents = LxModulePeer::getParents($this->getUser()->getAttribute('idProfile'));
        $this->html="<ul>";
        foreach ($modulesParents as $modulesParent):
                
                if($modulesParent['module_sf']){
                    // Menu Relatorio
                    // 03 Abril 2014 - El link relatorios solo puede ser visto por los ADM y por los Socios
                    if($modulesParent['module_sf'] == 'relatorio' && (aplication_system::esUsuarioRoot() || aplication_system::esSocio()))
                    {
                         $this->html.="<li><a href=\"#\" style=\"padding-right: 30px !important;\">".$modulesParent['module_name']."</a>";
                         $this->html.="
                                <ul>
                                    <li>".link_to('Propostas Consolidadas','@default?module=relatorio&action=index','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('WIP','@default?module=relatorio&action=wip','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('Consolidado Projetos','@default?module=relatorio&action=consolidadoProjeto','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('Vendas','@default?module=relatorio&action=consolidadoVendas','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('Financeiro','@default?module=relatorio&action=faturamentos','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('Bilability','@default?module=relatorio&action=bilability','style="padding-right: 30px !important;"')."</li>
                                    <li>".link_to('Não Bilability','@default?module=relatorio&action=nbilability','style="padding-right: 30px !important;"')."</li>
                                                                    </ul>
                             ";
                    }else{
                      if($modulesParent['module_sf']== "lxuser") {
                         $modulesParent['module_name']='Usuários'; 
                      }
                        if($modulesParent['module_sf'] == "projeto"){
                           $moduloParent = $modulesParent['module_name'].'/Propostas';
                        }else{
                           $moduloParent = $modulesParent['module_name']; 
                        }
                        $this->html.="<li>".link_to($moduloParent,'@default_index?module='.$modulesParent['module_sf'],'style="padding-right: 30px !important;"');
                        
                    }
                    
                }else{
                    //echo $modulesParent['module_name'];
                        if($modulesParent['module_name'] == "Projetos"){
                           $moduloParent = $modulesParent['module_name'].'/Propostas';
                        }else{
                           $moduloParent = $modulesParent['module_name']; 
                        }
                    $this->html.="<li><a href=\"#\" style=\"padding-right: 30px !important;\">".$moduloParent."</a>";			
                }			
                $this->html.= $this->ArmarArbolHijo($modulesParent['module_id'],$this->getUser()->getAttribute('idProfile'), $this->getUser()->getAttribute('idUserPanel'));
                $this->html.="</li>";
        endforeach;
        if(aplication_system::esContable() || aplication_system::esUsuarioRoot() || aplication_system::esSocio())
        {
            $this->html.="<li><a href=\"#\" style=\"padding-right: 30px !important;\">Contabilidade</a>";
            $this->html.="
                   <ul>
                       <li>".link_to('Fluxo de Caixa','@default?module=despesa&action=index','style="padding-right: 30px !important;"')."</li>
                       <li>".link_to('Faturamentos','@default?module=despesa&action=faturamento','style="padding-right: 30px !important;"')."</li>
                       <li>".link_to('Pagamentos','@default?module=despesa&action=pagamentos','style="padding-right: 30px !important;"')."</li>
                       <li>".link_to('Saidas','@default?module=despesa&action=saidas','style="padding-right: 30px !important;"')."</li>
                       <li>".link_to('Prestações de Contas','@default?module=despesa&action=contas','style="padding-right: 30px !important;"')."</li>
                    </ul>
                ";
            
        }
        $this->html.="</ul><br style='clear: left' />";
    }
    
    public function ArmarArbolHijo($id_padre="", $idProfile)
    {
	$htm_axu="";	
	$children = LxModulePeer::getModulesChildren($id_padre,$idProfile, $idUser);					
	if($children)
	{
		$htm_axu.="<ul>";
		foreach ($children as $subTmp)
		{
                    if($subTmp['module_id'] <> '30')
                    {
                        if($subTmp['module_sf']){
                            $htm_axu.="<li>".link_to($subTmp['module_name'],'@default_index?module='.$subTmp['module_sf']);
                        }else{
                            $htm_axu.="<li><a href=\"#\">".$subTmp['module_name']."</a>";
                        }
                    }
                    
                    $htm_axu.= $this->ArmarArbolHijo($subTmp['module_id'],$idProfile, $idUser);
                    $htm_axu.="</li>";
		}
		$htm_axu.="</ul>";
	}
	return $htm_axu;
    }
}
?>