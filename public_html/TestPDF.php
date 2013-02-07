<?php
    include('Reports/pdfTest.php');
    
    $pdf = new PDF();
    $pdf->demo();
    $pdf->showDocument();
?>
