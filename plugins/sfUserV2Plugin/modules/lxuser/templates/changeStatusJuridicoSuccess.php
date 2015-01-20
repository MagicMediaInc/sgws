<?php echo jq_link_to_remote(image_tag($Empresa->getStatus().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$Empresa->getIdEmpresa(),
    'url'     =>  'lxuser/changeStatusJuridico?id='.$Empresa->getIdEmpresa().'&status='.$Empresa->getStatus(),
    'script'  => true,
    'before'  => "$('#status_".$Empresa->getIdEmpresa()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
