<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <div id="topSite">
            <?php include_partial('global/header'); ?>
        </div>
        <?php include_component('home','menuTop'); ?>
        <div id="contentPpal">
            <div id="conteint">                
                <div style="margin: auto; width: 99%; min-height: 600px;">
                    <div id="content" align="center">
                        <div id="main">
                            <table cellpadding="0" cellspacing="5" width="100%" border="0">                            
                                <tr>                                
                                    <td valign="top" id="internalContent" ><?php echo $sf_content ?></td>
                                </tr>
                            </table>
                        </div>
                        <br />                        
                    </div>
                </div>                
            </div>
            <i>Dados Atualizados até 24-03-2014</i>
        </div>
        <div id="footer" class="hide"></div>
    </body>
</html>
