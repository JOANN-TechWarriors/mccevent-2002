<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header2.php'); ?>
    <?php include('session.php'); ?>
    
    <style>
        /* Bond paper styling */
        body {
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        
        .paper-container {
            background-color: white;
            width: 8.5in;
            min-height: 11in;
            margin: 0 auto;
            padding: 1in;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }
        
        @media screen and (max-width: 8.5in) {
            .paper-container {
                width: 100%;
                padding: 20px;
            }
        }
        
        /* Responsive table styles */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 1rem;
        }
        
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }
        
        /* Center alignment for headers */
        .header-content {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .header-content h2,
        .header-content h3 {
            margin: 0.5rem 0;
        }
        
        /* Signature section styling */
        .signature-section {
            margin-top: 2rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 2rem;
        }
        
        .signature-block {
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid black;
            margin: 0.5rem auto;
            width: 80%;
        }
        
        /* Print specific styles */
        @media print {
            body {
                background: none;
                padding: 0;
            }
            
            .paper-container {
                box-shadow: none;
                padding: 0.5in;
            }
            
            .no-print {
                display: none;
            }
            
            footer {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="paper-container">
        <?php   
        $active_main_event = $_GET['mainevent_id'];
        $active_sub_event = $_GET['sub_event_id'];
        
        $event_query = $conn->query("select * from main_event where mainevent_id='$active_main_event'");
        while ($event_row = $event_query->fetch()) { 
            $s_event_query = $conn->query("select * from sub_event where subevent_id='$active_sub_event'");
            while ($s_event_row = $s_event_query->fetch()) {
        ?>
        
        <div class="header-content">
            <center style="font-size: 100px;"><?php include('doc_header.php'); ?></center> <br> <br>
            
            <h2 style="font-size: 20px;"><?php echo $event_row['event_name']; ?></h2>
            <h3 style="font-size: 20px;">Over All Result - <?php echo $s_event_row['event_name']; ?></h3>
        </div>
        <br> <br>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. & Contestant Name</th>
                        <th>Result Summary</th>
                        <th>Place Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $o_result_query = $conn->query("select distinct contestant_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by place_title ASC");
                    while ($o_result_row = $o_result_query->fetch()) {
                        $contestant_id = $o_result_row['contestant_id'];
                    ?>
                    <tr>
                        <td>
                            <?php
                            $cname_query = $conn->query("select * from contestants where contestant_id='$contestant_id'");
                            while ($cname_row = $cname_query->fetch()) {
                                echo $cname_row['contestant_ctr'] . "." . $cname_row['fullname'];
                            }
                            ?>
                        </td>
                        <td>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Average Score</th>
                                        <th>Sum of Rank in all Judges</th>
                                    </tr>
                                    <?php
                                    $divz = 0;
                                    $totx_score = 0;
                                    $rank_score = 0;
                                    
                                    $tot_score_query = $conn->query("select * from sub_results where contestant_id='$contestant_id'");
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $divz++;
                                        $place_title = $tot_score_row['place_title'];
                                    }
                                    
                                    $tot_score_query = $conn->query("select judge_id,total_score,rank from sub_results where contestant_id='$contestant_id'");
                                    while ($tot_score_row = $tot_score_query->fetch()) {
                                        $totx_score += $tot_score_row['total_score'];
                                        $rank_score += $tot_score_row['rank'];
                                    }
                                    ?>
                                    <tr>
                                        <td><b>Ave: <?php echo round($totx_score/$divz,2) ?></b></td>
                                        <td><b>Sum: <?php echo $rank_score; ?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td class="text-center"><h3><?php echo $place_title; ?></h3></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="signature-section">
            <?php
            // Judges Signatures
            $jjn_result_query = $conn->query("select distinct judge_id from sub_results where mainevent_id='$active_main_event' and subevent_id='$active_sub_event' order by judge_id ASC");
            while ($jjn_result_row = $jjn_result_query->fetch()) {
                $jx_id = $jjn_result_row['judge_id'];
                $jname_query = $conn->query("select * from judges where judge_id='$jx_id'");
                $jname_row = $jname_query->fetch();
            ?>
            <div class="signature-block">
                <div class="signature-line"></div>
                <strong><?php echo $jname_row['fullname']; ?></strong>
                <div>Judge</div>
            </div>
            <?php } ?>
            
            <?php
            // Tabulator Signature
            $jjn_result_query = $conn->query("select * from organizer where org_id='$session_id'");
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line"></div>
                <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?></strong>
                <div>Tabulator</div>
            </div>
            <?php } ?>
            
            <?php
            // Organizer Signature
            $jjn_result_query = $conn->query("select * from organizer where organizer_id='$session_id'");
            while ($jjn_result_row = $jjn_result_query->fetch()) {
            ?>
            <div class="signature-block">
                <div class="signature-line"></div>
                <strong><?php echo $jjn_result_row['fname']." ".$jjn_result_row['mname']." ".$jjn_result_row['lname']; ?></strong>
                <div>Organizer</div>
            </div>
            <?php } ?>
        </div>
        
        <button type="submit" onclick="window.print()" class="btn btn-default pull-right no-print">
            <i class="icon-print"></i>
        </button>
        
        <?php } } ?>
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


    <!-- Analytics
    ================================================== -->
    <script>
      var _gauges = _gauges || [];
      (function() {
        var t   = document.createElement('script');
        t.type  = 'text/javascript';
        t.async = true;
        t.id    = 'gauges-tracker';
        t.setAttribute('data-site-id', '4f0dc9fef5a1f55508000013');
        t.src = '//secure.gaug.es/track.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(t, s);
      })();
    </script>

  </body>
</html>
