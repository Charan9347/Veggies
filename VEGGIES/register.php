<?php       
        
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


if(!empty($username) || !empty($email)||!empty($password)){
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "veggies";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if (mysqli_connect_error()) {
            die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(username, email, password) values(?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("isssi",$username,$email, $password);
                $stmt->execute();
                echo "New record inserted sucessfully.";
                }
                            
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }

?>