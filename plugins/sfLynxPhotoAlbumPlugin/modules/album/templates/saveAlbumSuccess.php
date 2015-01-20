<table>
    <tr>
        <td align="center">
            <div style="margin:0 auto; margin-left: 15px;" id="image_poster" >
            <?php foreach ($Posters as $Poster): ?>
                <div id="elemento_<?php echo $Poster->getIdPoster();?>" class="contentPicture">
                    <div class="imagePoster">
                        <?php if(is_file(sfConfig::get('app_directory_poster').'view_'.$Poster->getImage())):?>
                            <?php echo image_tag('/uploads/posters/view_'.$Poster->getImage(),' alt="" title="" class=""  ')  ?>
                        <?php else:?>
                            <?php echo image_tag('no_image_available.gif','width="200px" height="180px" ')  ?>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </td>
    </tr>
</table>