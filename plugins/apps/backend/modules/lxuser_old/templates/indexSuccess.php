<?php use_helper('Date') ?>
<?php  $appYml = sfConfig::get('app_upload_images_lxaccount'); ?>
<h1 class="icono_user"><?php echo __('Usuários') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Adicionar novo usuário')?></a>

<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    
<div id="renglon" style="height: 140px;">
    <?php echo form_tag('lxuser/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <div class="propiedades">
        <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
        Listagem de<br />
        Pessoas
    </div>
    <div class="propiedades propiedades-extend" style="width: 210px; border-left: 1px #ccc dotted; height: 80px;">
        <h1 class="titulo"><?php echo __('Consulta de Pessoas') ?></h1>
        <?php if($tiposCadastro): ?>
            <div class="button-holder">
                <?php foreach ($tiposCadastro as $type): ?>
                    <?php //echo $type->getTipoCadastro(); ?>
                    <input type="radio" id="radio-<?php echo $type->getIdTipoCadastro() ?>" name="radio-cad" class="regular-radio"  /><label for="radio-<?php echo $type->getIdTipoCadastro() ?>"></label>
                    <span class="title-radio" ><?php echo $type->getTipoCadastro(); ?></span>
                    <br />
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="propiedades propiedades-extend" style="width: 450px; border-left: 1px #ccc dotted; height: 80px;">
        <br />
        <br />
        <input type="text" style="width: 290px;" name="buscador" id="funkystyling" />
        <input type="submit" name="search" id="busca" value="Buscar" />
    </div>
</div>
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
        </tr>
    </table>
    
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
            &nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
    </th>
  
  <th>
    <?php echo link_to(__('Imagem'),'@default?module=lxuser&action=index&sort=name&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
    <?php if($sort == "name"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  <th>
    <?php echo link_to(__('Nome'),'@default?module=lxuser&action=index&sort=name&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "name"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Perfil'),'@default?module=lxuser&action=index&sort=lx_profile.name_profile&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "lx_profile.name_profile"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
 
  <th>
    <?php echo link_to(__('Tipo'),'@default?module=lxuser&action=index&sort=id_tipo_usuario&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "id_tipo_usuario"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  <th>
    <?php echo link_to(__('Login'),'@default?module=lxuser&action=index&sort=login&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "login"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Último acesso'),'@default?module=lxuser&action=index&sort=last_access&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "last_access"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  <th>
      <a href="javascript:void();">Vínculos</a>
  </th>
  <th>
    <?php echo link_to(__('Status'),'@default?module=lxuser&action=index&sort=lx_user.status&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "lx_user.status"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($LxUsers->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($LxUsers as $LxUser): ?>
      
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>"  valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">        
        <td class="borderBottomDarkGray" width="28" align="center">
          <?php
          //Valida que no se pueda modificar ni borrar el propio usuario ni el root ni administrador
          if($sf_user->getAttribute('idUserPanel')!=$LxUser->getIdUser() and $LxUser->getIdUser() > 2):
          ?>
            &nbsp;<input type="checkbox" id="chk_<?php echo $LxUser->getIdUser() ?>" name="chk[<?php echo $LxUser->getIdUser() ?>]" value="<?php echo $LxUser->getIdUser() ?>">&nbsp;
          <?php else:?>
                &nbsp;
           <?php endif;?>
        </td>
        <td class="borderBottomDarkGray">
            <?php if($LxUser->getPhoto()):  ?>
                <?php echo image_tag('/uploads/users/'.$appYml['size_2']['pref_2'].'_'.$LxUser->getPhoto(), 'class=""')?>
            <?php else:?>
                <?php echo image_tag('icons/icon_user', 'border=0  class=""');?>
            <?php endif;?>
        </td>
        <?php //Valida que no se pueda modificar el propio usuario ni el root ni administrador
         if($sf_user->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1):
         ?>
         
         <td class="borderBottomDarkGray"><?php echo $LxUser->getName(); ?></td>
         <?php else: ?>
         <td class="borderBottomDarkGray">

            <div class="displayTitle">
               <div id="title">
                    <a href="<?php echo url_for('lxuser/edit?id_user='.$LxUser->getIdUser()) ?>" class="titulo"><?php echo $LxUser->getName() ?></a>
               </div>
                <div class="row-actions" style="width: 140px; margin-left: 3px;">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('lxuser/edit?id_user='.$LxUser->getIdUser(), $LxUser) ?>" class="edit"><?php echo __('Edit') ?></a>
                        <?php
                        if($LxUser->getIdUser() != 2): ?>
                        &nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'lxuser/delete?id_user='.$LxUser->getIdUser(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </td>
       <?php endif; ?>                        
        <td class="borderBottomDarkGray">
            <?php $nucleo = LxProfilePeer::getNameProfile($LxUser->getIdProfile())  ?>
            <?php if($nucleo): ?>
                <?php echo $nucleo->getNameProfile() ?>
            <?php endif; ?>                        
        </td>
        <td class="borderBottomDarkGray">
            <?php $tipoUsuario = TipoUsuarioPeer::getTypeUser($LxUser->getIdTipoUsuario()) ?>
            <?php echo $tipoUsuario->getTipoUsuario() ?>
        </td>
        <td class="borderBottomDarkGray"><?php echo $LxUser->getLogin() ?></td>
        <td class="borderBottomDarkGray"><?php echo format_datetime($LxUser->getLastAccess(),'f',$sf_user->getCulture()); ?></td>
        <td class="borderBottomDarkGray" >
            <?php $vinculos = VinculoUserPeer::getCountVinculoUser($LxUser->getIdUser())  ?>
            <?php echo $vinculos ?>
        </td>
        <?php //Valida que no se pueda modificar el propio usuario ni el root ni administrador
             if($sf_user->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1):
        ?>
        <td class="borderBottomDarkGray">
              <?php echo image_tag($LxUser->getStatus().'.png','alt="" title="" border=0') ?>
        </td>
        <?php else: ?>
            <td class="borderBottomDarkGray" id="status_<?php echo $LxUser->getIdUser()?>">
        <?php echo jq_link_to_remote(image_tag($LxUser->getStatus().'.png','alt="" title="" border=0'), array(
                    'update'  =>  'status_'.$LxUser->getIdUser(),
                    'url'     =>  'lxuser/changeStatus?id_user='.$LxUser->getIdUser().'&status='.$LxUser->getStatus(),
                    'script'  => true,
                    'before'  => "$('#status_".$LxUser->getIdUser()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                ));
                ?>
        </td>
        <?php endif; ?>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
 </tbody>

</table>
   <?php else: ?>
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong><?php echo __('Sua busca não gerou resultados') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
 
</form>
<?php if ($LxUsers->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $LxUsers->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$LxUsers->getPage().' '.__('for').' ' ?> <?php echo $LxUsers->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($LxUsers->getFirstPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $LxUsers->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $LxUsers->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $LxUsers->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($LxUsers->getLastPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=lxuser&action=index&page='.$LxUsers->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'lxuser/index?page='.$LxUsers->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
      <i><?php echo $LxUsers->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>
