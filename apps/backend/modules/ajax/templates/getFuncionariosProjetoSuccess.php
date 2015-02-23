<option value="">Selecione</option> 
<?php if($items): ?>
    <?php foreach ($items as $key => $val): ?>
        <option value="<?php echo $key ?>"><?php echo $val ?></option> 
    <?php endforeach; ?>
<?php endif; ?>
