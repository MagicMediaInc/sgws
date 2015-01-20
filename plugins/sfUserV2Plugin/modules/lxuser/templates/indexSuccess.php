<?php use_helper('Date') ?>
<?php  $appYml = sfConfig::get('app_upload_images_lxaccount'); ?>
<script type="text/javascript"> 
    $(document).ready(function() {
        <?php if($sf_request->getParameter('by_status')): ?>
                $("#by_status").val(<?php echo $sf_request->getParameter('by_status') ?>);
        <?php endif; ?>
    })
</script>
<h1 class="icono_user"><?php echo __('Usuários') ?></h1>
<!--<a class="btn-adicionar" href="<?php //echo url_for($this->getModuleName().'/new') ?>"><?php //echo __('Adicionar novo usuário')?></a>-->

<div id="title_module">
    
    <div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" class="white" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    
<div id="renglon-list" style="height: 117px;">
    <ul class="lang">
        <li>&nbsp;<a class="icon_plus_adicionar" href="javascript:void(0);">Novo Usuário</a><ul>
                <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() ): ?>
                <li>
                    <a href="<?php echo url_for('lxuser/new') ?>">
                        <?php echo image_tag('icons/user_min_fisica')?> &nbsp;&nbsp;Funcionario
                    </a>
                </li>
                <?php endif; ?>
                 <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() || aplication_system::isALLGerente() ): ?>
                <li>
                    <a href="<?php echo url_for('lxuser/newJuridico?tcad=2') ?>">
                        <?php echo image_tag('icons/user_min_juridica')?>&nbsp;&nbsp;Cliente
                    </a>
                </li>
                <li>
                    <a href="<?php echo url_for('lxuser/newJuridico?tcad=3') ?>">
                        <?php echo image_tag('icons/user_min_juridica')?>&nbsp;&nbsp;Fornecedor
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>
    <?php echo form_tag('lxuser/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <div class="propiedades">
        <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
        Listagem de<br />
        Pessoas
    </div>
    <div class="propiedades propiedades-extend" style="width: 210px; border-left: 1px #ccc dotted; height: auto;">
        <h1 class="titulo"><?php echo __('Consulta de Pessoas') ?></h1>
        <?php if($tiposCadastro): ?>
            <?php if($sf_request->getParameter('radio-cad')):?>
                
            <?php endif; ?>
            <div class="button-holder">                
                
                <?php foreach ($tiposCadastro as $type): ?>
                    <?php //echo $type->getTipoCadastro(); ?>
                    <input type="radio" id="radio-<?php echo $type->getIdTipoCadastro() ?>" name="radio-cad" class="regular-radio" value="<?php echo $type->getIdTipoCadastro() ?>" <?php echo $sf_request->getParameter('radio-cad') == $type->getIdTipoCadastro() ? 'checked="true"' : '' ?>  /><label for="radio-<?php echo $type->getIdTipoCadastro() ?>"></label>
                    <span class="title-radio" ><?php echo $type->getTipoCadastro(); ?></span>
                    <br />
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="propiedades propiedades-extend" style="width: 430px; border-left: 0px #ccc dotted; height: 95px; padding-top: 20px;">
        <br />
        <br />
        <input type="text" style="width: 290px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" />
        <input type="submit" name="search" id="busca" value="Buscar" />
        <div style="margin-top: 5px;">
            <a href="<?php echo url_for('lxuser/index') ?>"><?php echo utf8_encode('Veja todos os usuarios') ?></a>
        </div>
    </div>
    
</div>
    <table border="0" style="width: 100%;">
        <tr>
            <td>
<!--                <a name="commit" href="#" onclick="return existItems(this);"><?php // echo __('Remover todos os') ?></a>-->
                <span style="color: #3792C0;">Resultados de Busca: </span> <?php echo $LxUsers->getNbResults() ?> registros encontrados
            </td>
            <td style="float: right; padding-bottom: 7px;">
                Status: 
                <select id="by_status" name="by_status" onchange="this.form.submit();">
                    <option value="99" <?php echo $status == '99' ? 'selected="selected"' : '' ?> >Todos</option>
                    <option value="1" <?php echo $status == '1' ? 'selected="selected"' : '' ?>>Ativo</option>
                    <option value="2" <?php echo $status == '2' ? 'selected="selected"' : '' ?>>Inativo</option>                    
                </select>
                <br />
            </td>
        </tr>
    </table>
    </form>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
        &nbsp;
<!--        <input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;-->
        
    </th>
  
  <th>
    <?php echo __('Imagem') ?>
  </th>
  <th>
    <?php echo link_to(__('Nome'),'@default?module=lxuser&action=index&sort=name&by='.$by.'&page='.$LxUsers->getPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?>
  <?php if($sort == "name"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  <th>
    Perfil
  </th>
  <th>
    <?php echo link_to(__('Email'),'@default?module=lxuser&action=index&sort=email&by='.$by.'&page='.$LxUsers->getPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?>
  <?php if($sort == "email"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  
  <th>
    Telefone
  </th>
  <th>
    Celular
  </th>
  
  
  <th>
      <a href="javascript:void();">Vínculos</a>
  </th>
  <th>
    <?php echo link_to(__('Status'),'@default?module=lxuser&action=index&sort=lx_user.status&by='.$by.'&page='.$LxUsers->getPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?>
  <?php if($sort == "lx_user.status"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($LxUsers->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($LxUsers as $LxUser): ?>
    <?php $nome = $rs->datosTipoUsuario($LxUser->getIdUser(), $LxUser->getIdTipoUsuario()) ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>"  valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">        
        <td class="borderBottomDarkGray" width="28" align="center">
          <?php
          //Valida que no se pueda modificar ni borrar el propio usuario ni el root ni administrador
          if($sf_user->getAttribute('idUserPanel')!=$LxUser->getIdUser() and $LxUser->getIdUser() > 2):
          ?>
            &nbsp;<input style="display: none;" type="checkbox" id="chk_<?php echo $LxUser->getIdUser() ?>" name="chk[<?php echo $LxUser->getIdUser() ?>]" value="<?php echo $LxUser->getIdUser() ?>">&nbsp;
          <?php else:?>
                &nbsp;
           <?php endif;?>
        </td>
        <td class="borderBottomDarkGray">
            <?php if($LxUser->getPhoto()):  ?>
                <?php echo image_tag('/uploads/users/'.$appYml['size_2']['pref_2'].'_'.$LxUser->getPhoto(), 'class="image"')?>
            <?php else:?>
                <?php echo image_tag('user.jpg', 'border=0  class="image" width= "35" height= "35"');?>
            <?php endif;?>
        </td>
        
        <?php //Valida que no se pueda modificar el propio usuario ni el root ni administrador
         //if($sf_user->getAttribute('idUserPanel')==$LxUser->getIdUser() or $LxUser->getIdUser() == 1):
         ?>
        <?php if($LxUser->getIdUser() == 1):?>
         
         <td class="borderBottomDarkGray">
             <?php echo $nome['nome'] ?>
         </td>
         <?php else: ?>
         <td class="borderBottomDarkGray">
            <div class="displayTitle">
               <div id="title">
                   
                        <a href="<?php echo url_for('lxuser/edit?id_user='.$LxUser->getIdUser()) ?>" class="titulo">                        
                             <?php echo $nome['nome'] ?>
                        </a>
                   
               </div>
                <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>
                <div class="row-actions" style="width: 140px; margin-left: 3px;">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('lxuser/edit?id_user='.$LxUser->getIdUser(), $LxUser) ?>" class="edit"><?php echo __('Edit') ?></a>
                        <?php endif;?>
                         <?php if(aplication_system::esUsuarioRoot()): ?>
                        <?php
                        if($LxUser->getIdUser() != 2): ?>
                        &nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'lxuser/delete?id_user='.$LxUser->getIdUser(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </td>
       <?php endif; ?>      
        <td class="borderBottomDarkGray">
            <?php $perfil = LxProfilePeer::getNameProfile($LxUser->getIdProfile())  ?>
            <?php echo $perfil ? $perfil->getNameProfile() : '' ?>
        </td>
        <td class="borderBottomDarkGray">
              <?php echo $LxUser->getEmail() ?>
        </td>
        <td class="borderBottomDarkGray">
            <?php echo $nome['ddd_telefone'].' '.$nome['telefone'] ?>
        </td>
        <td class="borderBottomDarkGray">
            <?php echo $nome['ddd_celular'].' '.$nome['celular'] ?>
        </td>
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
                <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>
                <?php echo jq_link_to_remote(image_tag($LxUser->getStatus().'.png','alt="" title="" border=0'), array(
                    'update'  =>  'status_'.$LxUser->getIdUser(),
                    'url'     =>  'lxuser/changeStatus?id_user='.$LxUser->getIdUser().'&status='.$LxUser->getStatus(),
                    'script'  => true,
                    'before'  => "$('#status_".$LxUser->getIdUser()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                ));
                ?>
                <?php else: ?>
                <?php echo image_tag($LxUser->getStatus().'.png','alt="" title="" border=0') ?>
                <?php endif; ?>
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
    
 

<?php if ($LxUsers->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" class="pagination" style="margin-top: 30px;" border="0">
	<tr>
            <td align="left" style="width: 40%;" ><i><?php echo $LxUsers->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$LxUsers->getPage().' '.__('for').' ' ?> <?php echo $LxUsers->getLastPage() ?></i> </td>
            <td align="left">	
        	<table>
                	<tr>
                		<?php if ($LxUsers->getFirstPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to('<<', '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getFirstPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?></td>
                		<td><?php echo link_to('<','@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getPreviousPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?></td>
                		<?php endif; ?>
                                <td >
                		<?php $links = $LxUsers->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $LxUsers->getPage()) ? '<a class="active" href="#">'.$page.'</a>' : link_to($page, '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?>
		                        <?php if ($page != $LxUsers->getCurrentMaxLink()): ?>
		                        
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($LxUsers->getLastPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to('>', '@default?module=lxuser&action=index&page='.$LxUsers->getNextPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?></td>
                		<td><?php echo link_to('>>', 'lxuser/index?page='.$LxUsers->getLastPage().$bus_pagi.'&radio-cad='.$sf_request->getParameter('radio-cad')) ?></td>
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
