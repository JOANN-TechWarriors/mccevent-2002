<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Review Report</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f3f4f6;
            padding: 2rem 1rem;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Paper container */
        .paper-container {
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            background: white;
            padding: 1in 1in;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .paper-border {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 1px solid #e5e7eb;
            pointer-events: none;
        }

        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h2 {
            font-size: 24px;
            margin-bottom: 0.5rem;
        }

        .header h3 {
            font-size: 20px;
            color: #444;
        }

        /* Section headers */
        h3.section-title {
            margin: 1.5rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
            font-size: 18px;
        }

        /* Table styles */
        .table-container {
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Nested tables */
        .nested-table {
            margin: 0;
        }

        .nested-table th,
        .nested-table td {
            padding: 4px;
            font-size: 13px;
        }

        /* Summary rows */
        .summary-row td {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        /* Placing styles */
        .placing {
            font-size: 20px;
            font-weight: bold;
            color: #2c5282;
        }

        /* Criteria table */
        .criteria-table {
            max-width: 500px;
        }

        /* Alert styles */
        .alert {
            padding: 8px;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 9999px;
            font-size: 12px;
        }

        .badge-info {
            background-color: #60a5fa;
            color: white;
        }
    </style>
</head>
<body>
    <div class="paper-container">
        <div class="paper-border"></div>
        <div class="content">
            <!-- Header Section -->
            <div class="header">
                <?php include('doc_header.php'); ?>
                <h2><?php echo $event_row['event_name']; ?></h2>
                <h3>Event Review - <?php echo $s_event_row['event_name']; ?></h3>
            </div>

            <!-- Contestants Section -->
            <h3 class="section-title">Contestants</h3>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Participant</th>
                            <th>Summary of Scores</th>
                            <th>Participant's Placing</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$mainevent_id' and subevent_id='$subevent_id' order by place_title ASC") or die(mysql_error());
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
                                <table class="nested-table">
                                    <tr>
                                        <th>Judge</th>
                                        <th>Score</th>
                                        <th>Rank</th>
                                    </tr>
                                    <?php
                                    $divz = 0;
                                    $totx_score = 0;
                                    $rank_score = 0;
                                    $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $divz = $divz + 1;
                                        $place_title = $tot_score_row['place_title'];
                                    }

                                    $tot_score_query = $conn->query("select judge_id,total_score,rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $totx_score = $totx_score + $tot_score_row['total_score'];
                                        $rank_score = $rank_score + $tot_score_row['rank'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php 
                                            $jx_id = $tot_score_row['judge_id'];
                                            $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                                            $jname_row = $jname_query->fetch();
                                            echo $jname_row['fullname'];
                                            ?>
                                        </td>
                                        <td><?php echo $tot_score_row['total_score']; ?></td>
                                        <td><?php echo $tot_score_row['rank']; ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="summary-row">
                                        <td></td>
                                        <td>Ave: <?php echo round($totx_score/$divz,2) ?></td>
                                        <td>Sum: <?php echo $rank_score; ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td class="placing"><?php echo $place_title ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Judges Section -->
            <h3 class="section-title">Judges</h3>
            <div class="table-container">
                <table class="criteria-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Code</th>
                            <th>Fullname</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $judge_query = $conn->query("SELECT * FROM judges WHERE subevent_id='$subevent_id' order by judge_ctr") or die(mysql_error());
                        while ($judge_row = $judge_query->fetch()) { 
                        ?>
                        <tr>
                            <td><?php echo $judge_row['judge_ctr']; ?></td>
                            <td><?php echo $judge_row['code']; ?></td>
                            <td><?php echo $judge_row['fullname']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Criteria Section -->
            <h3 class="section-title">Criteria</h3>
            <div class="table-container">
                <table class="criteria-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Criteria</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $percnt = 0;
                        $crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$subevent_id'") or die(mysql_error());
                        while ($crit_row = $crit_query->fetch()) { 
                            $percnt = $percnt + $crit_row['percentage'];
                            $crit_id = $crit_row['criteria_id'];
                        ?>
                        <tr>
                            <td><?php echo $crit_row['criteria_ctr']; ?></td>
                            <td><?php echo $crit_row['criteria']; ?></td>
                            <td><?php echo $crit_row['percentage']; ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <?php if($percnt < 100) { ?>
                            <td colspan="2">
                                <div class="alert alert-danger">
                                    <strong>The Total Percentage is under 100%.</strong>
                                </div>
                            </td>
                            <td>
                                <div class="alert alert-danger">
                                    <strong><?php echo $percnt; ?></strong>
                                </div>
                            </td>
                            <?php } elseif($percnt > 100) { ?>
                            <td colspan="2">
                                <div class="alert alert-danger">
                                    <strong>The Total Percentage is over 100%.</strong>
                                </div>
                            </td>
                            <td>
                                <div class="alert alert-danger">
                                    <strong><?php echo $percnt; ?></strong>
                                </div>
                            </td>
                            <?php } else { ?>
                            <td colspan="2"></td>
                            <td>
                                <span class="badge badge-info"><?php echo $percnt; ?></span>
                            </td>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Vote Poll Section (if active) -->
            <?php if($s_event_row['txtpoll_status']=="active") { ?>
            <h3 class="section-title">Vote Poll</h3>
            <div class="table-container">
                <table class="criteria-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Fullname</th>
                            <th>Total Votes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php    
                        $cont_query = $conn->query("SELECT * FROM contestants WHERE subevent_id='$subevent_id' order by contestant_ctr") or die(mysql_error());
                        while ($cont_row = $cont_query->fetch()) { 
                            $cont_id = $cont_row['contestant_id'];
                        ?>
                        <tr>
                            <td><?php echo $cont_row['contestant_ctr']; ?></td>
                            <td><?php echo $cont_row['fullname']; ?></td>
                            <td><?php echo $cont_row['txtPollScore']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } ?>
        </div>
    </div>
 
 <?php include('footer.php'); ?>


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
