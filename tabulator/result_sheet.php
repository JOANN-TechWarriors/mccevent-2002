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
            padding: 40px;
            margin: 0 auto;
            width: 100%;
            max-width: 8.5in;
            min-height: 11in;
        }

        /* Header styles */
        .header-content {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
        }

        .header-content h2 {
            margin-bottom: 10px;
            font-size: 24px;
        }

        .header-content h3 {
            margin-bottom: 10px;
            font-size: 20px;
        }

        /* Table styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 30px;
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
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        /* Participant styles */
        .participant-name {
            font-size: 16px;
            font-weight: bold;
        }

        /* Result styles */
        .result-average {
            background-color: #C5EAF9;
            font-weight: bold;
        }

        .result-sum {
            background-color: #DFF2FA;
            font-weight: bold;
        }

        /* Signature styles */
        .signatures-container {
            margin-top: 40px;
            page-break-inside: avoid;
            width: 100%;
        }

        .signature-group {
            margin-bottom: 30px;
            break-inside: avoid;
        }

        .signature-header {
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
            font-size: 16px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
        }

        .signature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .signature-box {
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            border-top: 1px solid black;
            width: 80%;
            margin: 50px auto 5px auto;
            max-width: 200px;
        }

        .signature-name {
            font-weight: bold;
            margin: 5px 0;
            font-size: 14px;
        }

        .signature-title {
            font-size: 12px;
            color: #555;
        }

        /* Print button */
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
                min-height: 11in;
            }

            .btn-print {
                display: none;
            }

            .signatures-container {
                margin-top: 20px;
            }

            .signature-group {
                margin-bottom: 20px;
            }

            .signature-grid {
                gap: 10px;
            }

            .signature-line {
                margin: 30px auto 5px auto;
            }

            @page {
                size: letter;
                margin: 0;
            }
        }

        /* Responsive styles */
        @media screen and (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .header-content h2 {
                font-size: 20px;
            }

            .header-content h3 {
                font-size: 16px;
            }

            .table {
                font-size: 12px;
            }

            .table th,
            .table td {
                padding: 8px 4px;
            }

            .participant-name {
                font-size: 14px;
            }

            .signature-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 10px;
            }

            .signature-box {
                padding: 5px;
            }

            .signature-name {
                font-size: 12px;
            }

            .signature-title {
                font-size: 11px;
            }
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
            <h2><?php echo $event_row['event_name']; ?></h2>
            <h3><?php echo $s_event_row['event_name']; ?></h3>
            <h2>Overall Results</h2>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="30%">Participants</th>
                        <th width="20%">Placing</th>
                        <th width="50%">Result Summary</th>
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
                                    <th width="50%">Average Score in all judges</th>
                                    <th width="50%">Sum of Rank in all judges</th>
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
                                    <td class="result-average text-center">
                                        <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?>
                                    </td>
                                    <td class="result-sum text-center">
                                        <?php echo $rank_score; ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="signatures-container">
            <!-- Judges Signatures -->
            <div class="signature-group">
                <div class="signature-header">BOARD OF JUDGES</div>
                <div class="signature-grid">
                    <?php
                    $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by judge_id ASC") or die(mysql_error());
                    while ($jjn_result_row = $jjn_result_query->fetch()) {
                        $jx_id=$jjn_result_row['judge_id'];
                        $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                        $jname_row = $jname_query->fetch();
                    ?>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-name"><?php echo $jname_row['fullname'];?></div>
                        <div class="signature-title">
                            <?php echo ($jname_row['jtype']=="Chairman") ? "Chairman of the Board" : "Judge"; ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Tabulator Signature -->
            <div class="signature-group">
                <div class="signature-header">TABULATION COMMITTEE</div>
                <div class="signature-grid">
                    <?php
                    $tab_query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
                    while ($tab_row = $tab_query->fetch()) {
                    ?>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-name">
                            <?php echo $tab_row['fname']." ".$tab_row['mname']." ".$tab_row['lname'];?>
                        </div>
                        <div class="signature-title">Tabulator</div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <!-- Organizer Signature -->
            <div class="signature-group">
                <div class="signature-header">EVENT ORGANIZER</div>
                <div class="signature-grid">
                    <?php
                    $org_query = $conn->query("select * from organizer where organizer_id='$session_id'") or die(mysql_error());
                    while ($org_row = $org_query->fetch()) {
                    ?>
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-name">
                            <?php echo $org_row['fname']." ".$org_row['mname']." ".$org_row['lname'];?>
                        </div>
                        <div class="signature-title">Event Organizer</div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <button type="button" onclick="window.print()" class="btn-print">
            Print Results
        </button>

        <?php } } ?>
    </div>

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