<html>
<head>
<Title>Registration Form</Title>
<style type="text/css">
    body { background-color: #fff; border-top: solid 10px #000;
        color: #333; font-size: .85em; margin: 20; padding: 20;
        font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
    }
    h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
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
<form method="post" action="index.php">
      Name  <input type="text" name="name" id="name"/></br>
      Email <input type="text" name="email" id="email"/></br>
      Job  <input type="text" name="job" id="job"/></br>
      <input type="submit" name="submit" value="Submit" />
      <input type="submit" name="submit" value="Load Data" />
</form>
<?php
    // DB connection info
    //TODO: Update the values for $host, $user, $pwd, and $db
    //using the values you retrieved earlier from the portal.
    $host = "rempahappserver.database.windows.net";
    $user = "umroini";
    $pass = "Befriend1";
    $db = "rempahdb";

    // Connect to database.
    try {
        $conn = new PDO( "sqlsrv:host=$host; database=$db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        echo "Failed Connect: ".$e;
    }
    // Insert registration info
    if(isset($_POST['submit'])) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $job = $_POST['job'];
        $date = date("Y-m-d");
        // Insert data
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
        echo "Failed insert: ".$e;
    }
    echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
    // Retrieve data
    $sql_select = "SELECT * FROM Team";
    $stmt = $conn->query($sql_select);
    $teams = $stmt->fetchAll();
    if(count($teams) > 0) {
        echo "<h2>People who are registered:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Job</th>";
        echo "<th>Date</th></tr>";
        foreach($teams as $team) {
            echo "<tr><td>".$team['name']."</td>";
            echo "<td>".$team['email']."</td>";
            echo "<td>".$team['job']."</td>";
            echo "<td>".$team['date']."</td></tr>";
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
