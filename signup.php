<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['signup'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
            
            if($stmt = $conn->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $username, $email, $password);
                
                // Attempt to execute the prepared statement
                if($stmt->execute()){
                    echo "New record created successfully";
                } else{
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } 
?>