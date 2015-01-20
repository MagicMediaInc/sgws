<?php 
    $existVinculo = VinculoUserPeer::getExistVinculo($sf_request->getParameter('user_atual'), $LxUser->getIdUser());
    $vinc = $existVinculo ? '1' : '0';
?>
<?php echo jq_link_to_remote(image_tag($vinc.'.png','alt="" title="" border=0'), array(
    'update'  =>  'vinculo_'.$LxUser->getIdUser(),
    'url'     =>  'vinculo/changeVinculo?id_user='.$LxUser->getIdUser().'&user_atual='.$sf_request->getParameter('user_atual'),
    'script'  => true,
    'before'  => "$('#vinculo_".$LxUser->getIdUser()."').html('". image_tag('preload.gif','title="" alt=""')."');"
));
?>