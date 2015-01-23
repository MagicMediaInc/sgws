<div id="title_module">
    <div class="frameForm" >
    <h1><?php echo __('Arquivos') ?></h1>
    </div>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("There aren't items selected"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Hidden'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
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
    <?php echo form_tag('archivo/index',array('name' => 'busca', 'id' => 'busca','style'=>'margin:0px')) ?>
    <div id="search" style="margin-bottom: 10px;">
            <label for="filter"><?php echo __('Pesquisar arquivos') ?></label> 
            <input type="text" name="buscador" value="" id="buscador" />
            <select id="tipo" name="tipo">
                <option value="">Selecione</option>
                <option value="1">Arquivos de seções</option>
                <option value="2">Arquivos restritos para associados</option>
            </select>
            &nbsp;<input type="submit" name="buscar" value="Pesquisar" id="buscador" />
            &nbsp;&nbsp;&nbsp;&nbsp; <a href="<?php echo url_for($this->getModuleName().'/index') ?>"><?php echo __('Ver todos')?></a>
    </div>
    </form>
    <?php echo form_tag('archivo/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table border="0">
        <tr>
            <td>

                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
            <td>&nbsp;|&nbsp;</td>
            <td>
                <a href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Adicionar novo arquivo')?></a>
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
    <?php echo link_to(__('Titulo arquivo'),'@default?module=archivo&action=index&sort=titulo_archivo&by='.$by.'&page='.$SfArchivosSeccions->getPage().'&buscador='.$buscador) ?>
    <?php if($sort == "titulo_archivo"){ echo image_tag($by_page); }?>
    </th>
    <th>
    <?php echo link_to(__('Arquivo'),'@default?module=archivo&action=index&sort=archivo&by='.$by.'&page='.$SfArchivosSeccions->getPage().'&buscador='.$buscador) ?>
    <?php if($sort == "archivo"){ echo image_tag($by_page); }?>
    </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($SfArchivosSeccions->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($SfArchivosSeccions as $SfArchivosSeccion): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $SfArchivosSeccion->getIdArchivoSeccion() ?>" name="chk[<?php echo $SfArchivosSeccion->getIdArchivoSeccion() ?>]" value="<?php echo $SfArchivosSeccion->getIdArchivoSeccion() ?>">&nbsp;</td>
        <td class="borderBottomDarkGray">
            <div class="displayTitle">
                <div id="title">                               
                    <a href="<?php echo url_for('archivo/edit?id_archivo_seccion='.$SfArchivosSeccion->getIdArchivoSeccion()) ?>" class="titulo"><?php echo $SfArchivosSeccion->getTituloArchivo() ?></a>
                </div>
                <div class="row-actions">
                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                        <a href="<?php echo url_for('archivo/edit?id_archivo_seccion='.$SfArchivosSeccion->getIdArchivoSeccion(), $SfArchivosSeccion) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                        <?php echo link_to(__('Delete'),'archivo/delete?id_archivo_seccion='.$SfArchivosSeccion->getIdArchivoSeccion(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>

                    </div>
                </div>
            </div>
        </td>
        
        <td class="borderBottomDarkGray"><?php echo $SfArchivosSeccion->getArchivo() ?>&nbsp;</td>
    </tr>
    <?php $i++; ?>
    <?php endforeach; ?>
  </tbody>
</table>
    <?php else: ?>
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong><?php echo __('Your search did not match any result') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
  
</form>
<?php if ($SfArchivosSeccions->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $SfArchivosSeccions->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$SfArchivosSeccions->getPage().' '.__('for').' ' ?> <?php echo $SfArchivosSeccions->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($SfArchivosSeccions->getFirstPage()!=$SfArchivosSeccions->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=archivo&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfArchivosSeccions->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=archivo&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfArchivosSeccions->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $SfArchivosSeccions->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $SfArchivosSeccions->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=archivo&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $SfArchivosSeccions->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($SfArchivosSeccions->getLastPage()!=$SfArchivosSeccions->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=archivo&action=index&page='.$SfArchivosSeccions->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'archivo/index?page='.$SfArchivosSeccions->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
            <i><?php echo $SfArchivosSeccions->getNbResults().' '.__('results') ?></i>
</div>
<?php endif; ?>
</div>

