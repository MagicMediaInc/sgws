<?php error_reporting(0); ?>
<script type="text/javascript">
        $('#fileUpload').html("");
        $("#fileUpload").animate({opacity: 100}, 1500 );
</script>
<?php if(!$errorImage):?>
    <script type="text/javascript">
        //$('#fileUpload').html("<img src=/images/1.png / border=/0/> File uploaded");
        $('#fileUpload').html("<div class='msn_ready' >File uploaded </div>");
        $("#fileUpload").animate({opacity: 0}, 3000);
    </script>

<?php $idContent = $item->getIdContent();
      $appYml = sfConfig::get('app_upload_images_album');
?>
<div id="item_<?php echo $idContent;?>" class='contentPicture'>
  <div id="elemento_<?php echo $idContent;?>" class="imagePoster">
    <?php if(is_file(sfConfig::get('sf_upload_dir').'/photo_album/'.$appYml['size_2']['pref_2'].'_'.$item->getImage())):?>
      <?php echo image_tag('/uploads/photo_album/'.$appYml['size_2']['pref_2'].'_'.$item->getImage(),' alt="" title="" class="  ')  ?>
    <?php else:?>
      <?php echo image_tag('no_image.jpg','width="200px" height="180px" ')  ?>
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
<?php else: ?>
    <script type="text/javascript">
        $('#fileUpload').html("The size of the image is too big, it can't be more than <?php echo sfConfig::get('app_image_size_max')?> Kb. Try another image");
        $("#fileUpload").animate({opacity: 0}, 5000);
    </script>
<?php endif;?>

