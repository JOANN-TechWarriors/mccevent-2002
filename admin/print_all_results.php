<?php
include('header2.php');
include('session.php');
$active_main_event = $_GET['main_event_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Bond paper styling */
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .page-container {
            background-color: white;
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto 2rem auto; /* Added bottom margin for spacing between pages */
            padding: 1in;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            page-break-after: always; /* Forces a page break after each container */
        }

        /* Hide the last page break */
        .page-container:last-child {
            page-break-after: auto;
        }

        @media screen and (max-width: 8.5in) {
            .page-container {
                width: 100%;
                padding: 20px;
                margin-bottom: 30px; /* Increased spacing between pages on mobile */
            }
        }

        /* Responsive table styles */
        .table-responsive {
            width: 100%;
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
            border: 1px solid #000;
        }

        .table thead th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Header styling */
        .event-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .event-header h2 {
            font-size: 20.5px;
            margin-bottom: 0.5rem;
        }

        .event-header h3 {
            font-size: 15.5px;
            margin-top: 0;
        }

        /* Inner table styling */
        .inner-table {
            width: 100%;
            font-size: small;
        }

        .inner-table th,
        .inner-table td {
            padding: 0.5rem;
        }

        /* Signature section */
        .signature-section {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .signature-box {
            text-align: center;
            min-width: 200px;
        }

        .signature-line {
            border-top: 1px solid black;
            margin-top: 2rem;
            padding-top: 0.5rem;
        }

        /* Page number styling */
        .page-number {
            position: absolute;
            bottom: 0.5in;
            right: 0.5in;
            font-size: 12px;
            color: #666;
        }

        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }

            .page-container {
                width: 100%;
                box-shadow: none;
                padding: 0.5in;
                margin: 0;
                page-break-after: always;
            }

            .print-button {
                display: none;
            }
        }

        /* Print button */
        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php   
    $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'") or die(mysql_error());
    while ($event_row = $event_query->fetch()) {
        $s_event_query = $conn->query("select * from sub_event where mainevent_id='$active_main_event'") or die(mysql_error());
        $page_count = 0;
        while ($s_event_row = $s_event_query->fetch()) {
            $active_sub_event = $s_event_row['subevent_id'];
            $page_count++;
    ?>

    <div class="page-container">
        <div class="event-header">
           <center> <?php include('doc_header.php'); ?></center>
           <br><br>
            <h2><?php echo $event_row['event_name']; ?> - Over All Result</h2>
            <h3><?php echo $s_event_row['event_name']; ?></h3>
        </div>

        <div class="table-responsive">
            <table class="table">
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
                        <td>
                            <div class="table-responsive">
                                <table class="inner-table">
                                    <tr>
                                        <th>Average Score</th>
                                        <th>Sum of Rank in all Judges</th>
                                    </tr>
                                    <?php
                                    $divz = 0;
                                    $c_ctr = 0;
                                    $totx_score = 0;
                                    $rank_score = 0;
                                    $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $divz = $divz + 1;
                                        $c_ctr = $c_ctr + 1;
                                        $place_title = $tot_score_row['place_title'];
                                    }

                                    $tot_score_query = $conn->query("select judge_id,total_score, deduction, rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $totx_score = $totx_score + $tot_score_row['total_score'];
                                        $rank_score = $rank_score + $tot_score_row['rank'];
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
                        <td><center><h3 style="font-size:small;"><?php echo $place_title; ?></h3></center></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <?php
            $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
                $jx_id = $jjn_result_row['judge_id'];
                $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                $jname_row = $jname_query->fetch();
            ?>
            <div class="signature-box">
                <div class="signature-line">
                    <strong><?php echo $jname_row['fullname']; ?></strong>
                    <div><?php echo $jname_row['jtype']; ?> Judge</div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="signature-section">
            <?php
            $jjn_result_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-box">
                <div class="signature-line">
                    <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?></strong>
                    <div>Tabulator</div>
                </div>
            </div>
            <?php } ?>

            <?php
            $jjn_result_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-box">
                <div class="signature-line">
                    <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?></strong>
                    <div>Organizer</div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="page-number">Page <?php echo $page_count; ?></div>
    </div>

    <?php
        }
    }
    ?>

    <!-- JavaScript files -->
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