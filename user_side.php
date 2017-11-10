<?php
session_start();
?>

<?php

if(isset($_SESSION['ans']) && !empty($_SESSION['ans'])){
	header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, charset=utf-8;");
	header("Content-Disposition: attachment; filename=" . 'excel-'.date('y-m-d ms').'.xls');
  ?>
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="text-align: left;">
  <tbody>
    <tr>
      <th style="text-align: left;">Email</th>
      <td><?php echo $_SESSION['user_data']->data->user_email; ?></td>
    </tr>
   <!--  <tr>
      <th style="text-align: left;">Year Taken</th>
      <td>2017</td>
    </tr>
    <tr>
      <th style="text-align: left;">Year Born</th>
      <td>1968</td>
    </tr>
    
    <tr>
      <th style="text-align: left;">Company:</th>
      <td>Centrepoint Solutions Inc.</td>
    </tr>
    <tr>
      <th style="text-align: left;">Industry:</th>
      <td>5412 Accounting, Tax Preparation, Bookkeeping, and Payroll Services</td>
    </tr>
    <tr>
      <th style="text-align: left;">Years of Post-secondary education attained:</th>
      <td>7</td>
    </tr>
    <tr>
      <th style="text-align: left;">Years in current position:</th>
      <td>5</td>
    </tr>
    <tr>
      <th style="text-align: left;">Type of position:</th>
      <td>Professional</td>
    </tr>
    <tr>
      <th style="text-align: left;">Number of people directly supervised/managed:</th>
      <td>10</td>
    </tr>
    <tr>
      <th style="text-align: left;">Country from the Ages 5 - 10:</th>
      <td>Canada</td>
    </tr>
    <tr>
      <th style="text-align: left;">State, Province, Prefecture, etc.:  </th>
      <td>BC</td>
    </tr>
    <tr>
      <th style="text-align: left;">Primary Neighbourhood you were in from Ages 5 - 10: </th>
      <td>North Delta </td>
    </tr>
    <tr>
      <th style="text-align: left;">Gender - M, F, X  </th>
      <td>M</td>
    </tr>
    <tr>
      <th style="text-align: left;">What was your first Language: </th>
      <td>English</td>
    </tr>
    <tr>
      <th style="text-align: left;">Country Today </th>
      <td>Canada</td>
    </tr>
    <tr>
      <th style="text-align: left;">State, Province, Prefecture, etc.:</th>
      <td>BC</td>
    </tr>
    <tr>
      <th style="text-align: left;">Primary Neighbourhood Today </th>
      <td>Metrotown</td>
    </tr> -->
  </tbody>
</table> 
<br>
<table width="600" border="1" cellpadding="5" cellspacing="0">
  <tbody>
<?php 

foreach ($_SESSION['ans'] as $key => $value) {
		$arr = explode("-", $value);
?>
  	<tr>
  		<td><?php echo $arr[0]; ?></td>
  		<td>.</td>
  	</tr>
  
<?php 
	}
 ?>
  </tbody>
</table>


<?php
$_SESSION['ans'] = '';
?>


<?php

exit();
wp_die();
}

?>



<?php 

