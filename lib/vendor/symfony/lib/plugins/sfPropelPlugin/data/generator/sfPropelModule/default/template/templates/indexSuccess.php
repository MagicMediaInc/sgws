<div id="title_module">
    <div class="frameForm" >
    <h1>[?php echo __('<?php echo $this->getModuleName()?>') ?]</h1>
    </div>
<div class="msn_error" id="no_select_item" style="display: none;">[?php echo __("Nenhum item selecionado"); ?].&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();">[?php echo __('Ocultar'); ?]</a> </div>
[?php if ($sf_user->hasFlash('listo')): ?]
    <div class="msn_ready">[?php echo $sf_user->getFlash('listo') ?]</div>
[?php endif; ?]
<div class="frameForm"><style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>
    [?php echo form_tag('<?php echo $this->getModuleName() ?>/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?]
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);">[?php echo __('Remover todos os') ?]</a>
            </td>
            <td>&nbsp;|&nbsp;</td>
            <td>
                <a href="[?php echo url_for($this->getModuleName().'/new') ?]">[?php echo __('Adicionar novo  <?php echo $this->getModuleName() ?>')?]</a>
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
<?php foreach ($this->getTableMap()->getColumns() as $column): ?>
  
  <th>
  <?php if ($column->isPrimaryKey()): ?>
  <?php	$key = $column->getPhpName();  ?> 
  <?php endif; ?>
  [?php echo link_to(__('<?php echo sfInflector::humanize(sfInflector::underscore($column->getPhpName())) ?>'),'@default?module=<?php echo $this->getModuleName() ?>&action=index&sort=<?php echo strtolower($column->getColumnName()) ?>&by='.$by.'&page='.$<?php echo $this->getPluralName()?>->getPage().'&buscador='.$buscador) ?]
  [?php if($sort == "<?php echo strtolower($column->getColumnName()); ?>"){ echo image_tag($by_page); }?]
  </th>
<?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
  [?php if ($<?php echo $this->getPluralName() ?>->getNbResults()): ?]
  	[?php $i=0; ?]
    [?php foreach ($<?php echo $this->getPluralName() ?> as $<?php echo $this->getSingularName() ?>): ?]
    [?php fmod($i,2)?$class = "grayBackground":$class=''; ?]
    <tr class="[?php echo $class;?]" valign="top" onmouseover="javascript:overRow([?php echo $i; ?]);" onmouseout="javascript:outRow([?php echo $i; ?]);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $key ?>() ?]" name="chk[[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $key ?>() ?]]" value="[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $key ?>() ?]">&nbsp;</td>
        <?php foreach ($this->getTableMap()->getColumns() as $column): ?>
            <?php if ($column->isPrimaryKey()): ?>
                <?php if (isset($this->params['route_prefix']) && $this->params['route_prefix']): ?>
                    <td class="borderBottomDarkGray">
                        <a href="[?php echo url_for('<?php echo $this->getUrlForAction(isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit') ?>', $<?php echo $this->getSingularName() ?>) ?]">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</a>
                        <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams() ?>, $<?php echo $this->getSingularName() ?>) ?]" class="edit">Edit</a>&nbsp;|&nbsp;
                        [?php echo link_to(__('Delete'),'<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]
                        <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams() ?>, $<?php echo $this->getSingularName() ?>) ?]" class="delete">Borrar</a>&nbsp;|&nbsp;
                        <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams() ?>, $<?php echo $this->getSingularName() ?>) ?]" class="view">Ver</a>
                    </td>
                <?php else: ?>
                    <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/<?php echo isset($this->params['with_show']) && $this->params['with_show'] ? 'show' : 'edit' ?>?<?php echo $this->getPrimaryKeyUrlParams() ?>) ?]" class="titulo">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]</a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_[?php echo $i; ?]" style="display: none;">
                                    <a href="[?php echo url_for('<?php echo $this->getModuleName() ?>/edit?<?php echo $this->getPrimaryKeyUrlParams() ?>, $<?php echo $this->getSingularName() ?>) ?]" class="edit">[?php echo __('Edit') ?]</a>&nbsp;|&nbsp;
                                    [?php echo link_to(__('Delete'),'<?php echo $this->getModuleName() ?>/delete?<?php echo $this->getPrimaryKeyUrlParams() ?>, array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?]
                                    
                                </div>
                            </div>
                        </div>
                    </td>
                <?php endif; ?>
            <?php else: ?>
                <td class="borderBottomDarkGray">[?php echo $<?php echo $this->getSingularName() ?>->get<?php echo $column->getPhpName() ?>() ?]&nbsp;</td>
            <?php endif; ?>
        <?php endforeach; ?>
    </tr>
    [?php $i++; ?]
    [?php endforeach; ?]
  </tbody>
</table>
    [?php else: ?]
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong>[?php echo __('Sua busca não gerou resultados') ?]</strong></td>
        </tr>
    </table>
    [?php endif; ?]
  
</form>
[?php if ($<?php echo $this->getPluralName()?>->haveToPaginate()): ?]
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i>[?php echo $<?php echo $this->getPluralName()?>->getNbResults().' '.__('resultados') ?]  - [?php echo __('page').' '.$<?php echo $this->getPluralName()?>->getPage().' '.__('for').' ' ?] [?php echo $<?php echo $this->getPluralName()?>->getLastPage() ?]</i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		[?php if ($<?php echo $this->getPluralName()?>->getFirstPage()!=$<?php echo $this->getPluralName()?>->getPage()) :?]
                		<td>[?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=<?php echo $this->getModuleName() ?>&action=index&sort='.$sort.'&by='.$by_page.'&page='.$<?php echo $this->getPluralName()?>->getFirstPage().$bus_pagi) ?]</td>
                		<td>[?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=<?php echo $this->getModuleName() ?>&action=index&sort='.$sort.'&by='.$by_page.'&page='.$<?php echo $this->getPluralName()?>->getPreviousPage().$bus_pagi) ?]</td>
                		[?php endif; ?]
                		<td >
                		[?php $links = $<?php echo $this->getPluralName()?>->getLinks(); 
                        
	                        foreach ($links as $page): ?]
	                        [?php echo ($page == $<?php echo $this->getPluralName()?>->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=<?php echo $this->getModuleName() ?>&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?]
		                        [?php if ($page != $<?php echo $this->getPluralName()?>->getCurrentMaxLink()): ?]
		                        -
		                        [?php endif; ?]
	                        [?php endforeach; ?]
                		</td>
                		[?php if ($<?php echo $this->getPluralName()?>->getLastPage()!=$<?php echo $this->getPluralName()?>->getPage()) :?]
                		<td>[?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=<?php echo $this->getModuleName() ?>&action=index&page='.$<?php echo $this->getPluralName()?>->getNextPage().$bus_pagi) ?]</td>
                		<td>[?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), '<?php echo $this->getModuleName() ?>/index?page='.$<?php echo $this->getPluralName()?>->getLastPage().$bus_pagi) ?]</td>
                		[?php endif; ?]
                	</tr>
            </table>
		</td>
	</tr>
</table>
[?php else: ?]
<div class="results">
    <i>[?php echo $<?php echo $this->getPluralName()?>->getNbResults().' '.__('resultados') ?]</i>
</div>
[?php endif; ?]
</div>

