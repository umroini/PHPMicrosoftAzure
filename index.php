<html>
<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top:0 solid 10px #000;
        color: #333; font-size: .85em; margin:4px 8px 16px 32px; padding:50;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 10; }
    h1 { font-size: 2em; }
    h2 { font-size: 1.75em; }
    h3 { font-size: 1.2em; }
    table { margin-top: 0.75em; }
    th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
    td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
</style>
</head>
<body>
<h1>Hi, Rempah Team!</h1>
<p>Please fill your name, email, and job, then click <strong>Submit</strong> to register.</p>
<form method="post" action="index.php" enctype="multipart/form-data">
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Job  <input type="text" name="job" id="job"/></br>
      <input type="submit" name="submit" value="Submit" />
      <input type="submit" name="submit" value="Load Data" />
</form>
<?php
    $host = "rempahappserver.database.windows.net";
    $user = "umroini";
    $pass = "Befriend1";
    $db = "rempahdb";

    try {
        $conn = new PDO( "sqlsrv:server = $host; database=$db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        echo "Failed Connect: " . $e;
    }
    
    if(isset($_POST['submit'])) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $job = $_POST['job'];
        $date = date("Y-m-d");
        
        $sql_insert = "INSERT INTO Team (name, email, job, date)
                   VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $job);
        $stmt->bindValue(4, $date);
        $stmt->execute();
    }
    catch(Exception $e) {
        echo "Failed insert: " . $e;
    }
        
    echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
    // Retrieve data
    $sql_select = "SELECT * FROM Team";
    $stmt = $conn->query($sql_select);
    $registers = $stmt->fetchAll();
    if(count($registers) > 0) {
        echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Job</th>";
        echo "<th>Date</th></tr>";
        foreach($registers as $register) {
            echo "<tr><td>".$register['name']."</td>";
            echo "<td>".$register['email']."</td>";
            echo "<td>".$register['job']."</td>";
            echo "<td>".$register['date']."</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h3>No one is currently registered.</h3>";
    }
 } catch(Exception $e) {
            echo "Failed List: " . $e;
        }
    }
?>
</body>
</html>
