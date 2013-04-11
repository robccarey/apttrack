<?php
    
    if(isset($_GET['id'])) {
        
        require('../connect.php');
        include('functions.php');
        $valid_session = checkLogin();
        if ($valid_session <= 0) { 
            ?>
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta HTTP-EQUIV="REFRESH" content="0; url=index.php?e=s">
                    </head>
                    <body>
                        <p>Session timeout.</p>
                        <p>Click <a href="index.php">here</a> to log in again.</p>
                    </body>
                </html>
            <?php
            return;
        } else {
            
            foreach (glob("Classes/*.php") as $filename)
            {
                include $filename;
            }
            $CURRENT_USER = new User($valid_session);
        }
        
        $html = '<html><head>';
        $html .= '<style type=\'text/css\'>
       
        table {
            border: 1px;
        }
    </style>';
        $html .= '</head><body>';
        
        $rep = new ReportTable($_GET['id'], $CURRENT_USER->getID());
        $html .= '<h1>'.$rep->getReportName().'</h1>';
        $html .= '<p>'.$rep->getReportDescription().'</p>';
        
                $html .= $rep->getStart();
                $html .= $rep->getHeader();
                $html .= $rep->getBody();
                $html .= $rep->getFooter();
                $html .= $rep->getEnd();
        
        $html .= '</body></html>';
        
        
        require('Classes/html2fpdf/html2fpdf.php');

        //echo 'read class file, ';
        
        $name="print_".time().".pdf";  
        
        //echo 'generated file name, ';
        // $name name of the PDF generated.  

        //$html=getHTML();  
        //echo 'got html, ';
        
        // getHTML() function will return the above mention HTML  

        $pdf=new HTML2FPDF();  
        //echo 'created class, ';
        $pdf->AddPage();  
        //echo 'added page, ';
        $pdf->WriteHTML($html);  
        //echo 'written html, ';
        
        $re=$pdf->Output($name,"D"); 
        //echo 'output file, ';
        
        
    }


    
?>
