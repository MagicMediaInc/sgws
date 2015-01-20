<?php use_helper('Date') ?>
<link rel="stylesheet" href="js/jq/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.all.css" />
<script src="js/jq/jquery-ui-1.8.16.custom/js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jq/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="js/jq/jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.core.js"></script>
<script src="js/jq/jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="js/jq/jquery-ui-1.8.16.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">
  
    $(document).ready(function() {
	$("#seguranca_from_date,#seguranca_to_date").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<h1 class="icono_seguranca"><?php echo __('Segurança') ?></h1>
<div id="title_module">
    <div class="frameForm" >
    
    </div>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('error')): ?>
    <div class="msn_error"><?php echo $sf_user->getFlash('error') ?></div>
<?php endif; ?>
<div id="renglon">
    <?php echo form_tag('seguranca/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <div class="propiedades">
        <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
        Listagem de<br />
        Pessoas
    </div>
    <div class="propiedades propiedades-extend" style="width: 840px; border-left: 1px #ccc dotted; height: 80px;">
        <h1 class="titulo"><?php echo __('Consulta de Pessoas') ?></h1>
        <table width="80%" >
            <tr>
                <td id="errorGlobal" colspan="2">
                    <?php echo $form->renderGlobalErrors() ?>
                </td>
            </tr>
            <tr>
                <td width="60%"><input type="text" style="width: 300px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" /></td>
                <td align="left"><a href="<?php echo url_for('seguranca/index') ?> "><?php echo __('Veja todo') ?></a>&nbsp;</td>
            </tr>
            <tr>
                <td style="padding-top: 8px;">
                    <label style="color: #333; font-weight: bold;"> <?php echo __('Data de Início') ?></label>
                    <input size="8" type="text" name="from_date" id="seguranca_from_date" value="<?php echo $sf_request->getParameter('from_date') ?>" >
                    &nbsp;&nbsp;
                    <label style="color: #333; font-weight: bold;"> <?php echo __('Data de Fim') ?></label>
                    <input size="8" type="text" name="to_date" id="seguranca_to_date" value="<?php echo $sf_request->getParameter('to_date') ?>" >
                </td>
                <td align="left">
                    <input type="submit" name="search" id="busca" value="Buscar" />
                    
                </td>
            </tr>
            
        </table>
    </div>
    </form>
</div>
<?php if ($LogActividadess->haveToPaginate()): ?>
    <div class="result_busca">
        Resultados da busca: <span><?php echo $LogActividadess->getNbResults().' '.__('registros encontrados') ?></span>
    </div>
<?php endif;?>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
    <th>
        &nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;
    </th>
  
  
  <th>
    <?php echo link_to(__('Nome'),'@default?module=seguranca&action=index&sort=id_user&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
    <?php if($sort == "id_user"){ echo image_tag($by_page); }?>
  </th>
  <th>
    <?php echo link_to(__('Tipo'),'@default?module=seguranca&action=index&sort=id_user&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "id_user"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('IP'),'@default?module=seguranca&action=index&sort=ip&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "ip"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Página'),'@default?module=seguranca&action=index&sort=modulo&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "modulo"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Data'),'@default?module=seguranca&action=index&sort=fecha&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "fecha"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Horário'),'@default?module=seguranca&action=index&sort=hora&by='.$by.'&page='.$LogActividadess->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "hora"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($LogActividadess->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($LogActividadess as $LogActividades): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $LogActividades->getIdLog() ?>" name="chk[<?php echo $LogActividades->getIdLog() ?>]" value="<?php echo $LogActividades->getIdLog() ?>">&nbsp;</td>
        <td class="borderBottomDarkGray">
            <div class="displayTitle">
               <div id="title">                               
                    <?php $user = LxUserPeer::getDataUser($LogActividades->getIdUser())  ?>
                    <?php echo $user['nome'] ?>
               </div>                
            </div>
        </td>
        <td class="borderBottomDarkGray"><?php echo $user['tipo'] ?>&nbsp;</td>
        <td class="borderBottomDarkGray"><?php echo $LogActividades->getIp() ?>&nbsp;</td>
        <td class="borderBottomDarkGray"><?php echo $LogActividades->getModulo() ?>&nbsp;</td>
        <td class="borderBottomDarkGray"><?php echo format_date($LogActividades->getFecha(), 'D')  ?>&nbsp;</td>
        <td class="borderBottomDarkGray"><?php echo $LogActividades->getHora() ?>&nbsp;</td>
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
<?php if ($LogActividadess->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $LogActividadess->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$LogActividadess->getPage().' '.__('for').' ' ?> <?php echo $LogActividadess->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($LogActividadess->getFirstPage()!=$LogActividadess->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=seguranca&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LogActividadess->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=seguranca&action=index&sort='.$sort.'&by='.$by_page.'&page='.$LogActividadess->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $LogActividadess->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $LogActividadess->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=seguranca&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $LogActividadess->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($LogActividadess->getLastPage()!=$LogActividadess->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=seguranca&action=index&page='.$LogActividadess->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'seguranca/index?page='.$LogActividadess->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
    <i><?php echo $LogActividadess->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

