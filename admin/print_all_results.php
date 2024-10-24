<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Bond paper simulation */
        html {
            background: #f0f0f0;
            min-height: 100%;
        }
        
        body {
            background: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Page setup for bond paper */
        .page {
            width: 8.5in;
            min-height: 13in;
            padding: 0.5in;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            box-sizing: border-box;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: avoid;
        }

        /* Print settings */
        @page {
            size: 8.5in 13in;
            margin: 0;
        }
        
        @media print {
            html, body {
                background: none;
                margin: 0;
                padding: 0;
            }
            
            .page {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
            }

            .no-print {
                display: none;
            }
        }

        /* Table styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        /* Header styles */
        .event-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .event-title {
            font-size: 20.5px;
            font-weight: bold;
            margin: 10px 0;
        }

        .sub-event-title {
            font-size: 15.5px;
            margin: 10px 0;
        }

        /* Results table */
        .results-table th {
            font-size: 15.5px;
            background-color: #f8f9fa;
        }

        /* Summary tables */
        .summary-table {
            font-size: small;
            margin: 0;
        }

        /* Signature section */
        .signature-section {
            margin-top: 50px;
        }

        .signature-table {
            margin: 0 auto;
            text-align: center;
        }

        .signature-table td {
            padding: 0 20px;
        }

        .signature-name {
            font-size: 10.5px;
            border-top: 1px solid black;
            padding-top: 5px;
            margin-top: 30px;
        }

        /* Print button */
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <?php
    include('header2.php');
    include('session.php');
    $active_main_event=$_GET['main_event_id'];
    
    $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
    while ($event_row = $event_query->fetch()) {
        $s_event_query = $conn->query("select * from sub_event where mainevent_id='$active_main_event'") or die(mysql_error());
        while ($s_event_row = $s_event_query->fetch()) {
            $active_sub_event=$s_event_row['subevent_id'];
    ?>
    <!-- Start of page for each event -->
    <div class="page">
        <div class="event-header">
            <?php include('doc_header.php'); ?>
            
            <h2 class="event-title"><?php echo $event_row['event_name']; ?> - Over All Result</h2>
            <h3 class="sub-event-title"><?php echo $s_event_row['event_name']; ?></h3>
        </div>

        <table class="table table-bordered results-table">
            <thead>
                <tr>
                    <th>Participants</th>
                    <th>Result Summary</th>
                    <th>Placing</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by place_title ASC") or die(mysql_error());
                while ($o_result_row = $o_result_query->fetch()) {
                    $contestant_id=$o_result_row['contestant_id'];
                ?>
                <tr>
                    <td>
                        <?php
                        $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'") or die(mysql_error());
                        while ($cname_row = $cname_query->fetch()) {
                            echo $cname_row['contestant_ctr'].".".$cname_row['fullname'];
                        }
                        ?>
                    </td>
                    <td>
                        <table class="table table-bordered summary-table">
                            <tr>
                                <th>Average Score</th>
                                <th>Sum of Rank in all Judges</th>
                            </tr>
                            <?php
                            $divz=0;
                            $c_ctr=0;
                            $totx_score=0;
                            $rank_score=0;
                            $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                            while ($tot_score_row = $tot_score_query->fetch()) {
                                $divz=$divz+1;
                                $c_ctr=$c_ctr+1;
                                $place_title=$tot_score_row['place_title'];
                            }

                            $tot_score_query = $conn->query("select judge_id,total_score, deduction, rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                            while ($tot_score_row = $tot_score_query->fetch()) {
                                $totx_score=$totx_score+$tot_score_row['total_score'];
                                $rank_score=$rank_score+$tot_score_row['rank'];
                                $totx_deduct=$tot_score_row['deduction'];
                            }
                            ?>
                            <tr>
                                <td><b>Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?></b></td>
                                <td><b>Sum: <?php echo $rank_score; ?></b></td>
                            </tr>
                        </table>
                    </td>
                    <td><center><h3 style="font-size:small;"><?php echo $place_title; ?></h3></center></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Judges Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <?php
                    $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                        $jx_id=$jjn_result_row['judge_id'];
                        $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                        $jname_row = $jname_query->fetch();
                    ?>
                    <td>
                        <div class="signature-name">
                            <strong><?php echo $jname_row['fullname']; ?></strong><br>
                            <?php echo $jname_row['jtype']; ?> Judge
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>

        <!-- Tabulator Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <?php
                    $tabulator_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
                    while ($tabulator_row = $tabulator_query->fetch()) {
                    ?>
                    <td>
                        <div class="signature-name">
                            <strong><?php echo $tabulator_row['fname']." ".$tabulator_row['mname']." ".$tabulator_row['lname']; ?></strong><br>
                            Tabulator
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>

        <!-- Organizer Section -->
        <div class="signature-section">
            <table class="signature-table">
                <tr>
                    <?php
                    $organizer_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
                    while ($organizer_row = $organizer_query->fetch()) {
                    ?>
                    <td>
                        <div class="signature-name">
                            <strong><?php echo $organizer_row['fname']." ".$organizer_row['mname']." ".$organizer_row['lname']; ?></strong><br>
                            Organizer
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>
    </div>
    <?php 
        } // End of sub_event while loop
    } // End of main_event while loop
    ?>

    <!-- Print Button -->
    <button type="button" onclick="window.print()" class="btn btn-default print-button no-print">
        <i class="icon-print"></i> Print
    </button>

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