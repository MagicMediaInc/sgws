<?php if($statusProfile):?>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th height="35">
            &nbsp;
        </th>
        <th colspan="2">
            <?php echo  $nameProfile?> - <?php echo __('Benefícios')?>
        </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($modulesNucleo): ?>
    <?php foreach ($modulesNucleo as $module) : ?>
      <tr>
          <td align="left" style="margin-left: 15px;" width="8%">
              &nbsp;&nbsp;&nbsp;
              <?php $check = LxUserModulePeer::valPermissionUser($module['id_module'], $idUser); ?>
              <?php if($check):?>
                <?php $checked = 'checked' ?>
              <?php else: ?>
                <?php $checked = '' ?>
              <?php endif ;?>
              <input <?php echo $checked ?>  type="checkbox" id="chk_<?php echo $module['id_module']?>  " name="chk_<?php echo $module['id_module']?>" value="<?php echo $module['id_module']?>" onclick="submitPermissionsUser(<?php echo $module['id_module']?>,<?php echo $idUser ?>);">
          </td>
          <td>
              <?php echo $module['name_module'] ?>
          </td>
          <td><div id="message_<?php echo $module['id_module'] ?>" class="msjPermissions"  ></div></td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
  </tbody>
</table>
<?php else:?>
<div class="ppalText"><?php echo __('Sorry!') ?><br /><?php echo __('Activate module')?> <a href="<?php echo url_for('lxprofile/edit?id_profile='.$idProfile) ?>" class="titulo"><?php echo $nameProfile?></a> <?php echo __('to update permissions')?></div>
<?php endif;?>
