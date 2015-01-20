<div style="width: 95%; margin: auto;">
    <table width="100%" border="0" cellspacing="1">
        <tr>
          <td width="51%">
              <div id="logo-cte">
                <?php echo link_to(image_tag('logo_cte'),'@homepage')  ?>
              </div>
          </td>
          <td width="49%" align="right" valign="bottom" style="padding-right: 30px;">
                 <?php if($sf_user->isAuthenticated()): ?>
                <div id="top_user_nav" style="margin-right: 5px;position: relative;top: 0px;">
                    <div style="display:inline-block">
                        <div class="name" style="font-weight: normal;">
                            <?php $datuser = lynxValida::datosTipoUsuario($sf_user->getAttribute('idUserPanel')) ?>
                            <a href="<?php echo url_for('@default_index?module=lxaccount') ?>">
                                <?php echo $sf_user->getAttribute('nameUser') ? $sf_user->getAttribute('nameUser') : $sf_user->getAttribute('loginUser') ?>
                                (<?php echo $sf_user->getAttribute('nomeProfile') ?>)
                            </a>
                        </div>
                        <div class="user_karmacash"><?php echo link_to(__('Fechar'),'@default?module=lxlogin&action=close');?></div>
                    </div>
                    <?php $foto = LxUserPeer::getCurrentPassword($sf_user->getAttribute('idUserPanel'))  ?>
                    <a href="<?php echo url_for('@default_index?module=lxaccount') ?>">
                    <?php if($foto->getPhoto()):  ?>
                        <?php echo image_tag('/uploads/users/med_'.$foto->getPhoto(), 'class="image" style="position: relative;top: 6px;"')?>
                    <?php else:?>
                        <?php echo image_tag('user.jpg', 'border=0  class="image" style="position: relative;top: 6px;"');?>
                    <?php endif;?>
                    </a>
                    <div class="arrow"></div>
                </div>
                <?php endif; ?>
          </td>
        </tr>
    </table>	
</div>
