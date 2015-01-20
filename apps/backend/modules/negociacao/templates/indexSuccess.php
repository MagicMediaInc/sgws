<h1 class="icono_seguranca">negociação</h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Nova Negociação')?></a>

    
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
    <?php echo link_to(__('Nome'),'@default?module=negociacao&action=index&sort=nome&by='.$by.'&page='.$Negociacaos->getPage().'&buscador='.$buscador) ?>
    <?php if($sort == "nome"){ echo image_tag($by_page); }?>
  </th>
  
    </tr>
  </thead>
  <tbody>
  <?php if ($Negociacaos->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($Negociacaos as $Negociacao): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;&nbsp;</td>
                                                        <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="<?php echo url_for('negociacao/edit?id_negociacao='.$Negociacao->getIdNegociacao()) ?>" class="titulo"><?php echo $Negociacao->getNome() ?></a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                    <a href="<?php echo url_for('negociacao/edit?id_negociacao='.$Negociacao->getIdNegociacao(), $Negociacao) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                                    <?php echo link_to(__('Delete'),'negociacao/delete?id_negociacao='.$Negociacao->getIdNegociacao(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                                    
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
<?php if ($Negociacaos->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $Negociacaos->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Negociacaos->getPage().' '.__('for').' ' ?> <?php echo $Negociacaos->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Negociacaos->getFirstPage()!=$Negociacaos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=negociacao&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Negociacaos->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=negociacao&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Negociacaos->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Negociacaos->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Negociacaos->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=negociacao&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Negociacaos->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Negociacaos->getLastPage()!=$Negociacaos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=negociacao&action=index&page='.$Negociacaos->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'negociacao/index?page='.$Negociacaos->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $Negociacaos->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>

