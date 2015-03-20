<?php $tarefa = TarefaPeer::retrieveByPK($sf_request->getParameter('cod_tarefa')); ?>    
<script type="text/javascript">  
	$(document).ready(function() {    
		$("#h-0<?php echo $fila ?>").val(<?php echo $primerdia['horas'] ? $primerdia['horas'] : '' ?>);       
		$("#descricao-0<?php echo $fila ?>").val("");     
		<?php if($primerdia['autorizado'] || $tarefa->getStatus() >= 6): ?>        
			$("#h-0<?php echo $fila ?>").attr('disabled','disabled');    
		<?php endif; ?>            
	});
</script>
<?php for($i = 1; $i <=6 ; $i++): ?>    
	<?php $start = date("Y-m-d", strtotime("$start + 1 day")); ?>   
	<?php $calculaTiempo = TempotarefaPeer::getHorasTrabajadasDia($sf_request->getParameter('cod_tarefa'), $start); ?>    
	<script type="text/javascript"> $(document).ready(function() {    
		console.log("#h-<?php echo $i ?><?php echo $fila ?> - "+<?php echo $tarefa->getStatus() ?>);    
		$("#h-<?php echo $i ?><?php echo $fila ?>").val(<?php echo $calculaTiempo['horas'] ? $calculaTiempo['horas'] : '' ?>);            
		$("#descricao-<?php echo $i ?><?php echo $fila ?>").val("<?php echo $calculaTiempo['info'] ? $calculaTiempo['info'] : '' ?>");            
		<?php if($calculaTiempo['autorizado'] || $tarefa->getStatus() >= 6): ?>            
			$("#h-<?php echo $i.$fila ?>").attr('disabled','disabled');        
		<?php endif; ?>});    
	</script>
<?php endfor; ?>