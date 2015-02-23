<div class="propiedades">
    <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index')  ?><br />
    Listagem de<br />
    Pessoas
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: 1px #ccc dotted; height: 94px;">
    <?php if($sf_user->getAttribute('new_user')): ?>        
        <?php echo link_to(image_tag('icons/info_pessoais'), 'lxuser/edit?id_user='.$sf_user->getAttribute('new_user'))  ?>
    <?php else:?>
        <?php echo link_to(image_tag('icons/info_pessoais'), 'lxuser/new')  ?>
    <?php endif;?>    
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: none; height: 80px;">
    <?php echo link_to(image_tag('icons/info_bancaria'),'lxuser/infoBancaria')  ?><br />
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: none; height: 80px;">
    <?php echo image_tag('icons/info_complementaria') ?><br />
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: none; height: 80px;">
    <?php echo link_to(image_tag('icons/info_vinculo'),'lxuser/vinculos')  ?><br />
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: none; height: 80px;">
    <?php echo link_to(image_tag('icons/info_permisos'),'lxuser/permisos')  ?><br />
</div>