<h1 class="icono_sistema"><?php echo __('Propriedades do Sistema') ?></h1>
<div id="title_module" style="margin-top: -31px;">
    <div id="renglon">
        <h2><?php echo __('Configurações Gerais')?></h2>
        &nbsp;
        <div class="propiedades">
            <?php echo image_tag('icons/clock') ?><br />
            Horas Úteis<br />
            (Billability)
        </div>
    </div>
    <div id="renglon">
        <h2><?php echo __('Pessoas')?></h2>
        &nbsp;
        <div class="base-propiedades">
            <div class="propiedades">
                <?php echo image_tag('icons/subtipo_pessoas') ?><br />
                Tipo e Subtipo de <br />
                Pessoas
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/status_pessoas') ?><br />
                Status de <br />
                Pessoas
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/perfil_pessoas') ?><br />
                Perfil de <br />
                Pessoas
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/tipo_contratacao') ?><br />
                Tipo de<br />
                Contrataçao
            </div>
            <div class="propiedades">
                <?php echo link_to(image_tag('icons/bancos'),'banco/index')  ?><br />
                Bancos
            </div>
        </div>
    </div>
    <div id="renglon">
        <h2><?php echo __('Projetos')?></h2>
        &nbsp;
        <div class="base-propiedades">
            <div class="propiedades">
                <?php echo image_tag('icons/tipo_projeto') ?><br />
                Tipo de<br />Projetos
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/status_projeto') ?><br />
                Status de<br />Projetos
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/tipo_tarefa') ?><br />
                Tipo de<br />Tarefa 
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/status_tarefa') ?><br />
                Status de<br />Tarefa
            </div>
        </div>
    </div>
    <div id="renglon">
        <h2><?php echo __('Notificações')?></h2>
        &nbsp;
        <div class="base-propiedades">
            <div class="propiedades">
                <?php echo image_tag('icons/tipo_notificacoes') ?><br />
                Tipo de<br />Notificações
            </div>
            <div class="propiedades">
                <?php echo image_tag('icons/status_notificacoes') ?><br />
                Status de<br />Notificações
            </div>
        </div>            
    </div>
</div>