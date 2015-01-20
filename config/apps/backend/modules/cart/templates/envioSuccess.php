<h1 class="icono_projeto">Meu carrinho de compras - Selecione o projeto que receberá os recursos </h1>
<?php if($meusProjetos): ?>
    <h2>Selecione o Projeto</h2><br />
    <form action="" method="POST">
        <select name="id_projeto">
            <?php foreach ($meusProjetos as $projeto): ?>
                <option value="<?php echo $projeto['id'] ?>"><?php echo $projeto['codigo_sgws_projeto'].' - '.$projeto['nome'] ?></option>
            <?php endforeach; ?>
        </select>
        <br /><br />
        <?php echo button_to('<< Voltar ', '@cart','class="button red medium"') ?>
        <input type="submit" value="Continuar" />
    </form>
<?php else: ?>
    <div class="msn_error">
        "Atualmente não há projetos"
    </div>
    <?php echo button_to('Voltar ', '@cart','class="button red medium"') ?>
<?php endif; ?>