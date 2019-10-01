<?php

session_start();
	include 'connect.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BudgetIt - Income</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
    <!--<link rel="stylesheet" href="./css/style.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/1129efb8ac.js"></script>      
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
    <style>
         .col-8{
            padding-left: 5%;
            padding-top: 10%;
            color: #41424E;
        }
        .col-4{
            background-color:#41424E;
            color:#CDCDCD; 
            line-height: 5em;
            margin:0 auto;
            padding-bottom: 10%;
        }
        .side-bar-links {
            color: #CDCDCD;
            
        }
        .side-bar-links:hover{
            text-decoration: none;
            color: #FF7800;
            
        }
        .side-bar-list{
            padding-left: 5%;   
        }
        .col-4 li {
            border-bottom: 1px solid #CDCDCD;    
        }
        #net-income{
            padding-left: 5px;
        }
        
        .expenditure{
            padding-bottom: 5%;
        }
        
        .continue:hover{ 
            background-color: #41424E!important;
            outline: 0;
        }
        .continue:active{
            outline: 0;
            border: none !important;
            box-shadow: none !important;
        }
        #user-image{
            width:150px;
            height: 150px;
        }
    </style>
</head>
<body>
 <nav class="flex">
        <figure>
            <img
					src="https://res.cloudinary.com/angelae/image/upload/v1569493481/Start-ng-Pre-internship/n2mmwn3pvnbjuaqjjkj3.png"
					alt="Logo"
					style="width: 63px; height: 63px; padding: 10px;"
				/>
        </figure>
        <div class="big-nav hidden">
            <ul>
                <a href="" class="toplinks"><li>Why BudgetIt?</li></a>
                <a href="" class="toplinks"><li>Solutions</li></a>
                <a href="" class="toplinks"><li>Resources</li></a>
                <a href="" class="toplinks"><li>How it works</li></a>
                <a href="" class="toplinks"><li>Support</li></a>
            </ul>
            <div>
                <a href="logout.php" >LOG OUT</a>
            </div>
        </div>
        <i class="fa fa-bars"></i>
        <div class="small-nav hidden">
            <a href="" class="toplinks">Why Budget It?</a>
            <a href="" class="toplinks">Solutions</a>
            <a href="" class="toplinks">Resources</a>
            <a href="" class="toplinks">How it Works</a>
            <a href="" class="toplinks">Support</a>
            <a href="">LOG OUT</a>
        </div>
    </nav>
    
    <section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4"><br>
                <div style="align-content: center;">
                </div>
                <div style="padding: 3%; font-size: 20px;">
                    <ul class="side-bar-list">
                        <li><i class='fas fa-home'></i> &nbsp;<a href="./index.html" class ="side-bar-links">Home</a></li>
                        <li><i class='fa fa-user'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links">Account</a></li>
                        <li><i class='fa fa-line-chart'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links">Dashboard</a></li>
                        <li><i class='fa fa-line-chart'></i>&nbsp;&nbsp;&nbsp;<a href="budgt_chart.php" class ="side-bar-links">Budget Chart</a></li>
                        <li><i class='fa fa-gear'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links">Settings</a></li>
                        <li><i class='fa fa-users'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links">Refer</a></li>
                        <li><i class='fa fa-sign-out'></i>&nbsp;&nbsp;&nbsp;<a href="logout.php" class ="side-bar-links">Logout</a></li>
                    </ul>
                </div>
            </div>
	<div class="col-md-6">
		<form action="" method="post">
			<input type="text" name="fromDate" class="form-control" placeholder="From Date...">
			<input type="text" name="toDate" class="form-control" placeholder="To Date...">
			<input type="submit" name="submit" value="Submit" class="btn btn-primary">
		</form>
	</div></div>
	</section>
	</div>
	<div>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		  	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		 	<script type="text/javascript">

			 google.load("visualization", "1", {packages:["corechart"]});
			 google.setOnLoadCallback(drawChart);
			 function drawChart() {
			 var data = google.visualization.arrayToDataTable([
			 
			 ['Budget Item','Amount'],

			 <?php 
			 
			    if(isset($_POST['submit'])) {

		            $from_date = $_POST['fromDate'];
		            $to_date = $_POST['toDate'];
		
		$username = $_SESSION['name'];
	//echo $username;die;
	    $usersql = "SELECT * FROM users WHERE username='$username'";
	    $query = mysqli_query($conn, $usersql);
	    
	    if(mysqli_num_rows($query) > 0){
	        $user_row = mysqli_fetch_array($query);
	       // print_r($user_row);die;
	    }
	
	        $user_id = $user_row['id'];
	//}
	
					$sql = "SELECT bs.subcategory_name, ube.amount FROM `user_budget_expense` ube
							LEFT JOIN `budget_subcategory` bs ON bs.id=ube.user_budget_id
							WHERE ube.user_id ='$user_id' AND DATE(ube.created_at) BETWEEN '".$from_date."' AND '".$to_date."'";

					$queryResult = mysqli_query($conn, $sql) or die(mysqli_error($conn));

					if(mysqli_num_rows($queryResult) > 0){

						while($row = mysqli_fetch_array($queryResult)){
						    //print_r($row);die;
							
						echo "['".$row['subcategory_name']."',".$row['amount']."],";
						}
					} }
			 ?> 
			 ]);
			 
			 var options = {
							 title: 'Budget Item according to their Amount allotted',
							  pieHole: 0,
							          pieSliceTextStyle: {
							            color: 'black',
							          },
							          legend: 'none'
							 };

							 var chart = new google.visualization.PieChart(document.querySelector("#columnchart12"));
							 chart.draw(data,options);
			 }
		</script>
	</div>
	<div class="container-fluid">
 		<div id="columnchart12" style="width: 100%; height: 500px;"></div>
 	</div>
 	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>