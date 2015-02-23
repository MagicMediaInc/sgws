<div id="title_module">
    <div class="frameForm" >
    <h1><?php echo __('Lembrete de senhas') ?></h1>
    </div>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("There aren't items selected"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Hidden'); ?></a> </div>
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
    <?php echo link_to(__('Email'),'@default?module=remember&action=index&sort=email&by='.$by.'&page='.$changeMails->getPage().'&buscador='.$buscador) ?>
  <?php if($sort == "email"){ echo image_tag($by_page); }?>
  </th>
    </tr>
  </thead>
  <tbody>
  <?php if ($changeMails->getNbResults()): ?>
  	<?php $i=0; ?>
    <?php foreach ($changeMails as $changeMail): ?>
    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>
    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">
        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;&nbsp;</td>
                                                        <td class="borderBottomDarkGray">
                        <div class="displayTitle">
                           <div id="title">                               
                                <a href="javascrip:void(0);" class="titulo"><?php echo $changeMail->getEmail() ?></a>
                           </div>
                            <div class="row-actions">
                                <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                    
                                    <?php echo link_to(__('Enviar nova senha'),'remember/delete?id_change_mail='.$changeMail->getIdChangeMail(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Confirmar que você quer gerar uma nova senha?'))) ?>
                                    
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
            <td align="center"><strong><?php echo __('Your search did not match any result') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
  
</form>
<?php if ($changeMails->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" border="0">
	<tr>
    	<td align="left" ><i><?php echo $changeMails->getNbResults().' '.__('results') ?>  - <?php echo __('page').' '.$changeMails->getPage().' '.__('for').' ' ?> <?php echo $changeMails->getLastPage() ?></i> </td>
        <td align="right">	
        	<table>
                	<tr>
                		<?php if ($changeMails->getFirstPage()!=$changeMails->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=remember&action=index&sort='.$sort.'&by='.$by_page.'&page='.$changeMails->getFirstPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=remember&action=index&sort='.$sort.'&by='.$by_page.'&page='.$changeMails->getPreviousPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $changeMails->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $changeMails->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=remember&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>
		                        <?php if ($page != $changeMails->getCurrentMaxLink()): ?>
		                        -
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($changeMails->getLastPage()!=$changeMails->getPage()) :?>
                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=remember&action=index&page='.$changeMails->getNextPage().$bus_pagi) ?></td>
                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'remember/index?page='.$changeMails->getLastPage().$bus_pagi) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<div class="results">
            <i><?php echo $changeMails->getNbResults().' '.__('results') ?></i>
</div>
<?php endif; ?>
</div>

