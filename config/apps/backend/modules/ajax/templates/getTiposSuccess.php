<option value="">Selecione</option> 
<?php if($items): ?>
    <?php foreach ($items as $val): ?>
        <option value="<?php echo $val->getIdSubtipo() ?>"><?php echo $val->getSubtipo() ?></option> 
    <?php endforeach; ?>
<?php endif; ?>