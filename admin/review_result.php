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
                // First, get all contestants and their average scores
                $rankings = array();
                
                $contestants_query = $conn->query("
                    SELECT 
                        r.contestant_id,
                        AVG(r.total_score) as average_score,
                        SUM(r.rank) as total_rank
                    FROM sub_results r 
                    WHERE r.mainevent_id='$mainevent_id' 
                    AND r.subevent_id='$subevent_id'
                    GROUP BY r.contestant_id
                    ORDER BY average_score DESC, total_rank ASC
                ") or die(mysql_error());
                
                $rank = 1;
                $prev_score = null;
                $prev_rank = null;
                $skip_rank = 0;
                
                // Store rankings with proper handling of ties
                while ($row = $contestants_query->fetch()) {
                    if ($prev_score === null) {
                        // First contestant
                        $rankings[$row['contestant_id']] = array(
                            'rank' => 1,
                            'average_score' => $row['average_score'],
                            'total_rank' => $row['total_rank']
                        );
                    } else if ($row['average_score'] == $prev_score && $row['total_rank'] == $prev_rank) {
                        // Tie - same score and rank
                        $rankings[$row['contestant_id']] = array(
                            'rank' => $rank,
                            'average_score' => $row['average_score'],
                            'total_rank' => $row['total_rank']
                        );
                        $skip_rank++;
                    } else {
                        // Different score - new rank
                        $rank = $rank + $skip_rank + 1;
                        $rankings[$row['contestant_id']] = array(
                            'rank' => $rank,
                            'average_score' => $row['average_score'],
                            'total_rank' => $row['total_rank']
                        );
                        $skip_rank = 0;
                    }
                    $prev_score = $row['average_score'];
                    $prev_rank = $row['total_rank'];
                }

                // Display contestants in ranked order
                foreach ($rankings as $contestant_id => $ranking_data) {
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
                            $rank = $ranking_data['rank'];
                            $suffix = match(($rank % 100) > 10 && ($rank % 100) < 14 ? 0 : $rank % 10) {
                                1 => 'st',
                                2 => 'nd',
                                3 => 'rd',
                                default => 'th'
                            };
                            echo $rank . $suffix . " Place";
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