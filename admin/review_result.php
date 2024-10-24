 
   
<!DOCTYPE html>
<html lang="en">
<head>
      
<?php
include('header2.php');
include('session.php');
  
$mainevent_id=$_GET['mainevent_id'];
$subevent_id=$_GET['sub_event_id'];
?>

<style>
    body {
        background-color: #f3f4f6;
        padding: 2rem 1rem;
        margin: 0;
    }
    .paper-container {
        max-width: 8.5in;
        width: 100%;
        min-height: 11in;
        margin: 0 auto;
        background: white;
        padding: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
    .content {
        position: relative;
        z-index: 1;
    }
    .table-responsive {
        width: 100%;
        margin-bottom: 1rem;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border: 1px solid #dee2e6;
    }
    .table-nested {
        margin: 0;
        width: 100%;
    }
    .header-center {
        text-align: center;
        margin-bottom: 2rem;
    }
    .header-center h2,
    .header-center h3 {
        margin: 0.5rem 0;
    }
    .section-title {
        margin: 1.5rem 0;
    }
    .contestant-place {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
    }
    @media (max-width: 768px) {
        .paper-container {
            padding: 0.5rem;
        }
        .table th,
        .table td {
            padding: 0.5rem;
        }
    }
</style>

<body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div class="paper-container">
        <div class="paper-border"></div>
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="span12">
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

                        <h3 class="section-title">Contestants</h3>
                        
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
                                        $contestant_id=$o_result_row['contestant_id'];
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
                                                <table class="table table-nested">
                                                    <tr>
                                                        <th>Judge</th>
                                                        <th>Score</th>
                                                        <th>Rank</th>
                                                    </tr>
                                                    <?php
                                                    $divz=0;
                                                    $totx_score=0;
                                                    $rank_score=0;
                                                    $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                                        $divz=$divz+1;  
                                                        $place_title=$tot_score_row['place_title'];
                                                    } 

                                                    $tot_score_query = $conn->query("select judge_id,total_score,rank from sub_results where contestant_id='$contestant_id'") or die(mysql_error());
                                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                                        $totx_score=$totx_score+$tot_score_row['total_score'];
                                                        $rank_score=$rank_score+$tot_score_row['rank'];
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                            $jx_id=$tot_score_row['judge_id'];
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
                                        <td class="contestant-place"><?php echo $place_title ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php 
                            }
                        } 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
      
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
    while ($judge_row = $judge_query->fetch()) 
        { ?>
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
  $percnt=0;
   	$crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$subevent_id'") or die(mysql_error());
    while ($crit_row = $crit_query->fetch()) 
        { $percnt=$percnt+$crit_row['percentage'];
            $crit_id=$crit_row['criteria_id'];
            ?>
  <tr>
  
   <td><?php echo $crit_row['criteria_ctr']; ?></td>
      <td><?php echo $crit_row['criteria']; ?></td>
       <td><?php echo $crit_row['percentage']; ?></td>
        
  </tr>
   <?php } ?>
   
     <tr>
  
    <?php
      if($percnt<100)
      { ?>
     <td colspan="2">
       <div class="alert alert-danger pull-right">
  
  <strong>The Total Percentage is under 100%.</strong> 
</div>
     </td>
      <td colspan="1">
        <div class="alert alert-danger">
  
  <strong><?php  echo $percnt; ?></strong> 
</div> 
    </td>
       
        <?php } ?>
        
         <?php
      if($percnt>100)
      { ?>
     <td colspan="2">
     <div class="alert alert-danger pull-right">
  
  <strong>The Total Percentage is over 100%.</strong> 
</div>
      </td>
       <td colspan="1">
        <div class="alert alert-danger">
  
  <strong><?php  echo $percnt; ?></strong> 
</div>
    
    </td>
       
        <?php } ?>
        
        
         <?php
      if($percnt==100)
      { ?>
    <td colspan="2"></td>
      <td colspan="1">
     <span class="badge badge-info"><?php  echo $percnt; ?></span>
    </td>
        
        <?php } ?>
  </tr>
 
  </tbody>
 
  </table>
          
          
          
          
          
          
            
           <?php if($s_event_row['txtpoll_status']=="active")
           { ?>
            
           
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
    while ($cont_row = $cont_query->fetch()) 
        { 
            $cont_id=$cont_row['contestant_id'];
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
  
  
  
  
  
  
           <?php }  } ?>
       
 
    </div>

  </div>
 
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
