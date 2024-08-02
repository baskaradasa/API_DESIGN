<?php
include '../connection.php';

$userID = $_POST["user_id"] ?? '';
$selectedItems = $_POST["selectedItems"] ?? '';
$deliverySystem = $_POST["deliverySystem"] ?? '';
$paymentSystem = $_POST["paymentSystem"] ?? '';
$note = $_POST["note"] ?? '';
$totalAmount = $_POST["totalAmount"] ?? '';
$images = $_POST["images"] ?? '';
$status = $_POST["status"] ?? '';
$emailDelivery = $_POST["emailDelivery"] ?? '';
$imageFilesBase64 = $_POST["imageFile"] ?? '';

$missingFields = [];
if (empty($userID)) $missingFields[] = 'user_id';
if (empty($selectedItems)) $missingFields[] = 'selectedItems';
if (empty($totalAmount)) $missingFields[] = 'totalAmount';
if (empty($imageFilesBase64)) $missingFields[] = 'imageFile';

if (!empty($missingFields)) {
    echo json_encode(array("success" => false, "error" => "Data tidak lengkap: " . implode(', ', $missingFields)));
    exit;
}

$sqlQuery = "INSERT INTO orders_table (user_id, selectedItems, deliverySystem, paymentSystem, note, totalAmount, images, status, emailDelivery)
             VALUES ('$userID', '$selectedItems', '$deliverySystem', '$paymentSystem', '$note', '$totalAmount', '$images', '$status', '$emailDelivery')";

if ($connectNow->query($sqlQuery)) {
    $imageFilesBase64Array = explode(",", $imageFilesBase64);
    $uploadSuccess = true;

    foreach ($imageFilesBase64Array as $index => $base64) {
        $imageFileName = uniqid() . '_' . basename($images);
        $imagesFileOfTransactionProof = base64_decode($base64);

        if (!file_put_contents("../transaction_proof_images/" . $imageFileName, $imagesFileOfTransactionProof)) {
            $uploadSuccess = false;
            break; // Jika gagal menyimpan satu gambar, hentikan proses
        }
    }

    echo json_encode(array("success" => $uploadSuccess));
} else {
    echo json_encode(array("success" => false, "error" => $connectNow->error));
}
?>
