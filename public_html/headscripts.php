    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adaptive personalised task tracker">
    <meta name="author" content="robert.carey@mail.com">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type='text/css'>
       
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            padding-bottom: 20px;
        }
        
        #descList dt{
            overflow: visible;
            width: 170px !important;
            margin-right: 8px;
        }
        
        dd {
          padding-left: 0;  
        }
        
        section {
            padding-top: 40px;
            margin-top: -40px;
        }
        
        .sidebar-nav {
            padding: 9px 0;
        }

        .sidebar-nav-fixed {
            position:fixed;
            top:60px;
            width:21.97%;
        }
        
        @media (max-width: 767px) {
            .sidebar-nav-fixed {
                position:static;
                width:auto;
            }
            
            section {
                padding-top: 0px;
                margin-top: 0px;
            }
            
            dd {
                padding-left: 0;  
            }
            
        }

        @media (max-width: 979px) {
            .sidebar-nav-fixed {
                top:70px;
            }
            
            section {
                padding-top: 0px;
                margin-top: 0px;
            }
            
            dd {
                padding-left: 15px;  
            }
            
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-34975820-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

      </script>