<?php

    require('fpdf/fpdf.php');
    
    class PDF extends FPDF {
                
        function demo() {
            $this->AddPage(); 
            $this->SetFont('Arial','B',16);
            $this->Cell(40,50,'Hello World!');
        }
        
        function showDocument() {
            $this->Output();
        }
    }
?>
