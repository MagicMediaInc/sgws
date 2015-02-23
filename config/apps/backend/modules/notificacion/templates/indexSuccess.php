<?php use_helper('Date') ?>
<?php $valida = new lynxValida() ?>
<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
 <script type="text/javascript"> 
    function toogleRespostas(idNot)
    {
        $("#comentarios-" + idNot).toggle('slow');
    }
</script>

<h1 class="icono_notificaciones"><?php echo __('NOTIFICAÇÕES') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Abrir Notificação')?></a>
<div id="title_module">    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm">
    <?php echo form_tag('notificacion/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <?php if ($Notificacioness->getNbResults()): ?>
    <table border="0">
        <tr>
            <td>
                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>
            </td>
            
        </tr>
    </table>
    <?php endif; ?>
</div>
<table cellpadding="0" cellspacing="0" border="0"  id="table-info" width="100%">
  
  <tbody>
  
  <?php if ($Notificacioness->getNbResults()): ?>
    <?php $i=0; ?>
    <?php foreach ($Notificacioness as $Notificaciones): ?>
    <?php if(NotificacionesDestinatariosPeer::getCountUserInNotificacion($Notificaciones->getIdNotificacion(), sfContext::getInstance()->getUser()->getAttribute('idUserPanel'))): ?>
    <?php $dataUsuario = LxUserPeer::getCurrentPassword($Notificaciones->getIdUser()) ?>
    <?php $totalComentarios = NotificacionesRespostaPeer::totalComentarios($Notificaciones->getIdNotificacion()) ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
      <tr>
          <th colspan="8">
                <hr style="border: 1px solid #09C; " />
          </th>
      </tr>
      <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;
            <?php if($Notificaciones->getIdUser() == sfContext::getInstance()->getUser()->getAttribute('idUserPanel') ): ?>
            <input type="checkbox" id="chk_<?php echo $Notificaciones->getIdNotificacion() ?>" name="chk[<?php echo $Notificaciones->getIdNotificacion() ?>]" value="<?php echo $Notificaciones->getIdNotificacion() ?>">&nbsp;
            <?php endif; ?>
        </td>
        <td class="borderBottomDarkGray" style="width: 28%; border-right: 1px solid #CCCCCC;">
            <div class="displayTitle" style="width: 100%; position: relative; height: 100px;">                
                <div id="image_photo" style="min-height: 75px; min-width: 120px; float: left;">
                    <?php if($dataUsuario->getPhoto()):  ?>
                        <?php echo image_tag('/uploads/users/big_'.$dataUsuario->getPhoto(), 'class="borderImage"')?>
                    <?php else:?>
                        <?php echo image_tag('user.jpg', 'border=0 width="100" class="borderImage"');?>
                    <?php endif;?>
                </div>
                <div id="title" style="float: left; width: 209px;">    
                    <?php $usuario = $valida->datosTipoUsuario($Notificaciones->getIdUser()) ?>
                    <?php if($Notificaciones->getIdUser() == sfContext::getInstance()->getUser()->getAttribute('idUserPanel') ): ?>
                        <a href="<?php echo url_for('notificacion/edit?id_notificacion='.$Notificaciones->getIdNotificacion()) ?>" class="titulo-notificacion">
                            <h2 class="titulo"><?php echo $usuario['nome'] ? $usuario['nome'] : 'Administrador' ?></h2>
                        </a>
                    <?php else: ?>
                        <a href="javascript:void(0);" class="titulo-notificacion">
                            <h2 class="titulo"><?php echo $usuario['nome'] ? $usuario['nome'] : 'Administrador' ?></h2>
                        </a>
                    <?php endif; ?>
                 </div>
                 <div class="fecha" style="width: 32%;float: left;">
                     <?php echo date("d-m-Y", strtotime($Notificaciones->getFecha()) )  ?>
                 </div>                     
                 <div style="width: 50%; margin-top: 15px; float: left;">
                        <?php echo image_tag('icons/pessoas_vinculadas') ?>
                        <?php echo link_to('Pessoas Vinculadas','@default?module=notificacion&action=pessoasVinculadas&id_notificacion='.$Notificaciones->getIdNotificacion(),'style="position: relative; top: -10px;" id=pessoas_noti_'.$Notificaciones->getIdNotificacion().'') ?>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#pessoas_noti_<?php echo $Notificaciones->getIdNotificacion() ?>").fancybox({
                                        'width'			: '55%',
                                        'height'                : '75%',
                                        'autoScale'		: false,
                                        'transitionIn'		: 'none',
                                        'transitionOut'		: 'none',
                                        'type'                  : 'iframe'
                                });
                            });
                        </script>
                    </div>
                        
            </div>
            <?php if($Notificaciones->getIdUser() == sfContext::getInstance()->getUser()->getAttribute('idUserPanel') ): ?>
                    <div style="width: 109px; position: absolute; padding: 0px; margin-top: 6px; text-align: right;">
                        <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                            <a href="<?php echo url_for('notificacion/edit?id_notificacion='.$Notificaciones->getIdNotificacion(), $Notificaciones) ?>" class="edit">
                                <?php echo image_tag('edit_not','style="position: relative;top: -2px;"') ?>
                            </a>&nbsp;
                            <?php echo link_to(image_tag('delete_not'),'notificacion/delete?id_notificacion='.$Notificaciones->getIdNotificacion(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>
                        </div>
                    </div>
                    <?php endif; ?>
            <br />
            
        </td>
        <td class="borderBottomDarkGray" style="padding-left: 10px;">
            <a class="btn-comentario" href="javascript:void(0);" onclick="$('#form-comentarios-<?php echo $Notificaciones->getIdNotificacion() ?>').show();"><?php echo __('Incluir Comentário')?></a>
            <div>
                <h2>Assunto:</h2><br />
                <?php echo $Notificaciones->getAsunto() ?>  &nbsp;<br /><br />
                <h2>Descrição:</h2><br />
                <?php echo $Notificaciones->getConteudo() ?>
            </div>
            <div>
                <?php //if($totalComentarios): ?>
                <div class="head-comments">
                    <span id="tot-<?php echo $Notificaciones->getIdNotificacion() ?>"><?php echo $totalComentarios ?></span> Comentários 
                    <?php if($totalComentarios): ?>
                        [+ info ]
                    <div id="toogle-<?php echo $Notificaciones->getIdNotificacion() ?>" class="icon-toogle" onclick="javascript:toogleRespostas(<?php echo $Notificaciones->getIdNotificacion() ?>)">
                        <?php echo image_tag('down_resposta') ?>
                    </div>
                    <?php endif ?>
                </div>
                <?php //endif ?>
                <div id="comentarios-<?php echo $Notificaciones->getIdNotificacion() ?>" style="width: 99%;">
                    <div id="list-comentarios-<?php echo $Notificaciones->getIdNotificacion() ?>">
                        
                    </div>
                    <div id="form-comentarios-<?php echo $Notificaciones->getIdNotificacion() ?>" style="display: none;">
                        <textarea cols="60" rows="5" id="text-coment-<?php echo $Notificaciones->getIdNotificacion() ?>"></textarea>
                        <br /><input type="button" value="<?php echo __('Comentar') ?>" onclick="javascript:guardaComentario(<?php echo $Notificaciones->getIdNotificacion() ?>);" />
                    </div>
                </div>
                <script type="text/javascript"> 
                    $(document).ready(function() {
                         cargaRespostas(<?php echo $Notificaciones->getIdNotificacion() ?>); 
                    });
                </script>
            </div>
            
        </td>
        
    </tr>
    <?php $i++; ?>
    <?php endif; ?>
    <?php endforeach; ?>
  
  <?php else: ?>
    
        <tr>
            <td align="center" ><h2 class="erro_no_data"><?php echo __('Atualmente não há notificações') ?></h2></td>
        </tr>
    
    <?php endif; ?>  
  </tbody>
</table>
    
  
</form>
<?php if ($Notificacioness->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0" class="hide" style="display: none;">
	<tr>
    	<td align="left" ><i><?php echo $Notificacioness->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Notificacioness->getPage().' '.__('for').' ' ?> <?php echo $Notificacioness->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($Notificacioness->getFirstPage()!=$Notificacioness->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=notificacion&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Notificacioness->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=notificacion&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Notificacioness->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Notificacioness->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Notificacioness->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=notificacion&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $Notificacioness->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Notificacioness->getLastPage()!=$Notificacioness->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=notificacion&action=index&page='.$Notificacioness->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'notificacion/index?page='.$Notificacioness->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results hide" style="display: none;">
    <i><?php echo $Notificacioness->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
</div>

