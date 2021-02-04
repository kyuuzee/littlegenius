<!DOCTYPE html>

<html>
	<head>
        <title>Progress for Multiplication</title>
	</head>
	<body>
        <?php
            
            //check connection and display error message if not succesful
            if (!($connection = mysqli_connect("localhost","root","")))
                die ("Could not connect to the database </body></html>");
            
            if (!mysqli_select_db($connection,"littlegenius"))
                die ("Could not open little genius database </body></html>");
        
            $email = $_COOKIE["email"];
            
            //if user has completed the questions, set the value to 1
            $query = "UPDATE users SET multiplication = 1 WHERE email = '$email'";
        
            //check if query can't be run
            if (!($result = mysqli_query($connection,$query))) {
                echo "<p> could not execute query! </p>";
                die (mysqli_error($connection)."</body></html>");
            }
            
            mysqli_close($connection);
            setcookie("multiplication",1);
            header("Location: account.html");
        ?>
	</body>
</html>