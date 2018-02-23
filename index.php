<?php

require 'db.php';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
$search = $_REQUEST['search'];
$search = filter_var($search, FILTER_SANITIZE_STRING);
$jsonArray = [];

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $utf8set = "set names utf8";
    $con->query($utf8set);
    
    $query = "SELECT title, description FROM vetiver WHERE title like '%" . $search . "%' OR description like '%" . $search . "%'";
    if ($stmt = $con->prepare($query)) {
        /* execute statement */
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($title, $description);
        
        
        /* fetch values */
        while ($stmt->fetch()) {
            $jsonArray[] = array(
                'title' => $title,
                'description' => $description
            );
        }
        /* close statement */
        $stmt->close();
    }
}
$result = array('data' =>$jsonArray);
print(json_encode($result));
?>