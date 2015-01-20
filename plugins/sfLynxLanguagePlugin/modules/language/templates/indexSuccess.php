<div id="title_module">
    <table cellpadding="0" cellspacing="2" border="0" width="100%">
        <tr>
            <td align="left"><h1><?php echo __('Languages') ?></h1></td>
            
        </tr>
    </table>
</div>
<div class="msn_error" align="center" id="no_select_item" style="display: none;"><?php echo __("There aren't items selected"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Hidden'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div id="search_box">
    <?php echo form_tag('language/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table>
        <tr>
            <td>
                <table align="center">
                    <tr>
                        <td>
                            
                            <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Delete all') ?></a>
                        </td>
                        <td>&nbsp;|&nbsp;</td>
                        <td>
                            <a href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Add new language')?></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
		<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >
	</th>
  
  <th>

    <?php echo link_to(__('Language'),'language/index?&sort=language&by='.$by.'&page='.$SfLanguages->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "language"){ echo image_tag($by_page,'align="top"'); }?>
  </th>

  <th>
    <?php echo link_to(__('Country'),'language/index?&sort=country&by='.$by.'&page='.$SfLanguages->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "country"){ echo image_tag($by_page,'align="top"'); }?>
  </th>

  <th>
    <?php echo link_to(__('Principal'),'language/index?&sort=principal&by='.$by.'&page='.$SfLanguages->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "principal"){ echo image_tag($by_page,'align="top"'); }?>
  </th>

  <th>
    <?php echo link_to(__('Status'),'language/index?&sort=status&by='.$by.'&page='.$SfLanguages->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "status"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
    </tr>
    </tr>
  </thead>
  <tbody>
  <?php if ($SfLanguages): ?>
  	<?php $i=0; ?>
    <?php foreach ($SfLanguages as $SfLanguage): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" height="35" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="10">
                <?php if ($SfLanguage->getPrincipal() != 1): ?>
                    <input type="checkbox" id="chk_<?php echo $SfLanguage->getIdLanguage() ?>" name="chk[<?php echo $SfLanguage->getIdLanguage() ?>]" value="<?php echo $SfLanguage->getIdLanguage() ?>">
                <?php endif;?>
        </td>
                                                        <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="<?php echo url_for('language/edit?id_language='.$SfLanguage->getIdLanguage()) ?>" class="titulo"><?php echo ucwords(sfI18N::getNativeName($SfLanguage->getLanguage())) ?></a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                    <a href="<?php echo url_for('language/edit?id_language='.$SfLanguage->getIdLanguage(), $SfLanguage) ?>" class="edit"><?php echo __('Edit') ?></a>
                                    <?php if ($SfLanguage->getPrincipal() != 1): ?>&nbsp;|&nbsp;
                                        <?php echo link_to(__('Delete'),'language/delete?id_language='.$SfLanguage->getIdLanguage(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                                    <?php endif;?>
                                    
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="borderBottomDarkGray"><?php echo sfI18N::getCountry($SfLanguage->getCountry(),$SfLanguage->getLanguage()) ?></td>
                    <td class="borderBottomDarkGray"><?php echo image_tag($SfLanguage->getPrincipal().'.png','alt="" title=""'); ?></td>
                    <td class="borderBottomDarkGray"><?php echo image_tag($SfLanguage->getStatus().'.png','alt="" title=""') ?></td>
             </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
    <?php endif; ?>
  </tbody>
</table>
</form>
<?php if ($SfLanguages->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $SfLanguages->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$SfLanguages->getPage().' '.__('for').' ' ?> <?php echo $SfLanguages->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($SfLanguages->getFirstPage()!=$SfLanguages->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=language&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfLanguages->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=language&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfLanguages->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $SfLanguages->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $SfLanguages->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=language&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $SfLanguages->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($SfLanguages->getLastPage()!=$SfLanguages->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=language&action=index&page='.$SfLanguages->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'language/index?page='.$SfLanguages->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php endif; ?>


