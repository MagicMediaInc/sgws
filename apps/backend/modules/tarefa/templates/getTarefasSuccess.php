<option value="">Selecione tarefa</option>
<?php if($items): ?>
  <?php foreach ($items as $item): ?>
    <?php if(aplication_system::accessTaskHidratec($item, $gerente)): ?>
    <option value="<?php echo $item['id'] ?>" data-status="<?php echo $item['status'] ?>"><?php echo $item['tarefa'] ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>

