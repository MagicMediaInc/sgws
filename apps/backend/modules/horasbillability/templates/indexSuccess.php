
<h1 class="icono_projeto"><?php echo __('horas billability') ?></h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Nova hora por mês')?></a>
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
    <?php echo link_to(__('Ano'),'@default?module=horasbillability&action=index&sort=ano&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "ano"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes1'),'@default?module=horasbillability&action=index&sort=mes1&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes1"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes2'),'@default?module=horasbillability&action=index&sort=mes2&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes2"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes3'),'@default?module=horasbillability&action=index&sort=mes3&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes3"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes4'),'@default?module=horasbillability&action=index&sort=mes4&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes4"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes5'),'@default?module=horasbillability&action=index&sort=mes5&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes5"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes6'),'@default?module=horasbillability&action=index&sort=mes6&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes6"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes7'),'@default?module=horasbillability&action=index&sort=mes7&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes7"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes8'),'@default?module=horasbillability&action=index&sort=mes8&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes8"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes9'),'@default?module=horasbillability&action=index&sort=mes9&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes9"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes10'),'@default?module=horasbillability&action=index&sort=mes10&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes10"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes11'),'@default?module=horasbillability&action=index&sort=mes11&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes11"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Mes12'),'@default?module=horasbillability&action=index&sort=mes12&by='.$by.'&page='.$HorasBillabilitys->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "mes12"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($HorasBillabilitys->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($HorasBillabilitys as $HorasBillability): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;&nbsp;</td>
        <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="<?php echo url_for('horasbillability/edit?codigo='.$HorasBillability->getCodigo()) ?>" class="titulo"><?php echo $HorasBillability->getAno() ?></a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                    <a href="<?php echo url_for('horasbillability/edit?codigo='.$HorasBillability->getCodigo(), $HorasBillability) ?>" class="edit"><?php echo __('Editar') ?></a>&nbsp;|&nbsp;
                                    <?php echo link_to(__('Excluir'),'horasbillability/delete?codigo='.$HorasBillability->getCodigo(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                                    
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes1() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes2() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes3() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes4() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes5() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes6() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes7() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes8() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes9() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes10() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes11() ?>&nbsp;</td>
                    <td class="borderBottomDarkGray"><?php echo $HorasBillability->getMes12() ?>&nbsp;</td>
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
<?php if ($HorasBillabilitys->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $HorasBillabilitys->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$HorasBillabilitys->getPage().' '.__('for').' ' ?> <?php echo $HorasBillabilitys->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($HorasBillabilitys->getFirstPage()!=$HorasBillabilitys->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=horasbillability&action=index&sort='.$sort.'&by='.$by_page.'&page='.$HorasBillabilitys->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=horasbillability&action=index&sort='.$sort.'&by='.$by_page.'&page='.$HorasBillabilitys->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $HorasBillabilitys->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $HorasBillabilitys->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=horasbillability&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $HorasBillabilitys->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($HorasBillabilitys->getLastPage()!=$HorasBillabilitys->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=horasbillability&action=index&page='.$HorasBillabilitys->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'horasbillability/index?page='.$HorasBillabilitys->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $HorasBillabilitys->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

