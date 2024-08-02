<?php
include '../connection.php';


$minRating = 4.4;
$limitDesignItems = 5;

$sqlQuery = "Select * FROM items_table WHERE rating>= '$minRating' ORDER BY rating DESC LIMIT $limitDesignItems";
                                                                    //5 or less than 5 newly available top rated clothes item
                                                                    //not greater than 5

$resultOfQuery = $connectNow->query($sqlQuery);

if($resultOfQuery->num_rows > 0) 
{
    $designItemsRecord = array();
    while($rowFound = $resultOfQuery->fetch_assoc())
    {
        $designItemsRecord[] = $rowFound;
    }

    echo json_encode(
        array(
            "success"=>true,
            "designItemsData"=>$designItemsRecord,
        )
    );
}
else 
{
    echo json_encode(array("success"=>false));
}