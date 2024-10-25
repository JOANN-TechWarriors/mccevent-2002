<!DOCTYPE html>
<html lang="en">
   
<?php
   include('header2.php');
   include('..//admin/session.php');
   $active_sub_event=$_GET['event_id'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Results</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }

        /* Container styles */
        .container {
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 0 auto;
            width: 100%;
            max-width: 8.5in;
            min-height: 11in;
        }

        /* Header styles */
        .header-content {
            text-align: center;
            margin-bottom: 20px;
        }

        .header-content table {
            margin: 0 auto;
        }

        .header-content td {
            padding: 5px;
            text-align: center;
        }

        /* Table styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            background-color: transparent;
            font-size: 14px;
        }

        .table th,
        .table td {
            padding: 12px 8px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Nested table styles */
        .table .table {
            margin: 0;
            background-color: transparent;
        }

        .table .table td,
        .table .table th {
            padding: 8px;
        }

        /* Participant name styles */
        .participant-name {
            font-size: 16px;
            font-weight: bold;
        }

        /* Result highlight colors */
        .result-average {
            background-color: #C5EAF9;
            font-weight: bold;
        }

        .result-sum {
            background-color: #DFF2FA;
            font-weight: bold;
        }

        /* Signature section styles */
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .signature-table td {
            text-align: center;
            padding: 10px;
            width: 33.33%;
        }

        .signature-line {
            border-top: 1px solid black;
            margin-top: 50px;
            display: inline-block;
            min-width: 200px;
            margin-bottom: 5px;
        }

        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
            }

            .container {
                box-shadow: none;
                padding: 0.5in;
                width: 8.5in;
                height: 11in;
            }

            .table {
                page-break-inside: avoid;
            }

            .signature-section {
                page-break-inside: avoid;
            }

            .btn-print {
                display: none;
            }
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 6px 4px;
            }

            .participant-name {
                font-size: 14px;
            }

            .signature-table td {
                padding: 5px;
            }

            .signature-line {
                min-width: 150px;
            }
        }

        /* Print button styles */
        .btn-print {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            float: right;
            margin-top: 20px;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php   
        $s_event_query = $conn->query("select * from sub_event where subevent_id='$active_sub_event'") or die(mysql_error());
        while ($s_event_row = $s_event_query->fetch()) {
            $MEidxx=$s_event_row['mainevent_id'];
            $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
            while ($event_row = $event_query->fetch()) {
        ?>
        
        <div class="header-content">
            <?php include('..//admin/doc_header.php'); ?>
            
            <table>
                <tr>
                    <td>
                        <h2><?php echo $event_row['event_name']; ?></h2>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php echo $s_event_row['event_name']; ?></h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h2>Overall Results</h2>
                    </td>
                </tr>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Participants</th>
                        <th style="width: 120px;">Placing</th>
                        <th>Result Summary</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by place_title ASC") or die(mysql_error());
                    while ($o_result_row = $o_result_query->fetch()) {
                        $contestant_id=$o_result_row['contestant_id'];
                    ?>
                    <tr>
                        <td>
                            <div class="participant-name">
                            <?php
                            $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'") or die(mysql_error());
                            while ($cname_row = $cname_query->fetch()) {
                                echo $cname_row['contestant_ctr'].".".$cname_row['fullname']; 
                            }
                            ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="participant-name">
                            <?php 
                            $placingzz_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                            while ($placingzz_row = $placingzz_query->fetch()) {
                                $place_title=$placingzz_row['place_title'];
                            }
                            echo $place_title; 
                            ?>
                            </div>
                        </td>
                        <td>
                            <table class="table">
                                <tr>
                                    <th>Average Score in all judges</th>
                                    <th>Sum of Rank in all judges</th>
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
                                    <td class="result-average">
                                        Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?>
                                    </td>
                                    <td class="result-sum">
                                        Sum: <?php echo $rank_score; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="signature-section">
            <!-- Judges Signatures -->
            <table class="signature-table">
                <tr>
                    <?php
                    $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                        $jx_id=$jjn_result_row['judge_id'];
                        $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                        $jname_row = $jname_query->fetch();
                    ?>
                    <td>
                        <div class="signature-line">
                            <strong><?php echo $jname_row['fullname'];?></strong>
                        </div>
                        <div>
                            <?php echo ($jname_row['jtype']=="Chairman") ? "Chairman Judge" : "Judge"; ?>
                        </div>
                    </td>
                    <?php } ?>
                </tr>
            </table>

            <!-- Tabulator Signature -->
            <table class="signature-table">
                <tr>
                    <?php
                    $jjn_result_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                    ?>
                    <td>
                        <div class="signature-line">
                            <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname'];?></strong>
                        </div>
                        <div>Tabulator</div>
                    </td>
                    <?php } ?>
                </tr>
            </table>

            <!-- Organizer Signature -->
            <table class="signature-table">
                <tr>
                    <?php
                    $jjn_result_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                    ?>
                    <td>
                        <div class="signature-line">
                            <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname'];?></strong>
                        </div>
                        <div>Organizer</div>
                    </td>
                    <?php } ?>
                </tr>
            </table>
        </div>

        <button type="button" onclick="window.print()" class="btn-print">
            Print Results
        </button>

        <?php } } ?>
    </div>

    <!-- JavaScript -->
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