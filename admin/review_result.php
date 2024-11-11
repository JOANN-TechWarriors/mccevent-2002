<!DOCTYPE html>
<html lang="en">
   
<?php
include('header2.php');
include('session.php');

$mainevent_id = $_GET['mainevent_id'];
$subevent_id = $_GET['sub_event_id'];
?>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
<div class="container">
    <div class="row">
        <div class="span12">
        <?php   
        $event_query = $conn->query("select * from main_event where mainevent_id='$mainevent_id'") or die(mysql_error());
        while ($event_row = $event_query->fetch()) { 
            $s_event_query = $conn->query("select * from sub_event where subevent_id='$subevent_id'") or die(mysql_error());
            while ($s_event_row = $s_event_query->fetch()) {
        ?>
            <center>
                <?php include('doc_header.php'); ?>
                <table>
                    <tr>
                        <td align="center">
                            <h2><?php echo $event_row['event_name']; ?></h2> 
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <h3>Event Review - <?php echo $s_event_row['event_name']; ?></h3> 
                        </td>
                    </tr>
                </table>
            </center>

            <h3>Contestants</h3>
            <table class="table table-bordered">
                <thead>
                    <th>Participant</th>
                    <th>Summary of Scores</th>
                    <th>Participant's Placing</th>
                </thead>
                <tbody>
                <?php
                // First, calculate average scores and ranks for all contestants
                $rankings = array();
                
                $contestants_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$mainevent_id' and subevent_id='$subevent_id'") or die(mysql_error());
                while ($contestant = $contestants_query->fetch()) {
                    $contestant_id = $contestant['contestant_id'];
                    
                    // Calculate total scores and counts
                    $score_query = $conn->query("select sum(total_score) as total, count(*) as count from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                    $score_data = $score_query->fetch();
                    
                    $average_score = $score_data['total'] / $score_data['count'];
                    
                    // Store in rankings array
                    $rankings[$contestant_id] = array(
                        'average_score' => $average_score,
                        'contestant_id' => $contestant_id
                    );
                }

                // Sort by average score in descending order
                uasort($rankings, function($a, $b) {
                    return $b['average_score'] <=> $a['average_score'];
                });

                // Add ranking positions
                $position = 1;
                $last_score = null;
                $last_position = 1;

                foreach ($rankings as &$ranking) {
                    if ($last_score !== null && $ranking['average_score'] < $last_score) {
                        $last_position = $position;
                    }
                    $ranking['position'] = $last_position;
                    $last_score = $ranking['average_score'];
                    $position++;
                }

                // Display contestants in ranked order
                foreach ($rankings as $contestant_id => $ranking) {
                    ?>
                    <tr>
                        <td><?php
                            $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'") or die(mysql_error());
                            $cname_row = $cname_query->fetch();
                            echo $cname_row['contestant_ctr'].".".$cname_row['fullname'];
                        ?></td>
                        <td>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Judge</th>
                                    <th>Score</th>
                                    <th>Rank</th>
                                </tr>
                                <?php
                                $divz = 0;
                                $totx_score = 0;
                                $rank_score = 0;
                                
                                $tot_score_query = $conn->query("select judge_id,total_score,rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                while ($tot_score_row = $tot_score_query->fetch()) {
                                    $divz++;
                                    $totx_score += $tot_score_row['total_score'];
                                    $rank_score += $tot_score_row['rank'];
                                    ?>
                                    <tr>
                                        <td><?php 
                                            $jx_id = $tot_score_row['judge_id'];
                                            $jname_query = $conn->query("select * from judges where judge_id='$jx_id'") or die(mysql_error());
                                            $jname_row = $jname_query->fetch();
                                            echo $jname_row['fullname'];
                                        ?></td>
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
                        </td>
                        <td>
                            <strong style="font-size:25px;">
                            <?php
                            // Convert numerical position to ordinal
                            $position = $ranking['position'];
                            $suffix = match(($position % 100) > 10 && ($position % 100) < 14 ? 0 : $position % 10) {
                                1 => 'st',
                                2 => 'nd',
                                3 => 'rd',
                                default => 'th'
                            };
                            echo $position . $suffix . " Place";
                            ?>
                            </strong>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <h3>Judges</h3>
            <table class="table table-bordered" style="width:500px;">
                <thead>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Fullname</th>
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

            <h3>Criteria</h3>
            <table class="table table-bordered" style="width:500px;">
                <thead>
                    <th>No.</th>
                    <th>Criteria</th>
                    <th>Percentage</th>
                </thead>
                <tbody>
                <?php    
                $percnt = 0;
                $crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$subevent_id'") or die(mysql_error());
                while ($crit_row = $crit_query->fetch()) { 
                    $percnt += $crit_row['percentage'];
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
                        <td colspan="1">
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
                        <td colspan="1">
                            <div class="alert alert-danger">
                                <strong><?php echo $percnt; ?></strong> 
                            </div>
                        </td>
                    <?php } else { ?>
                        <td colspan="2"></td>
                        <td colspan="1">
                            <span class="badge badge-info"><?php echo $percnt; ?></span>
                        </td>
                    <?php } ?>
                </tr>
                </tbody>
            </table>

            <?php if($s_event_row['txtpoll_status']=="active") { ?>
                <h3>Vote Poll</h3>
                <table class="table table-bordered">
                    <thead>
                        <th>No.</th>
                        <th>Fullname</th>
                        <th>Total Votes</th>
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
            <?php } ?>
            <?php } } ?>
        </div>
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