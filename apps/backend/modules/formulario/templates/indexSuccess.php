<h1 class="icono_seguranca">Downloads</h1>

<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>">Novo</a>

<div id="title_module">

<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>

<?php if ($sf_user->hasFlash('listo')): ?>

    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>

<?php endif; ?>

<div class="frameForm"><style>
  #contentPpal{
    min-width: 0px !important;
    width: 0% !important;
  }
  .requerido{
    display: block;
    height: 42px;
    padding:10px 5px;
  }
  .container{
    width: 100%;
  }
  .divtitles{
    margin-right: 10px;
    display: inline-block;
    width: 135px;
    vertical-align: middle !important;
  }
  .divcontens{
    display: inline-block;
  }
  .row{
    /*vertical-align: middle;*/
    /*margin-bottom: 10px;*/
    padding:5px 0px 5px 20px;
  }
  .grey{
    background: #eee;
  }
</style>

    <?php echo form_tag('formulario/deleteAll',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>

    <table border="0">

        <tr>

            <td>

                <a name="commit" href="#" onclick="return existItems(this);"><?php echo __('Remover todos os') ?></a>

            </td>            

        </tr>

    </table>

</div>

<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">

  <thead>

    <tr>

    <th>

		&nbsp;<input type="checkbox" id="chkTodos" value="checkbox" onClick="checkTodos(this);" >&nbsp;

	</th>

  <th>

    <?php echo link_to(__('Nome'),'@default?module=formulario&action=index&sort=nome&by='.$by.'&page='.$Formularios->getPage().'&buscador='.$buscador) ?>

  <?php if($sort == "nome"){ echo image_tag($by_page); }?>

  </th>

  <th>

    <?php echo 'Arquivo' ?>

  </th>

  <th>

    <?php echo link_to(__('Status'),'@default?module=formulario&action=index&sort=status&by='.$by.'&page='.$Formularios->getPage().'&buscador='.$buscador) ?>

  <?php if($sort == "status"){ echo image_tag($by_page); }?>

  </th>

    </tr>

  </thead>

  <tbody>

  <?php if ($Formularios->getNbResults()): ?>

  	<?php $i=0; ?>

    <?php foreach ($Formularios as $Formulario): ?>

    <?php fmod($i,2)?$class = "grayBackground":$class=''; ?>

    <tr class="<?php echo $class;?>" valign="top" onmouseover="javascript:overRow(<?php echo $i; ?>);" onmouseout="javascript:outRow(<?php echo $i; ?>);">

        <td class="borderBottomDarkGray" width="28" align="center">&nbsp;<input type="checkbox" id="chk_<?php echo $Formulario->getIdFormulario() ?>" name="chk[<?php echo $Formulario->getIdFormulario() ?>]" value="<?php echo $Formulario->getIdFormulario() ?>">&nbsp;</td>

        <td class="borderBottomDarkGray">

            <div class="displayTitle">

               <div id="title">                               

                    <a href="<?php echo url_for('formulario/edit?id_formulario='.$Formulario->getIdFormulario()) ?>" class="titulo"><?php echo $Formulario->getNome() ?></a>

               </div>

                <div class="row-actions">

                    <div class="row-actions_<?php echo $i; ?>" style="display: none;">

                        <a href="<?php echo url_for('formulario/edit?id_formulario='.$Formulario->getIdFormulario(), $Formulario) ?>" class="edit"><?php echo __('Editar') ?></a>&nbsp;|&nbsp;

                        <?php echo link_to(__('Excluir'),'formulario/delete?id_formulario='.$Formulario->getIdFormulario(), array('method' => 'delete', 'class' => 'delete' , 'confirm' => __('Você tem certeza que deseja excluir esta caracterísitica?'))) ?>



                    </div>

                </div>

            </div>

        </td>

        <td  class="borderBottomDarkGray">

            <?php if($Formulario->getArquivo()): ?>

                <a href="<?php echo '/uploads/formulario/'.$Formulario->getIdFormulario().'/'.$Formulario->getArquivo() ?>" target="_blank">

                    <?php echo image_tag('file','style="position: relative; top: 4px; width:18px; "') ?>                                            

                    <?php echo $Formulario->getArquivo() ?>

                </a>

            <?php endif; ?>

        </td>

        <td class="borderBottomDarkGray" id="status_<?php echo $Formulario->getIdFormulario()?>">

                <?php echo jq_link_to_remote(image_tag($Formulario->getStatus().'.png','alt="" title="" border=0'), array(

                    'update'  =>  'status_'.$Formulario->getIdFormulario(),

                    'url'     =>  'formulario/changeStatus?id_formulario='.$Formulario->getIdFormulario().'&status='.$Formulario->getStatus(),

                    'script'  => true,

                    'before'  => "$('#status_".$Formulario->getIdFormulario()."').html('". image_tag('preload.gif','title="" alt=""')."');"

                ));

                ?>

        </td>

    </tr>

    <?php $i++; ?>

    <?php endforeach; ?>

  </tbody>

</table>

    <?php else: ?>

    <table width="100%" align="center"  border="0" cellspacing="10">

        <tr>

            <td align="center"><strong><?php echo __('Sua busca não gerou resultados') ?></strong></td>

        </tr>

    </table>

    <?php endif; ?>

  

</form>

<?php if ($Formularios->haveToPaginate()): ?>

<table width="100%" align="center" id="paginationTop" border="0">

	<tr>

    	<td align="left" ><i><?php echo $Formularios->getNbResults().' '.__('resultados') ?>  - <?php echo __('page').' '.$Formularios->getPage().' '.__('for').' ' ?> <?php echo $Formularios->getLastPage() ?></i> </td>

        <td align="right">	

        	<table>

                	<tr>

                		<?php if ($Formularios->getFirstPage()!=$Formularios->getPage()) :?>

                		<td><?php echo link_to(image_tag('icon_first_page.jpg','alt='.__('First').' title='.__('First').' border=0'), '@default?module=formulario&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Formularios->getFirstPage().$bus_pagi) ?></td>

                		<td><?php echo link_to(image_tag('icon_prew_page.jpg','alt='.__('Previous').' title='.__('Previous').' border=0'),'@default?module=formulario&action=index&sort='.$sort.'&by='.$by_page.'&page='.$Formularios->getPreviousPage().$bus_pagi) ?></td>

                		<?php endif; ?>

                		<td >

                		<?php $links = $Formularios->getLinks(); 

                        

	                        foreach ($links as $page): ?>

	                        <?php echo ($page == $Formularios->getPage()) ? '<strong>'.$page.'</strong>' : link_to($page, '@default?module=formulario&action=index&sort='.$sort.'&by='.$by_page.'&page='.$page.$bus_pagi) ?>

		                        <?php if ($page != $Formularios->getCurrentMaxLink()): ?>

		                        -

		                        <?php endif; ?>

	                        <?php endforeach; ?>

                		</td>

                		<?php if ($Formularios->getLastPage()!=$Formularios->getPage()) :?>

                		<td><?php echo link_to(image_tag('icon_next_page.jpg','alt='.__('Next').' title='.__('Next').' border=0'), '@default?module=formulario&action=index&page='.$Formularios->getNextPage().$bus_pagi) ?></td>

                		<td><?php echo link_to(image_tag('icon_last_page.jpg','alt='.__('Last').' title='.__('Last').' border=0'), 'formulario/index?page='.$Formularios->getLastPage().$bus_pagi) ?></td>

                		<?php endif; ?>

                	</tr>

            </table>

		</td>

	</tr>

</table>

<?php else: ?>

<div class="results">

    <i><?php echo $Formularios->getNbResults().' '.__('resultados') ?></i>

</div>

<?php endif; ?>

</div>



