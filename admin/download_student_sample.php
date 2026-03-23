<?php
session_start();
$logger = require __DIR__ . '/../logger.php';

$file = "../uploads/student_registration/done/sample_file.csv";

$logger->info("CSV download request received",[
    "file"=>$file
]);
                                                           
if(file_exists($file)){
       
    $logger->info("CSV file found, starting download",[
        "file"=>$file
    ]);

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));

    readfile($file);

    $logger->info("CSV file downloaded successfully",[
        "file"=>$file
    ]);

    exit;           

}else{

    $logger->error("CSV file not found",[
        "file"=>$file
    ]);

    echo "Sample file not found!";
}
?>