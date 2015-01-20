<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>

<h1 class="icono_projeto">
    <a href="<?php echo url_for('@default_index?module=projeto') ?> ">projetos</a> /
    <?php echo __('Despesas do Projeto') ?> <?php echo $projeto->getCodigoSgwsProjeto() ?> 
</h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for($this->getModuleName().'/new?id_projeto='.$sf_request->getParameter('id_projeto').($sf_request->getParameter('id_tarefa') ? '&id_tarefa='.$sf_request->getParameter('id_tarefa') : '' )) ?>"><?php echo __('Nova Despesa')?></a>


<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" style="position: relative; top: 0px;"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
<div class="frameForm" style="position: relative; top: 0px;">
    <?php include_partial('global/menuProjeto') ?>
    <h2>
        Projeto <?php echo $projeto->getCodigoSgwsProjeto() ?> : 
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
            <th>Valor Previsto</th>
            <th>Valor</th>
            <th>GP</th>
            <th>ADM</th>
            <th>&nbsp;</th>
        </thead>
        <tbody>
            <?php if(count($result)): ?>
                <?php $vSubtipo = '--' ?>
                <?php $total_salida = 0 ?>
                <?php $total_salida_2 = 0 ?>
                <?php $noCat = false ?>
                <?php $contDesNoCategoriazada = 0 ?>
                <?php $totalSubtipoProjeto = 99 ?>
                <?php $totalPrevisto = 0 ?>
                <?php foreach ($result as $valor): ?>
                <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>
                <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>
                <?php $totalNoSubtipoProjeto = SaidasPeer::getSubtiposProjeto($sf_request->getParameter('id_projeto'), 0) ?>
            
                <?php if(!$valor->getCodigoSubtipo()): ?>
                    <?php $contDesNoCategoriazada++ ?> 
                <?php endif; ?>
                
                <?php if(($vSubtipo == '--' || $vSubtipo != $valor->getCodigoSubtipo()) && $valor->getCodigoSubtipo() > 0): ?>
                    <?php $valorSubtipoProjeto = ProjetoSubtipoGastoPeer::getValorProjetoSubtipo($sf_request->getParameter('id_projeto'), $valor->getCodigoSubtipo()) ?>
                    <?php $totalSubtipoProjeto = SaidasPeer::getSubtiposProjeto($sf_request->getParameter('id_projeto'), $valor->getCodigoSubtipo()) ?>
                    <tr>
                        <td colspan="13" style="background-color: #FFF; color: #000; font-weight: bold; padding-left: 5px;">
                            <?php echo $tipo  ?  $tipo->getSubtipo() : '' ?> - <?php echo $subtipo ? $subtipo->getSubtipo() : '' ?>
                            <?php //echo $valor->getCodigoSubtipo()?>
                        </td>
                    </tr>
                    <?php $iS = 1 ?>
                <?php endif; ?>
                    
                <?php if(($vSubtipo == '--' || $vSubtipo != $valor->getCodigoSubtipo()) && !$valor->getCodigoSubtipo() && !$noCat): ?>  
                    <?php $noCat = true ?>
                    <tr>
                        <td colspan="13" style="background-color: #FFF; color: #000; font-weight: bold; padding-left: 5px;">
                            <?php //echo $totalNoSubtipoProjeto ?>Despesas não categorizadas
                        </td>
                    </tr>
                <?php endif; ?>    
                <tr>
                    <td>&nbsp;</td>
                    <td> <?php echo $valor->getDatareal() ? date('d/m/Y', strtotime($valor->getDatareal())) : '' ?></td>
                    <td>
                        <?php $projeto = PropostaPeer::getDataByCodProjeto($valor->getCodigoprojeto()) ?>
                        <?php echo $projeto ? $projeto->getCodigoSgwsProjeto() : '' ?>
                    </td>
                    <td>
                        <?php $func =  lynxValida::datosTipoUsuario($valor->getCodigofuncionario() ? $valor->getCodigofuncionario() : $valor->getConfirmadopor(), 2) ?>
                        <?php echo $func['nome'] ?>
                    </td>
                    <td>
                        <?php echo $tipo  ?  $tipo->getSubtipo() : '' ?>
                    </td>
                    <td>
                        <?php echo $subtipo ? $subtipo->getSubtipo() : '' ?>
                    </td>
                    <td>
                        <?php $fornecedor =  lynxValida::datosTipoUsuario($valor->getCodigocadastro(), 3) ?>
                        <?php echo $fornecedor['nome'] ?>
                    </td>
                    <td>
                        <?php echo ucfirst($valor->getFormapagamento())  ?>
                    </td>
                    <td>&nbsp;</td>
                    <td>
                        R$ <?php echo aplication_system::monedaFormat($valor->getSaidas())  ?>
                        <?php $total_salida = $total_salida + $valor->getSaidas()  ?>
                        <?php $total_salida_2 = $total_salida_2 + $valor->getSaidas() ?>
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
                        <?php $vConfirmacao = $valor->getConfirmacao() ? '1' : '0' ?>
                        <?php if(aplication_system::esContable()): ?>
                            <?php echo jq_link_to_remote(image_tag($vConfirmacao.'.png','alt="" title="" border=0'), array(
                                'update'  =>  'confirma_'.$valor->getCodigoSaida(),
                                'url'     =>  'despesa/confirmacion?id='.$valor->getCodigoSaida().'&confirma='.$valor->getConfirmacao(),
                                'script'  => true,
                                'before'  => "$('#confirma_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                    $('#status_".$valor->getCodigoSaida()."').html('". image_tag('preload.gif','title="" alt=""')."');
                                        "
                            ));
                            ?>
                        <?php else: ?>
                            <?php echo image_tag($vConfirmacao.'.png','alt="" title="" border=0') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(aplication_system::esContable() || aplication_system::esSocio() || $projeto->getGerente() == aplication_system::getUser() ||  aplication_system::compareUserVsResponsable($valor->getCodigofuncionario())): ?>
                            <?php if(aplication_system::esContable() || aplication_system::esSocio() || $projeto->getGerente() == aplication_system::getUser() ): ?>
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
                
                <?php if(($iS == $totalSubtipoProjeto) || ($contDesNoCategoriazada == $totalNoSubtipoProjeto) ) : ?>
                <tr>
                    <td colspan="8" style="background-color: #F1F1F1; padding-left: 5px; font-weight: bold; ">
                        Subtotais:
                    </td>
                    <td style="background-color: #F1F1F1; font-weight: bold;">
                        <?php if(!$noCat): ?>
                        <?php echo $valorSubtipoProjeto ? 'R$ '.aplication_system::monedaFormat($valorSubtipoProjeto->getValor()) : '' ?>
                            <?php if($valorSubtipoProjeto): ?>
                                <?php $totalPrevisto = $totalPrevisto + $valorSubtipoProjeto->getValor() ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                    <td style="background-color: #F1F1F1; font-weight: bold;">
                        R$ <?php echo aplication_system::monedaFormat($total_salida)  ?>
                        
                    </td>
                    <td style="background-color: #F1F1F1; font-weight: bold;" colspan="3"></td>
                </tr>
                <?php $total_salida = 0 ?>
                <?php endif; ?>
                <?php $vSubtipo = $valor->getCodigoSubtipo() ?>
                <?php $iS++ ?>    
                   
                <?php endforeach; ?>
                
                
                <?php if($otrosSubtipos): ?>
                    <?php foreach ($otrosSubtipos as $val): ?>
                        <?php $subtipo = SubtipoUserPeer::retrieveByPK($val) ?>
                        <?php $tipo = SubtipoUserPeer::retrieveByPK($subtipo->getIdParent()) ?>
                        <?php $valorSubtipoProjeto = ProjetoSubtipoGastoPeer::getValorProjetoSubtipo($sf_request->getParameter('id_projeto'),$val) ?>
                        
                        <tr>
                            <td colspan="13" style="background-color: #FFF; color: #000; font-weight: bold; padding-left: 5px;">
                                <?php echo $tipo  ?  $tipo->getSubtipo() : '' ?> - <?php echo $subtipo ? $subtipo->getSubtipo() : '' ?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" style="background-color: #F1F1F1; padding-left: 5px; font-weight: bold; ">
                                Subtotais:
                            </td>
                            <td style="background-color: #F1F1F1; font-weight: bold;">
                                <?php if($valorSubtipoProjeto): ?>
                                    R$ <?php echo aplication_system::monedaFormat($valorSubtipoProjeto->getValor())  ?>
                                    <?php $totalPrevisto = $totalPrevisto + $valorSubtipoProjeto->getValor() ?>
                                <?php endif; ?>
                            </td>
                            <td style="background-color: #F1F1F1; font-weight: bold;">
                                

                            </td>
                            <td style="background-color: #F1F1F1; font-weight: bold;" colspan="3"></td>
                        </tr>

                    <?php endforeach; ?>
                <?php endif; ?>
                <tr><td colspan="11">&nbsp;</td></tr>
                <tr>
                    <td colspan="8" style="background-color: #F1F1F1; padding-left: 5px; font-weight: bold; ">
                        TOTAL:
                    </td>
                    <td style="background-color: #F1F1F1; font-weight: bold;">
                        R$ <?php echo aplication_system::monedaFormat($totalPrevisto)  ?>
                    </td>
                    <td style="background-color: #F1F1F1; font-weight: bold;">R$ <?php echo aplication_system::monedaFormat($total_salida_2)  ?></td>
                    <td style="background-color: #F1F1F1; font-weight: bold;" colspan="3"></td>
                    
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>