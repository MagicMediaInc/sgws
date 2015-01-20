<?php use_helper('Text') ?>
<div id="title_module">
    <div class="frameForm" >
    <h1><?php echo __('Galeria') ?></h1>
    </div>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("There aren't items selected"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Hidden'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm">
    <?php echo form_tag('album/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <table border="0">
        <tr>
            <td>

                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Eliminar todos') ?></a>
            </td>
            <td>&nbsp;|&nbsp;</td>
            <td>
                <a href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo álbum de fotos')?></a>
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
    <?php echo link_to(__('Nome do álbum'),'@default?module=album&action=index&sort=album_name&by='.$by.'&page='.$SfAlbums->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "album_name"){ echo image_tag($by_page); }?>
  </th>
  
  <th>
    <?php echo link_to(__('Notícias relacionadas'),'@default?module=album&action=index&sort=id_relation&by='.$by.'&page='.$SfAlbums->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "id_relation"){ echo image_tag($by_page); }?>
  </th>
  <th>
    <?php echo link_to(__('Status'),'@default?module=album&action=index&sort=status&by='.$by.'&page='.$SfAlbums->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "status"){ echo image_tag($by_page,'align="top"'); }?>
  </th>
  <?php if($sf_user->getAttribute('idProfile') == 1 || $sf_user->getAttribute('idProfile') == 2):?>
    <!--<th>
        <?php //echo __('Visível') ?>
    </th>-->
  <?php endif;?>
    </tr>
  </thead>
  <tbody>
  <?php if ($SfAlbums->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($SfAlbums as $SfAlbum): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
            <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $SfAlbum->getIdAlbum() ?>" name="chk[<?php echo $SfAlbum->getIdAlbum() ?>]" value="<?php echo $SfAlbum->getIdAlbum() ?>">&nbsp;</td>
            <td class="borderBottomDarkGray">
                <div class="displayTitle">
                    <div id="title">                               
                        <a href="<?php echo url_for('album/edit?id_album='.$SfAlbum->getIdAlbum()) ?>" class="titulo"><?php echo truncate_text($SfAlbum->getAlbumName(), 80) ?></a>
                    </div>
                    <div class="row-actions">
                        <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                            <a href="<?php echo url_for('album/edit?id_album='.$SfAlbum->getIdAlbum(), $SfAlbum) ?>" class="edit"><?php echo __('Edit') ?></a>&nbsp;|&nbsp;
                            <?php echo link_to(__('Delete'),'album/delete?id_album='.$SfAlbum->getIdAlbum(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'))) ?>

                        </div>
                    </div>
                </div>
            </td>
            <td class="borderBottomDarkGray">
                <?php if(!$SfAlbum->getIdRelation() == 0): ?>
                    <?php echo $SfAlbum->getIdRelation() ?>
                    <?php $relatedName = LxProfilePeer::retrieveByPK($SfAlbum->getIdRelation());
                    echo truncate_text($relatedName->getNameProfile(), 80) ?>&nbsp;
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </td>
            <?php 
                $status = $SfAlbum->getStatus();
                $id = $SfAlbum->getIdAlbum();
                //Valida que el usuario tenga la credencial para modificar el status
                if(!sfContext::getInstance()->getUser()->hasCredential('sf_album_update')):
            ?>
            <td class="borderBottomDarkGray" id="status_<?php echo $id; ?>">
                <?php echo image_tag($status.'.png','alt="" title="" border=0') ?>
            </td>
            <?php else: ?>
            <td class="borderBottomDarkGray" id="status_<?php echo $id; ?>">
                    <?php echo jq_link_to_remote(image_tag($status.'.png','alt="" title="" border=0'), array(
                        'update'  =>  'status_'.$id,
                        'url'     =>  'album/changeStatus?id='.$id.'&status='.$status.'&field=status',
                        'script'  => true,
                        'before'  => "$('#status_".$id."').html('". image_tag('preload.gif','title="" alt=""')."');"
                    )); ?>
            </td>
            <?php if($sf_user->getAttribute('idProfile') == 1 || $sf_user->getAttribute('idProfile') == 2):?>
           <!-- <td class="borderBottomDarkGray" id="status_<?php echo $SfAlbum->getIdAlbum(); ?>">
                <?php //echo link_to(image_tag('permission'),'@default?module=album&action=visualizacionNucleo&id_album='.$SfAlbum->getIdAlbum(),'class=login id=permission_album_'.$SfAlbum->getIdAlbum().'') ?>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $("#permission_album_<?php echo $SfAlbum->getIdAlbum() ?>").fancybox({
                                'width'			: '55%',
                                'height'                : '75%',
                                'autoScale'		: false,
                                'transitionIn'		: 'none',
                                'transitionOut'		: 'none',
                                'type'                  : 'iframe'
                        });
                    });
                </script>
            </td>-->
        <?php endif; ?>
        </tr>
        <?php endif; ?>
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
<?php if ($SfAlbums->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $SfAlbums->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$SfAlbums->getPage().' '.__('for').' ' ?> <?php echo $SfAlbums->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($SfAlbums->getFirstPage()!=$SfAlbums->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=album&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfAlbums->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=album&action=index&sort='.$sort.'&by='.$by_page.'&page='.$SfAlbums->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $SfAlbums->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $SfAlbums->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=album&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $SfAlbums->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($SfAlbums->getLastPage()!=$SfAlbums->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=album&action=index&page='.$SfAlbums->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'album/index?page='.$SfAlbums->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
            <i><?php echo $SfAlbums->getNbResults().' '.__('results') ?></i>
</div>
<?php endif; ?>
</div>

