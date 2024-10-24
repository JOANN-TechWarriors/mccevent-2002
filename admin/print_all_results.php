<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Page size styling */
        @page {
            size: legal;
            margin: 1cm;
        }

        /* Print styles */
        @media print {
            .sub-event-section {
                page-break-before: always;
            }
            
            .no-print {
                display: none;
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
            background-color: white;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }

        /* Container styling */
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
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
        }

        /* Signatures section */
        .signatures {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .signature-box {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid black;
            margin-top: 2rem;
            padding-top: 0.5rem;
        }

        /* Small text */
        .small-text {
            font-size: small;
        }

        /* Print button */
        .print-btn {
            float: right;
            margin: 1rem;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include('header2.php'); ?>
        <?php include('session.php'); ?>
        <?php 
            $active_main_event = $_GET['main_event_id'];
            $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'");
            while ($event_row = $event_query->fetch()) {
                $s_event_query = $conn->query("select * from sub_event where mainevent_id='$active_main_event'");
                while ($s_event_row = $s_event_query->fetch()) {
                    $active_sub_event = $s_event_row['subevent_id'];
        ?>
        
        <section class="sub-event-section">
            <?php include('doc_header.php'); ?>
            
            <div class="event-header">
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
                            $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by place_title ASC");
                            while ($o_result_row = $o_result_query->fetch()) {
                                $contestant_id = $o_result_row['contestant_id'];
                        ?>
                        <tr>
                            <td>
                                <?php
                                    $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'");
                                    while ($cname_row = $cname_query->fetch()) {
                                        echo $cname_row['contestant_ctr'].".".$cname_row['fullname'];
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="table-responsive">
                                    <table class="table small-text">
                                        <tr>
                                            <th>Average Score</th>
                                            <th>Sum of Rank in all Judges</th>
                                        </tr>
                                        <?php
                                            $divz = 0;
                                            $c_ctr = 0;
                                            $totx_score = 0;
                                            $rank_score = 0;
                                            
                                            $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'");
                                            while ($tot_score_row = $tot_score_query->fetch()) {
                                                $divz++;
                                                $c_ctr++;
                                                $place_title = $tot_score_row['place_title'];
                                            }

                                            $tot_score_query = $conn->query("select judge_id,total_score, deduction, rank from sub_results where contestant_id='$contestant_id'");
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
                            <td class="text-center"><h3 class="small-text"><?php echo $place_title; ?></h3></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="signatures">
                <?php
                    $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by judge_id ASC");
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                        $jx_id = $jjn_result_row['judge_id'];
                        $jname_query = $conn->query("select * from judges where judge_id='$jx_id'");
                        $jname_row = $jname_query->fetch();
                ?>
                <div class="signature-box">
                    <div class="signature-line">
                        <strong><?php echo $jname_row['fullname']; ?></strong>
                        <div class="small-text"><?php echo $jname_row['jtype']; ?> Judge</div>
                    </div>
                </div>
                <?php } ?>

                <?php
                    $org_query = $conn->query("select * from organizer where org_id='$session_id'");
                    while ($org_row = $org_query->fetch()) {
                ?>
                <div class="signature-box">
                    <div class="signature-line">
                        <strong><?php echo $org_row['fname']." ".$org_row['mname']." ".$org_row['lname']; ?></strong>
                        <div>Tabulator</div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </section>
        <?php 
                }
            } 
        ?>
        
        <button onclick="window.print()" class="print-btn no-print">
            <i class="icon-print"></i> Print
        </button>
    </div>



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
