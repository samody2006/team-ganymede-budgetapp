<?php
session_start();
ob_start();

include 'connect.php';

?>
<?php
function budgetItemfxn($conn){
	$bugetItems = "SELECT subcategory_name FROM budget_subcategory";
				$budgetitemQuery = mysqli_query($conn, $bugetItems);
        
            if(mysqli_num_rows($budgetitemQuery) > 0){
				// 	while($budgetRows = mysqli_fetch_array($budgetitemQuery)){
				// 	    return $budgetRows;
				// 	}
				$budgetRows = mysqli_fetch_array($budgetitemQuery);	
				//print_r($budgetRows);die;
					foreach ($budgetRows as $key => $value) {
						$output = '<option value='.$value.'>'.$value.'</option>';
						return $output;
					}
				//	return $output;
					//return $budgetRows['subcategory_name'];	
				}
				
	
    }

if(isset($_POST['submit'])){

	$formValues = $_POST;

	$netAmt = $_POST['net_income'];
	$budgetItem = $_POST['item_unit'];
	$priority = $_POST['priority'];
	
	$username = $_SESSION['name'];
	
	    $usersql = "SELECT * FROM users WHERE username='$username'";
	    $query = mysqli_query($conn, $usersql);
	    
	    if(mysqli_num_rows($query) > 0){
	        $user_row = mysqli_fetch_array($query);
	    }
	
	        $user_id = $user_row['id'];
	       
		 $userIncome = "INSERT INTO user_amount(user_amount.user_id, user_amount.amount_entered) VALUES('$user_id', '$netAmt')";

		 $userIncomeQuery = mysqli_query($conn, $userIncome);

		 $retrieve_last_insert_query = "SELECT * FROM user_amount WHERE id =(SELECT LAST_INSERT_ID()) AND user_id='$user_id'";
		 $retrieve_last_insert = mysqli_query($conn, $retrieve_last_insert_query);

		 if(mysqli_num_rows($retrieve_last_insert) > 0){
		 	$rows = mysqli_fetch_assoc($retrieve_last_insert);
		 }
		 
		 $user_budget_id = $rows['id'];
		 
		 	foreach ($budgetItem as $key => $value) {
		 		# code...
		 		
		 		$budget_item_priority = $priority[$key];
		 		
		 		$budgeted_amount = ($budget_item_priority)/100 * $netAmt;
		 		
		 		$budget_item = "SELECT id FROM budget_subcategory WHERE subcategory_name='$budgetItem[$key]'";
		 		$budgetConn = mysqli_query($conn, $budget_item);
		 		
		 		if(mysqli_num_rows($budgetConn) > 0){
		 		    $budget_user_row = mysqli_fetch_assoc($budgetConn);
		 		}
		 		
		 		$budget_subcategory_id = $budget_user_row['id'];
		 		
		 		$sql = "INSERT INTO `user_budget_expense`(user_id, user_budget_id, priority_id, user_amount_id, amount) VALUES ('$user_id', '$budget_subcategory_id', '$budget_item_priority', '$user_budget_id', '$budgeted_amount')";
		 		 $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
		 		 
		 		 if($result){
		 		     
		 		    $balance = "SELECT SUM(ube.amount) AS 'sum_amount', us.amount_entered
                       FROM `user_amount` us                       
                       LEFT JOIN `user_budget_expense` ube ON us.id=ube.user_amount_id
                       WHERE ube.user_amount_id = '$user_budget_id'";
                       
                       $balancequeryResult = mysqli_query($conn, $balance);
                       
                       if($balanceresult = mysqli_num_rows($balancequeryResult) > 0){

                          $balancerow = mysqli_fetch_array($balancequeryResult);
                        }
                       
		 		     $balance = $balancerow['amount_entered'] - $balancerow['amount'];
                        
                    $updateBalance = "UPDATE user_amount SET balance='".$balance."' WHERE id='".$_GET['id']."'";
                    $update_bal_query = mysqli_query($conn, $updateBalance);
		 		 }
				}
				header('Location: budgetindex.php?id='.$user_budget_id);
	}
