<?php echo jq_link_to_remote(image_tag($Despesa->getBaixa().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$Despesa->getCodigoSaida(),
    'url'     =>  'despesa/darBaixa?id='.$Despesa->getCodigoSaida().'&baixa='.$Despesa->getBaixa(),
    'script'  => true,
    'before'  => "$('#status_".$Despesa->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
