<h1 class="icono_projeto"><?php echo __('Tipos de Tarefas') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo Tipo de Tarefa')?></a>
<div id="title_module">
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm">
    <?php echo form_tag('tipotarefa/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
        </tr>
    </table>
</div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
	&nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
    </th>
  <th>
    <?php echo link_to(__('Tarefa'),'@default?module=tipotarefa&action=index&sort=tarefa&by='.$by.'&page='.$Tarefadescricaos->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "tarefa"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($Tarefadescricaos->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($Tarefadescricaos as $Tarefadescricao): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $Tarefadescricao->getDescricao() ?>" name="chk[<?php echo $Tarefadescricao->getDescricao() ?>]" value="<?php echo $Tarefadescricao->getDescricao() ?>">&nbsp;</td>
        <td class="borderBottomDarkGray">
            <div class="displayTitle">
               <div id="title">                               
                    <a href="<?php echo url_for('tipotarefa/edit?descricao='.$Tarefadescricao->getDescricao()) ?>" class="titulo"><?php echo $Tarefadescricao->getTarefa() ?></a>
               </div>
                <div class="row-actions">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('tipotarefa/edit?descricao='.$Tarefadescricao->getDescricao(), $Tarefadescricao) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'tipotarefa/delete?descricao='.$Tarefadescricao->getDescricao(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                    </div>
                </div>
            </div>
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
  
</form>
<?php if ($Tarefadescricaos->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $Tarefadescricaos->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Tarefadescricaos->getPage().' '.__('for').' ' ?> <?php echo $Tarefadescricaos->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Tarefadescricaos->getFirstPage()!=$Tarefadescricaos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=tipotarefa&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Tarefadescricaos->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=tipotarefa&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Tarefadescricaos->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Tarefadescricaos->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Tarefadescricaos->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=tipotarefa&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Tarefadescricaos->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Tarefadescricaos->getLastPage()!=$Tarefadescricaos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=tipotarefa&action=index&page='.$Tarefadescricaos->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'tipotarefa/index?page='.$Tarefadescricaos->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $Tarefadescricaos->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

