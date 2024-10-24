<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tally Sheet</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f4f6;
            padding: 2rem 1rem;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Paper container */
        .paper-container {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            background: white;
            padding: 1in 1in;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .paper-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 1px solid #e5e7eb;
            pointer-events: none;
        }

        /* Header styles */
        .document-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .title-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .title-header h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 20.5px;
            margin-bottom: 2rem;
        }

        /* Event section styles */
        .event-section {
            margin-bottom: 2rem;
        }

        .event-name {
            font-size: 15.5px;
            margin-bottom: 0.5rem;
        }

        .event-name strong {
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 1rem 0;
        }

        /* Table styles */
        .table-container {
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }

        .table th,
        .table td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: center;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 14px;
        }

        .table td {
            font-size: 14px;
        }

        .table td strong {
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .paper-container {
                box-shadow: none;
                padding: 0.5in;
            }
        }
    </style>
</head>
<body>
    <div class="paper-container">
        <div class="paper-border"></div>
        <div class="content">
            <!-- Document Header -->
            <div class="document-header">
                <?php include('doc_header.php'); ?>
            </div>

            <!-- Title Header -->
            <div class="title-header">
                <?php   
                $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
                while ($event_row = $event_query->fetch()) { 
                ?>
                    <h3><?php echo $event_row['event_name']; ?></h3>
                    <div class="subtitle">Tally Sheet</div>
                <?php } ?>
            </div>

            <!-- Events and Results -->
            <?php   
            $sy_query = $conn->query("select DISTINCT sy FROM main_event where organizer_id='$session_id' AND mainevent_id='$active_main_event='") or die(mysql_error());
            while ($sy_row = $sy_query->fetch()) {
                $sy = $sy_row['sy'];
                
                $event_query = $conn->query("select * from main_event where organizer_id='$session_id' AND sy='$sy'") or die(mysql_error());
                while ($event_row = $event_query->fetch()) {
                    $main_event_id = $event_row['mainevent_id'];
                    
                    $SEctrQuery = $conn->query("select * FROM sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                    while($SECtr = $SEctrQuery->fetch()) {
                        $rs_subevent_id = $SECtr['subevent_id'];
            ?>
                        <div class="event-section">
                            <h4 class="event-name">EVENT: <strong><?php echo $SECtr['event_name']; ?></strong></h4>
                            <hr/>
                            
                            <div class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <?php   
                                            $contxx_query = $conn->query("select DISTINCT fullname from contestants where subevent_id='$rs_subevent_id'") or die(mysql_error());
                                            while ($contxx_row = $contxx_query->fetch()) { 
                                            ?>
                                                <th><center><?php echo $contxx_row['fullname']; ?></center></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php  
                                            $contxxz_query = $conn->query("select contestant_id from contestants where subevent_id='$rs_subevent_id'") or die(mysql_error());
                                            while ($contxxz_row = $contxxz_query->fetch()) {  
                                                $contxzID = $contxxz_row['contestant_id'];
                                                
                                                $place_query = $conn->query("select DISTINCT place_title from sub_results where contestant_id='$contxzID' AND subevent_id='$rs_subevent_id'") or die(mysql_error());
                                                while ($place_row = $place_query->fetch()) { 
                                            ?>
                                                    <td><strong><center><?php echo $place_row['place_title']; ?></center></strong></td>
                                            <?php } } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>

  <?php include('footer.php'); ?>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
 
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
 