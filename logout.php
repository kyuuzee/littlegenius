<!DOCTYPE html>

<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
        <?php
            
            //delete all cookies by setting the time back
            setcookie('username',"", time()-24*60*60);
            setcookie('email',"", time()-24*60*60);
            setcookie('addition',"", time()-24*60*60);
            setcookie('subtraction',"", time()-24*60*60);
            setcookie('division',"", time()-24*60*60);
            setcookie('multiplication',"", time()-24*60*60);
            header ('location: homepage.html');
        ?>
    </body>
</html>