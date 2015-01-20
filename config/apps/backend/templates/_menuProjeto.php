<?php $module = sfContext::getInstance()->getModuleName() ?>
<?php $action = sfContext::getInstance()->getActionName() ?>
<table width="100%" border="0" cellspacing="5" cellpadding="0" style="border-bottom:  1px dotted #CCC; margin-bottom: 20px; padding-bottom: 5px;">
        <tr>
            <td style="width: 105px;">
                    <a href="<?php echo url_for('@default?module=projeto&action=index&q=all') ?>">
                        <div class="opcoe-menu <?php echo $module == 'projeto' && $sf_request->getParameter('q') == 'all' || $module == 'projeto'  && !$sf_request->getParameter('q') ? 'opcoe-menu-active' : '' ?>"  >
                        <img src="/images/icons/list_pessoas.png"><br>
                        Listagem de Projetos    
                        </div>
                    </a>
                
            </td>
            <td style="padding-left: 10px; width: 790px;">
                <a href="<?php echo url_for('@default?module=projeto&action=index&q=pj') ?>">
                    <div class="opcoe-menu <?php echo $module == 'projeto' && $action!='listaAnalisis' && $action!='analisisCritico' && $sf_request->getParameter('q') == 'pj' || $module == 'despesa' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/subtipo_pessoas') ?><br />
                        Meus Projetos
                    </div>
                </a>
                <a href="<?php echo url_for('@default_index?module=projeto&q=prop') ?>">
                    <div class="opcoe-menu <?php echo $module == 'projeto' && $action!='listaAnalisis' && $action!='analisisCritico' && $sf_request->getParameter('q') == 'prop' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('folder_sent-48') ?><br />
                        Propostas
                    </div>
                </a>
                <a href="<?php echo url_for('@default_index?module=tarefa') ?>">
                    <div class="opcoe-menu <?php echo $module == 'tarefa' && $action == 'index' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/taks','width="48"') ?><br />
                        Minhas Tarefas
                    </div>
                </a>
                <a href="<?php echo url_for('@default_index?module=contas') ?>">
                    <div class="opcoe-menu <?php echo $module == 'contas' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/contas','width="48"') ?><br />
                        Prestação de Contas
                    </div>
                </a>
                <a href="<?php echo url_for('@default?module=tarefa&action=timeSheet') ?>">
                    <div class="opcoe-menu <?php echo $module == 'tarefa' && $action == 'timeSheet' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/timesheet','width="48"') ?><br />
                        Time Sheet
                    </div>
                </a>
                <?php if(aplication_system::esGerente() || aplication_system::esSocio() || aplication_system::esContable()): ?>
                <a href="<?php echo url_for('@default?module=projeto&action=listaAnalisis') ?>">
                    <div class="opcoe-menu <?php echo $module == 'projeto' && $action == 'listaAnalisis' ? 'opcoe-menu-active' : '' ?>"  >
                        <?php echo image_tag('icons/tools-48','width="48"') ?><br />
                        Análise crítica
                    </div>
                </a>
                <?php endif; ?>
                <a href="<?php echo url_for('@default_index?module=projeto') ?>" style="display: none;">
                    <div class="opcoe-menu"  >
                        <?php echo image_tag('icons/faturamento','width="48"') ?><br />
                        Projeção de Faturamento
                    </div>
                </a>
            </td>
            <?php if(aplication_system::esGerente() || aplication_system::esSocio() || aplication_system::esContable()): ?>
            <td>
                Para criar uma nova proposta deve primeiro ser gerada um
                <a href="<?php echo url_for('@default?module=projeto&action=listaAnalisis') ?>">Análise crítica</a>
            </td>
            <?php endif; ?>
        </tr>
    </table>