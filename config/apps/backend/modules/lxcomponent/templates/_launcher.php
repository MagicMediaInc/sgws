<div class="frameForm" style="margin-bottom: 0px; min-height: 142px" >
    <br />
    <table cellpadding="0" cellspacing="5" border="0" width="100%">
        <tr align="center">
            <td><?php echo link_to(image_tag('icon_user_addnew.png',"alt='".__('Adicionar novo Usuário')."' title='".__('Adicionar novo Usuário')."'"),'@default?module=lxuser&action=new')?></td>
            <td><?php echo link_to(image_tag('icon_user_permisions.png',"alt='".__('Perfil')."' title='".__('Perfil')."'"),'@default_index?module=lxprofile')?></td>
            <td><?php echo link_to(image_tag('icon_user_password.png',"alt='".__('Trocar senha')."' title='".__('Trocar a senha')."'"),'@default_index?module=lxchangePassword')?></td>
            <td><?php echo link_to(image_tag('icon_user_info.png',"alt='".__('Informação da conta')."' title='".__('Informação da conta')."'"),'@default_index?module=lxaccount')?></td>
        </tr>
        <tr align="center">
            <td>
                <?php echo link_to(__('Adicionar novo Usuário'),'@default?module=lxuser&action=new')?>
            </td>
            <td>
                <?php echo link_to(__('Perfil'),'@default_index?module=lxprofile')?>
            </td>
            <td>
                <?php echo link_to(__('Trocar senha'),'@default_index?module=lxchangePassword')?>
            </td>
            <td>
                <?php echo link_to(__('Informação da conta'),'@default_index?module=lxaccount')?>
            </td>
        </tr>
    </table>    
</div>