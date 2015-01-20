<?php if($items): ?>
    <?php foreach ($items as $it => $val): ?>
<option value="<?php echo $it ?>"><?php echo html_entity_decode($val) ?></option> 
    <?php endforeach; ?>
<?php endif; ?>
