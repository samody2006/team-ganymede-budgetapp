<?php include 'connect.php';

if (isset($_GET['id'])) {

  // $sql = "SELECT bs.subcategory_name, ube.amount, us.amount_entered, ube.id, us.user_id
  //                      FROM `user_amount` us                       
  //                      LEFT JOIN `user_budget_expense` ube ON us.id=ube.user_amount_id
  //                      LEFT JOIN `budget_subcategory` bs ON bs.id=ube.user_budget_id
  //                      WHERE ube.user_amount_id = '" . $_GET['id'] . "'";

  // $queryResult = mysqli_query($conn, $sql);

  // if ($result = mysqli_num_rows($queryResult) > 0) {

  //   $row = mysqli_fetch_array($queryResult);

  //   $expensesql = "SELECT SUM(ube.amount) AS 'sum_amount', us.amount_entered
  //                      FROM `user_amount` us                       
  //                      LEFT JOIN `user_budget_expense` ube ON us.id=ube.user_amount_id
  //                      WHERE ube.user_id = '" . $_GET['id'] . "'";

  //   $expensequeryResult = mysqli_query($conn, $sql);

  //   if ($expenseresult = mysqli_num_rows($expensequeryResult) > 0) {

  //     $expenserow = mysqli_fetch_array($expensequeryResult);
  //   }
  // }
  $id = $_GET['id'];
  // fecth income
  $query3 = "SELECT * FROM user_amount WHERE user_id = '$id' ORDER BY id DESC LIMIT 1";
  $data5 = mysqli_query($conn, $query3);
  $total = 0;
  while ($row5 = mysqli_fetch_array($data5)) {
    $total = $row5['amount_entered'];
  }

  // fetch amount
  $query = "SELECT * FROM user_budget_expense WHERE user_id = '$id'";
  $data = mysqli_query($conn, $query);
  $expenses = 0;
  while ($row = mysqli_fetch_array($data)) {
    $expenses += $row['amount'];
  }
} else {
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
          <div class="col-md-12">
            <!-- app info -->
            <div class="row" style="margin-top: 90px;">
              <div class="col-4 text-center mb-2">
                <h6 class="text-uppercase info-title">budget</h6>
                <span class="budget-icon"><i class="fas fa-money-bill-alt"></i></span>
                <h4 class="text-uppercase mt-2 budget" id="budget"><span>&#8358; </span><span id="budget-amount">
                    <?php
                      echo $total;
                    ?>

                  </span></h4> <span id="addedBudgetResponseMessage"> </span>
                <span id="budgetResponseMessage"> </span>
              </div>
              <div class="col-4 text-center">
                <h6 class="text-uppercase info-title">expenses</h6>
                <span class="expense-icon"><i class="far fa-credit-card"></i></span>
                <h4 class="text-uppercase mt-2 expense" id="expense"><span>&#8358; </span><span id="expense-amount">
                    <?php
                      echo $expenses;
                    ?>
                  </span>
                  <span id="addedExpenseResponseMessage"> </span></h4>
              </div>
              <div class="col-4 text-center">
                <h6 class="text-uppercase info-title">Balance</h6>
                <span class="expense-icon"><i class="far fa-credit-card"></i></span>
                <h4 class="text-uppercase mt-2 expense" id="expense"><span>&#8358; </span><span id="expense-amount">
                    <?php

                    echo $total - $expenses;
                    ?>
                  </span>
                  <span id="addedExpenseResponseMessage"> </span></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <table class="table table-stripe">
      <thead>
        <th>Item</th>
        <th>Item Budget Amount</th>
        <th>Date</th>
      </thead>
      <tbody>
        <?php
        //echo $user_id;die;
        $budget_all = "SELECT bs.subcategory_name, ube.amount, DATE(ube.created_at), ube.id
                        FROM `user_budget_expense` ube
                        LEFT JOIN `user_amount` us ON us.id=ube.user_amount_id
                        LEFT JOIN `budget_subcategory` bs ON bs.id=ube.user_budget_id
                        WHERE us.user_id='" . $id . "'";

        $budgetallResult = mysqli_query($conn, $budget_all) or die(mysqli_error($conn));

        if ($budgetresult = mysqli_num_rows($budgetallResult) > 0) {

          while ($budgetrows = mysqli_fetch_array($budgetallResult)) { ?>
            <tr>
              <td><?php echo $budgetrows['subcategory_name']; ?></td>
              <td><?php echo $budgetrows['amount']; ?></td>
              <td><?php echo $budgetrows['DATE(ube.created_at)']; ?></td>
            </tr>
          <?php }
          } else { ?>
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