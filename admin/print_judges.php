<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge List</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Paper-like background styling */
        body {
            background-color: #f0f0f0;
            padding: 20px;
        }

        .paper-container {
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 20px auto;
            max-width: 210mm; /* A4 width */
            min-height: 297mm; /* A4 height */
        }

        /* Responsive table styling */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }

            .paper-container {
                box-shadow: none;
                padding: 0;
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }

        /* Header styling */
        .event-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .event-header h2 {
            margin-bottom: 15px;
        }

        /* Table styling */
        .table {
            margin-bottom: 30px;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .judge-code {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .paper-container {
                padding: 20px;
            }

            .event-header h2 {
                font-size: 1.5rem;
            }

            .event-header h3 {
                font-size: 1.2rem;
            }

            .judge-code {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php include('header2.php'); ?>
    <?php include('session.php'); ?>

    <div class="container-fluid">
        <div class="paper-container">
            <?php 
            $sub_event_id = $_GET['sub_event_id'];
            $se_name = $_GET['se_name'];
            
            $s_event_query = $conn->query("select * from sub_event where subevent_id='$sub_event_id'") or die(mysql_error());
            while ($s_event_row = $s_event_query->fetch()) {
                $active_main_event = $s_event_row['mainevent_id'];
                
                $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
                while ($event_row = $event_query->fetch()) {
            ?>
                
           <center> <?php include('doc_header.php'); ?></center>
              <br><br>
            <div class="event-header">
                <h2><?php echo $event_row['event_name']; ?></h2>
                <h4>Judge Code for <?php echo $se_name; ?></h4>
            </div>

            <div class="table-responsive">
            <center>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Fullname</th>
                            <th>Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $judge_query = $conn->query("SELECT * FROM judges WHERE subevent_id='$sub_event_id' order by judge_ctr") or die(mysql_error());
                        while ($judge_row = $judge_query->fetch()) {
                        ?>
                        <tr>
                            <td><?php echo $judge_row['judge_ctr']; ?></td>
                            <td><?php echo $judge_row['fullname']; ?></td>
                            <td style="font-size: 10px;"><span class="judge-code"><?php echo $judge_row['code']; ?></span></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                        </center>
            </div>

            <?php 
                }
            } 
            ?>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
 
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    <script src="..//assets/js/jquery.js"></script>
    <script src="..//assets/js/bootstrap-transition.js"></script>
    <script src="..//assets/js/bootstrap-alert.js"></script>
    <script src="..//assets/js/bootstrap-modal.js"></script>
    <script src="..//assets/js/bootstrap-dropdown.js"></script>
    <script src="..//assets/js/bootstrap-scrollspy.js"></script>
    <script src="..//assets/js/bootstrap-tab.js"></script>
    <script src="..//assets/js/bootstrap-tooltip.js"></script>
    <script src="..//assets/js/bootstrap-popover.js"></script>
    <script src="..//assets/js/bootstrap-button.js"></script>
    <script src="..//assets/js/bootstrap-collapse.js"></script>
    <script src="..//assets/js/bootstrap-carousel.js"></script>
    <script src="..//assets/js/bootstrap-typeahead.js"></script>
    <script src="..//assets/js/bootstrap-affix.js"></script>
    <script src="..//assets/js/holder/holder.js"></script>
    <script src="..//assets/js/google-code-prettify/prettify.js"></script>
    <script src="..//assets/js/application.js"></script>

  </body>
</html>
