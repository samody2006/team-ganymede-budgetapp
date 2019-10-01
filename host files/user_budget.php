<?php
include 'connect.php';?>

<?php
function budgetItemfxn($conn){
	$bugetItem = "SELECT subcategory_name FROM budget_subcategory";
				$budgetitemQuery = mysqli_query($conn, $bugetItem);

				if(mysqli_num_rows($budgetitemQuery) > 0){
					$budgetRows = mysqli_fetch_assoc($budgetitemQuery); 
									
					foreach ($budgetRows as $key => $value) {
						$output = '<option value="'.$value.'">'.$value.'</option>';
						return $output;
					}
					
				}
				//return $output;										
}
?>

<?php

session_start();

if(isset($_POST['submit'])){

	$formValues = $_POST;

	$netAmt = $formValues['net_income'];
	$budgetItem = $formValues['item_unit'];
	$priority = $formValues['priority'];
	$user_id = isset($_SESSION['id'];

	if(!empty($formValues)){

		 $userIncome = "INSERT INTO user_amount (user_id, amount_entered) VALUES ('".$user_id."', '".$netAmt."')";

		 $userIncomeQuery = mysqli_query($conn, $userIncome);

		 $retrieve_last_insert_query = "SELECT * FROM user_amount WHERE id =(SELECT LAST_INSERT_ID()) AND user_id='".$user_id."'";
		 $retrieve_last_insert = mysqli_query($conn, $retrieve_last_insert_query);

		 if(mysqli_num_rows($retrieve_last_insert) > 0){
		 	$rows = mysqli_fetch_assoc($retrieve_last_insert);

		 	foreach ($budgetItem as $key => $value) {
		 		# code...
		 		$budget_item_priority = $priority[$key];
		 		$budgeted_amount = ($budget_item_priority)/100 * $netAmt;
		 		
		 		$sql = "INSERT INTO user_budget_expense (user_id, user_budget_id, priority_id, user_amount_id, amount) VALUES ('".$user_id."', '".$budgetItem[$key]."', '".$priority[$key]."', '".$rows['id']."', '".$budgeted_amount."')";
		 		$query1 = mysqli_query($conn, $sql);

		 		$retrieve_last_budget_insert_query = "SELECT * FROM user_budget_expense WHERE id =(SELECT LAST_INSERT_ID()) AND user_id='".$user_id."'";
		 		$retrieve_last_budget_insert = mysqli_query($conn, $retrieve_last_budget_insert_query);

				if(mysqli_num_rows($retrieve_last_budget_insert) > 0){
				 	$Rows = mysqli_fetch_assoc($retrieve_last_budget_insert);
				 }
				}
		 }	
	}
	header('Location: budgetindex.php?id='.$rows['id']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ganymede</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/1129efb8ac.js"></script>      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
    <style>
    .border-black{
        border: 3px solid black !important;
    }
    input[type="checkbox"]{
        height: 30px;
        width: 30px;
    }
    .remove-glow:focus{
        outline: none;
        border: 3px solid black !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }
    .remove-glow-2:focus{
        outline: none;
        border: 1px solid #cccccc !important;
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        box-shadow: none !important;
    }
</style>
</head>
<body>
    <div class="container border-black py-4 mt-5 rounded w-50">
        <div class="container">

            <p class="text-primary">We need information on your Income and Expenditures to help you plan better</p>
            <p>Fill in the following information:</p>

            <form action="#" id="add_name" method="post">
                <div class="form-group">
                    <label class="h5">Net Income:</label>
                    <input type="number" name="net_income" class="remove-glow border-black rounded form-control col-md-3 pl-3">
                </div>
                <h5>Expenditures:</h5>
                <button type="button" class="btn btn-success" id="add">
                        <span>
                            Add Items
                        </span>
                        <i class="fas fa-plus text-white" ></i>
                </button>
                <div id="dynamic_field">
                </div> 
                <!-- <h6 class="mt-4">Add More</h6> -->
                <input type="submit" id="submit" value="Continue" name="submit" class="mt-4 form-control btn btn-primary">
            </form>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

<script type="text/javascript">
    $(document).ready(function(){  
      var i=1;  
    //   var maximum = 15;
    //   if (i < maximum){
        $('#add').click(function(){  
           // var html = '';
           var html = '';
           		html += '<div class="row">';
				  html += '<div class="col-md-6"><select name="item_unit[]" class="form-control item_unit"><option value="">Select Item</option><?php echo budgetItemfxn($conn); ?></select></div>';
				  html += '<div class="col-md-6"><select name="priority[]" class="form-control priority"><option selected disabled>Priority</option><option value="5">High</option><option value="3">Medium</option><option value="1">Low</option></select></div>';
				  html += '</div>';
			$('#dynamic_field').append(html); 
    });  

      $('#dynamic_field').on('click', '.btn_remove', function(e){  
         var button_id = $(this).attr("id");   
         $('#row'+button_id+'').remove();  
     });         
     });  
    
</script>
</html>