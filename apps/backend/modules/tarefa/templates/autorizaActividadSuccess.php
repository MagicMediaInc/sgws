<?php echo jq_link_to_remote(image_tag($Reg->getAutorizado().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$Reg->getCodigoregistro(),
    'url'     =>  'tarefa/autorizaActividad?id_actividad='.$Reg->getCodigoregistro().'&status='.$Reg->getAutorizado(),
    'script'  => true,
    'before'  => "$('#status_".$Reg->getCodigoregistro()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
