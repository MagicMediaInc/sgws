<?php use_helper('Date') ?>
<script type="text/javascript">
    $(document).ready(function() {
        <?php if(sfContext::getInstance()->getUser()->getAttribute('idProfile') > 2 && !sfContext::getInstance()->getUser()->hasCredential('permisos_insert_1')): ?>
                $('#title_module input[type=checkbox]').attr('disabled','true');
                $("#id_profile").attr('disabled', true);
                $("#atribui_perfil").attr('disabled', true);
                
        <?php endif; ?>
        <?php if(sfContext::getInstance()->getUser()->getAttribute('new_user') == sfContext::getInstance()->getUser()->getAttribute('idUserPanel')): ?>
            <?php if(!sfContext::getInstance()->getUser()->hasCredential('permisos_insert_2')): ?>
                $('#title_module input[type=checkbox]').attr('disabled','true');
                $("#id_profile").attr('disabled', true);
                $("#atribui_perfil").attr('disabled', true);                
            <?php endif; ?>
        <?php endif; ?>
        
    });
</script>
<h1 class="icono_user"><?php echo __('Pessoas') ?></h1>
<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div id="renglon">
        <?php include_partial('global/menu') ?>
    </div>
    <div id="vinculos">
        <h1 class="titulo"><?php echo __('Permissões') ?></h1>
        <form action="<?php echo url_for('permisos/index') ?>" method="post">
        <?php if($profiles): ?>
            <div class="button-holder" style="width: 540px; padding-top: 10px; text-align: left;">
                <?php echo __('Perfil') ?>
                <select name="id_profile" id="id_profile" style="width: 200px; margin-left: 20px;">
                    <option value=""><?php echo __('Selecione o Perfil') ?></option>
                    <?php foreach ($profiles as $profile): ?>
                        <?php if($perfilActual): ?>
                            <?php if($perfilActual['id_profile'] == $profile->getIdProfile()):?>
                                <?php $selected = 'selected="selected"' ?>
                            <?php else: ?>
                                <?php $selected = '' ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php $selected = '' ?>
                        <?php endif;?>
                    <option <?php echo $selected ?> value="<?php echo $profile->getIdProfile() ?>"><?php echo $profile->getNameProfile() ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" name="search" id="atribui_perfil" value="<?php echo __('Atribuir Perfil') ?>" /><br />
                <span class="msn_help"> Se você já tem um perfil atribuído a substituí-lo irá repor os privilégios do usuário pelo novo perfil</span>
            </div>
            <div class="button-holder" style="width: 400px; padding-top: 24px;">
                <?php echo image_tag('icons/perm_1','class="icon_leyenda"')?>&nbsp;<?php echo __('Visão Geral') ?>&nbsp;&nbsp;
                <?php echo image_tag('icons/perm_2','class="icon_leyenda"')?>&nbsp;<?php echo __('Informações própias') ?>&nbsp;&nbsp;
                <?php echo image_tag('icons/perm_3','class="icon_leyenda"')?>&nbsp;<?php echo __('Sem permissão') ?>
            </div>
        <?php endif; ?>                    
        </form>
    </div>
    
        <table width="100%" cellpadding="0" cellspacing="3" border="0" >
            <?php if ($modules): ?>
                <?php foreach ($modules as $module): ?>                
                    <tr>
                        <td>
                            <?php $children = LxModulePeer::getOnlyChildrenPermissions($module['module_id']); ?>
                            <?php if($children): ?>
                            
                                <div id="renglon-permiso">       
                                    <h2><?php echo $module['module_name'] ?></h2>
                                <?php foreach ($children as $subTmp): ?>
                                    <?php $typeSelected = LxUserModulePeer::getTypeByModuleUser($subTmp['module_id'],$sf_user->getAttribute('new_user')) ?>
                                    <?php $typeSelected = $typeSelected ? $typeSelected->getTypeVision() : ''; ?>
                                    <?php if($module['module_id'] == 1):?>
                                        <div id="space-module" class="propiedades">
                                            <div class="nome-module">
                                                <div class="img-module">
                                                    <?php echo image_tag('modules/'.$subTmp['module_sf'])?> <br />
                                                </div>
                                                <div class="text">
                                                    <?php echo $subTmp['module_name'] ?>
                                                </div>
                                            </div><br />
                                            <div class="vistas-module">
                                                <div class="space-opcoe">
                                                    <div class="opcoe">                                                        
                                                        <?php echo image_tag('icons/perm_1')?> 
                                                    </div>
                                                    <div class="opcoe">
                                                        <?php echo image_tag('icons/perm_2')?> 
                                                    </div>                                                    
                                                    <input type="hidden" name="val-perm-<?php echo $subTmp['module_id'] ?>" id="val-perm-<?php echo $subTmp['module_id'] ?>" value="" />
                                                    <?php for($i=1; $i<3; $i++):?>
                                                    <div class="opcoe<?php echo $i == 1 ? ' opcoe-left' : ' opcoe-right' ?>" >
                                                        <?php foreach ($privileges as $privilege): ?>
                                                            <?php if(LxUserModulePeer::valPrivilegeUser($privilege['id_privilege'], $sf_user->getAttribute('new_user'), $subTmp['module_id'],$i)):?>
                                                                <?php $checked = " checked"; ?>
                                                            <?php else: ?>
                                                                <?php $checked = " "; ?>
                                                            <?php endif; ?>
                                                            <div style="margin-top: 5px; text-align: left; font-weight: normal">      
                                                                <input <?php echo $checked ?> type="checkbox" id="chk_<?php echo $subTmp['module_id'] ?>_<?php echo $privilege['id_privilege'] ?>_<?php echo $i ?>" name="chk_<?php echo $subTmp['module_id']?>_[<?php echo $privilege['id_privilege']?>]" value="<?php echo $privilege['id_privilege']?>" onclick="submitPermissionsPessoa(<?php echo $subTmp['module_id']?>,<?php echo $privilege['id_privilege']?>, <?php echo $i ?>);" >
                                                                <?php echo $privilege['name_privilege'] ?> <br />
                                                            </div>                                                
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <?php endfor; ?>
                                                </div>                                                   
                                            </div>
                                            <div id="message_<?php echo $subTmp['module_id'] ?>" class="message" style="border: 1px solid; top: -31px; position: relative;">
                                                    
                                            </div>
                                        </div>
                                        
                                    <?php else: ?>
                                    
                                    
                                    <div id="space-module" class="propiedades" style="width: 150px;  height: 65px; margin-right: 7px;">
                                        <div style="width: 115px; height: 10px; text-align: left; padding-left: 3px;" class="nome-module">
                                            <div class="text">
                                                <?php echo $subTmp['module_name']  ?> 
                                            </div>
                                        </div><br />
                                        <div  class="vistas-module" style="border: 1px solid #ccc;padding: 6px 2px 3px 4px; margin-top: 0px; height: 95px;">
                                            <!--<div style="border-bottom: 1px dotted #ccc; padding-bottom: 5px; margin-bottom: 10px; display: none;">
                                                <?php for($i=1; $i<=3; $i++):?>
                                                    <?php if($typeSelected == $i):?>
                                                        <?php $checked = 'checked="checked"' ?>
                                                    <?php else: ?>
                                                        <?php $checked = '' ?>
                                                    <?php endif; ?>
                                                    <?php echo image_tag('icons/perm_'.$i)?> 
                                                <input <?php echo $checked ?> onclick="setValPermissionModule(<?php echo $i ?>, <?php echo $subTmp['module_id'] ?>);" type="radio" id="radio-perm-<?php echo $i ?>-<?php echo $subTmp['module_id'] ?>" name="radio-perm-<?php echo $subTmp['module_id'] ?>" class="regular-radio" value="<?php echo $i ?>"  /><label for="radio-perm-<?php echo $i ?>-<?php echo $subTmp['module_id'] ?>"></label>
                                                    
                                                <?php endfor; ?>                                                
                                                <input type="hidden" name="val-perm-<?php echo $subTmp['module_id'] ?>" id="val-perm-<?php echo $subTmp['module_id'] ?>" value="" />
                                            </div>-->
                                            <?php foreach ($privileges as $privilege): ?>
                                                <?php if(LxUserModulePeer::valPrivilege($privilege['id_privilege'], $sf_user->getAttribute('new_user'), $subTmp['module_id'])):?>
                                                    <?php $checked = " checked"; ?>
                                                <?php else: ?>
                                                    <?php $checked = " "; ?>
                                                <?php endif; ?>
                                                <div style="margin-top: 5px; text-align: left; font-weight: normal; padding-left: 15px;">      
                                                    <input <?php echo $checked ?> type="checkbox" id="chk_<?php echo $subTmp['module_id'] ?>_<?php echo $privilege['id_privilege'] ?>" name="chk_<?php echo $subTmp['module_id']?>_[<?php echo $privilege['id_privilege']?>]" value="<?php echo $privilege['id_privilege']?>" onclick="submitPermissionsPessoaSimple(<?php echo $subTmp['module_id']?>,<?php echo $privilege['id_privilege']?>);" >
                                                    <?php echo $privilege['name_privilege'] ?> <br />
                                                </div>                                                
                                            <?php endforeach; ?>
                                            <div id="message_<?php echo $subTmp['module_id'] ?>" class="message">
                                                &nbsp;
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    
</div>
</div>
