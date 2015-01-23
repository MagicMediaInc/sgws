<h1 class="icono_banco"><?php echo __('Bancos') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Adicionar novo banco')?></a>
<div id="title_module">
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php include_partial('menu') ?>
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
    <?php echo form_tag('banco/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
        </tr>
    </table>
</div>
<?php if ($Bancos->haveToPaginate()): ?>
    <div class="result_busca">
        Resultados da busca: <span><?php echo $Bancos->getNbResults().' '.__('registros encontrados') ?></span>
    </div>
<?php endif;?>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
		&nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
	</th>
  
  
  <th>
    <?php echo link_to(__('Nombre banco'),'@default?module=banco&action=index&sort=nombre_banco&by='.$by.'&page='.$Bancos->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "nombre_banco"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Status'),'@default?module=banco&action=index&sort=status&by='.$by.'&page='.$Bancos->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "status"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($Bancos->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($Bancos as $Banco): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $Banco->getIdBanco() ?>" name="chk[<?php echo $Banco->getIdBanco() ?>]" value="<?php echo $Banco->getIdBanco() ?>">&nbsp;</td>
        <td class="borderBottomDarkGray">
            <div class="displayTitle">
               <div id="title">                               
                    <a href="<?php echo url_for('banco/edit?id_banco='.$Banco->getIdBanco()) ?>" class="titulo"><?php echo $Banco->getNombreBanco() ?></a>
               </div>
                <div class="row-actions">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('banco/edit?id_banco='.$Banco->getIdBanco(), $Banco) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'banco/delete?id_banco='.$Banco->getIdBanco(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>

                    </div>
                </div>
            </div>
        </td>
        <td class="borderBottomDarkGray">
            <?php echo image_tag($Banco->getStatus().'.png','alt="" title="" border=0') ?>
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
<?php if ($Bancos->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $Bancos->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Bancos->getPage().' '.__('for').' ' ?> <?php echo $Bancos->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Bancos->getFirstPage()!=$Bancos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=banco&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Bancos->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=banco&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Bancos->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Bancos->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Bancos->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=banco&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Bancos->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Bancos->getLastPage()!=$Bancos->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=banco&action=index&page='.$Bancos->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'banco/index?page='.$Bancos->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $Bancos->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

