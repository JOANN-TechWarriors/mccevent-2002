<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php 
function randomcode() {
$var = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$code = '' ;
while ($i <= 5) {
$num = rand() % 33;
$tmp = substr($var, $num, 1);
$code = $code . $tmp;
$i++;
}
return $code;
}



function randomcode2() {
$var2 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i2 = 0;
$code2 = '' ;
while ($i2 <= 5) {
$num2 = rand() % 33;
$tmp2 = substr($var2, $num2, 1);
$code2 = $code2 . $tmp2;
$i2++;
}
return $code2;
}
 

function randomcode3() {
$var3 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i3 = 0;
$code3 = '' ;
while ($i3 <= 5) {
$num3 = rand() % 33;
$tmp3 = substr($var3, $num3, 1);
$code3 = $code3 . $tmp3;
$i3++;
}
return $code3;
}  



function randomcode4() {
$var4 = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i4 = 0;
$code4 = '' ;
while ($i4 <= 5) {
$num4 = rand() % 33;
$tmp4 = substr($var4, $num4, 1);
$code4 = $code4 . $tmp4;
$i4++;
}
return $code4;
}
 
?>




<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    error_reporting(0);
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    
     	$query = $conn->query("SELECT * FROM contestants WHERE subevent_id='$sub_event_id'");
			$row = $query->fetch();
			$num_row = $query->rowcount();
		      if( $num_row > 0 ) 
                { 
                    ?>	<script>
               
								window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
							</script><?php
                }
                
                
                $query = $conn->query("SELECT * FROM judges WHERE subevent_id='$sub_event_id'");
			$row = $query->fetch();
			$num_row = $query->rowcount();
		      if( $num_row > 0 ) 
                { 
                    ?>	<script>
               
								window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
							</script><?php
                }
                
                
                $query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$sub_event_id'");
			$row = $query->fetch();
			$num_row = $query->rowcount();
		      if( $num_row > 0 ) 
                { 
                    ?><script>
               
								window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
							</script><?php
                }
        
  ?>


<style type="text/css">
#footer{
	position: fixed;
	bottom: 20px;
	right: 20px;
    background-color: lightyellow;
    border: 2px solid black;
    box-shadow: 3px 3px 8px #818181;
    padding: 4px;
    width: 200px;
}
#main{
margin:0 auto;
width:200px;
border:1px solid gray;
padding:10px;
}

</style>
 
 <script type="text/javascript" src="..//includes/bootstrap/js/jquery-latest.js"></script>

 <body data-spy="scroll" data-target=".bs-docs-sidebar">
 
   
       <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
       
         
               
       
            <ul  >
            
             
      
               
              <li>
              <br />
                  <a href="home.php">Home | Organizer: <b><?php echo $name; ?></b></a>
              </li>
              
              
                   
          
            </ul>
        
       
            
        </div>
      </div>
    </div>
   <br><br><br>
    <div class="container">

   <form method="POST" enctype="multipart/form-data">
   
    
  <input type="hidden" value="<?php echo $se_name; ?>" name="se_name" />
  <input name="code1" type="hidden" value="<?php echo randomcode(); ?>" />
  <input name="code2" type="hidden" value="<?php echo randomcode2(); ?>" />
  <input name="code3" type="hidden" value="<?php echo randomcode3(); ?>" />
  <input name="code4" type="hidden" value="<?php echo randomcode4(); ?>" />
 
 
   
   <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 
  
  <div class="col-lg-4">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Contestant's Settings</h3>
            </div>
 
 
    <div class="panel-body">
 
<style type="text/css">
/*
#main {
    max-width: 800px;
    margin: 0 auto;
}*/
</style>
 
<div id="main">
     
    <div class="my-form">

            <p class="text-box">
            <label for="box1">Contestant No. <span class="box-number">1</span></label>
    <input type="text" placeholder="Contestant Course" name="cour1" id="cour1" required="true" />
    <br><br>
    <input type="file" name="pic1" id="pic1" accept="image/*" required="true" />
    <br>
    <input type="text" placeholder="Contestant Fullname" name="con1" id="con1" required="true" />
    <input type="hidden" value="<?php echo rand(100000,999999); ?>" name="rand1" id="rand1" required="true"/>
    <br><br>

    <label for="box2">Contestant No. <span class="box-number">2</span></label>
    <input type="text" placeholder="Contestant Course" name="cour2" id="cour2" required="true" />
    <br><br>
    <input type="file" name="pic2" id="pic2" accept="image/*" required="true" />
    <br>
    <input type="text" placeholder="Contestant Fullname" name="con2" id="con2" required="true"/>
    <input type="hidden" value="<?php echo rand(100000,999999); ?>" name="rand2" id="rand2" required="true"/>
    <br><br>
                
            </p>
            <p><a class="add-box" href="#">Add Contestant</a></p>
      
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('.my-form .add-box').click(function(){
        var n = $('.text-box').length + 3; // Adjust starting index as needed
        if( 15 < n ) {
            alert('Maximum Number of Contestants reached!');
            return false;
        }
        var box_html = $('<p class="text-box"><label for="box' + n + '">Contestant No. <span class="box-number">' + n + '</span></label> <input type="text" placeholder="Course" name="cour' + n + '" id="cour' + n + '" required="true" /> <br><br> <input type="file" name="pic' + n + '" id="pic' + n + '" accept="image/*" required="true" /> <br><input type="text" placeholder="Contestant Fullname" name="con' + n + '" id="con' + n + '" required="true" /> <input type="hidden" value="<?php echo rand(100000,999999); ?>" name="rand' + n + '" id="rand' + n + '" required="true" /> <a href="#" class="remove-box">Remove</a></p>');
        box_html.hide();
        $('.my-form p.text-box:last').after(box_html);
        box_html.fadeIn('slow');
        return false;
    });

    $('.my-form').on('click', '.remove-box', function(){
        $(this).parent().css('background-color', '#FF6C6C');
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.box-number').each(function(index){
                $(this).text(index + 1);
            });
        });
        return false;
    });
});
</script>
 
 
</div>
 
          </div>
          
        
  </div>
  
  
   <div class="col-lg-4">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Judge's Settings</h3>
            </div>
 
 


 
     <div class="panel-body">
  
