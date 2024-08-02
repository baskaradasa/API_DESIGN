<?php
include '../connection.php';


$sqlQuery = "Select * FROM items_table ORDER BY item_id DESC";

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