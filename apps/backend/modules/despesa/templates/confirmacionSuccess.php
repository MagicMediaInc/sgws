<?php echo jq_link_to_remote(image_tag($Despesa->getConfirmacao().'.png','alt="" title="" border=0'), array(
    'update'  =>  'confirmado_'.$Despesa->getCodigoSaida(),
    'url'     =>  'despesa/confirmacion?id='.$Despesa->getCodigoSaida().'&confirmado='.$Despesa->getConfirmacao(),
    'script'  => true,
    'before'  => "$('#confirmado_".$Despesa->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
<?php $img = $Despesa->getConfirmacao().'.png'; ?>