<h1 class="icono_user"><?php echo __('Propriedades do Sistema') ?> -  <?php echo __('Pessoas') ?></h1>
<a class="btn-adicionar" href="<?php echo url_for($this->getModuleName().'/new') ?>"><?php echo __('Adicionar novo subtipo')?></a>
<div id="title_module">
    
<div class="msn_error" id="no_select_item" style="display: none;"><?php echo __("Nenhum item selecionado"); ?>.&nbsp;&nbsp;<a href="#" onclick="noSelectedItem();"><?php echo __('Ocultar'); ?></a> </div>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<h1 class="titulo"><?php echo __('Consulta de Subtipo') ?></h1>
    <div style="float: left; width: 250px;" >
        <?php echo form_tag('subtipo/index',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
            <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
                <thead>
                    <th style="padding-left: 10px;">
                        Tipos de Cadastro
                    </th>
                </thead>
                <tbody>
                    <?php if($tiposCadastro): ?>
                        <?php foreach ($tiposCadastro as $type): ?>
                            <tr>
                                <td class="borderBottomDarkGray" style="padding-left: 10px;">
                                    <?php echo jq_link_to_remote($type->getTipoCadastro(), array(
                                        'update'  =>  'list_subtipos',
                                        'url'     =>  'subtipo/listaSubTipos?id_tipo_cadastro='.$type->getIdTipoCadastro(),
                                        'script'  => true,
                                        'before' => "$('#list_subtipos').html('<div align=center class=ppalText>". image_tag('loading.gif','title="" alt=""')."</div>');",
                                    ));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>                        
                    <?php endif; ?>
                </tbody>
            </table>
        </form>
    </div>
    <div id="list_subtipos">
        Selecionar um tipo de cadastro para apresentar seus subtipos
    </div>