<style type="text/css">
/*
#main {
    max-width: 800px;
    margin: 0 auto;
}
*/
</style>
 
<div id="main">
     
    <div class="my-formx">
      
            <p class="text-boxx">
                <label for="boxx1">Judge No. <span class="boxx-number">1</span></label>
                <input type="text" name="jud1" placeholder="Judge Fullname" value="" id="boxx1" required="true" />
         
                <label for="boxx2">Judge No. <span class="boxx-number">2</span></label>
                <input type="text" name="jud2" placeholder="Judge Fullname" value="" id="boxx2" required="true" />
           
              
            </p>
            <p><a class="add-boxx" href="#">Add Judge</a></p>
      
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('.my-formx .add-boxx').click(function(){
        var m = $('.text-boxx').length + 2;
        if( 4 < m ) {
            alert('Maximum Number of Judges reach!');
            return false;
        }
        var boxx_html = $('<p class="text-boxx"><label for="boxx' + m + '">Judge No. <span class="boxx-number">' + m + '</span></label> <input type="text" placeholder="Judge Fullname" name="jud' + m + '" value="" id="boxx' + m + '" required="true" /> <a href="#" class="remove-boxx">Remove</a></p>');
        boxx_html.hide();
        $('.my-formx p.text-boxx:last').after(boxx_html);
        boxx_html.fadeIn('slow');
        return false;
    });
    $('.my-formx').on('click', '.remove-boxx', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.boxx-number').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });
});
</script>
 
 
</div>
 
          </div>
          
        
  </div>
  
  
  
   <div class="col-lg-4">
 <div class="panel panel-primary">
            <div class="panel-heading">
             <h3 class="panel-title">Criteria's Settings </h3>
            </div>
       <div class="panel-body">
 
 
  
<style type="text/css">
/*
#main {
    max-width: 800px;
    margin: 0 auto;
}
*/
</style>
 
<div id="main">
     
    <div class="my-formxj">
       
            <p class="text-boxxj">
                <label for="boxxj1">Criteria No. <span class="boxxj-number">1</span></label>
               
                <input type="text" name="crit1" placeholder="Description" value="" id="boxxj1" required="true" />
                
        &nbsp;&nbsp;&nbsp;Criteria Points: <select style="margin-top: 5px !important;" name="cp1"> 
  <?php
  $n1=-1;
  while($n1<100)
  { $n1=$n1+1;
    
    ?>
    <option><?php echo $n1; ?></option>
  <?php } ?>
  </select>%<br />
                <label for="boxxj2">Criteria No. <span class="boxxj-number">2</span></label>
                <input type="text" name="crit2" placeholder="Description" value="" id="boxxj2" required="true" />
            &nbsp;&nbsp;&nbsp;Criteria Points: <select style="margin-top: 5px !important;" name="cp2"> 
  <?php
  $n1=-1;
  while($n1<100)
  { $n1=$n1+1;
    
    ?>
    <option><?php echo $n1; ?></option>
  <?php } ?>
  </select>%<br />
                
            </p>
            <p><a class="add-boxxj" href="#">Add Criteria</a></p>
      
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($){
    $('.my-formxj .add-boxxj').click(function(){
        var j = $('.text-boxxj').length + 2;
        if( 8 < j ) {
            alert('Maximum Number of Criteria reach!');
            return false;
        }
        var boxxj_html = $('<p class="text-boxxj"><label for="boxxj' + j + '">Criteria No. <span class="boxxj-number">' + j + '</span></label> <input type="text" placeholder="Description" name="crit' + j + '" value="" id="boxxj' + j + '" required="true" /> &nbsp;&nbsp;&nbsp;Criteria Points: <select style="margin-top: 5px !important;" name="cp' + j + '"> <?php  $n1=-1; while($n1<100){ $n1=$n1+1; echo "<option>".$n1."</option>"; } ?> </select>% <a href="#" class="remove-boxxj">Remove</a></p>');
        boxxj_html.hide();
        $('.my-formxj p.text-boxxj:last').after(boxxj_html);
        boxxj_html.fadeIn('slow');
        return false;
    });
    $('.my-formxj').on('click', '.remove-boxxj', function(){
        $(this).parent().css( 'background-color', '#FF6C6C' );
        $(this).parent().fadeOut("slow", function() {
            $(this).remove();
            $('.boxxj-number').each(function(index){
                $(this).text( index + 1 );
            });
        });
        return false;
    });
});
</script>
 
 
</div>
 
          </div>
          
        
  </div>
 
 

 <div id="footer">
 
  <table><tr>
  <td><button name="save_settings" id="submit" type="submit"  class="btn btn-primary">Save Settings</button></td>
  <td>&nbsp;</td>
  <td><a href="home.php"  class="btn btn-default">Cancel</a></td>
  </tr></table>
   
 
