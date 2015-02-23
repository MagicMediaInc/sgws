<option value="">Selecione tarefa</option>
<?php if($items): ?>
  <?php foreach ($items as $item): ?>
    <?php if(aplication_system::accessTaskHidratec($item)): ?>
    <option value="<?php echo $item['id'] ?>"><?php echo $item['tarefa'] ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>

