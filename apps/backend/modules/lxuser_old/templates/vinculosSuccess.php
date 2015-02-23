<?php use_helper('Date') ?>
<h1 class="icono_user"><?php echo __('Pessoas') ?></h1>
<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div id="renglon">
        <?php include_partial('menu') ?>
    </div>
    <div id="vinculos">
        <h1 class="titulo"><?php echo __('Vínculo') ?></h1>
        <form action="<?php echo url_for('lxuser/vinculos') ?>" method="post">
        <?php if($tiposCadastro): ?>
            <div class="button-holder" style="width: 250px;">
                <?php foreach ($tiposCadastro as $type): ?>
                    <?php //echo $type->getTipoCadastro(); ?>
                <input type="radio" id="radio-<?php echo $type->getIdTipoCadastro() ?>" name="radio-cad" class="regular-radio" value="<?php echo $type->getIdTipoCadastro() ?>" /><label for="radio-<?php echo $type->getIdTipoCadastro() ?>"></label>
                    <span class="title-radio" ><?php echo $type->getTipoCadastro(); ?></span>
                    <br />
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
            <input type="text" style="width: 290px;" name="buscador" id="funkystyling" />
            <input type="submit" name="search" id="busca" value="Buscar" /><br />
            <a href="<?php echo url_for('lxuser/vinculos') ?>"><?php echo __('Veja todos') ?></a>
        </form>
    </div>
</div>
    
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
        &nbsp;&nbsp;
    </th>
  
  <th>
    <?php echo link_to(__('Nome'),'@default?module=lxuser&action=index&sort=name&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "name"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Nucleo'),'@default?module=lxuser&action=index&sort=lx_profile.name_profile&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "lx_profile.name_profile"){ echo image_tag($by_page,'align="top"'); }?>
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
    <?php echo link_to(__('Vínculo'),'@default?module=lxuser&action=index&sort=lx_user.status&by='.$by.'&page='.$LxUsers->getPage().'&buscador='.$buscador) ?>
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
                          &nbsp;&nbsp;
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
                                <div class="row-actions">
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
                    <td class="borderBottomDarkGray"><?php echo $LxUser->getLogin() ?></td>
                    <td class="borderBottomDarkGray"><?php echo format_datetime($LxUser->getLastAccess(),'f',$sf_user->getCulture()); ?></td>

                    <?php 
                        //Valida que el usuario este vinculado con el usuario actual                    
                        $existVinculo = VinculoUserPeer::getExistVinculo($sf_user->getAttribute('new_user'), $LxUser->getIdUser());
                        $vinc = $existVinculo ? '1' : '0';
                        
                    ?>
                    <td class="borderBottomDarkGray" id="vinculo_<?php echo $LxUser->getIdUser()?>">
                    <?php echo jq_link_to_remote(image_tag($vinc.'.png','alt="" title="" border=0'), array(
                                'update'  =>  'vinculo_'.$LxUser->getIdUser(),
                                'url'     =>  'lxuser/changeVinculo?id_user='.$LxUser->getIdUser(),
                                'script'  => true,
                                'before'  => "$('#vinculo_".$LxUser->getIdUser()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                            ));
                            ?>
                    </td>                    
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
