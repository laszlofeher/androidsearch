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

$search             = $_REQUEST['words'];
$OverallRating      = (int)$_REQUEST['overallrating'];
$vet                = (int)$_REQUEST['vet'];
$UserFriendly       = (int)$_REQUEST['userfriendly'];
$ClassAplicability  = (int)$_REQUEST['classaplicability'];
$id                 = (int)$_REQUEST['id'];
$search             = filter_var($search, FILTER_SANITIZE_STRING);

$jsonArray = [];

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
} else {
    $utf8set = "set names utf8";
    $con->query($utf8set);
    
    $query = "UPDATE vetiver SET"
            . " overallrating = ?, "
            . " vetcurriculum = ?, "
            . " userfriendly = ?, "
            . " classcapacity= ? WHERE id = ?";
    if ($stmt = $con->prepare($query)) {
        $stmt->bind_param('iiiii', $OverallRating, $vet, $UserFriendly, $ClassAplicability, $id);
        
        /* execute statement */
        $stmt->execute();
        /* bind result variables */
        
        /* close statement */
        $stmt->close();
    }
}
print(0);
?>