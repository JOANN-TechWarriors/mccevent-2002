<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judging Results</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: #f0f0f0;
            padding: 20px;
        }

        /* Container styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header styles */
        .header-content {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-content h2 {
            margin-bottom: 10px;
            color: #333;
        }

        .header-content h3 {
            color: #666;
        }

        /* Table styles */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Judge signature section */
        .judge-signature {
            text-align: right;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .judge-signature h4 {
            margin-bottom: 5px;
        }

        .judge-title {
            font-style: italic;
            color: #666;
        }

        /* Alert styles */
        .alert {
            padding: 20px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            border-radius: 4px;
            margin: 20px 0;
            text-align: center;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
            }

            .container {
                max-width: 100%;
                padding: 20px;
                box-shadow: none;
            }

            .table th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table tbody tr:nth-child(even) {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: letter;
                margin: 0.5in;
            }
        }

        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 10px;
            }

            .table th,
            .table td {
                padding: 8px;
                font-size: 14px;
            }

            .header-content h2 {
                font-size: 20px;
            }

            .header-content h3 {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        include('header2.php');
        include('..//admin/session.php');
        error_reporting(0);
        $event_id=$_GET['event_id'];
        $judge_id=$_GET['judge_id'];
        ?>

        <div class="content">
            <?php   
            $s_event_query = $conn->query("select * from sub_event where subevent_id='$event_id'") or die(mysql_error());
            while ($s_event_row = $s_event_query->fetch()) {
                $MEidxx=$s_event_row['mainevent_id'];
                
                $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
                while ($event_row = $event_query->fetch()) {
            ?>
                    
            <div class="header-content">
                <?php include('..//admin/doc_header.php'); ?>
                <h2><?php echo $event_row['event_name']; ?></h2>
                <h3><?php echo $s_event_row['event_name']; ?></h3>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No. & Contestant Name</th>
                            <?php
                            $criteria_query = $conn->query("select * from criteria where subevent_id='$event_id' ORDER BY criteria_ctr ASC") or die(mysql_error());
                            while ($crit_row = $criteria_query->fetch()) {
                            ?>
                            <th><?php echo $crit_row['criteria']; ?></th>
                            <?php } ?>
                            <th>Total Score</th>
                            <th>Rank</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $score_query = $conn->query("select * from sub_results where subevent_id='$event_id' and judge_id='$judge_id' ORDER BY contestant_id ASC") or die(mysql_error());
                        $num_rowxz = $score_query->rowcount();
                        
                        if($num_rowxz > 0) {
                            while ($score_row = $score_query->fetch()) {
                                // Your existing score data code here
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                        $con_id = $score_row['contestant_id'];
                                        $cont_query = $conn->query("select * from contestants where contestant_id='$con_id'") or die(mysql_error());
                                        while ($cont_row = $cont_query->fetch()) {
                                            echo $cont_row['contestant_ctr'].". ".$cont_row['fullname'];   
                                        }
                                        ?>
                                    </td>
                                    <?php
                                    $criteria_query = $conn->query("select * from criteria where subevent_id='$event_id' ORDER BY criteria_ctr ASC") or die(mysql_error());
                                    while ($crit_row = $criteria_query->fetch()) {
                                        $ctr = $crit_row['criteria_ctr'];
                                        echo "<td>" . $score_row['criteria_ctr'.$ctr] . "</td>";
                                    }
                                    ?>
                                    <td><?php echo $score_row['total_score']; ?></td>
                                    <td><?php echo $score_row['rank']; ?></td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="100%">
                                    <div class="alert">
                                        <h3>No data to Display... Judges not finish scoring at this moment.</h3>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            $j_query = $conn->query("select * from judges where subevent_id='$event_id' and judge_id='$judge_id'") or die(mysql_error());
            while ($j_row = $j_query->fetch()) {
            ?>
                <div class="judge-signature">
                    <h4><?php echo $j_row['fullname']; ?></h4>
                    <?php if($j_row['jtype']=="Chairman"){ ?>
                        <div class="judge-title">Chairman</div>
                    <?php } ?>
                    <div class="judge-title">Event Judge</div>
                </div>
            <?php
            }
            ?>

            <?php
                }
            }
            ?>
        </div>
    </div>

    <?php include('..//admin/footer.php'); ?>


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
