<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        @media print {
            .paper-container {
                width: 100%;
                box-shadow: none;
                padding: 0;
            }
        }

        /* Responsive table */
        .table-responsive {
            overflow-x: auto;
            width: 100%;
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

        .table-striped tbody tr:nth-of-odd {
            background-color: rgba(0,0,0,.05);
        }

        /* Center alignment */
        .text-center {
            text-align: center;
        }

        /* Header styling */
        .event-header {
            margin-bottom: 2rem;
        }

        .event-header h2,
        .event-header h3 {
            margin: 0.5rem 0;
        }

        /* Judge signature section */
        .judge-signature {
            margin-top: 2rem;
            float: right;
            text-align: center;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 21cm) {
            .paper-container {
                width: 100%;
                padding: 1cm;
            }
        }

        /* Alert styling */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
    </style>
</head>
<body>
    <?php
    include('header2.php');
    include('..//admin/session.php');
    error_reporting(0);
    $event_id=$_GET['event_id'];
    $judge_id=$_GET['judge_id'];
    ?>

    <div class="paper-container">
        <?php
        $s_event_query = $conn->query("select * from sub_event where subevent_id='$event_id'") or die(mysql_error());
        while ($s_event_row = $s_event_query->fetch()) {
            $MEidxx=$s_event_row['mainevent_id'];
            
            $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxx'") or die(mysql_error());
            while ($event_row = $event_query->fetch()) {
        ?>
            
        <div class="text-center event-header">
           <center> <?php include('..//admin/doc_header.php'); ?></center>
           
           <br><br>
            <h2><?php echo $event_row['event_name']; ?></h2>
            <h3><?php echo $s_event_row['event_name']; ?></h3>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No. &amp; Contestant Name</th>
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
                            $s1=$score_row['criteria_ctr1'];
                            $s2=$score_row['criteria_ctr2'];
                            $s3=$score_row['criteria_ctr3'];
                            $s4=$score_row['criteria_ctr4'];
                            $s5=$score_row['criteria_ctr5'];
                            $s6=$score_row['criteria_ctr6'];
                            $s7=$score_row['criteria_ctr7'];
                            $s8=$score_row['criteria_ctr8'];
                            $s9=$score_row['criteria_ctr9'];
                            $s10=$score_row['criteria_ctr10'];
                            $total_score=$score_row['total_score']; 
                            $rank=$score_row['rank'];
                            $s_result_id=$score_row['subresult_id'];
                            $con_id=$score_row['contestant_id'];
                    ?>
                    <tr>
                        <td>
                            <?php
                            $cont_query = $conn->query("select * from contestants where contestant_id='$con_id'") or die(mysql_error());
                            while ($cont_row = $cont_query->fetch()) {
                                $c_num=$cont_row['contestant_ctr'];
                                echo $c_num.". ".$cfnme=$cont_row['fullname'];   
                            }
                            ?>
                        </td>
                        <?php
                        $criteria_query = $conn->query("select * from criteria where subevent_id='$event_id' ORDER BY criteria_ctr ASC") or die(mysql_error());
                        while ($crit_row = $criteria_query->fetch()) {
                        ?>
                        <td>
                            <?php
                            switch($crit_row['criteria_ctr']) {
                                case 1: echo $s1; break;
                                case 2: echo $s2; break;
                                case 3: echo $s3; break;
                                case 4: echo $s4; break;
                                case 5: echo $s5; break;
                            }
                            ?>
                        </td>
                        <?php } ?>
                        <td><?php echo $total_score; ?></td>
                        <td><?php echo $rank; ?></td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="8">
                            <div class="alert alert-warning">
                                <h3>No data to Display... Judges not finish scoring at this moment.</h3>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
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
                <p>Chairman</p>
            <?php } ?>
            <p>Event Judge</p>
        </div>
        <?php
        }}}
        ?>
    </div>

    <!-- Scripts -->
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