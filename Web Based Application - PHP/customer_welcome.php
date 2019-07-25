<?php
    include('connection.php');




    session_start();

if(!$_SESSION['cid']){
    header("location: index.php");
}

    if($_SERVER["REQUEST_METHOD"] == "POST") {


        $cid = $_SESSION['cid'];

        $aid = $_POST['AccountID'];

        $queryowns ="DELETE FROM owns WHERE aid='$aid'";

        $deleteowns =mysqli_query($database,$queryowns);


        $queryaccount ="DELETE FROM account WHERE aid='$aid' ";

        $deleteaccount =mysqli_query($database,$queryaccount);


        if(!$deleteaccount && !$deleteowns ){
            echo  "<script type='text/javascript'>
                        window.alert('Account cannot closed' );
                        window.location.href = 'customer_welcome.php'
                   </script>";
        }
        else{
            echo "<script type='text/javascript'>
                        window.alert('Account is closed');
                        window.location.href = 'customer_welcome.php'
             </script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Index</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=divice-width, inital-scale=1, shrink-to-fit= no">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        .button {
            display: inline-block;
            padding: 10px 25px;
            font-size: 24px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;
        }

        .button:hover {background-color: #3e8e41}

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }

        .button1 {padding: 2px 25px;
                  background-color: red;}
    </style>

    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>

</head>
<body>

<nav  class="navbar navbar-inverse ">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand " href="customer_welcome.php">Banking Application</a>
        </div>

        <ul class="nav navbar-nav navbar-right" >
            <li><a href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Previous Page</a></li>
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Log Out</a></li>
        </ul>

    </div>
</nav>

<div  class="container">

    <?php
    echo "<h3 align='center'>Welcome  " . $_SESSION['name'] . "</h3>";
    echo "<p align='center'>Customer ID: " . $_SESSION['cid'] . "</p>";
    ?>

    <div class="panel container-fluid">
        <h1 align="center"> Account Information</h1>
        <?php



        $result = mysqli_query($database, "SELECT aid, branch, balance,openDate 
                  FROM customer NATURAL JOIN owns NATURAL JOIN account 
                  WHERE cid = " .$_SESSION['cid']);
        if (!$result) {
            printf("Error: %s\n", mysqli_error($database));
            exit();
        }

        echo "<table class=\"w3-table w3-striped w3-border\">
            <tr>
                <th>Account ID</th>
                <th>Branch</th>
                <th>Balance</th>
                <th>OpenDate</th>
                <th>Close</th>
            </tr>";
        while($res = mysqli_fetch_array($result)) {
            echo "<tr>";
                echo "<td>".$res['aid']."</td>";
                echo "<td>".$res['branch']."</td>";
                echo "<td>".$res['balance']."</td>";
                echo "<td>".$res['openDate']."</td>";
                echo "<td> <form action=\"\" method=\"post\">
                                <button name=\"AccountID\" class=\"button button1\" value=".$res['aid'] .">
                                    Close
                                 </button> 
                           </form>
                    </td>";
            echo "</tr>";
        }
        echo "</table>";
        ?>
    </div>
    <div class="w3-center">
        <div class="w3-bar">
            <a href="money_transfer.php" class="button" >Money Transfer</a>
        </div>
    </div>
</div>



</body>
</html>