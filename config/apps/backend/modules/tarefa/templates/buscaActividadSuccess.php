<script type="text/javascript"> 
    $("#h-0<?php echo $fila ?>").val('<?php echo $primerdia['horas'] ? $primerdia['horas'] : '' ?>');   
    $("#descricao-0<?php echo $fila ?>").val('<?php echo $primerdia['info'] ? $primerdia['info'] : '' ?>'); 
    <?php if($primerdia['autorizado']): ?>
        $("#h-0<?php echo $fila ?>").attr('disabled','disabled');
    <?php endif; ?>
</script>
<?php for($i = 1; $i <=6 ; $i++): ?>
    <?php $start = date("Y-m-d", strtotime("$start + 1 day")); ?>
    <?php $calculaTiempo = TempotarefaPeer::getHorasTrabajadasDia($sf_request->getParameter('cod_tarefa'), $start); ?>
    <script type="text/javascript"> 
        $("#h-<?php echo $i ?><?php echo $fila ?>").val('<?php echo $calculaTiempo['horas'] ? $calculaTiempo['horas'] : '' ?>');    
        $("#descricao-<?php echo $i ?><?php echo $fila ?>").val('<?php echo $calculaTiempo['info'] ? $calculaTiempo['info'] : '' ?>');    
        <?php if($calculaTiempo['autorizado']): ?>
            $("#h-<?php echo $i.$fila ?>").attr('disabled','disabled');
        <?php endif; ?>
    </script>
<?php endfor; ?>
