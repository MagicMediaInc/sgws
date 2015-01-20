<?php echo jq_link_to_remote(image_tag($LxProfile->getStatus().'.png','alt="" title="" border=0'), array(
    'update'  =>  'status_'.$LxProfile->getIdProfile(),
    'url'     =>  'lxprofile/changeStatus?id_profile='.$LxProfile->getIdProfile().'&status='.$LxProfile->getStatus(),
    'script'  => true,
    'before'  => "$('#status_".$LxProfile->getIdProfile()."').html('<div>". image_tag('preload.gif','title="" alt=""')."</div>');$('#list_permissions').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
    'complete'=> "$('#list_permissions').html('<div class=ppalText>".__(sfConfig::get('mod_lxprofile_msn_ppal_permissions'))."</div>');"
));
?>
