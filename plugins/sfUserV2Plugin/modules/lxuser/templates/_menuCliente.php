<div class="propiedades">
    <?php echo link_to(image_tag('icons/list_pessoas'), 'lxuser/index?radio-cad='.$sf_user->getAttribute('tc_empresa'))  ?><br />
    Listagem de<br />
    <?php echo $sf_user->getAttribute('tc_empresa') == 2 ? 'Clientes' : 'Fornecedores' ?>
</div>
<div class="propiedades propiedades-extend" style="width: 115px; border-left: 1px #ccc dotted; height: 94px;">
    <?php if($sf_request->getParameter('id')): ?>        
        <?php echo link_to(image_tag('icons/info_pessoais'), 'lxuser/editCliente?id='.$sf_request->getParameter('id'))  ?>
    <?php else:?>
        <?php echo link_to(image_tag('icons/info_pessoais'), 'lxuser/new')  ?>
    <?php endif;?>    
</div>

