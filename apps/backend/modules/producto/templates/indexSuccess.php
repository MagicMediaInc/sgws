<?php if ($sf_user->hasFlash('loja')): ?>
<input type="text" name="loja_session" id="loja_session" value ="<?php echo $sf_user->getFlash('loja'); ?>" >
<?php endif; ?>
<h1 class="icono_projeto"><?php echo __('Produtos') ?></h1>
<?php if(aplication_system::esEnviromaq()): ?>
    <a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Novo Produto')?></a>
<?php endif; ?>

<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    
  <?php include_partial('producto/menu') ?>
  <div style="padding-left: 36px; width: 100%; margin-bottom: 15px;">
        
  <form action="" method="POST">
      <input type="text" placeholder="Palavra Chave" style="width: 100px;" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" />
      &nbsp;&nbsp;<label>Lojas</label>
      <select id="loja" name="loja">
          <option value="1">SGWS</option>
          <option value="2">Enviromaq</option>
    </select>  
      &nbsp;&nbsp;<label>Categorias</label>
      <select name="categoria" id="categoria" onchange="this.form.submit();">
          <option value="" <?php echo !$sf_request->getParameter('categoria') ? 'selected' : '' ?>>Tudo</option>  
      <?php foreach ($categorias as $rs): ?>
          <option value="<?php echo $rs->getId() ?>" <?php echo $sf_request->getParameter('categoria') == $rs->getId() ? 'selected' : '' ?>><?php echo $rs->getNome() ?></option>
      <?php endforeach; ?>
    </select>  
    <input type="submit" name="buscar" id="buscar" value="Buscar" />
    <a href="<?php echo url_for($this->getModuleName().'/index') ?> "><?php echo __('Veja todo') ?></a>  
  </form>  
    </div>
  <?php if ($Productoss->getNbResults()): ?>
    <div style="padding-left: 30px; width: 100%;">
        
    <?php $i=0; ?>
    
    <?php foreach ($Productoss as $Productos): ?>
            <?php $idContent = $Productos->getId(); ?>
            <?php $valor_desconto = $Productos->getPreco() - ($Productos->getPreco() * $Productos->getDesconto() / 100); ?>
        
            <div id="item_<?php echo $idContent;?>" class="contentPicture" style="float: left; width: 185px; margin-right: 10px; margin-bottom: 20px; cursor: auto;">
                <?php if(file_exists(sfConfig::get('sf_upload_dir').'/productos/big_'.$Productos->getFoto())): ?>
                    <?php echo image_tag('/uploads/productos/big_'.$Productos->getFoto(),'class="big" width="175" height="98" ') ?>
                <?php else: ?>
                    <?php echo image_tag('semfoto.jpg', ' width="175" height="98"') ?>
                <?php endif; ?>   
                <div class="" style="padding-top: 5px; font-weight: bold; height: 30px; margin-left: 0px; width: 197px; position: relative; top: 0px; text-align: left;">
                    <?php echo $Productos->getNome() ?>
                    <br />
                    R$ <?php echo number_format($valor_desconto,2,',','.') ?>
                    <br />
                    <?php if($Productos->getEstoque() > $Productos->getMinEstoque() ):?>
                    <span><?php echo __('En Estoque') ; echo " ". $Productos->getEstoque() ;?></span>
                    <?php else:?>
                    <span><?php echo __('Estoque abaixo do mínimo')?></span>
                    <?php endif;?>
                    <br />
                </div>
                <div class="row-actions" style="height: 30px; margin-left: 0px; width: 180px; position: relative; top: 15px; left: -12px; float: left;">
                    <?php if(aplication_system::esEnviromaq()): ?>
                    <a href="<?php echo url_for('producto/edit?id='.$idContent) ?>" class="edit"><?php echo __('Editar') ?></a>&nbsp;|&nbsp;
                    <?php echo link_to(__('Excluir'),'producto/delete?id='.$idContent, array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Are you sure you want to delete the selected data?'))) ?>
                    
                    <?php endif; ?>
                    <?php if(aplication_system::isAllAction() || aplication_system::isALLGerente()): ?>
                    <li><a id="<?php echo $idContent?>" href="#" class="edit"><?php echo __('Mais detalhes') ?></a></li>
                    <?php endif; ?>
                </div>
            </div>
        
        <?php $i++; ?>
    <?php endforeach; ?>
        
    </div>    
    <?php else: ?>
    <table width="100%" align="center"  border="0" cellspacing="10">
        <tr>
            <td align="center"><strong><?php echo __('Sua busca não gerou resultados') ?></strong></td>
        </tr>
    </table>
    <?php endif; ?>
  
</form>
<?php if ($Productoss->haveToPaginate()): ?>
<table width="100%" align="center" id="paginationTop" class="pagination" border="0" style="margin-top: 40px;">
	<tr>
    	<td align="left" ><i><?php echo $Productoss->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Productoss->getPage().' '.__('for').' ' ?> <?php echo $Productoss->getLastPage() ?></i> </td>
        <td align="left">	
        	<table>
                	<tr>
                		<?php if ($Productoss->getFirstPage()!=$Productoss->getPage()) :?>
                		<td><?php echo link_to('<<', '@default?module=producto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Productoss->getFirstPage().$bus_pagi.$bus_cat) ?></td>
                		<td><?php echo link_to('<','@default?module=producto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Productoss->getPreviousPage().$bus_pagibus_cat) ?></td>
                		<?php endif; ?>
                		<td >
                		<?php $links = $Productoss->getLinks(); 
                        
	                        foreach ($links as $page): ?>
	                        <?php echo ($page == $Productoss->getPage()) ? '<a class="active" href="#" >'.$page.'</a>' : link_to($page, '@default?module=producto&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi.$bus_cat) ?>
		                        <?php if ($page != $Productoss->getCurrentMaxLink()): ?>
		                        
		                        <?php endif; ?>
	                        <?php endforeach; ?>
                		</td>
                		<?php if ($Productoss->getLastPage()!=$Productoss->getPage()) :?>
                		<td><?php echo link_to('>', '@default?module=producto&action=index&page='.$Productoss->getNextPage().$bus_pagi.$bus_cat) ?></td>
                		<td><?php echo link_to('>>', 'producto/index?page='.$Productoss->getLastPage().$bus_pagi.$bus_cat) ?></td>
                		<?php endif; ?>
                	</tr>
            </table>
		</td>
	</tr>
</table>
<?php else: ?>
<br />
        <div class="results" style="width: 100%; float: left;">
    <i><?php echo $Productoss->getNbResults().' '.__('resultados') ?></i>
</div>
<?php endif; ?>
    <input type="hidden" id="idLoja" value=" <?php echo $loja;?>">
    <input type="hidden" id="idRestring" value=" <?php echo $restring;?>">
<script type="text/javascript"> 
$(document).ready(function() {
     var idLoja = $('#idLoja').val();
     $("#loja option[value="+idLoja+"]").attr("selected",true);
     var idRestring  = $.trim($('#idRestring').val());
     
     $("#loja").change(function() {
        if($('#idRestring').val() == " " || $.trim($('#idRestring').val()) == $.trim($(this).val()) ){
            this.form.submit();
            }else{
                alert("Finalize ou cancelar o pedido em andamento para poder trocar de loja");
                $("#loja option[value="+idRestring+"]").attr("selected",true);
            }
        });
        
        $("div > li > a").click(function() {
            var url = 'producto/detalhe/id/'+$(this).attr('id')+'/loja/'+idLoja;
        if($('#idRestring').val() == " " || $.trim($('#idRestring').val()) == $.trim(idLoja) ){
            $(location).attr('href',url);
            }else{
                alert("Finalize ou cancelar o pedido em andamento para poder trocar de loja");
                $("#loja option[value="+idRestring+"]").attr("selected",true);
            }
        });
 });
 
</script>
