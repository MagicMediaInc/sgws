<?php use_stylesheet('/js/fancybox/jquery.fancybox.css') ?>
<?php use_javascript('fancybox/jquery.fancybox.js') ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox({'width' : '60%','height' : '60%' , 'autoScale' : false});
        $('#resultsList td').addClass('borderBottomDarkGray');
    });
</script>
<h1 class="icono_projeto"><?php echo __('Análise Crítica') ?></h1>
<?php if(aplication_system::esSocio() || aplication_system::esUsuarioRoot() || aplication_system::isGerenteTecnicoComercial() ): ?>
<a class="btn-adicionar fancybox fancybox.iframe" href="<?php echo url_for('@default?module=projeto&action=analisisCritico') ?>"> Incluir Proposta</a>
<?php endif; ?>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready" style="position: relative; top: 0px;"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>
    <div class="frameForm">
        
        <!--filtro de busqueda-->
        <?php echo form_tag('projeto/listaAnalisis',array('name' => 'frmChk', 'id' => 'frmChk','style'=>'margin:0px')) ?>
    <?php include_partial('global/menuProjeto') ?>
    <table width="100%" border="0" cellspacing="5" cellpadding="0" style="border-bottom: 1px solid #E5E5E5; margin-bottom: 2px;">
      <tr>
          <td width="318" colspan="2">
              <span id="title_id"class="tit-principal"></span>
              <br /><br />
          </td>        
      </tr>
          <td align="left" width="9%">
            <table width="100%" border="0" cellspacing="3" cellpadding="0">
                <tr>
                  <td width="9%" align="left">
                      <label>Tipo</label><br />
                      <select id="tipo_busqueda" name="tipo_busqueda">  
                          <option value="1" <?php echo $sf_request->getParameter('tipo_busqueda') == 1 ? 'selected' : '' ?>>Gerente</option>
                          <option value="2" <?php echo $sf_request->getParameter('tipo_busqueda') == 2 ? 'selected' : '' ?>>Cliente</option>
                          <option value="3" <?php echo $sf_request->getParameter('tipo_busqueda') == 3 ? 'selected' : '' ?>>Responsável Técnico</option>
                          <option value="4" <?php echo $sf_request->getParameter('tipo_busqueda') == 4 ? 'selected' : '' ?>>Responsável Comercial</option>
                      </select>
                  </td>
                </tr>
            </table>    
          </td>
          <td>
            <label>Palavra Chave</label><br />
            <span class="propiedades propiedades-extend" style="width: 450px; border-left: 1px #ccc dotted; height: 120px;">
                <input type="text" style="width: 290px;" placeholder="Gerente, Cliente" name="buscador" id="funkystyling" value="<?php echo $sf_request->getParameter('buscador') ?>" />
                <input type="submit" name="search" id="busca" value="Buscar" />
            </span>
          </td>
     </tr>
     <tr>
         <td colspan="2">&nbsp;</td>
     </tr>
    </table>    
</form>
        <!--cierre filtro-->
        <table width="100%" cellpadding='0' cellspacing="0" id="resultsList">
            <caption style="padding-bottom: 8px;">
                <div style="width:50% ; float: left"><h1>Registro de Histórico de Análises</h1></div>
            </caption>
            <thead>
                <th style="padding-left: 10px;">Data</th>
                <th>Proposta</th>
                <th>Responsável Técnico </th>								<th>Responsável Comercial </th>				
                <th>Cliente</th>
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
                                <?php $respoTecnico = LxUserPeer::retrieveByPK($revision->getResponsableTecnico())  ?>
                                <?php echo $respoTecnico ? $respoTecnico->getName() : '' ?>
                            </td>														<td>                                <?php $respoComercial = LxUserPeer::retrieveByPK($revision->getResponsableComercial())  ?>                                <?php echo $respoComercial ? $respoComercial->getName() : '' ?>                            </td>
                             <td>
                                <?php $respo = CadastroJuridicaPeer::retrieveByPK($revision->getIdCliente())  ?>
                                <?php echo $respo ? $respo->getNomeFantasia() : '' ?>
                            </td>
                            <td>
                                <?php $statusILoco = $revision->getStatus() ? '1' : '0' ?>
                                <?php //echo $revision->getStatus() ? 'Aprovado' : 'Não aprovado' ?>
                                <?php echo image_tag($statusILoco.'.png','alt="" title="" border=0') ?>
                            </td>
                            <?php $status = $revision->getAprobacionProposta() ? '1' : '0' ?>
                            <td>
                                <?php $status = StatusPeer::retrieveByPK($revision->getAprobacionProposta()) ?>
                                <?php echo $status ? (($status->getStatus() > 3) ? 'Vendida' : $status->getIdstatus()) : ''?>
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