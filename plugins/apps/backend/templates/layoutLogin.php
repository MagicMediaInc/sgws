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
        
        <div id="container" style="margin-top: 200px;">
            <table cellpadding="0" cellspacing="5" width="100%" border="0">
                <tr>
                    <td align="center">
                        <?php echo image_tag('logo_cte') ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><?php echo $sf_content ?></td>
                </tr>
            </table>
        </div>
        
    </body>
</html>
