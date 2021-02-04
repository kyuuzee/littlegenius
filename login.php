<!DOCTYPE html>
<html>
    <head> 
        <title>Login</title>
    </head>
    
    <body>
        <?php
        
        //check connection and display error message if not succesful
        if (!($connection = mysqli_connect("localhost","root","")))
            die ("Could not connect to the database </body></html>");

        if (!mysqli_select_db($connection,"littlegenius"))
            die ("Could not open littlegenius database </body></html>");
        
        
        //escapes special characters in string
        $emailnc = mysqli_real_escape_string($connection, $_POST["email"]);
        $pwd = mysqli_real_escape_string($connection, $_POST["pwd"]);
        
        
        
        if (empty($emailnc)) {
            echo "<script>
                    alert('Please enter your email.');
                    window.location.href='homepage.html';
                    </script>";
        }
        else {
            
            //if email field is not empty, assign to variable $email
            $email = $emailnc;
            
            
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($connection,$query);

            if (!($result)) {
                echo "<p> could not execute query! </p>";
                die (mysqli_error($connection)."</body></html>");
            }



            if(mysqli_num_rows($result)==0){  //check if email is in database. If 0, means that the user has not signed up yet
                echo "<script>
                        alert('You have not signed up yet. Please signup before logging into your account.');
                        window.location.href='homepage.html';
                        </script>";
            }
            elseif(mysqli_num_rows($result)==1){

                while($row = mysqli_fetch_array($result)) {

                    $hash = md5($pwd, PASSWORD_DEFAULT);

                    if ($hash == $row[2]) {
                        mysqli_close($connection);
                        setcookie("username", $row[1],  time()+24*60*60);
                        setcookie("email", $row[0], time()+24*60*60);
                        setcookie("addition", $row[3], time()+24*60*60);
                        setcookie("subtraction", $row[4],time()+24*60*60);
                        setcookie("multiplication", $row[5], time()+24*60*60);
                        setcookie("division", $row[6], time()+24*60*60);
                        header ('location: account.html');
                    }
                    else {
                        mysqli_close($connection);
                        echo "<script>
                        alert('Wrong email or password. Please try again.');
                        window.location.href='homepage.html';
                        </script>";
                    }
                }
            }
        }

        

?>
        </body>
</html>
