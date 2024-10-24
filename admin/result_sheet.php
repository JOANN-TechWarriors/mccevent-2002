<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Paper-like styling */
        body {
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .paper-container {
            background: white;
            width: 21cm; /* A4 width */
            min-height: 29.7cm; /* A4 height */
            margin: 0 auto;
            padding: 2cm;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        @media print {
            body {
                background: none;
                padding: 0;
            }
            .paper-container {
                box-shadow: none;
                width: 100%;
                min-height: auto;
                padding: 1cm;
            }
            footer {
                page-break-after: always;
            }
            .no-print {
                display: none;
            }
        }

        /* Responsive table styling */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Center alignment for specific elements */
        .text-center {
            text-align: center;
        }

        /* Header styling */
        .event-header {
            margin-bottom: 2rem;
        }

        .event-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .sub-event-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        /* Result summary table */
        .result-summary {
            background-color: #fff;
            margin-bottom: 1rem;
        }

        .result-summary th {
            background-color: #C5EAF9;
        }

        /* Signature section */
        .signature-section {
            margin-top: 3rem;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .signature-block {
            margin: 1rem;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 2rem;
            padding-top: 0.5rem;
            min-width: 200px;
        }

        /* Print button */
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #0056b3;
        }

        @media screen and (max-width: 768px) {
            .paper-container {
                width: 100%;
                padding: 1cm;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
            
            .signature-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <?php
    include('header2.php');
    include('session.php');
    $active_sub_event = $_GET['event_id'];
    ?>

    <div class="paper-container">
        <?php   
        $s_event_query = $conn->query("select * from sub_event where subevent_id='$active_sub_event'") or die(mysql_error());
        while ($s_event_row = $s_event_query->fetch()) {
            $MEidxx = $s_event_row['mainevent_id'];
            $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
            while ($event_row = $event_query->fetch()) {
        ?>

        <div class="event-header text-center">
            <?php include('doc_header.php'); ?>
            
            <div class="event-title">
                <?php echo $event_row['event_name']; ?>
            </div>
            <div class="sub-event-title">
                <?php echo $s_event_row['event_name']; ?>
            </div>
            <div class="event-title">Overall Result</div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Participants</th>
                        <th>Placing</th>
                        <th>Result Summary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by place_title ASC") or die(mysql_error());
                    while ($o_result_row = $o_result_query->fetch()) {
                        $contestant_id = $o_result_row['contestant_id'];
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
                        <td class="text-center">
                            <?php 
                            $placingzz_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                            while ($placingzz_row = $placingzz_query->fetch()) {
                                echo $placingzz_row['place_title'];
                            }
                            ?>
                        </td>
                        <td>
                            <div class="table-responsive">
                                <table class="table result-summary">
                                    <tr>
                                        <th>Average Score in all judges</th>
                                        <th>Sum of Rank in all judges</th>
                                    </tr>
                                    <?php
                                    $divz = 0;
                                    $c_ctr = 0;
                                    $totx_score = 0;
                                    $rank_score = 0;
                                    $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $divz++;  
                                        $c_ctr++;
                                    }

                                    $tot_score_query = $conn->query("select judge_id,total_score, deduction, rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $totx_score += $tot_score_row['total_score'];
                                        $rank_score += $tot_score_row['rank'];
                                        $totx_deduct = $tot_score_row['deduction'];
                                    }
                                    ?>
                                    <tr>
                                        <td><b>Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?></b></td>
                                        <td><b>Sum: <?php echo $rank_score; ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <?php
            $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
                $jx_id = $jjn_result_row['judge_id'];
                $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                $jname_row = $jname_query->fetch();
            ?>
            <div class="signature-block">
                <div class="signature-line">
                    <?php echo $jname_row['fullname']; ?>
                </div>
                <div>
                    <?php echo ($jname_row['jtype'] == "Chairman") ? "Chairman Judge" : "Judge"; ?>
                </div>
            </div>
            <?php } ?>

            <?php
            $jjn_result_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line">
                    <?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?>
                </div>
                <div>Tabulator</div>
            </div>
            <?php } ?>

            <?php
            $jjn_result_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line">
                    <?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?>
                </div>
                <div>Organizer</div>
            </div>
            <?php } ?>
        </div>

        <?php } } ?>
    </div>

    <button onclick="window.print()" class="print-btn no-print">
        <i class="icon-print"></i> Print
    </button>

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/bootstrap-affix.js"></script>
    <script src="../assets/js/holder/holder.js"></script>
    <script src="../assets/js/google-code-prettify/prettify.js"></script>
    <script src="../assets/js/application.js"></script>
</body>
</html>