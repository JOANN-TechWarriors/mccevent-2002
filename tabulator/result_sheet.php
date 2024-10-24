<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Paper-like background and page setup */
        body {
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .paper-container {
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 0 auto;
            max-width: 8.5in;
            min-height: 11in;
            box-sizing: border-box;
        }

        /* Responsive table styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 1rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        /* Center alignment for specific elements */
        .text-center {
            text-align: center;
        }

        /* Header styling */
        .event-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .event-header h2 {
            margin-bottom: 0.5rem;
        }

        /* Signature section */
        .signature-section {
            margin-top: 3rem;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .signature-block {
            text-align: center;
            min-width: 200px;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 2rem;
            padding-top: 0.5rem;
        }

        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }

            .paper-container {
                box-shadow: none;
                padding: 0.5in;
            }

            .no-print {
                display: none;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .paper-container {
                padding: 20px;
            }

            .signature-section {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="paper-container">
        <?php include('..//admin/doc_header.php'); ?>
        
        <div class="event-header">
            <h2><?php echo $event_row['event_name']; ?></h2>
            <h3><?php echo $s_event_row['event_name']; ?></h3>
            <h3>Overall Results</h3>
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
                            <h3>
                                <?php
                                $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'") or die(mysql_error());
                                while ($cname_row = $cname_query->fetch()) {
                                    echo $cname_row['contestant_ctr'].".".$cname_row['fullname'];
                                }
                                ?>
                            </h3>
                        </td>
                        <td class="text-center">
                            <h3>
                                <?php 
                                $placingzz_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                while ($placingzz_row = $placingzz_query->fetch()) {
                                    $place_title = $placingzz_row['place_title'];
                                }
                                echo $place_title; 
                                ?>
                            </h3>
                        </td>
                        <td>
                            <div class="table-responsive">
                                <table class="table">
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
                                        $place_title = $tot_score_row['place_title'];
                                    }

                                    $tot_score_query = $conn->query("select judge_id,total_score, deduction, rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $totx_score += $tot_score_row['total_score'];
                                        $rank_score += $tot_score_row['rank'];
                                        $totx_deduct = $tot_score_row['deduction'];
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center" style="background-color: #C5EAF9">
                                            <b>Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?></b>
                                        </td>
                                        <td class="text-center" style="background-color: #DFF2FA">
                                            <b>Sum: <?php echo $rank_score; ?></b>
                                        </td>
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
                    <strong><?php echo $jname_row['fullname']; ?></strong>
                </div>
                <div>
                    <?php echo ($jname_row['jtype']=="Chairman") ? "Chairman Judge" : "Judge"; ?>
                </div>
            </div>
            <?php } ?>

            <?php
            $org_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
            while ($org_row = $org_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line">
                    <strong><?php echo $org_row['fname']." ".$org_row['mname']." ".$org_row['lname']; ?></strong>
                </div>
                <div>Tabulator</div>
            </div>
            <?php } ?>

            <?php
            $organizer_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
            while ($organizer_row = $organizer_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line">
                    <strong><?php echo $organizer_row['fname']." ".$organizer_row['mname']." ".$organizer_row['lname']; ?></strong>
                </div>
                <div>Organizer</div>
            </div>
            <?php } ?>
        </div>

        <button type="submit" onclick="window.print()" class="btn btn-default pull-right no-print">
            <i class="icon-print"></i> Print
        </button>
    </div>

    <!-- JavaScript includes -->
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
</body>
</html>