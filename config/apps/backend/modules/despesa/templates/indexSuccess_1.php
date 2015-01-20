<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>

<h1 class="icono_projeto">
    <a href="<?php echo url_for('@default_index?module=projeto') ?> ">projetos</a> /
    <?php echo __('Despesas do Projeto') ?> #<?php echo $sf_request->getParameter('id_projeto') ?> 
</h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for($this->getModuleName().'/new?id_projeto='.$sf_request->getParameter('id_projeto').($sf_request->getParameter('id_tarefa') ? '&id_tarefa='.$sf_request->getParameter('id_tarefa') : '' )) ?>"><?php echo __('Nova Despesa')?></a>


<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" style="position: relative; top: 0px;"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm" style="position: relative; top: 0px;">
    <?php include_partial('global/menuProjeto') ?>
    <h2>
        Projeto #<?php echo $projeto->getCodigoProjeto() ?>: 
        <?php echo $projeto->getNomeProposta() ?>
        <?php if($infoTarefa): ?>
            <br />
            Tarefa #<?php echo $infoTarefa['id'].' '.$infoTarefa['tarefa'] ?> 
        <?php endif; ?>
    </h2>
    <br />
    
    
    <table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
        <thead>
            <th>&nbsp;</th>
            <th>Data Real</th>
            <th>Projeto</th>
            <th>Responsável</th>
            <th>Tipo</th>
            <th>Subtipo</th>
            <th>Fornecedor</th>
            <th>Pagamento</th>
            <th>Valor</th>
            <th>GP</th>
            <th>ADM</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
            <?php if(count($result)): ?>
                <?php foreach ($result as $valor): ?>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo date('d/m/Y', strtotime($valor->getDatareal())) ?></td>
                    <td>
                        <?php $projeto = PropostaPeer::getDataByCodProjeto($valor->getCodigoprojeto()) ?>
                        <?php echo $projeto ? $projeto->getCodigoSgwsProjeto() : '' ?>
                    </td>
                    <td>
                        <?php $func =  lynxValida::datosTipoUsuario($valor->getCodigofuncionario() ? $valor->getCodigofuncionario() : $valor->getConfirmadopor(), 2) ?>
                        <?php echo $func['nome'] ?>
                    </td>
                    <td>
                        <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>
                        <?php echo $tipo  ?  $tipo->getSubtipo() : '' ?>
                    </td>
                    <td>
                        <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>
                        <?php echo $subtipo ? $subtipo->getSubtipo() : '' ?>
                    </td>
                    <td>
                        <?php $fornecedor =  lynxValida::datosTipoUsuario($valor->getCodigocadastro(), 3) ?>
                        <?php echo $fornecedor['nome'] ?>
                    </td>
                    <td>
                        <?php echo ucfirst($valor->getFormapagamento())  ?>
                    </td>
                    <td>
                        R$ <?php echo aplication_system::monedaFormat($valor->getSaidas())  ?>
                    </td>
                    <td id="status_<?php echo $valor->getCodigoSaida() ?>" >
                        <?php if((aplication_system::esGerente() && aplication_system::compareUserVsResponsable($projeto->getGerente())) || (aplication_system::esSocio()) && !$valor->getConfirmacao()): ?>
                            <?php echo jq_link_to_remote(image_tag($valor->getBaixa().'.png','alt="" title="" border=0'), array(
                                'update'  =>  'status_'.$valor->getCodigoSaida(),
                                'url'     =>  'despesa/darBaixa?id='.$valor->getCodigoSaida().'&baixa='.$valor->getBaixa(),
                                'script'  => true,
                                'before'  => "$('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');"
                            ));
                            ?>
                        <?php else: ?>
                            <?php echo image_tag($valor->getBaixa().'.png','alt="" title="" border=0') ?>
                        <?php endif; ?>
                    </td>
                    <td id="confirma_<?php echo $valor->getCodigoSaida() ?>" >
                        <?php if(aplication_system::esContable()): ?>
                            <?php echo jq_link_to_remote(image_tag($valor->getConfirmacao().'.png','alt="" title="" border=0'), array(
                                'update'  =>  'confirma_'.$valor->getCodigoSaida(),
                                'url'     =>  'despesa/confirmacion?id='.$valor->getCodigoSaida().'&confirma='.$valor->getConfirmacao(),
                                'script'  => true,
                                'before'  => "$('#confirma_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                    $('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                        "
                            ));
                            ?>
                        <?php else: ?>
                            <?php echo image_tag($valor->getConfirmacao().'.png','alt="" title="" border=0') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(aplication_system::esContable() || aplication_system::compareUserVsResponsable($valor->getCodigofuncionario())): ?>
                            <?php if(aplication_system::esContable()): ?>
                                <a href="<?php echo url_for('@default?module=despesa&action=editFinanciero&id='.$valor->getCodigoSaida().'&id_projeto='.$sf_request->getParameter('id_projeto')) ?>">
                                    <?php echo image_tag('icons/informacoe','width=20') ?>
                                </a>
                            <?php else: ?>
                                <a href="<?php echo url_for('@default?module=despesa&action=edit&id='.$valor->getCodigoSaida()) ?>">
                                    <?php echo image_tag('icons/informacoe','width=20') ?>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>