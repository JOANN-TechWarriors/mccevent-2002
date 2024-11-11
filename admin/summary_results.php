<!DOCTYPE html>
<html lang="en">
   
<?php
include('header.php');
include('session.php');
$active_main_event=$_GET['main_event_id'];
?>
 
<head>
    <style>
        /* Bond paper simulation */
        html {
            background: #f5f5f5; /* Light gray background for the outer area */
            min-height: 100%;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        
        body {
            background: white; /* Pure white for the bond paper */
            width: 8.5in;
            min-height: 13in; /* Long bond paper size */
            margin: 0 auto;
            padding: 0.5in;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            position: relative;
        }

        /* Paper edges effect */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(0,0,0,0.1), transparent);
        }

        /* Print settings */
        @page {
            size: 8.5in 13in;
            margin: 0;
        }
        
        @media print {
            html {
                background: none;
                padding: 0;
            }
            
            body {
                box-shadow: none;
                margin: 0;
                padding: 0.5in;
                background: white;
            }
        }
        
        .container {
            width: 100% !important;
            max-width: none;
            margin: 0;
            padding: 0;
            background: white; /* Ensure container is also white */
        }
        
        .span12 {
            width: 100%;
            margin: 0;
            background: white; /* Ensure span12 is white */
        }
        
        /* Table styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 1rem;
            -webkit-overflow-scrolling: touch;
            background: white; /* Ensure tables have white background */
        }
        
        table {
            width: 100% !important;
            margin-bottom: 1rem;
            border-collapse: collapse;
            page-break-inside: auto;
            background: white; /* White background for tables */
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        table.table-bordered {
            border: 1px solid #dee2e6;
        }
        
        table.table-bordered th,
        table.table-bordered td {
            border: 1px solid #dee2e6;
            padding: 0.5rem;
            vertical-align: middle;
            text-align: center;
            background: white; /* White background for cells */
        }

        /* Header styles */
        .header-title {
            text-align: center;
            margin-bottom: 1in;
            padding-top: 0.5in;
            background: white; /* White background for header */
        }
        
        .event-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .tally-sheet-title {
            font-size: 20.5px;
            margin-top: 10px;
        }
        
        /* Sub-event styles */
        .sub-event {
            margin: 30px 0;
            page-break-inside: avoid;
            background: white; /* White background for sub-events */
        }
        
        .sub-event h4 {
            font-size: 15.5px;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        
        /* Center alignment helper */
        .center-align {
            text-align: center;
        }
        
        /* Paper content area */
        .paper-content {
            max-width: 7.5in;
            margin: 0 auto;
            background: white; /* White background for paper content */
        }
        
        /* Additional margin controls */
        .content-wrapper {
            margin: 0.5in;
            background: white; /* White background for content wrapper */
        }
        .place-1st { color: gold; font-weight: bold; }
        .place-2nd { color: #C0C0C0; font-weight: bold; }
        .place-3rd { color: #CD7F32; font-weight: bold; }
        .other-place { color: #000; }
    </style>
</head>
 
<body>
    <div class="container">
        <div class="span12">
            <div class="paper-content">
                <?php   
                $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
                while ($event_row = $event_query->fetch()) { 
                ?>
                <div class="header-title">
                    <?php include('doc_header.php'); ?>
                    <br><br>
                    <div class="event-title">
                        <strong><?php echo $event_row['event_name']; ?></strong>
                    </div>
                    <div class="tally-sheet-title">
                        Tally Sheet
                    </div>
                </div>
                <?php }  ?>

                <div class="table-responsive">
                    <table align="center">
                        <?php   
                        $sy_query = $conn->query("select DISTINCT sy FROM main_event where organizer_id='$session_id' AND mainevent_id='$active_main_event='") or die(mysql_error());
                        while ($sy_row = $sy_query->fetch()) {
                            $sy=$sy_row['sy'];
                            $MEctrQuery = $conn->query("select * FROM main_event where sy='$sy'") or die(mysql_error());
                            $MECtr = $MEctrQuery->rowCount();
                        ?>
                        <tr>
                            <td>   
                                <?php   
                                $event_query = $conn->query("select * from main_event where organizer_id='$session_id' AND sy='$sy'") or die(mysql_error());
                                while ($event_row = $event_query->fetch()) {
                                    $main_event_id=$event_row['mainevent_id'];
                                    $SEctrQuery = $conn->query("select * FROM sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                                    while($SECtr = $SEctrQuery->fetch()) {
                                        $rs_subevent_id=$SECtr['subevent_id'];
                                ?>
                                <div class="sub-event">
                                    <h4>EVENT: <strong><?php echo $SECtr['event_name']; ?></strong></h4>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <?php   
                                                $contxx_query = $conn->query("select DISTINCT fullname from contestants where subevent_id='$rs_subevent_id'") or die(mysql_error());
                                                while ($contxx_row = $contxx_query->fetch()) { 
                                                ?>
                                                <th><center><?php echo $contxx_row['fullname']; ?></center></th>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <?php  
                                                $contxxz_query = $conn->query("select contestant_id from contestants where subevent_id='$rs_subevent_id'") or die(mysql_error());
                                                while ($contxxz_row = $contxxz_query->fetch()) {  
                                                    $contxzID=$contxxz_row['contestant_id'];
                                                    // Modified query to order by total_score or relevant ranking field
                                                    $place_query = $conn->query("
                                                        SELECT 
                                                            CASE 
                                                                WHEN total_score = (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id') THEN '1st Place'
                                                                WHEN total_score = (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id' AND total_score < (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id')) THEN '2nd Place'
                                                                WHEN total_score = (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id' AND total_score < (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id' AND total_score < (SELECT MAX(total_score) FROM sub_results WHERE subevent_id='$rs_subevent_id'))) THEN '3rd Place'
                                                                ELSE CONCAT(ROW_NUMBER() OVER (ORDER BY total_score DESC), 'th Place')
                                                            END as place_title,
                                                            total_score
                                                        FROM sub_results 
                                                        WHERE contestant_id='$contxzID' 
                                                        AND subevent_id='$rs_subevent_id'
                                                        ORDER BY total_score DESC
                                                        LIMIT 1
                                                    ") or die(mysql_error());
                                                    
                                                    while ($place_row = $place_query->fetch()) {
                                                        $place = $place_row['place_title'];
                                                        $class = '';
                                                        if (strpos($place, '1st') !== false) $class = 'place-1st';
                                                        else if (strpos($place, '2nd') !== false) $class = 'place-2nd';
                                                        else if (strpos($place, '3rd') !== false) $class = 'place-3rd';
                                                        else $class = 'other-place';
                                                ?>
                                                <td><center><span class="<?php echo $class; ?>"><?php echo $place; ?></span></center></td>
                                                <?php } } ?>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <?php } } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>

    <!-- JavaScript -->
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