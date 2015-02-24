<h1 class="tit-principal">Projeto <?php echo $codigoProjeto ?></h1>
<h2>Equipe da Tarefa sdfgf: <?php echo $descricao->getTarefa() ?></h2>
<?php if ($sf_user->hasFlash('listo')): ?>
    <div class="msn_ready"><?php echo $sf_user->getFlash('listo') ?></div>
<?php endif; ?>


<div class="clear" style="margin-top: 15px;"></div>
<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
  <thead>
    <tr>
        <th style="width: 2%">&nbsp;</th>
        <th style="width: 25%;">Nome</th>
        <th style="width: 17%;">Tipo de Pessoa</th>
        
        <th style="width: 10%;">Telefone</th>
        <th style="width: 10%;">Celular</th>
        <th style="width: 17%;">Email</th>
    </tr>
  </thead>
  <tbody>
    <?php if($equipo): ?> 
      <?php foreach ($equipo as $func): ?>
        <?php $usu = LxUserPeer::retrieveByPK($func->getCodigofuncionario()) ?>
        <?php $usud = CadastroFisicaPeer::getNamePessoa($func->getCodigofuncionario()) ?>
        <tr>
            <td class="borderBottomDarkGray"></td>
            <td class="borderBottomDarkGray"><?php echo $usu->getName()  ?></td>
            <td class="borderBottomDarkGray">Funcionario</td>
            <td class="borderBottomDarkGray"><?php echo $usud['telefone']  ?></td>
            <td class="borderBottomDarkGray"><?php echo $usud['celular']  ?></td>
            <td class="borderBottomDarkGray"><?php echo $usu->getEmail() ?></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?> 
  </tbody>
  
</table>