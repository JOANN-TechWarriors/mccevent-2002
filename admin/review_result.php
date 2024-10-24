<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Review</title>
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
        }

        /* Center header content */
        .header-center {
            text-align: center;
            width: 100%;
            margin-bottom: 2rem;
            padding: 1rem;
        }

        .header-center h2 {
            margin-bottom: 0.5rem;
            color: #333;
        }

        .header-center h3 {
            color: #666;
        }

        /* Container for all content */
        .content-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Responsive table styles */
        .table-responsive {
            width: 100%;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: bold;
            color: #333;
        }

        /* Section headers */
        .section-header {
            margin: 2rem 0 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #dee2e6;
            color: #333;
        }

        /* Nested tables */
        .nested-table {
            margin: 0;
            width: 100%;
            background-color: #fff;
        }

        .nested-table th,
        .nested-table td {
            padding: 0.5rem;
            border: 1px solid #dee2e6;
        }

        /* Score highlights */
        .score-highlight {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        /* Alert styles */
        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .badge-info {
            color: #fff;
            background-color: #17a2b8;
        }

        /* Media queries */
        @media (max-width: 768px) {
            .content-container {
                padding: 0.5rem;
            }

            .table th,
            .table td {
                padding: 0.5rem;
            }

            .header-center h2 {
                font-size: 1.5rem;
            }

            .header-center h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php
    include('header2.php');
    include('session.php');
    
    $mainevent_id = $_GET['mainevent_id'];
    $subevent_id = $_GET['sub_event_id'];
    ?>

    <div class="content-container">
        <?php   
        $event_query = $conn->query("select * from main_event where mainevent_id='$mainevent_id'") or die(mysql_error());
        while ($event_row = $event_query->fetch()) {
            $s_event_query = $conn->query("select * from sub_event where subevent_id='$subevent_id'") or die(mysql_error());
            while ($s_event_row = $s_event_query->fetch()) {
        ?>
            
            <div class="header-center">
                <?php include('doc_header.php'); ?>
                <h2><?php echo $event_row['event_name']; ?></h2>
                <h3>Event Review - <?php echo $s_event_row['event_name']; ?></h3>
            </div>

            <!-- Contestants Section -->
            <h3 class="section-header">Contestants</h3>
            <div class="table-responsive">
                <table class="table">
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
                                    <div class="table-responsive">
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
                                            <tr>
                                                <td></td>
                                                <td><b>Ave: <?php echo round($totx_score/$divz,2) ?></b></td>
                                                <td><b>Sum: <?php echo $rank_score; ?></b></td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                                <td class="score-highlight"><?php echo $place_title ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Judges Section -->
            <h3 class="section-header">Judges</h3>
            <div class="table-responsive">
                <table class="table">
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
            <h3 class="section-header">Criteria</h3>
            <div class="table-responsive">
                <table class="table">
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
                                    <div class="alert alert-danger pull-right">
                                        <strong>The Total Percentage is under 100%.</strong>
                                    </div>
                                </td>
                                <td>
                                    <div class="alert alert-danger">
                                        <strong><?php echo $percnt; ?></strong>
                                    </div>
                                </td>
                            <?php } else if($percnt > 100) { ?>
                                <td colspan="2">
                                    <div class="alert alert-danger pull-right">
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

            <!-- Vote Poll Section -->
            <?php if($s_event_row['txtpoll_status'] == "active") { ?>
                <h3 class="section-header">Vote Poll</h3>
                <div class="table-responsive">
                    <table class="table">
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

        <?php
            }
        }
        ?>
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
