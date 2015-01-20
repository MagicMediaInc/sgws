<option value="">Selecione</option> 
<?php if($items): ?>
    <?php foreach ($items as $val): ?>
        <option value="<?php echo $val['id'] ?>"><?php echo $val['nome'] ?></option> 
    <?php endforeach; ?>
<?php endif; ?>
