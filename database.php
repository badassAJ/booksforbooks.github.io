<?php
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$dob = $_POST['dob'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];

if (!empty($firstname)|| !empty($lastname) || !empty($dob) || !empty($email) || !empty($password)|| !empty($cpassword))
{
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "booksforbooks";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if(mysqli_connect_error())
    {
        die('Connect Error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    }
    else
    {
        $SELECT = "SELECT email From register Where email = ? Limit 1";
        $INSERT = "INSERT Into readers (firstname,lastname,dob,email,password,cpassword) values(?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if($rnum==0)
        {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssii", $firstname, $lastname, $dob, $email, $password, $cpassword);
            $stmt->execute();
            echo "New record added successfully";
        }
        else
        {
            echo " email already taken";
        }
        $stmt->close();
        $conn->close();
    }
}
 else
  {
    echo "All field are required to filled";
    die();
}
