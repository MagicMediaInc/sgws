<?php echo jq_link_to_remote(image_tag($Despesa->getConfirmacao().'.png','alt="" title="" border=0'), array(
    'update'  =>  'confirma_'.$Despesa->getCodigoSaida(),
    'url'     =>  'despesa/confirmacion?id='.$Despesa->getCodigoSaida().'&confirma='.$Despesa->getConfirmacao(),
    'script'  => true,
    'before'  => "$('#confirma_".$Despesa->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
        $('#status_".$Despesa->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
<?php $img = $Despesa->getConfirmacao().'.png'; ?>
<script type="text/javascript"> 
    $(document).ready(function() {
        $('#status_<?php echo $Despesa->getCodigoSaida() ?>').html('<?php echo image_tag($img,'title="" alt=""') ?>');
    });    
</script>