
<?php use_javascript('/sfLynxSectionPlugin/js/reorder.js'); ?>
<script type="text/javascript"> 
    $(document).ready(function() {
        <?php if($sf_request->getParameter('searchByNucleo')): ?>
                $('#searchByNucleo').val(<?php echo $sf_request->getParameter('searchByNucleo') ?>);
        
        $("#test-list").sortable({
            handle : '.handle',
            update : function () {
                var order = $('#test-list').sortable('serialize');
                $("#info").load("lxsection/processSortable?"+order);
            }
          });
        <?php endif; ?>
    })
</script>
<?php //echo $sf_request->getParameter('searchByNucleo') ?>
<div id="title_module">
    <div class="frameForm" >
    <h1><?php echo __('Se&ccedil;&otilde;es') ?> do <?php echo $nombreNucleo->getNameProfile() ?></h1>
  </div>
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('error')): ?>
    <div class="msn_error"><?php echo $sf_user->getFlash('error') ?></div>
<?php endif; ?><br />
<div class="frameForm" >
    
    <table style="width: 100%; border: 0px solid #000;">
        <tr>
            <td>
                <a href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Adicionar nova Seção')?></a>                
            </td>
            <td style="text-align: right;">
                <?php if($sf_user->getAttribute('idProfile') < 2): ?>
                    <form method="POST" name="form" action="<?php echo url_for('lxsection/index') ?>">
                    Seleccione Núcleo
                    <select name="searchByNucleo" id="searchByNucleo" onChange="document.form.submit();" >
                        <option value=""><?php echo 'Todos' ?></option>
                        <?php foreach ($nucleosActivos as $nuc): ?>
                            <option value="<?php echo $nuc->getIdProfile() ?>"><?php echo $nuc->getNameProfile() ?></option>
                        <?php endforeach; ?>
                    </select>
                    </form>
                <?php endif; ?>
                <span style="text-align: right;font-style: italic; float: right;">Para ordenar las secciones arrastes y cambie de posición las filas correspondientes<br /></span>
            </td>
        </tr>
    </table>
</div>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="260" valign="top">
                <!-- TreeView Secciones -->
                <table cellpadding="0" cellspacing="0" border="0" width="100%" align="left">
                        <tr>
                                <td align="left">
                                <div id="tree-div" style="overflow:hidden; height:auto;width:250px;border:0px solid #c3daf9;  "></div>
                                <div id="resultados" style="overflow:auto; padding-bottom:50px; height:120px;width:500px;border:2px solid #c3daf9; display: none; padding-bottom:35px;"></div>
                                </td>
                        </tr>
                </table>
        </td>
        <td valign="top">
            <div id="info" style="display: none;">Waiting for update</div>
            
            <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
              <thead>
                <tr>
                <th>&nbsp;
                    
                </th>

              <th>

                <?php echo link_to(__('Nome da seção'),'@default?module=lxsection&action=index&sort=id&by='.$by.'&page='.$SfSections->getPage().'&buscador='.$buscador) ?>
              <?php if($sort == "id"){ echo image_tag($by_page,'align="top"'); }?>
              </th>
              <th style="text-align: right;">
                <?php echo link_to(__('Nucleo'),'@default?module=lxsection&action=index&sort=home&by='.$by.'&page='.$SfSections->getPage().'&buscador='.$buscador) ?>
              <?php if($sort == "home"){ echo image_tag($by_page,'align="top"'); }?>
              </th>
                </tr>
              </thead>
              <tbody>
                  <?php if ($SfSections->getNbResults()): ?>
                  <tr>
                      <td colspan="3">
                          <ul id="test-list">
                            <?php $i=0; ?>
                            <?php foreach ($SfSections as $SfSection): ?>
                                <li id="listItem_<?php echo $SfSection->getId() ?>" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);" >
                                    <div id="title">
                                        <?php if($sf_request->getParameter('searchByNucleo')): ?>
                                            <img src="/images/arrow.png" alt="move" width="16" height="16" class="handle" />
                                        <?php else: ?>
                                            <img src="/images/arrow_blank.png" alt="move" width="16" height="16"  />
                                        <?php endif; ?>
                                        <?php $nameSection = SfSectionI18nPeer::getNameSection($SfSection->getId()) ?>
                                        <a href="<?php echo url_for('lxsection/edit?id='.$SfSection->getId()) ?>" class="titulo" style="font-size: 11px;"><?php echo $nameSection['name_section'] ?></a>
                                        <div class="borderBottomDarkGray" style="float: right;">
                                            <?php $nucleo = LxProfilePeer::getNameProfile($SfSection->getIdProfile()) ;?>
                                            <?php echo $SfSection->getIdProfile() > 0 ? $nucleo->getNameProfile() : 'Root';?>
                                        </div>
                                    </div>
                                    <div class="row-actions" style="width: 350px;">
                                        <div class="row-actions_<?php echo $i; ?>" style="display: none;">
                                            <a href="<?php echo url_for('lxsection/edit?id='.$SfSection->getId(), $SfSection) ?>" class="edit"><?php echo __('Editar') ?></a>
                                            <?php if($SfSection->getDelete()==1): ?>
                                            &nbsp;|&nbsp;
                                            <?php echo link_to(__('Eliminar'),'lxsection/delete?id='.$SfSection->getId(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Voc� tem certeza de que deseja excluir os dados selecionados?'))) ?>
                                            <?php endif;?>&nbsp;|&nbsp;
                                            <a style="font-size: 11px;" href="<?php echo url_for('lxsection/editContent?id='.$SfSection->getId().'&language='.$language, $SfSection) ?>" class=""><?php echo __('Editar o conte&uacute;do') ?></a>
                                            &nbsp;|&nbsp;
                                            <a style="font-size: 11px;" href="<?php echo url_for('lxsection/asignFile?id='.$SfSection->getId(), $SfSection) ?>" class=""><?php echo __('Arquivos') ?></a>
                                            &nbsp;|&nbsp;
                                            <a style="font-size: 11px;" href="<?php echo url_for('lxsection/asignAlbum?id='.$SfSection->getId(), $SfSection) ?>" class=""><?php echo __('Album') ?></a>
                                            &nbsp;|&nbsp;
                                            <a style="font-size: 11px;" href="<?php echo url_for('lxsection/asignVideo?id='.$SfSection->getId(), $SfSection) ?>" class=""><?php echo __('Video') ?></a>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </ul>
                      </td>
                  </tr>
                  
         
              </tbody>
            </table>
            <?php else: ?>
            <table width="100%" align="center"  border="0" cellspacing="10">
                <tr>
                    <td align="center"><strong><?php echo __('Sua busca no gerou resultados') ?></strong></td>
                </tr>
            </table>
            <?php endif; ?>

                      
            <table width="100%" align="center" id="paginationTop" border="0">
                    <tr>
                    <td align="left" ><i><?php echo $SfSections->getNbResults().' '.__('resultados') ?>  </td>                    
                    </tr>
            </table>
            
        </td>
    </tr>
</table>
</div>


