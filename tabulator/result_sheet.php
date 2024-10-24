<!DOCTYPE html>
<html lang="en">
   
<?php
   include('header2.php');
   include('..//admin/session.php');
   $active_sub_event=$_GET['event_id'];
?>
<head>
    <style>
        body {
            background: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .container {
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 0 auto;
            max-width: 8.5in;
            min-height: 11in;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px;
            border: 1px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        /* Center alignment */
        .text-center {
            text-align: center;
        }

        /* Make tables responsive */
        @media screen and (max-width: 768px) {
            .table-responsive {
                display: block;
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Print styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }
            
            .container {
                box-shadow: none;
                padding: 0.5in;
            }

            footer {
                page-break-after: always;
            }
        }

        /* Signature styles */
        .signature-table {
            width: 100%;
            margin-top: 30px;
        }

        .signature-table td {
            text-align: center;
            padding: 10px;
        }

        .signature-line {
            border-top: 1px solid black;
            margin-top: 50px;
            display: inline-block;
            min-width: 200px;
        }
    </style>
</head>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div class="container">
        <div class="row">
            <div class="span12">
                <?php   
                $s_event_query = $conn->query("select * from sub_event where subevent_id='$active_sub_event'") or die(mysql_error());
                while ($s_event_row = $s_event_query->fetch()) {
                    $MEidxx=$s_event_row['mainevent_id'];
                    $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
                    while ($event_row = $event_query->fetch()) {
                ?>
                
                <center>
                    <?php include('..//admin/doc_header.php'); ?>
                    
                    <table>
                        <tr>
                            <td align="center">
                                <font size="4"><?php echo $event_row['event_name']; ?></font>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <font size="3"><?php echo $s_event_row['event_name']; ?></font>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <font size="4">Over All Result</font>
                            </td>
                        </tr>
                    </table>
                </center>
                
                <br />
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Participants</th>
                            <th>Placing</th>
                            <th>Result Summary</th>
                        </thead>
                        <tbody>
                            <?php
                            $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$MEidxx' and subevent_id='$active_sub_event' order by place_title ASC") or die(mysql_error());
                            while ($o_result_row = $o_result_query->fetch()) {
                                $contestant_id=$o_result_row['contestant_id'];
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
                                        $place_title=$placingzz_row['place_title'];
                                    }
                                    echo $place_title; 
                                    ?>
                                    </h3>
                                </td>
                                <td>
                                    <table class="table table-bordered">
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
                                            <td bgcolor="#C5EAF9">
                                                <b>Ave: <?php echo round(($totx_score-$totx_deduct)/$divz,1) ?></b>
                                            </td>
                                            <td bgcolor="#DFF2FA">
                                                <b>Sum: <?php echo $rank_score; ?></b>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <hr />
                <br />
                
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

                <hr />
                
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

                <hr />
                
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

                <button type="submit" onclick="window.print()" class="btn btn-default pull-right">
                    <i class="icon-print"></i>
                </button>
                
                <?php } } ?>
            </div>
        </div>
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