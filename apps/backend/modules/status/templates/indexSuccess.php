<h1 class="icono_seguranca"><?php echo __('status') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo Status')?></a>
<div id="title_module">
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>

<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
		&nbsp;
	</th>
  
  
  <th>
    <?php echo link_to(__('Nome Status'),'@default?module=status&action=index&sort=idstatus&by='.$by.'&page='.$Statuss->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "idstatus"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($Statuss->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($Statuss as $Status): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;&nbsp;</td>
                                                        <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="<?php echo url_for('status/edit?status='.$Status->getStatus()) ?>" class="titulo"><?php echo $Status->getIdstatus() ?></a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                    <a href="<?php echo url_for('status/edit?status='.$Status->getStatus(), $Status) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                                    <?php echo link_to(__('Delete'),'status/delete?status='.$Status->getStatus(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                                    
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
  

<?php if ($Statuss->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $Statuss->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Statuss->getPage().' '.__('for').' ' ?> <?php echo $Statuss->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Statuss->getFirstPage()!=$Statuss->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=status&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Statuss->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=status&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Statuss->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Statuss->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Statuss->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=status&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Statuss->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Statuss->getLastPage()!=$Statuss->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=status&action=index&page='.$Statuss->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'status/index?page='.$Statuss->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $Statuss->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

