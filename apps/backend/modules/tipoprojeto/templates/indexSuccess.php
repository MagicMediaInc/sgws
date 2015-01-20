<h1 class="icono_projeto"><?php echo __('Tipos de Projetos') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo Tipo de Projeto')?></a>
<div id="title_module">
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm">
    <?php echo form_tag('tipoprojeto/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table border="0">
        <tr>
            <td>
                <a style="display: none"  name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
        </tr>
    </table>
</div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
		&nbsp;<input style="display: none"  type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
	</th>

  
  <th>
    Código
    
  </th>
  <th>
    <?php echo link_to(__('Tipo de Projeyo'),'@default?module=tipoprojeto&action=index&sort=tipo&by='.$by.'&page='.$Projetotipos->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "tipo"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($Projetotipos->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($Projetotipos as $Projetotipo): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input style="display: none" type="checkbox" id="chk_<?php echo $Projetotipo->getCodigotipo() ?>" name="chk[<?php echo $Projetotipo->getCodigotipo() ?>]" value="<?php echo $Projetotipo->getCodigotipo() ?>">&nbsp;</td>
        <td class="borderBottomDarkGray">
            <a href="<?php echo url_for('tipoprojeto/edit?codigotipo='.$Projetotipo->getCodigotipo()) ?>" class="titulo"><?php echo $Projetotipo->getCodigotipo() ?></a>
        </td>
        <td class="borderBottomDarkGray">
            <div class="displayTitle">
            <div id="title">                               
            <a href="<?php echo url_for('tipoprojeto/edit?codigotipo='.$Projetotipo->getCodigotipo()) ?>" class="titulo"><?php echo $Projetotipo->getTipo() ?></a>
            </div>
            <div class="row-actions">
            <div class="row-actions_<?php echo $i; ?>" style="display: none;">
            <a href="<?php echo url_for('tipoprojeto/edit?codigotipo='.$Projetotipo->getCodigotipo(), $Projetotipo) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
            <?php echo link_to(__('Delete'),'tipoprojeto/delete?codigotipo='.$Projetotipo->getCodigotipo(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>

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
<?php if ($Projetotipos->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $Projetotipos->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Projetotipos->getPage().' '.__('for').' ' ?> <?php echo $Projetotipos->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Projetotipos->getFirstPage()!=$Projetotipos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=tipoprojeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Projetotipos->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=tipoprojeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Projetotipos->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Projetotipos->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Projetotipos->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=tipoprojeto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Projetotipos->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Projetotipos->getLastPage()!=$Projetotipos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=tipoprojeto&action=index&page='.$Projetotipos->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'tipoprojeto/index?page='.$Projetotipos->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $Projetotipos->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

