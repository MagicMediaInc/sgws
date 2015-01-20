<?php if($comentarios): ?>
    <?php foreach ($comentarios as $resposta): ?>
        <?php $dataUsuario = LxUserPeer::getCurrentPassword($resposta->getIdUser()) ?>
        <div style="background-color: #F8F8F8; padding: 7px; margin-bottom: 7px;" id="resposta-<?php echo $resposta->getIdResposta() ?>">            
            <table width="100%">
                <tr>
                    <td style="width: 9%;">
                        <div id="image_photo" style="min-width: 63px; float: left;">
                            <?php if($dataUsuario->getPhoto()):  ?>
                                <?php echo image_tag('/uploads/users/med_'.$dataUsuario->getPhoto(), 'width="50"')?>
                            <?php else:?>
                                <?php echo image_tag('user.jpg', 'border=0 width="50" height="50" class="borderImage"');?>
                            <?php endif;?>
                        </div>    
                    </td>
                    <td style="vertical-align: top;">
                        <div>
                            <?php $usuario = $valida->datosTipoUsuario($resposta->getIdUser()) ?>
                            <b><?php echo $usuario['nome'] ? $usuario['nome'] : 'Administrador' ?></b><br />
                            <?php echo $resposta->getConteudo() ?> 
                        </div>
                        <?php if(sfContext::getInstance()->getUser()->getAttribute('idProfile') < 2 ||  $resposta->getIdUser() == sfContext::getInstance()->getUser()->getAttribute('idUserPanel') ): ?>
                            <div style="float: right; position: relative; right: 3px; top: -25px; width: 15px">
                                <a href="javascript:void(0);" onclick="javascript:deleteComentario(<?php echo $resposta->getIdResposta() ?>, <?php echo $resposta->getIdNotificacion() ?>);">
                                    <?php echo image_tag('delete') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>            
        </div>        
    <?php endforeach; ?>
<?php endif; ?>