function show_form_to_questionair($attr) {


$current_user = '';
if (is_user_logged_in()){
		 $current_user = wp_get_current_user();
}


if(isset($_POST['ans']) && !empty($_POST['ans'])){

	$_SESSION['ans'] = $_POST['ans'];
	$_SESSION['user_data'] = $current_user;
	$_SESSION['quiz_id'] = $_POST['quiz_id'];

	$qs = $ans = $ovrall = '';
	foreach ($_POST['ans'] as $key => $value) {
		$arr = explode("-", $value);
		$overall .= $arr[0] . ', ';
		$qs .= $arr[1] . ', ';
		$ans .= $arr[2] . ', ';
	}

	global $wpdb;
	$user_answers = $wpdb->prefix . 'user_answers'; 
	$quiz_id = $_POST['quiz_id'];



// echo '<pre>';
// print_r($current_user->data->ID);
// echo '</pre>';
// exit;


$user_id = $current_user->data->ID;

	$wpdb->query("INSERT INTO $user_answers 
					(`user_id`,`questions`, `quiz_id`, `answers`, `quiz_result`) 
					VALUES 
					('$user_id','$qs', '$quiz_id', '$ans', '$overall')");


?>

<script>
	window.location = '<?php echo  get_permalink(); ?>';        	
</script>
<?php


}
	






if(!isset($attr) || empty($attr)) {
	echo '<h2>Admin kindly choose a Questionair to show. likewise ([formQuestion <i>questionair="5"</i>]) </h2>';
}else {
	?>


<form action="<?php echo get_permalink(); ?>?downloadExcel" target="_blank" method="POST" >
<div class="info_form">
	
</div>


<div class="quiz_container">
<style>
	div#qResult-table h4 {
	    font-size: 20px;
	    font-weight: 600;
	    font-size: 18px !important;
	    margin: 0;
	}

	div#qResult-table p {
	    font-size: 14px;
	    margin-bottom: 25px;
	}
	.quiz_ul input {
	    width: 20px;
	    height: 20px;
	    vertical-align: text-bottom !important;
	}
	.quiz_ul label {
	    overflow: hidden;
	}

	.span1 {
	    width: 8%;
	    float: left;
	    display: block;
	}

	.span2 {
	    float: left;
	    width: 92%;
	    display: block;
	}
	.quiz_container *,.quiz_container {
	    font-family: 'Open Sans',sans-serif,Arial;
	}
		.btn-two {
	    display: block;
	    background: black;
	    color: white;
	    font-weight: 600;
	    padding: 10px;
	    transition: all 0.4s;
	    cursor: pointer;
	    text-align: center;
	    text-transform: capitalize;
	    border: black 1px solid;
	    max-width: 200px;
	    margin: auto;
		}
	div#qResult-table {
	    border-top: 1px solid #d5d5d5;
	    padding-top: 21px;
	}
		.btn-two:hover,a.btn-two:hover,a.btn-two:active {
	    background: white;
	    color: black !important;
	    font-weight: 600;
	    text-decoration: none !important;
	}
		.quiz_container {    
		background: #f7f7f7;
	    border: 1px solid #d5d5d5;
	    border-radius: 4px;
	    padding: 20px;
	    -webkit-box-shadow: 0 5px 8px rgba(0,0,0,.1);
	    -moz-box-shadow: 0 5px 8px rgba(0,0,0,.1);
	    box-shadow: 0 5px 8px rgba(0,0,0,.1);
	}

	.quiz_intro-h {
	    color: #3b3b3b;
	    line-height: 0.8;
	    margin-bottom: 10px;
	    margin: 0 0 20px;
	    padding: 0 0 20px;
	    font-size: 32px !important;
	    line-height: 1 !important;
	    font-weight: 500;
	    border-bottom: 1px solid #e5e5e5;
	}

	.quiz_ul {
	    list-style-type: none;
	    margin-left: 20px;
	    padding: 0;
	    margin-bottom: 30px !important
	}
	.quiz_q {
	    color: black;
	    width: 100%;
	    font-size: 18px !important;
	    margin: 6px 0;
	    line-height: 1.5 !important;
	    margin-bottom: 15px;
	    margin-top: 5px;
	}

	.quiz_ul label input {
	    vertical-align: inherit;
	}

	.quiz_ul label {
	    display: block;
	    margin-bottom: 0.5em;
	    color: #3b3b3b;
	    cursor: pointer;
	    vertical-align: middle;
	    font-size: 14px;
	    text-transform: none;
	    font-weight: 400;
	}
	.quiz_intro-p {
	    margin-bottom: 4px;
	}
	.introf {
	    display: none;
	    font-weight: bold;
	    text-decoration: underline;
	    font-size: 15px;
	    color: #333;
	}

	.introf:first-child {
	    display: block;
	    font-size: 18px !important;
	    font-weight: 600;
	}

	.quiz_q {
	    font-weight: 600;
	}

	/* progress bar */
	.progress {
	    position: relative;
	    height: 20px;
	    margin-bottom: 20px;
	    overflow: hidden;
	    background-color: #f5f5f5;
	    border-radius: 4px;
	    -webkit-box-shadow: inset 0 0px 3px 1px rgba(0,0,0,.1);
	    box-shadow: inset 0 0px 3px 1px rgba(0,0,0,.1);
	}
	.progress-bar {
	    float: left;
	    width: 0;
	    height: 100%;
	    font-size: 12px;
	    line-height: 20px;
	    color: #fff;
	    text-align: center;
	    background-color: #337ab7;
	    -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
	    box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
	    -webkit-transition: width .6s ease;
	    -o-transition: width .6s ease;
	    transition: width .6s ease;
	}
	.progress_completed {
	    position: absolute;
	    color: #337ab7;
	    text-align: center;
	    width: 100%;
	    display: block;
	    line-height: 1;
	    text-shadow: 1px 1px white;
	}
</style>
<div id="ajax-response"></div>

