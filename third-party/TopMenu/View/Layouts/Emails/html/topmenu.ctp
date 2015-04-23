<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Topmenu.com</title>
    </head>

    <body bgcolor="#EEEEEE" style=" height:100%; margin:30px; padding:0px; font-size:12px; color:#333333; line-height:120%;font-family: Arial, Helvetica, sans-serif;">
        <div style="width:100%; background-color:#EEEEEE;">
            <div style="height:10px; width:100%; font-size:1px; "></div>
            <div style="width:90%; margin:20px auto; background-color:#FFF; height: 90%">
                <div style="width:100%">
                    <?php 
                    echo $this->Html->link(
                        $this->Html->image(FULL_BASE_URL . DS . 'img' . DS . 'topmenu_logo.png'),
                        FULL_BASE_URL,
                        array(
                            'escape' => false
                        )
                    );
                    ?>
                </div>
                <div style="width:100%">
                    <?php
                    echo $this->fetch('content');
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
