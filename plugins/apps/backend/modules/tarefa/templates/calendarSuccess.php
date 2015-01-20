<table cellpadding="0" cellspacing="0" border="0"  id="resultsList">
    <thead>
        <tr>
            <th style="width: 8%; padding-left: 10px;">PROJETO</th>
            <th style="width: 24%;">TAREFA</th>
            <th style="width: 10%;">Segunda</th>
            <th style="width: 10%;">Terça</th>
            <th style="width: 10%;">Quarta</th>
            <th style="width: 10%;">Quinta</th>
            <th style="width: 10%;">Sexta</th>
            <th style="width: 10%;">Sábado</th>
            <th style="width: 10%;">Domingo</th>
        </tr>
    </thead>
    <tbody>
        <?php if($lista): ?>
        <?php foreach ($lista as $la): ?>        
        <tr>
            <td style="width: 15%">
                <?php echo globalFunctions::getNomeProjeto($la['projeto']);  ?>
            </td>
            <td><?php echo $la['nome_tarefa'] ?> </td>
            <?php $start = $inicio; ?>
            <?php for($i = 0; $i < 7 ; $i++): ?>            
            <td>
                <?php $actividad = TempotarefaPeer::getHorasTrabajadasDia($la['tarefa'], $start); ?>
                <?php echo $actividad['horas'] ?  $actividad['horas'].' horas' : '' ?>
            </td>
            <?php $start = date("Y-m-d", strtotime("$start + 1 day")); ?>
            <?php endfor; ?>
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>