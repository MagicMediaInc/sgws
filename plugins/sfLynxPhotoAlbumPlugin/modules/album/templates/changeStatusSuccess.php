<?php if($field == 'status'): ?>
<?php $status = $item->getStatus();
      $id = $item->getIdAlbum();
?>
<?php echo jq_link_to_remote(image_tag($status.'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$id,
    'url'     =>  'album/changeStatus?id='.$id.'&status='.$status.'&field=status',
    'script'  => true,
    'before'  => "$('#status_".$id."').html('". image_tag('preload.gif','title="" alt=""')."');"
)); ?>
<?php endif; ?>