</div>
</form>
          </div>
          
          
<?php 

if(isset($_POST['save_settings']))
{
  $sub_event_id = $_POST['sub_event_id'];
  $se_name = $_POST['se_name'];

  for ($i = 1; $i <= 15; $i++) {
      if(isset($_POST["con$i"])) {
          $con_name = $_POST["con$i"];
          $rand_code = $_POST["rand$i"];
          $cour_name = $_POST["cour$i"];
          $pic_name = $_FILES["pic$i"]['name'];
          $pic_tmp_name = $_FILES["pic$i"]['tmp_name'];
          
          if($con_name != "") {
              $target_dir = "../img/";
              $target_file = $target_dir . basename($pic_name);
              
              if (move_uploaded_file($pic_tmp_name, $target_file)) {
                  $conn->query("INSERT INTO contestants (fullname, subevent_id, contestant_ctr, rand_code, AddOn, Picture) VALUES ('$con_name', '$sub_event_id', '$i', '$rand_code', '$cour_name', '$target_file')");
              } else {
                  echo "Sorry, there was an error uploading the file.";
              }
          }
      }
  }
 
 /* end contestants */
   

   
   /* judges */
   
    $code1=$_POST['code1'];
    $code2=$_POST['code2'];
    $code3=$_POST['code3'];
    $code4=$_POST['code4'];
  

   $j1_name=$_POST['jud1'];
   if($j1_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr,code)values('$j1_name','$sub_event_id','1','$code1')");
   }
   
   
   $j2_name=$_POST['jud2'];
   if($j2_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr,code)values('$j2_name','$sub_event_id','2','$code2')");
   }
   
   
   $j3_name=$_POST['jud3'];
   if($j3_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr,code)values('$j3_name','$sub_event_id','3','$code3')");
   }
   
   
   $j4_name=$_POST['jud4'];
   if($j4_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr,code)values('$j4_name','$sub_event_id','4','$code4')");
   }
   
 
 /* end judges */
 
 

  /* criteria */
   $c1_name=$_POST['crit1']; 
    $cp1=$_POST['cp1'];
  if($c1_name!="" or $cp1>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c1_name','$sub_event_id','$cp1','1')"); 
    }
    
    
       $c2_name=$_POST['crit2']; 
    $cp2=$_POST['cp2'];
   if($c2_name!="" or $cp1>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c2_name','$sub_event_id','$cp2','2')"); 
    }
    
    
       $c3_name=$_POST['crit3']; 
    $cp3=$_POST['cp3'];
    if($c3_name!="" or $cp3>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c3_name','$sub_event_id','$cp3','3')"); 
    }
    
    
       $c4_name=$_POST['crit4']; 
    $cp4=$_POST['cp4'];
   if($c4_name!="" or $cp4>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c4_name','$sub_event_id','$cp4','4')"); 
    }
    
    
       $c5_name=$_POST['crit5']; 
    $cp5=$_POST['cp5'];
    if($c5_name!="" or $cp5>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c5_name','$sub_event_id','$cp5','5')"); 
    }
    
    
       $c6_name=$_POST['crit6']; 
    $cp6=$_POST['cp6'];
    if($c6_name!="" or $cp6>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c6_name','$sub_event_id','$cp6','6')"); 
    }
    
    
       $c7_name=$_POST['crit7']; 
    $cp7=$_POST['cp7'];
   if($c7_name!="" or $cp7>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c7_name','$sub_event_id','$cp7','7')"); 
    }
    
    
       $c8_name=$_POST['crit8']; 
    $cp8=$_POST['cp8'];
    if($c8_name!="" or $cp8>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c8_name','$sub_event_id','$cp8','8')"); 
    }
 
 
    /* end criteria */
 
 
 ?>
<script>
window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
alert('Event details successfully set.');						
</script>
<?php  
 
 
} ?>
  
<?php include('footer.php'); ?>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
