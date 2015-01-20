<?php if($statusProfile):?>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th height="35">
            &nbsp;
        </th>
        <th>
            <?php echo  $nameProfile?> - <?php echo __('Benefícios')?>
        </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($LxModules): ?>
    <?php echo html_entity_decode($LxModules);?>
  <?php endif; ?>
  </tbody>
</table>
<?php else:?>
<div class="ppalText"><?php echo __('Sorry!') ?><br /><?php echo __('Activate module')?> <a href="<?php echo url_for('lxprofile/edit?id_profile='.$idProfile) ?>" class="titulo"><?php echo $nameProfile?></a> <?php echo __('to update permissions')?></div>
<?php endif;?>
