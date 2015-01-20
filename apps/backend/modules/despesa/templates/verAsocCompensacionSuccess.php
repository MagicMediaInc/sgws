<script type="text/javascript">
    $(document).ready(function() {
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>
<h1 class="tit-principal">
   Compensação #<?php echo $sf_request->getParameter('id') ?>
</h1>
<h2>
    <?php echo $data->getDescricaosaida() ?>
</h2>
<hr>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
        <thead>
            <th style="background-color: #5092bd; ">&nbsp;</th>
            <th style="width: 10%">Data Real</th>
            <th style="width: 9%">Projeto</th>
            <th style="width: 15%">Descrição</th>
            <th>Fornecedor / Cliente</th>
            <th>Pagamento</th>
            <th>Entrada</th>
            <th>Saídas</th>
        </thead>
        <tbody>
            <?php if(count($result)): ?>
                <?php $total = 0; ?>
                <?php $totalGral = 0; ?>
                <?php $statusPedido = 0; ?>
                <?php foreach ($result as $valor): ?>
                <?php $monto = $valor->getSaidas() ?>
                <?php $total = $valor->getOperacao() == 'e' ? $total + $monto : $total - $monto ?>
                <?php $totalGral = $total + $monto  ?>
                
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo date('d-m-Y', strtotime($valor->getDatareal())) ?></td>
                    <td>
                        <?php $projeto = PropostaPeer::getDataByCodProjeto($valor->getCodigoprojeto()) ?>
                        <?php echo $projeto ? $projeto->getCodigoSgwsProjeto() : '' ?>
                    </td>
                    <td style="width: 250px;">
                        <!-- Descripcion -->
                        <?php $func = LxUserPeer::getCurrentPassword($valor->getCodigofuncionario() ? $valor->getCodigofuncionario() : $valor->getConfirmadopor()) ?>
                        (<?php echo $valor->getCentro() ?>)
                         - <?php echo $func->getName() ?>
                        <?php echo html_entity_decode($valor->getDescricaosaida()) ?>                        
                    </td>
                    <td>
                        <?php $fornecedor =  lynxValida::datosTipoUsuario($valor->getCodigocadastro(), 3) ?>
                        <?php if($fornecedor): ?>
                        <span style="font-weight: bold;"><?php echo $fornecedor['nome'] ?></span> <br >
                        <?php endif; ?>
                        <?php $tipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoTipo()) ?>
                        <?php echo $tipo ? $tipo->getSubtipo() : '' ?>   
                        <?php $subtipo = SubtipoUserPeer::retrieveByPK($valor->getCodigoSubtipo()) ?>
                        <?php echo $subtipo ? ' - '.$subtipo->getSubtipo() : '' ?>
                        
                    </td>
                    <td><?php echo ucfirst($valor->getFormapagamento())  ?></td>
                    <td><?php echo $valor->getOperacao() == 'e' ? 'R$ '.aplication_system::monedaFormat($monto,2,",",".")  : '' ?>&nbsp;</td>
                    <td><?php echo $valor->getOperacao() == 's' ? 'R$ '.aplication_system::monedaFormat($monto,2,",",".")  : '' ?>&nbsp;</td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12"  class="center"><span class="erro_no_data" >Sua busca não gerou resultados</span></td>
                </tr>
            <?php endif; ?>
        </tbody>
        
</table>