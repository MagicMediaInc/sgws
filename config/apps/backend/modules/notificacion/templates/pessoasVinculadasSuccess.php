<h1 style="color: #006699; font-size: 20px !important; font-weight: normal;">
    Notificação: <?php echo $Notificacion->getAsunto() ?></h1>
<h2>Pessoas Vinculadas</h2>
<br />
<?php if($vinculados):?>
    <ul>
        <?php foreach ($vinculados as $user): ?>
            <?php $usuario = $valida->datosTipoUsuario($user['id_user']); ?>
            <li style="float: left;">        
                <div id="image_photo" style="min-height: 110px; min-width: 120px; float: left;">
                    <?php if($user['foto']):  ?>
                        <?php echo image_tag('/uploads/users/med_'.$user['foto'], 'class="borderImage" width="95"')?>
                    <?php else:?>
                        <?php echo image_tag('user.jpg', 'border=0 width="95" height="" class="borderImage"');?>
                    <?php endif;?>
                </div><br />
                <div style="width: 115px; text-align: center; margin-bottom: 20px;">
                    <?php echo $user['id_user'] > 2 ? $usuario['nome'] : 'ADMINISTRADOR' ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