?>
<!DOCTYPE html>
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
        @media (max-width:350px){
            #word{
                font-size: 100%;
                text-align: center;
            }
        }
        .side-bar-links:hover{
            text-decoration: none;
            color: #FF7800;
            
        }
        /* making side bar responsive */
        /*display on mobile*/
        .side-bar-list{
            padding-left: 0;  
            font-size: 11px;
            
        }
        /* display on other bigger devices*/
        @media (min-width:380px){
            .side-bar-list{
                padding-left: 1%;
                font-size: 80%;
            }
        }
        @media (min-width:450px){
            .side-bar-list{
                padding-left: 2%;
                font-size: 90%;
            }
        }
        @media (min-width:720px){
            .side-bar-list{
                padding-left: 5%;
                font-size: 100%;
            }
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

         /* TOUR STYLES BY 15SAMUEL15*/
         .shepherd-button-secondary {
            background-color: #fd7e14 !important;
            color: #fff !important;
            transition: all 0.3s ease-in;
        }

        .shepherd-button-secondary:hover {
            background-color: grey !important;
        }

        .shepherd-button-primary {
            background-color: #007bff !important;
            color: #fff !important;    
        }

        .shepherd-button-primary:hover {
            background-color: #fd7e14 !important;
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
                <a href="#" class="toplinks"><li>Why BudgetIt?</li></a>
                <a href="#" class="toplinks"><li>Solutions</li></a>
                <a href="#" class="toplinks"><li>Resources</li></a>
                <a href="#" class="toplinks"><li>How it works</li></a>
                <a href="#" class="toplinks"><li>Support</li></a>
            </ul>
            <div>
                <a href="logout.php" >LOG OUT</a>
            </div>
        </div>
        <i class="fa fa-bars"></i>
        <div class="small-nav hidden">
            <a href="#" class="toplinks">Why Budget It?</a>
            <a href="#" class="toplinks">Solutions</a>
            <a href="#" class="toplinks">Resources</a>
            <a href="#" class="toplinks">How it Works</a>
            <a href="#" class="toplinks">Support</a>
            <a href="logout.php">LOG OUT</a>
        </div>
    </nav>
    
    <section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4"><br>
                <div style="align-content: center;">
                </div>
                <div style="padding: 3%;">
                    <ul class="side-bar-list">
                        <li><i class='fas fa-home'></i> &nbsp;<a href="./index.html" class ="side-bar-links first">Home</a></li>
                        <li><i class='fa fa-user'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links second">Account</a></li>
                        <li><i class='fa fa-line-chart'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links third">Dashboard</a></li>
                        <li><i class='fa fa-line-chart'></i>&nbsp;&nbsp;&nbsp;<a href="budgt_chart.php" class ="side-bar-links fourth">Budget Chart</a></li>
                        <li><i class='fa fa-gear'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links fifth">Settings</a></li>
                        <li><i class='fa fa-users'></i>&nbsp;&nbsp;&nbsp;<a href="" class ="side-bar-links seventh">Refer</a></li>
                        <li><i class='fa fa-sign-out'></i>&nbsp;&nbsp;&nbsp;<a href="logout.php" class ="side-bar-links out">Logout</a></li>
                    </ul>
                </div>
            </div>
        <div class="col-8">
            <div>
                <h2></h2>
                <h4 id="word">We need information on your Income and Expenditure to help you plan better. Please fill in the following information:</h4> 
                </div>
            <br>
            <br>
            <div>
            <form action="" id="add_name" method="post">
                <div class="form-group">
                    <label class="h5">Net Income:</label>
                    <input type="number" style="width:100%;" name="net_income" class="remove-glow border-black rounded form-control col-md-3 pl-3" placeholder="Income amount">
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
            </form></div>
        </div>
    </div>
    
    <script src="./js/menu-action.js"></script>
<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#add').on('click', function(e) {
            
    //         $.ajax({
				// 	url: "fetch_items.php",
				// 	dataType: "html",
				// 	success: function(Result){
				// 		$(".result").html(Result)
				// 	}
				// })
            
           var html = '<div class="row">';
			   html += '<div class="col-md-6"><select name="item_unit[]" class="form-control item_unit"><option>Select Item</option><option><?php echo budgetItemfxn($conn); ?></option></select></div>';
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <!-- TOUR JAVASCRIPT CODE BY 15SAMUEL15  -->
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@latest/dist/js/shepherd.min.js"></script>

<script>

const tour = new Shepherd.Tour({
    defaultStepOptions: {
        cancelIcon: {
        enabled: true
            },
            classes: 'shepherd-theme-custom',
            scrollTo: { behavior: 'smooth', block: 'center' }
        }
        });

        tour.addStep({
        title: 'Welcome to Spendless Dashboard',
        text: `Follow me as I take you on a tour about the features of this page.
                P.S : Some of the links aren't currently available, the pages are currently being developed.`,
        attachTo: {
            element: '.start',
            on: 'top'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });


        tour.addStep({
        title: 'Home Page Link',
        text: `This link takes you to the home page of this site.`,
        attachTo: {
            element: '.first',
            on: 'top'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });
        
        tour.addStep({
        title: 'Check your Account',
        text: `This link takes you to the page where you get to see details of your statement of cash flow.`,
        attachTo: {
            element: '.second',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.addStep({
        title: 'Dashboard',
        text: `This is the current page you are on, this
                 page gives you various ways of checking how you have been handling your finances.`,
        attachTo: {
            element: '.third',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.addStep({
        title: 'Budget Chart Link',
        text: `This link takes you to a page where you create your budgets with ease and preview 
                our summary based on all your expenditure.`,
        attachTo: {
            element: '.fourth',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.addStep({
        title: 'Settings Link',
        text: `This link takes you to the Settings page for instance if you want to tighten the security 
                of your account - this is where you are to click.`,
        attachTo: {
            element: '.fifth',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.addStep({
        title: 'Referral Link',
        text: `Are you enjoying our service? Click this link to see how you can get to refer
                friends here and what you stand to get for that.`,
        attachTo: {
            element: '.seventh',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.addStep({
        title: 'Log out link',
        text: `Click this link when you are through navigating this site. Thank you.`,
        attachTo: {
            element: '.out',
            on: 'bottom'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });


        tour.addStep({
        title: 'THANKS FOR TAKING THIS TOUR',
        text: `You are now good to go. Navigating the nooks and crannies of Spendless.....`,
        attachTo: {
            element: '.start',
            on: 'top'
        },
        buttons: [
            {
            action() {
                return this.back();
            },
            classes: 'shepherd-button-secondary',
            text: 'Back'
            },
            {
            action() {
                return this.next();
            },
            classes: 'shepherd-button-primary',
            text: 'Next'
            }
        ],
        id: 'creating'
        });

        tour.start();

</script>

</body>
</html>