<?php
/**
 * json 
 * data = [
 * {title           =   'example title',
 *  description     =   'description example',
 *  author          =   'author example', 
 *  overallrating   =   6,
 *  vetcurriculum   =   5,
 *  userfriendly    =   5,
 *  classcapacity   =   4},
 * {title           =   'example title',
 *  description     =   'description example',
 *  author          =   'author example', 
 *  overallrating   =   6,
 *  vetcurriculum   =   5,
 *  userfriendly    =   5,
 *  classcapacity   =   4}
 * ]
 * 
 */
require 'db.php';
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
/*  Resource Type Media Library	
    Organization	
    European Basic Skills	
    Education Level	
    VET Browse	
    CopyRight
*/
$search         = $_REQUEST['words'];
$orgnization    = (int)$_REQUEST['orgnization'];
$ebs            = (int)$_REQUEST['ebs'];
$el             = (int)$_REQUEST['el'];
$vb             = (int)$_REQUEST['vb'];
$copyright      = (int)$_REQUEST['copyright'];

$search         = filter_var($search, FILTER_SANITIZE_STRING);

$jsonArray = [];

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $utf8set = "set names utf8";
    $con->query($utf8set);
    
    $query = "SELECT title, "
            . " description, "
            . " author, "
            . " overallrating, "
            . " vetcurriculum, "
            . " userfriendly, "
            . " classcapacity FROM vetiver WHERE title like '%" . $search . "%' OR description like '%" . $search . "%'";
    if ($stmt = $con->prepare($query)) {
        /* execute statement */
        $stmt->execute();
        /* bind result variables */
        $stmt->bind_result($title, 
                $description, 
                $author, 
                $overallrating, 
                $vetcurriculum, 
                $userfriendly, 
                $classcapacity);
        /* fetch values */
        while ($stmt->fetch()) {
            $jsonArray[] = array(
                'title' => $title,
                'description'   => $description,
                'author'        => $author,
                'overallrating' => $overallrating,
                'vetcurriculum' => $vetcurriculum,
                'userfriendly'  => $userfriendly,
                'classcapacity' => $classcapacity
            );
        }
        /* close statement */
        $stmt->close();
    }
}
$result = array('data' =>$jsonArray);
print(json_encode($result));
?>