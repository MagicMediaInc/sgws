<?php echo jq_link_to_remote(image_tag($Formulario->getStatus().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$Formulario->getIdFormulario(),
    'url'     =>  'formulario/changeStatus?id_formulario='.$Formulario->getIdFormulario().'&status='.$Formulario->getStatus(),
    'script'  => true,
    'before'  => "$('#status_".$Formulario->getIdFormulario()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
