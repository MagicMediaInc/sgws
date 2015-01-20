<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<script type="text/javascript"> 
$(document).ready(function() {
      //$("#album").validationEngine();
});
</script>

<?php if ($form->getObject()->isNew()): ?>
    <?php echo jq_form_remote_tag(array(
        'url'    => 'album/saveAlbum',
        'update' => 'indicator',
        'position' => 'after',
        'loading'  => "$('#indicator').show()",
        'complete' => "$('#indicator').hide()",
        'success'  => "$('#galeria').show(); $('#edit').val('true')",
      ), array(
        'id'     => 'album',)
      ) ?>
<?php else: ?>
    <form id="album" action="<?php echo url_for('album/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id_album='.$form->getObject()->getIdAlbum() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>> 
<?php endif; ?>

<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<div class="frameForm" align="left">
  <table width="100%">
      <tr>
        <td>
            &nbsp;<?php echo __('Os campos marcados com') ?> <span class="required">*</span> <?php echo __('são requeridos ')?>
        </td>
      </tr>
      <tr>
        <td id="errorGlobal">
            <?php echo $form->renderGlobalErrors() ?>
        </td>
      </tr>
      <tr>
          <td>
              <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Voltar na lista'), '@default?module=album&action=index&'.$sf_user->getAttribute('uri_album'), array('class' => 'button')) ?>
                        </div>
                    </td>
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                                <?php echo link_to(__('Delete'), 'album/delete?id_album='.$form->getObject()->getIdAlbum(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                    <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                </tr>
            </table>
          </td>
      </tr>
    <tfoot>
      <tr>
        <td>
            <?php echo $form->renderHiddenFields(false) ?>
            <table cellspacing="4">
                <tr>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Voltar na lista'), '@default?module=album&action=index&'.$sf_user->getAttribute('uri_album'), array('class' => 'button')) ?>
                        </div>
                    </td>            
                    <?php if (!$form->getObject()->isNew()): ?>
                    <td>
                        <div class="button">
                            <?php echo link_to(__('Delete'), 'album/delete?id_album='.$form->getObject()->getIdAlbum(), array('method' => 'delete', 'confirm' => __('Tem certeza de que quer apagar os dados selecionados?'), 'class' => 'button')) ?>
                        </div>
                    </td>
                    <?php endif; ?>
                    <td>
                        <input type="submit" value="<?php echo __('Salvar') ?>" />
                    </td>
                </tr>
            </table>
        </td>
      </tr>
    </tfoot>
    <tbody>
        <tr>
            <td>                
                <table cellpadding="0" cellspacing="2" border="0" width="100%">
                  <tr style="display: none;">
                      <td><?php echo $form['id_relation']->renderLabel() ?><br />
                        <?php echo $form['id_relation'] ?>
                        <?php echo $form['id_relation']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td>
                        <?php echo $form['album_name']->renderLabel() ?><br />
                        <?php echo $form['album_name'] ?>
                        <?php echo $form['album_name']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td>
                        <?php echo $form['fecha']->renderLabel() ?><br />
                        <?php echo $form['fecha'] ?>
                        <?php echo $form['fecha']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td>
                        <?php echo $form['leyenda']->renderLabel() ?><br />
                        <?php echo $form['leyenda'] ?>
                        <?php echo $form['leyenda']->renderError() ?>
                    </td>
                  </tr>
                  <tr>
                      <td><?php echo $form['status']->renderLabel() ?><br />
                        <?php echo $form['status'] ?>
                        <?php echo $form['status']->renderError() ?>
                    </td>
                  </tr>
                </table>                
            </td>
        </tr>
    </tbody>
  </table>
</div>


<div id ="indicator" class="frameForm" align="left" style="display: none" >
    <p><?php echo image_tag('preload.gif').' Loading...'; ?></p>
</div>


<!-- GALLERY BEGINING -->
<?php use_javascript('/js/jq/jq.ajaxupload.js'); ?>
<?php echo'
<script type="text/javascript">
$(document).ready(function() {
      uploadItem("album/uploadImage");
})
</script>
'; ?>
<?php if ($form->getObject()->isNew()): ?>
<div id="galeria" class="frameForm" style="display:none" align="left">
<?php else: ?>
<div id="galeria" class="frameForm" align="left">
<?php endif; ?>
  <div class="frameHomeImages">
    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
      <thead>
        <tr>
          <th>&nbsp;<?php echo __('Uploaded images')?>
          </th>
        </tr>
      </thead>
      <tr>
        <td style="padding-left: 8px">
          <span class="msn_help">
          <b><?php echo __('Select image');?></b><br />
          <?php $appYml = sfConfig::get('app_upload_images_album');
                echo __('The image must be jpeg, jpg, png or gif<br />');
                echo __('The image must have a maximum weight of '.(sfConfig::get('app_image_size_text')).'<br /> ');
                echo __('The image should have a minimum size of '.$appYml['size_1']['image_width_1'].' x '.$appYml['size_1']['image_height_1'].' pixeles');
          ?>
          </span>



          <br/><br/>
          <div id="upload_image"> </div>
          <br/>
          <div id="msg_upload">
            <!-- <span class="msn_help"><?php //echo __('Only jpg, gif and png files allowed');?></span> -->
          </div>
          <div id="wait"></div>
        </td>
      </tr>

      <tr>
        <td height="25" align="center" valign="middle">
          <div id="fileUpload"> </div>
          <div id="mimeError" class="msn_error" style="display:none" > Extension is not allowed</div>
        </td>
      </tr>

      <tr>
        <td id="image_poster">
          <?php if (!$form->getObject()->isNew()): ?>
            <?php $items = $sf_user->getAttribute('items') ?>
              <?php foreach($items as $item): ?>
                    <?php $idContent = $item->getIdContent();
                          $appYml = sfConfig::get('app_upload_images_album');
                    ?>
                    <div id="item_<?php echo $idContent;?>" class='contentPicture'>
                      <div id="elemento_<?php echo $idContent;?>" class="imagePoster">
                        <?php if(is_file(sfConfig::get('sf_upload_dir').'/photo_album/'.$appYml['size_2']['pref_2'].'_'.$item->getImage())):?>
                          <?php echo image_tag('/uploads/photo_album/'.$appYml['size_2']['pref_2'].'_'.$item->getImage(),' alt="" title="" class="  ')  ?>
                        <?php else:?>
                          <?php echo image_tag('small_no_image.jpg')  ?>
                        <?php endif;?>
                      </div>
                      <div id="deleteHomeImage">
                      <?php echo jq_link_to_remote('Delete image', array(
                        'update'   =>  'item_'.$idContent,
                        'url'      =>  'album/deleteImage?id='.$idContent,
                        'script'   => true,
                        'confirm'  => __('Tem certeza de que quer apagar os dados selecionados?'),
                        'before'   => "$('#item_".$idContent."').html('<div align=center><br />".image_tag('preload.gif','title="" alt=""')."</div>');",
                        'complete' => "$('#item_".$idContent."').remove();"
                      ),'class="delete"');
                      ?>
                      </div>
                    </div>

              <?php endforeach; ?>
          <?php endif; ?>
          <div id="preLoad" class="contentPicture"  style="display:none">
            <br/><br/>
            <img alt="" src="/images/preload.gif"> <br/><br/><p align="center">Uploading image</p>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <br/>
  <?php if (!$form->getObject()->isNew()): ?>
    <input type="submit" value="<?php echo __('Finish') ?>" />
  <?php else: ?>
  <div class="button" style="width:45px; margin-left:5px">
    <?php echo link_to(__('Finish'), '@default?module=album&action=index&'.$sf_user->getAttribute('uri_album'), array('class' => 'button')) ?>
  </div>
  <?php endif; ?>
</div>

<?php echo jq_sortable_element('image_poster', array(
    'url' => 'album/changePosition',
    'only' => 'contentPicture',
    ),
    'response',
    '<div class="load">Arranging positions … </div><br />',
    '<div class="load">Positions saved</div><br />'
) ?>
</form>