<?php
	global $wpdb;
	$charset_collete = $wpdb -> get_charset_collate();

	$answers = $wpdb->prefix . 'answers';
	$questions = $wpdb->prefix . 'questions';
	$quizes = $wpdb->prefix . 'quizes';
	$results = $wpdb->prefix . 'results';

	$quiz_id = $attr['questionair'];
?>
	<div class="progress">
	  	 <span class="progress_completed">0%</span>
		  <div class="progress-bar" style="width:0%">
		  </div>
	</div>
<div class="quiz_div-1">

<?php
$sql = "SELECT  q.title , q.description FROM $quizes q where id = ".$quiz_id;
$result = $wpdb->get_results($sql);
if (count($result) > 0) {


    foreach($result as $row) {
?>

	<div class="quiz_intro">
			<h2 class="quiz_intro-h"><?= $row->title ?></h2>
	</div>


<?php
    }
}else {
	die('no quiz here');
}
?>




 <!--  <tr>
      <th style="text-align: left;">Year Taken</th>
      <td>2017</td>
    </tr>
    <tr>
      <th style="text-align: left;">Year Born</th>
      <td>1968</td>
    </tr>
    
    <tr>
      <th style="text-align: left;">Company:</th>
      <td>Centrepoint Solutions Inc.</td>
    </tr>
    <tr>



    </tr>
    <tr>
      <th style="text-align: left;">State, Province, Prefecture, etc.:</th>
      <td>BC</td>
    </tr>
    <tr>
      <th style="text-align: left;"> </th>
      <td>Metrotown</td>
    </tr> -->


    <tr>
      <th style="text-align: left;">:  </th>
      <td>BC</td>
    </tr>
    <tr>
      <th style="text-align: left;"> </th>
      <td>North Delta </td>
    </tr>
    <tr>
      <th style="text-align: left;"> </th>
      <td>M</td>
    </tr>
    <tr>
      <th style="text-align: left;">What was your first Language: </th>
      <td>English</td>
    </tr>
    <tr>
      <th style="text-align: left;">Country Today </th>
      <td>Canada</td>
<div class="extra_fields">
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Year Taken 31/12/2017" name="year_taken">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Year Born 31/12/2017" name="year_born">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Company" name="company">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Industry" name="industry">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Years of Post-secondary education attained" name="year_post_sec">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Years in current position" name="year_position">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Type of position" name="type_pos">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Number of people directly supervised/managed:" name="num_people">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Country from the Ages 5 - 10:" name="country_age">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="State, Province, Prefecture, etc." name="state">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Primary Neighbourhood you were in from Ages 5 - 10:" name="primary">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Gender - M, F, X " name="gender">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Primary Neighbourhood Today" name="company">
	</div>
</div>



<?php

$sql = "SELECT  q.question , q.id FROM $questions q where quiz_id = ".$quiz_id;
$result = $wpdb->get_results($sql);
$total_rows = count($result);

if ($total_rows > 0) {
 $z = 0;
 $i = 0;
    foreach($result as $row) {
$i++;
?>
<div class="quiz_q_div" id="question-<?= $i; ?>" style="display: <?php  if($i >= 2){echo 'none'; }?>">
	<span class="introf intof_q">Question: <?= $i; ?></span>
	<h2 class="quiz_q"><?= $row->question; ?></h2>
	<span class="introf intof_q">Answer: <?= $i; ?></span>

	<?php
		$ans = "SELECT  a.answer , a.id, a.mark FROM $answers a where a.q_id = ". $row -> id;
	$ansResult = $wpdb->get_results($ans);
	?>

	<input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
	<!-- <input type="hidden" name="ques_id" value="<?= $row -> id; ?>"> -->
	<ul class="quiz_ul">

	<?php	


	$ii = 0;
	$abc = 'a';    
	foreach($ansResult as $ansResultRow ) {
		$ii++;
	?>
	<li>
		<label for="mark-<?= $i?>-<?= $ii;?>">
			<span class="span1">
	<input type="radio" id="Ans-<?= $i?><?= $ii;?>" data-ans="<?= $ansResultRow -> id; ?>" name="ans[<?= $i;?>]" value="<?= $i?><?= $abc;?>-<?= $row -> id?>-<?= $ansResultRow -> id; ?>">
			</span> 
			<span class="span2"><?= $ansResultRow->answer; ?></span>
		</label>
	</li>
	<?php

	$abc++;
		    }
		    ?>

		    </ul>
		    <?php 
		if($i !== $total_rows){
	?>
		    <span class="btn-two q-next">Next</span>
	<?php
		}else{
	 ?>

		    <span class="btn-two q-nextz">Next</span>
	<?php 
		}
		 ?>
	    </div>

	    <?php
    }
    ?>
	    <div class="all_rec">
	    	<input type="hidden" id="older_val" >
	    	<input type="hidden" id="percent_val">
	    	<input type="hidden" id="final_check">
	    	<input type="hidden" id="quiz_no" value="<?= $quiz_id; ?>">
	    	<input type="hidden" id="quiz_result">
	    	

	    </div>

    <?php
} else {
    echo "0 results";
}


