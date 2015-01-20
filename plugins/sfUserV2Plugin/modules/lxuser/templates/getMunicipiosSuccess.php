<option value="">Selecione un Municipio... </option>
<?php if($items): ?>
  <?php foreach ($items as $item): ?>
    <option value="<?php echo $item->getIdMunicipio() ?>"> <?php echo $item->getNameMunicipio(); ?> </option>
  <?php endforeach; ?>
<?php endif; ?>
