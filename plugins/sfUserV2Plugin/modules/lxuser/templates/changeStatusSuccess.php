<?php echo jq_link_to_remote(image_tag($LxUser->getStatus().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$LxUser->getIdUser(),
    'url'     =>  'lxuser/changeStatus?id_user='.$LxUser->getIdUser().'&status='.$LxUser->getStatus(),
    'script'  => true,
    'before'  => "$('#status_".$LxUser->getIdUser()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>