?>


<br>
<div class="tablez" id="qResult-table" style="display: none">
<button type="submit" name="submit">Download from here</button>





</div>
<?php 
if(isset($attr['next_page_link']) && !empty($attr['next_page_link'])){
?>
<div class="next_page_link" style="display: none;">
<a class="btn-two" href="<?= $attr['next_page_link']; ?>">Next Questionair</a>
</div>
<?php
}
 ?>


</div>
</div>  <!-- end of main container -->

</form>
	 	<script>


	 	(function($) {


// pattern one

// yellow(0)
// purple(1)
// green (2)
// orange(3)

// yellow(0) + purple(1) = purple(1) 
// green(2)  + purple(1) = green(2)
// orange(3) + purple(1) = yellow(0)
// orange(3) + green(2)  = purple(1)

// 0 + 0 = 0		1 + 0 = 1		2 + 0 =	0		3 + 0 = 3		4 + 0 = 0
// 0 + 1 = 1		1 + 1 = 1		2 + 1 = 2		3 + 1 = 0		4 + 1 = 1
// 0 + 2 =	0		1 + 2 =	2		2 + 2 =	2		3 + 2 = 1		4 + 2 = 2
// 0 + 3 =	3		1 + 3 =	0		2 + 3 =	1		3 + 3 = 3		4 + 3 = 3

// If you select the most choices in any one color category, then your results correspond with the same color category.  

// Equal responses all colors = yellow 

// last quiz, Equal responses all colors = purple 

// you can even see its backend(realtime calculation) by inspect element in browser then click console

//  calculator



	 		function getVal(oldVal, newVal){


				var older_val = $('#older_val');

	 			if(oldVal == 0 && newVal == 0) {
					older_val.val('0');
	 			}
	 			else if(oldVal == 0 && newVal == 1){	 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 0 && newVal == 2){	 					 			
					older_val.val('0');
	 			}
	 			else if(oldVal == 0 && newVal == 3){	 					 			
					older_val.val('3');
	 			}
	 			else if(oldVal == 0 && newVal == 4){	 					 			
					older_val.val('0');
	 			}
	 			
	 			else if(oldVal == 1 && newVal == 0){	 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 1 && newVal == 1){	 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 1 && newVal == 2){	 					 			
					older_val.val('2');
	 			}
	 			else if(oldVal == 1 && newVal == 3){	 					 			
					older_val.val('0');
	 			}
	 			else if(oldVal == 1 && newVal == 4){	 					 			
					older_val.val('1');
	 			}

	 			else if(oldVal == 2 && newVal == 0){	 			
					older_val.val('0');
	 			}
	 			else if(oldVal == 2 && newVal == 1){	 			
					older_val.val('2');
	 			}
	 			else if(oldVal == 2 && newVal == 2){	 					 			
					older_val.val('2');
	 			}
	 			else if(oldVal == 2 && newVal == 3){	 					 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 2 && newVal == 4){	 					 			
					older_val.val('2');
	 			}

	 			else if(oldVal == 3 && newVal == 0){	 			
					older_val.val('3');
	 			}
	 			else if(oldVal == 3 && newVal == 1){	 			
					older_val.val('0');
	 			}
	 			else if(oldVal == 3 && newVal == 2){	 					 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 3 && newVal == 3){	 					 			
					older_val.val('3');
	 			}
	 			else if(oldVal == 3 && newVal == 4){	 					 			
					older_val.val('3');
	 			}

	 			else if(oldVal == 4 && newVal == 0){	 			
					older_val.val('0');
	 			}
	 			else if(oldVal == 4 && newVal == 1){	 			
					older_val.val('1');
	 			}
	 			else if(oldVal == 4 && newVal == 2){	 					 			
					older_val.val('2');
	 			}
	 			else if(oldVal == 4 && newVal == 3){	 					 			
					older_val.val('3');
	 			}
	 			else if(oldVal == 4 && newVal == 4){	 					 			
					older_val.val('4');
	 			}

	 			else {
					older_val.val(newVal);
	 			}
			}

// Progress Bar
function pro_bar (){var progress = $('.progress-bar')[0].style.width;var progress_val = parseInt(progress.replace("%",""));var percent_val = 100 / parseInt($('.quiz_q_div').length);var total_progress =  progress_val + percent_val;$('.progress-bar').css('width', total_progress+'%');$('.progress_completed').text(Math.floor(total_progress)+'%');}



// how many times this value occoured
function countInArray(array, what) {
    var count = 0; 
var array = $('input[type="radio"]:checked').map(function(){
            return parseInt($(this).val());
        }).get()
    for (var i = 0; i < array.length; i++) {
        if (array[i] === what) {
            count++;
        }
    }
    return count;
}


function mode(number){
    var count = 0;
    var sortedNumber = number.sort();
    var start = number[0], item;
    for(var i = 0 ;  i < sortedNumber.length; i++){
      if(start === sortedNumber[i] || sortedNumber[i] === sortedNumber[i+1]){
         item = sortedNumber[i]
      }
    }
    return item
}


	 		$('.q-next').click(function (){
	
				var	divId = $(this).parent().attr('id');
				var checkedEle = $('div#'+divId+' input:checked').val();

				if(checkedEle) {
					$('div#'+divId).hide();
					$('div#'+divId).next('div').show();

					var oldVal = $('#older_val').val();

					if(oldVal){
						getVal(oldVal, checkedEle);
						console.log(oldVal+'+'+checkedEle+'='+$('#older_val').val());
						pro_bar();

// check if most of the questions are			
// if same then pass 1 else pass 0			
						var final_check = $('#final_check');

						if(oldVal == checkedEle) {
							if(final_check.val() == ''){
								final_check.val('1');
							}else if(final_check.val() == 1) {
								final_check.val('1');
							}else {
								final_check.val('0');						
							}
						}else {
							if(final_check.val() == ''){
								final_check.val('0');
							}else {
								final_check.val('0');						
							}							
						}


					}else {
						$('#older_val').val(checkedEle);
						pro_bar();
					}
				}
			});

			
	 		$('.q-nextz').click(function(){

				var final_check = $('#final_check');
				var oldVal = $('#older_val').val();
				var	divId = $(this).parent().attr('id');
				var checkedEle = $('div#'+divId+' input:checked').val();
				if(checkedEle) {
					getVal(oldVal, checkedEle);
					$('div#'+divId).hide();
					var oldVal = $('#older_val').val();


					$('#qResult-table').show();

// checking for Frequently Repeated(30%) Answers
	var ans_checked = $('input[type="radio"]:checked');
 	var list = ans_checked.map(function(){
            return parseInt($(this).val());
        }).get();


 	var total_qes = $('.quiz_q_div').length;
	var total_per = Math.ceil( total_qes * 30 / 100);
	var valu_rep = mode(list);
	var valu_repitions = countInArray(list, valu_rep);
	
// End of checking for Frequently Repeated Answers

<?php

if(isset($attr['pattern']) && !empty($attr['pattern'])){

?>
	if(final_check.val() == 1){
		oldVal = 1;
		console.log('pattern 2, All answers were same');
	}else {
		if(valu_repitions >= total_per ){
			console.log('total 30% of '+total_qes+' Questions = '+ total_per); // total questions
			console.log('repeated Answer = '+valu_rep); 
			console.log('repeated times = '+valu_repitions); 
			oldVal = valu_rep;
		}else{
			console.log('all values were different and could not touch the limit of percentage '+total_per);
					console.log(oldVal+'+'+checkedEle+'='+$('#older_val').val());
		}
	}
<?php 

}else {
 ?>
	if(final_check.val() == 1){
		oldVal = 0;
		console.log('All answers were same');
	}else {
		if(valu_repitions >= total_per ){
			console.log('total 30% of '+total_qes+' Questions = '+ total_per); // total questions
			console.log('repeated Answer = '+valu_rep); 
			console.log('X repeated = '+valu_repitions); 
			oldVal = valu_rep;
		}else{
			console.log('all values were different and could not touch the limit of percentage '+total_per);
					console.log(oldVal+'+'+checkedEle+'='+$('#older_val').val());
		}
	}
<?php 
} 
?>

				 	$('#quiz_result').val(oldVal);

					$('#qResult-'+oldVal).show();
					$('.next_page_link').show();
					$('#resulter').hide();

		 			$('.progress-bar').css('width','100%');
		 			$('.progress_completed').text('100%');

				}
	 		});
})( jQuery );




	 	</script>

	<?php
}


}
add_shortcode('formQuestion', 'show_form_to_questionair');

 ?>