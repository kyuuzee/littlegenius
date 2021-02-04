<!DOCTYPE html>

<html>
	<head>
        <title>Signup</title>
	</head>
	<body>
        <?php
        
            //check connection and display error message if not succesful
            if (!($connection = mysqli_connect("localhost","root","")))
                die ("Could not connect to the database </body></html>");
            
            if (!mysqli_select_db($connection,"littlegenius"))
                die ("Could not open little genius database </body></html>");
            
            extract($_POST);
            $email = '';
            $username = '';
            $pwd = '';
        
        
            //escapes special characters in string
            $emailnc = mysqli_real_escape_string($connection, $_POST["email"]);
            $pwdnc = mysqli_real_escape_string($connection, $_POST["pwd"]);
            $usernamenc = mysqli_real_escape_string($connection, $_POST["username"]);
            $pwdlength = strlen($pwdnc);
            
        

            if (empty($usernamenc) || empty($pwdnc) || empty($emailnc)) {   //check if any of the fields are empty
                 echo "<script>
                    alert('Fields cannot be empty. Please sign up again.');
                    window.location.href='homepage.html';
                    </script>";
            }
            else {
                
                if (filter_var($emailnc, FILTER_VALIDATE_EMAIL)) { //check if email is of the correct format. If yes, assign to variable $email
                  $email = $emailnc;
                } 
                else {
                   echo "<script>
                        alert('Invalid email. Please sign up again.');
                        window.location.href='homepage.html';
                        </script>";
                }


                if ($pwdlength < 6){ //check length of password (6-20 chars)
                    echo "<script>
                        alert('Password must be longer than 6 characters. Please sign up again.');
                        window.location.href='homepage.html';
                        </script>";
                }
                elseif ($pwdlength > 20){
                   echo "<script>
                            alert('Password cannot exceed 20 characters. Please sign up again.');
                            window.location.href='homepage.html';
                            </script>";
                }
                else { //if password is in that range, assign to $pwd variable
                    $pwd = $pwdnc;
                }
            }
        
            
            // check if email already existed in database
            $query1 = "SELECT * FROM users WHERE email = '$emailnc'";
            $result1 = mysqli_query($connection,$query1);
            if (mysqli_num_rows($result1) > 0) {
                echo "<script>
                            alert('Email has already been used. Please use a different email.');
                            window.location.href='homepage.html';
                            </script>";
            }
            
            //if username field is not empty, assign to variable $username
            $username = $usernamenc;
        
            //hashing the password
            $hash = md5($pwd, PASSWORD_DEFAULT);
            
            $query2 = "INSERT INTO users VALUES ('$email','$username','$hash',0,0,0,0)"; //set value 0,0,0,0 for add, sub, mult, div
        
            if (!($result = mysqli_query($connection,$query2))) {
                echo "<p> could not execute query! </p>";
                die (mysqli_error($connection)."</body></html>");
            }
            
            mysqli_close($connection);
            setcookie("username",$username,time()+24*60*60);
            setcookie("email",$email,time()+24*60*60 );
            setcookie("addition", 0, time()+24*60*60);
            setcookie("subtraction", 0, time()+24*60*60);
            setcookie("multiplication", 0, time()+24*60*60);
            setcookie("division", 0, time()+24*60*60);
            header("Location: account.html");
        ?>
	</body>
</html>