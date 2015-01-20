<?php use_helper('Date') ?>
<?php  $appYml = sfConfig::get('app_upload_images_lxaccount'); ?>
<script type="text/javascript"> 
    $(document).ready(function() {
        <?php if($sf_request->getParameter('by_status')): ?>
                $("#by_status").val(<?php echo $sf_request->getParameter('by_status') ?>);
        <?php endif; ?>
    })
</script>
<h1 class="icono_user"><?php echo $sf_user->getAttribute('tc_empresa') == 2 ? 'Clientes' : 'Fornecedores' ?></h1>

<div id="title_module">
    
    <div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" class="white" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    
<div id="renglon-list" style="height: 117px;">
    <ul class="lang">
        <li>&nbsp;<a class="icon_plus_adicionar" href="javascript:void(0);">Novo Usuário</a><ul>
                <li>
                    <a href="<?php echo url_for('lxuser/new') ?>">
                        <?php echo image_tag('icons/user_min_fisica')?> &nbsp;&nbsp;Funcionario
                    </a>
                </li>
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
            </ul>
        </li>
    </ul>
    <?php echo form_tag('lxuser/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <div class="propiedades">
        <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
        Listagem de<br />
        <?php echo $sf_user->getAttribute('tc_empresa') == 2 ? 'Clientes' : 'Fornecedores' ?>
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
    <table border="0" style="width: 100%; ">
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
      Código Cliente
  </th>
  <th style="width: 25%;">
      Nome Fantasia
  </th>
  <th style="width: 25%;">
      Razão Social
  </th>
  <th>
      Email
  </th>
  <th>CNPJ</th>
  <th>Status</th>
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
          if($sf_user->getAttribute('idUserPanel')!=$LxUser->getIdEmpresa() and $LxUser->getIdEmpresa() > 2):
          ?>
            &nbsp;<input style="display: none;" type="checkbox" id="chk_<?php echo $LxUser->getIdEmpresa() ?>" name="chk[<?php echo $LxUser->getIdEmpresa() ?>]" value="<?php echo $LxUser->getIdEmpresa() ?>">&nbsp;
          <?php else:?>
                &nbsp;
           <?php endif;?>
        </td>
        
         <td class="borderBottomDarkGray">
            <div class="displayTitle">
               <div id="title">
                    <a href="<?php echo url_for('lxuser/editCliente?id='.$LxUser->getIdEmpresa()) ?>" class="titulo">                        
                        <?php echo $LxUser->getCodigoCliente() ? $LxUser->getCodigoCliente() : 'N/A' ?>
                    </a>
               </div>
                <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>
                <div class="row-actions" style="width: 100px; margin-left: 3px;">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('lxuser/editCliente?id='.$LxUser->getIdEmpresa(), $LxUser) ?>" class="edit"><?php echo __('Editar') ?></a>
                        <?php endif;?>
                        <?php if(aplication_system::esUsuarioRoot()): ?>
                        <?php
                        if($LxUser->getIdEmpresa() != 2): ?>
                        &nbsp;|&nbsp;
                        <?php echo link_to(__('Excluir'),'lxuser/deleteCliente?radio-cad='.$sf_request->getParameter('radio-cad').'&id='.$LxUser->getIdEmpresa(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        <?php endif;?>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </td>
         
        <td class="borderBottomDarkGray">
              <?php echo $LxUser->getNomeFantasia() ?>
        </td>
        <td class="borderBottomDarkGray">
              <?php echo $LxUser->getRazaoSocial() ?>
        </td>
        <td class="borderBottomDarkGray">
              <?php echo strtolower($LxUser->getEmail()) ?>
        </td>
        
        <td class="borderBottomDarkGray">
            <?php echo $LxUser->getCnpj() ?>
        </td>
        
        <td class="borderBottomDarkGray" id="status_<?php echo $LxUser->getIdEmpresa()?>">
            <?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot()): ?>
            <?php echo jq_link_to_remote(image_tag($LxUser->getStatus().'.png','alt="" title="" border=0'), array(
                'update'  =>  'status_'.$LxUser->getIdEmpresa(),
                'url'     =>  'lxuser/changeStatusJuridico?id='.$LxUser->getIdEmpresa().'&status='.$LxUser->getStatus(),
                'script'  => true,
                'before'  => "$('#status_".$LxUser->getIdEmpresa()."').html('". image_tag('preload.gif','title="" alt=""')."');"
            ));
            ?>
            <?php else: ?>
                <?php echo image_tag($LxUser->getStatus().'.png','alt="" title="" border=0') ?>
            <?php endif; ?>
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
<table width="100%" align="center" id="paginationTop" class="pagination" style="margin-top: 30px;" border="0">
	<tr>
    	<td align="left" style="width: 40%;" ><i><?php echo $LxUsers->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$LxUsers->getPage().' '.__('for').' ' ?> <?php echo $LxUsers->getLastPage() ?></i> </td>
        <td align="left">	
        	<table>
                	<tr>
                		<?php if ($LxUsers->getFirstPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to('<<', '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getFirstPage().$bus_pagi.'&'.$bus_TC) ?></td>
                		<td><?php echo link_to('<','@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxUsers->getPreviousPage().$bus_pagi.'&'.$bus_TC) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $LxUsers->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $LxUsers->getPage()) ? '<a class="active" href="#">'.$page.'</a>' : link_to($page, '@default?module=lxuser&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi.'&'.$bus_TC) ?>
		                        <?php if ($page != $LxUsers->getCurrentMaxLink()): ?>
		                        
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($LxUsers->getLastPage()!=$LxUsers->getPage()) :?>
                		<td><?php echo link_to('>', '@default?module=lxuser&action=index&page='.$LxUsers->getNextPage().$bus_pagi.'&'.$bus_TC) ?></td>
                		<td><?php echo link_to('>>', 'lxuser/index?page='.$LxUsers->getLastPage().$bus_pagi.'&'.$bus_TC) ?></td>
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
