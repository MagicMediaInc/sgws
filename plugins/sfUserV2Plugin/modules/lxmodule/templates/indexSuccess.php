<?php use_javascript('reorderModule.js'); ?>
<h1 class="icono_user"><?php echo __('M&oacute;dulos') ?></h1>
<div id="title_module">
    
<div class="msn_error" align="center" id="no_select_item" style="display: none;"><?php echo __("Não há itens selecionados"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Escondido'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div class="frameForm" >
    <?php echo form_tag('lxmodule/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
            <td>&nbsp;|&nbsp;</td>
            <td>
                <a href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Agregar novo módulo')?></a>
            </td>
        </tr>
    </table>
           
</div>

<div style="float:left;width: 350px;">
  <div id="tree-div" style="overflow:hidden; height:auto;width:350px;border:0px solid #c3daf9;  "></div>
  <div id="resultados" style="overflow:auto; padding-bottom:50px; height:120px;width:500px;border:2px solid #c3daf9; display: none; padding-bottom:35px;"></div>
</div>


<div style="margin-left: 360px;">
   
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th >
            &nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
	</th>
  
    <th>
    <?php echo link_to(__('Nome do módulo'),'@default?module=lxmodule&action=index&sort=name_module&by='.$by.'&page='.$LxModules->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "name_module"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Sf module'),'@default?module=lxmodule&action=index&sort=sf_module&by='.$by.'&page='.$LxModules->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "sf_module"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Credencial'),'@default?module=lxmodule&action=index&sort=credential&by='.$by.'&page='.$LxModules->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "credential"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Status'),'@default?module=lxmodule&action=index&sort=status&by='.$by.'&page='.$LxModules->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "status"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Módulo pai'),'@default?module=lxmodule&action=index&sort=id_parent&by='.$by.'&page='.$LxModules->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "id_parent"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody >
  <?php if ($LxModules->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($LxModules as $LxModule): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
      <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
          <td class="borderBottomDarkGray" width="28" align="center">
              <?php if(!$LxModule->getDelete()):?>
                &nbsp;<input type="checkbox" id="chk_<?php echo $LxModule->getIdModule() ?>" name="chk[<?php echo $LxModule->getIdModule() ?>]" value="<?php echo $LxModule->getIdModule() ?>">&nbsp;
              <?php else:?>
                    &nbsp;
               <?php endif;?>
          </td>
          <td class="borderBottomDarkGray">
              <div class="displayTitle">
                  <div id="title">
                      <a href="<?php echo url_for('lxmodule/edit?id_module='.$LxModule->getIdModule()) ?>" class="titulo"><?php echo $LxModule->getNameModule() ?></a>
                  </div>
                  <div class="row-actions" style="width: 180px;">
                      <div class="row-actions_<?php echo $i; ?>" style="display: none;" >
                        <a href="<?php echo url_for('lxmodule/edit?id_module='.$LxModule->getIdModule(), $LxModule) ?>" class="edit"><?php echo __('Edit') ?></a>
                        <?php if($LxModule->getDelete()):?>
                        &nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'lxmodule/delete?id_module='.$LxModule->getIdModule(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        <?php endif;?>
                      </div>
                  </div>
              </div>
          </td>
          
          <td class="borderBottomDarkGray"><?php echo $LxModule->getSfModule() ?>&nbsp;</td>
          <td class="borderBottomDarkGray"><?php echo $LxModule->getCredential() ?>&nbsp;</td>
          <td class="borderBottomDarkGray"><?php echo image_tag($LxModule->getStatus().'.png','alt="" title=""');?></td>
          <td class="borderBottomDarkGray"><?php $lxModuleName = LxModulePeer::getModuleXId($LxModule->getIdParent()); echo $lxModuleName; ?>&nbsp;</td>
      </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
    </tbody>
</table>
   <?php else: ?>
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong><?php echo __('Sua busca não encontrou nenhum resultado') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
</form>

<?php if ($LxModules->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $LxModules->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$LxModules->getPage().' '.__('for').' ' ?> <?php echo $LxModules->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($LxModules->getFirstPage()!=$LxModules->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=lxmodule&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxModules->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=lxmodule&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LxModules->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $LxModules->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $LxModules->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=lxmodule&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $LxModules->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($LxModules->getLastPage()!=$LxModules->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=lxmodule&action=index&page='.$LxModules->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'lxmodule/index?page='.$LxModules->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
      <i><?php echo $LxModules->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

</div>