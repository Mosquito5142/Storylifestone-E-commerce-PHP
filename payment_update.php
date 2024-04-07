<?php
include "config.php";
session_start();

// Assuming 'so_no' is coming from the form as a hidden input
$so_no = isset($_POST['so_no']) ? mysqli_real_escape_string($conn, $_POST['so_no']) : '';
$total = $_POST['total'];
$image_name = $_FILES["myfile"]["name"];
$image_type = $_FILES["myfile"]["type"];

// Check if a file is selected
if ($image_name <> "") {
    $image_data = addslashes(file_get_contents($_FILES["myfile"]["tmp_name"]));

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE sales_orders SET ";
    $sql .= "image_name='$image_name', image_type='$image_type', image_data='$image_data' , order_status='รอตรวจสอบ'";
    $sql .= " WHERE so_no='$so_no'";

    if (mysqli_query($conn, $sql)) {
        
        $sToken = "bOCFnn1gLxQd2Zu2Du5QnhHXHxDRqRRfgq2IQhOsTtX";
        $sMessage = "\n";
        $sMessage .= "มีรายการสั่งซื้อ"."\n";
        $sMessage .= "หมายเลขคำสั่งซื้อ : "."$so_no"."\n";
        $sMessage .= "เป็นจำนวนเงิน : "."$total"." บาท"."\n";
        $sMessage .= "และได้รับการชำระเงินเรียบร้อย กรุณาทำการตรวจสอบคำสั่งซื้อด้วย"."\n";

        $chOne = curl_init(); 
        curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
        curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt( $chOne, CURLOPT_POST, 1); 
        curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
        $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
        curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec( $chOne ); 
        
        // สิ้นสุดการเขียนข้อมูลลงในหน้าเว็บ
        ob_end_flush();
        
        // ส่งไปยังหน้าเว็บตามที่ต้องการหลังจากที่ output buffer ถูก flush
        header("Location: check_so.php?id=$so_no");
        exit(); // Ensure script stops execution after the redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "No file selected.";
}
?>
<style>
    .thanks-message {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        font-size: 36px;
        color: red;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        z-index: 9999;
    }
</style>

<script>
    // รอ 3 วินาทีก่อนที่จะไปยังหน้า index.php
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);
</script>
