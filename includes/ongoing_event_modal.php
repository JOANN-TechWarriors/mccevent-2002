<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4><strong>ADD MAIN EVENT</strong></h4><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <table align="center" class="table table-bordered cp" id="example">
            
            <tbody>
              <tr>
                <td>
                  <strong>Event #:</strong><br />
                  <input name="sy" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" type="number" placeholder="0" required />
                  <br />
                  <strong>Event Name:</strong><br />
                  <input type="text" name="main_event" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" placeholder="Event Name" required />
                  <br />
                  <strong>Date Start:</strong><br />
                  <div class="container">
                    <input type="date" name="date_start" min="2023-04-25" class="form-control btn-block" required />
                  </div>
                  <strong>Date End:</strong><br />
                  <div class="container">
                    <input type="date" name="date_end" min="2023-04-25" class="form-control btn-block" required />
                  </div>
                  <strong>Time Start:</strong><br />
                  <div class="container">
                    <input type="time" name="event_time" required placeholder="hh:mm" class="form-control btn-block" />
                  </div>
                  <strong>Venue:</strong><br />
                  <textarea name="place" class="form-control btn-block" style="text-indent: 10px !important;" placeholder="Event Venue" required rows="2"></textarea>
                  <br />
                </td>
              </tr>
            </tbody>
          </table>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button title="Click to save" name="create" type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>SAVE</strong></button>
      </div>
        </form>
      </div>
     
    </div>
  </div>
</div>

<?php 
<<<<<<< HEAD
include ("../admin/dbcon.php");
=======
include "dbcon.php";
>>>>>>> b77b374fd7ac336d8cec2548774a60ff6476fedd
if(isset($_POST['create'])) {
  $event_name = $_POST['main_event']; 
  $date_start = $_POST['date_start']; 
  $date_end = $_POST['date_end']; 
  $event_place = $_POST['place']; 
  $event_sy = $_POST['sy']; 

  $org_query = $conn->query("SELECT * FROM main_event WHERE organizer_id='$session_id'") or die(mysqli_error($conn));
  $num_row = $org_query->num_rows;
  if($num_row > 0) {
    $conn->query("INSERT INTO main_event(event_name, status, organizer_id, date_start, date_end, place, sy) VALUES('$event_name', 'activated', '$session_id', '$date_start', '$date_end', '$event_place', '$event_sy')");
  } else {
    $conn->query("INSERT INTO main_event(event_name, status, organizer_id, date_start, date_end, place, sy) VALUES('$event_name', 'activated', '$session_id', '$date_start', '$date_end', '$event_place', '$event_sy')");
  } 
?>
<script>
alert('Event <?php echo $event_name; ?> successfully added...');
window.location = 'ongoing_event.php';
</script>
<?php } ?>
