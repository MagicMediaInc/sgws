<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>
<h1 class="icono_projeto"><?php echo __('Revisões') ?></h1>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>

<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" style="position: relative; top: 0px;"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div class="frameForm">
        <?php include_partial('global/menuProjeto') ?>
        <table width="100%" cellpadding='0' cellspacing="0" id="resultsList">
            <caption style="padding-bottom: 8px;">
                <div style="width:50% ; float: left"><h1>Registro de Histórico de Análises</h1></div>
            </caption>
            <thead>
                <th style="padding-left: 10px;">Data</th>
                <th>Proposta</th>
                <th>Responsável</th>
                <th>Situação in loco</th>
                <th>Status da Proposta</th>
                <th>Análise Inicial</th>
                <th>&nbsp;</th>
            </thead>
            <tbody>
                <?php if($revisiones): ?>
                    <?php foreach ($revisiones as $revision) : ?>
                        <tr>
                            <td style="padding-left: 10px;"><?php echo date("d-m-Y", strtotime($revision->getDataCreacion())) ?></td>
                            <td>
                                <?php if($revision->getIdProposta()): ?>
                                    <?php $prop = PropostaPeer::retrieveByPK($revision->getIdProposta()); ?>
                                    <?php echo $prop ? $prop->getCodigoSgws() : 'Aguardando' ?>
                                <?php else: ?>
                                    <?php echo 'Aguardando' ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php $respo = LxUserPeer::retrieveByPK($revision->getIdResponsavel())  ?>
                                <?php echo $respo ? $respo->getName() : '' ?>
                            </td>
                            <td>
                                <?php $statusILoco = $revision->getStatus() ? '1' : '0' ?>
                                <?php //echo $revision->getStatus() ? 'Aprovado' : 'Não aprovado' ?>
                                <?php echo image_tag($statusILoco.'.png','alt="" title="" border=0') ?>
                            </td>
                            <?php $status = $revision->getAprobacionProposta() ? '1' : '0' ?>
                            <td>
                                <?php $status = StatusPeer::retrieveByPK($revision->getAprobacionProposta()) ?>
                                <?php echo $status ? $status->getIdstatus() : ''?>
                            </td>
                            <td><?php echo image_tag($revision->getAnalisisPpal().'.png','alt="" title="" border=0') ?></td>
                            <td><a class="fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=editAnalisisCritico&id_analisis='.$revision->getId()) ?>">Ver Detalhe</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                <tr id="r-new-revision" class="hide">
                    <td style="padding-left: 10px;"><input readonly="true" type="text" size="7" name="data_rev" id="data_rev" value="<?php echo date("d-m-Y") ?> "  /></td>
                    <td><input type="text" readonly="true" size="15" name="responsavel_rev" id="responsavel_rev" value="<?php echo aplication_system::getNameUser() ?>" /></td>
                    <td>
                        <select name="situacao_rev" id="situacao_rev" >
                            <option value="1">Proposta</option>
                        </select>
                    </td>
                    <td><textarea cols="30" rows="4" id="descricao_rev" name="descricao_rev"></textarea></td>
                    <td><input type="submit" value="Concluir" /></td>
                </tr>
            </tbody>
        </table>
    </div>