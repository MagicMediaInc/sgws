<h1 class="icono_user"><?php echo __('Perfil de Pessoas') ?></h1>
<a class="btn-adicionar"  href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Agregar novo núcleo')?></a>
<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <?php echo form_tag('lxprofile/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>    

    <table width="100%" border="0">
        <tr valign="top">
            <td width="40%">
              
                <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
                    <thead>
                        <tr>
                            <th>
                                &nbsp;
                            </th>
                            <th>
                                <?php echo __('Nome Perfil') ?>
                            </th>
                            <th>
                                <?php echo __('Status') ?>&nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($LxProfiles): ?>
                        <?php $i=0; ?>
                        <?php foreach ($LxProfiles as $LxProfile): ?>
                        <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
                        <tr class="<?php echo $class;?>"  valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
                            <td class="borderBottomDarkGray" width="28" align="center">
                            &nbsp;
                            </td>
                            <td class="borderBottomDarkGray">
                                <div class="displayTitle">
                                    <div id="title">
                                        <?php if($sf_user->getAttribute('idProfile')!=$LxProfile->getIdProfile() and $LxProfile->getIdProfile()!=1 ): ?>
                                        <a href="<?php echo url_for('lxprofile/edit?id_profile='.$LxProfile->getIdProfile()) ?>" class="titulo"><?php echo $LxProfile->getNameProfile() ?></a>
                                        <?php else:?>
                                        <?php echo $LxProfile->getNameProfile() ?>
                                        <?php endif;?>
                                    </div>
                                    <div class="row-actions">
                                        <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                            <?php if($sf_user->getAttribute('idProfile')!=$LxProfile->getIdProfile() and $LxProfile->getIdProfile()!=1 ): ?>
                                                <a href="<?php echo url_for('lxprofile/edit?id_profile='.$LxProfile->getIdProfile(), $LxProfile) ?>" class="edit"><?php echo __('Editar') ?></a>&nbsp;|&nbsp;
                                                <?php if($sf_user->getAttribute('idProfile')!=$LxProfile->getIdProfile() and $LxProfile->getIdProfile()!=2 ): ?>
                                                    <?php echo link_to(__('Eliminar'),'lxprofile/delete?id_profile='.$LxProfile->getIdProfile(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que deseja excluir os dados selecionados?'))) ?>&nbsp;|&nbsp;
                                                <?php endif;?>
                                                <?php echo jq_link_to_remote(__('Permissões'), array(
                                                    'update'  =>  'list_permissions',
                                                    'url'     =>  'lxprofile/permission?id_profile='.$LxProfile->getIdProfile(),
                                                    'script'  => true,
                                                    'before' => "$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
                                                ));
                                                ?>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="borderBottomDarkGray" id="status_<?php echo $LxProfile->getIdProfile()?>">
                                <?php if($sf_user->getAttribute('idProfile')!=$LxProfile->getIdProfile() and $LxProfile->getIdProfile()!=1): ?>
                                    <?php echo jq_link_to_remote(image_tag($LxProfile->getStatus().'.png','alt="" title="" border=0'), array(
                                        'update'  =>  'status_'.$LxProfile->getIdProfile(),
                                        'url'     =>  'lxprofile/changeStatus?id_profile='.$LxProfile->getIdProfile().'&status='.$LxProfile->getStatus(),
                                        'script'  => true,
                                        'before'  => "$('#status_".$LxProfile->getIdProfile()."').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
                                        'complete'=> "$('#list_permissions').html('<div class=ppalText>".__(sfConfig::get('mod_lxprofile_msn_ppal_permissions'))."</div>');"
                                    ));
                                    ?>
                                <?php else:?>
                                &nbsp;
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if ($LxProfiles->haveToPaginate()): ?>
                <table width="100%" align="center" id="paginationTop" border="0">
                    <tr>
                        <td align="left" ><i><?php echo $LxProfiles->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$LxProfiles->getPage().' '.__('for').' ' ?> <?php echo $LxProfiles->getLastPage() ?></i> </td>
                        <td align="right">
                            <table>
                                <tr>
                                    <?php if ($LxProfiles->getFirstPage()!=$LxProfiles->getPage()) :?>
                                    <td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=lxprofile&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxProfiles->getFirstPage().$bus_pagi) ?></td>
                                    <td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=lxprofile&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxProfiles->getPreviousPage().$bus_pagi) ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php $links = $LxProfiles->getLinks();
                                        foreach ($links as $page): ?>
                                        <?php echo ($page == $LxProfiles->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=lxprofile&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
                                            <?php if ($page != $LxProfiles->getCurrentMaxLink()): ?>
                                            -
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                    <?php if ($LxProfiles->getLastPage()!=$LxProfiles->getPage()) :?>
                                    <td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=lxprofile&action=index&page='.$LxProfiles->getNextPage().$bus_pagi) ?></td>
                                    <td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'lxprofile/index?page='.$LxProfiles->getLastPage().$bus_pagi) ?></td>
                                    <?php endif; ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php endif; ?>
            </td>
            <td width="10">&nbsp;</td>
            <td align="center" >
                <div id="list_permissions">
                    <div class="ppalText"><?php echo __(sfConfig::get('mod_lxprofile_msn_ppal_permissions')) ?></div>
                </div>
            </td>
        </tr>
        
    </table>
    
    
    

</div>


