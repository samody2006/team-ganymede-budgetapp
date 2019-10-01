<?php include 'connect.php'; 

if(isset($_GET['id'])){
    
    $sql = "SELECT bs.subcategory_name, ube.amount, ube.priority_id, us.amount_entered, ube.id, us.user_id
                       FROM `user_amount` us                       
                       LEFT JOIN `user_budget_expense` ube ON us.id=ube.user_amount_id
                       LEFT JOIN `budget_subcategory` bs ON bs.id=ube.user_budget_id
                       WHERE ube.user_amount_id = '".$_GET['id']."'";

                        $queryResult = mysqli_query($conn, $sql);
        
            if($result = mysqli_num_rows($queryResult) > 0){

            $row = mysqli_fetch_array($queryResult);
                          
            $expensesql = "SELECT SUM(ube.amount) AS 'sum_amount', us.amount_entered
                       FROM `user_amount` us                       
                       LEFT JOIN `user_budget_expense` ube ON us.id=ube.user_amount_id
                       WHERE ube.user_amount_id = '".$_GET['id']."'";

                        $expensequeryResult = mysqli_query($conn, $sql);

                        if($expenseresult = mysqli_num_rows($expensequeryResult) > 0){

                          $expenserow = mysqli_fetch_array($expensequeryResult);
                        }
                        
                        
            $balancesql = "SELECT balance
                       FROM `user_amount`
                       WHERE id = '".$_GET['id']."'";

                        $balancequeryResult = mysqli_query($conn, $balancesql);

                        if($balanceresult = mysqli_num_rows($balancequeryResult) > 0){

                          $balancerow = mysqli_fetch_array($balancequeryResult);
                        }           
                        //print_r($balancerow);die;
    }   
}else{
        header('Location: userpage.php');
}    
?> 

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <meta http-equiv="X-UA-Compatible" content="ie=edge">
 <!-- bootstrap css -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
 <!-- main css -->
 <link rel="stylesheet" href="./css/main.css">
 <!-- google fonts -->
 <link href="https://fonts.googleapis.com/css?family=Courgette" rel="stylesheet">
 <!-- font awesome -->
 <link rel="stylesheet" href="css/all.css">
 <title>Ganymede budget app</title>
 <style>
 </style>
</head>
<body>
 <div class="container-fluid">
  <div class="row">
   <div class="col-11 mx-auto pt-3">
    <!-- title -->
    <h3 class="text-uppercase mb-4">Ganymede budget app</h3>
    <div class="row my-3">
     <div class="col-md-5">
      <!-- budget feedback -->
      <div class="budget-feedback alert alert-danger text-capitalize">budget feedback</div>
      <div class="edit_delete">
        <table class="table table-stripe">
          <thead>
              <th>Expense Title</th>
              <th>Priority</th>
              <th>Expense Value</th></thead>
            <tbody>     
            <tr>
              <td><?php echo $row['subcategory_name'] ? $row['subcategory_name'] : ''; ?></td>
              <td><?php $priority = $row['priority_id'] == 5 ? 'High' : ($row['priority_id'] == 3) ? 'Medium' : 'Low';
            echo $priority;?>
              </td>
              <td><?php echo $row['priority_id'].'%'; ?></td>
              <td><a href="process.php?edit=<?php echo $row['id'];?>" class="edit-icon mx-2"><i class="fas fa-edit"></i></a></td>
                <td><a href="process.php?delete=<?php echo $row['id'];?>" class="delete-icon"><i class="fas fa-trash"></i></a>
              </td>            
            </tr></tbody>
        </table>
   </div>
     </div>
     <div class="col-md-7">
      <!-- app info -->
      <div class="row" style="margin-top: 90px;">
       <div class="col-4 text-center mb-2">
        <h6 class="text-uppercase info-title">budget</h6>
        <span class="budget-icon"><i class="fas fa-money-bill-alt"></i></span>
        <h4 class="text-uppercase mt-2 budget" id="budget"><span>&#8358; </span><span id="budget-amount">
          <?php
            if($result){
              echo $row['amount_entered'];
            }
          ?>

        </span></h4>  <span id="addedBudgetResponseMessage"> </span>
                      <span id="budgetResponseMessage" >  </span>
       </div>
       <div class="col-4 text-center">
        <h6 class="text-uppercase info-title">expenses</h6>
        <span class="expense-icon"><i class="far fa-credit-card"></i></span>
        <h4 class="text-uppercase mt-2 expense" id="expense"><span>&#8358; </span><span id="expense-amount">
          <?php
            if($expenseresult){
              echo $row['amount'];
            }
          ?>
        </span>
                      <span id="addedExpenseResponseMessage"> </span></h4>
       </div>
       <div class="col-4 text-center">
        <h6 class="text-uppercase info-title">Balance</h6>
        <span class="expense-icon"><i class="far fa-credit-card"></i></span>
        <h4 class="text-uppercase mt-2 expense" id="expense"><span>&#8358; </span><span id="expense-amount">
          <?php
            if($balanceresult){
              echo $balancerow['balance'];
            }
          ?>
        </span>
                      <span id="addedExpenseResponseMessage"> </span></h4>
       </div></div>
      </div>
     </div>
    </div>
  </div>
  <table class="table table-stripe">
      <thead>
              <th>Item</th>
              <th>Item Budget Amount</th>
              <th>Date</th></thead>
      <tbody>
          <?php
          //echo $user_id;die;
          $budget_all = "SELECT bs.subcategory_name, ube.amount, DATE(ube.created_at), ube.id
                        FROM `user_budget_expense` ube
                        LEFT JOIN `user_amount` us ON us.id=ube.user_amount_id
                        LEFT JOIN `budget_subcategory` bs ON bs.id=ube.user_budget_id
                        WHERE us.user_id='".$row['user_id']."' AND ube.user_amount_id='".$_GET['id']."'"; 
                        
        $budgetallResult = mysqli_query($conn, $budget_all) or die(mysqli_error($conn));

        if($budgetresult = mysqli_num_rows($budgetallResult) > 0){
            
           while($budgetrows = mysqli_fetch_array($budgetallResult)){?>
           <tr>
                <td><?php echo $budgetrows['subcategory_name']; ?></td>
                <td><?php echo $budgetrows['amount']; ?></td>
                <td><?php echo $budgetrows['DATE(ube.created_at)']; ?></td></tr>
        <?php } }else{?>
            <td><?php echo 'No Budget Available'; ?></td>
       <?php } ?>
      
      </tbody>
  </table>
  <a class="button btn btn-danger" href="userpage.php">Back</a>
 </div>




 <!-- jquery -->
 <script src="js/jquery-3.3.1.min.js"></script>
 <!-- bootstrap js -->
 <script src="js/bootstrap.bundle.min.js"></script>
 <!-- script js -->
 <!--<script src="js/calculator.js"></script>-->
</body>

</html>