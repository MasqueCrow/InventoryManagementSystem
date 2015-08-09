<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        ini_set('SMTP','smtp.sp.edu.sg' );
        ini_set('SMTP_PORT', 25);
               
        $to='tcheajiawei@hotmail.com';
        $subject='Test mail';
        $message='This is a demo message';
        $from='tcheajiawei.12@sp.edu.sg';
        $headers='From:'.$from;
        mail($to,$subject,$message,$from);
        echo 'Mail sent.';
        ?>
    </body>
</html>
