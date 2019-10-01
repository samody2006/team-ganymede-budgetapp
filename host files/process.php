<?php

include 'connect.php';

if(isset($_GET['delete'])){

      $delete_budget_item = "DELETE FROM `user_budget_expense`
                       WHERE id = '".$_GET['delete']."'";

      $deletequeryResult = mysqli_query($conn, $delete_budget_item);
    }
    
    
if(isset($_GET['edit'])){
    echo "
        <!DOCTYPE html>
        <html>
        <head>
        	<title></title>
        	<meta charset='UTF-8'>
             <meta name='viewport' content='width=device-width, initial-scale=1.0'>
             <meta http-equiv='X-UA-Compatible' content='ie=edge'>
             <!-- bootstrap css -->
             <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
             <!-- main css -->
             <link rel='stylesheet' href='./css/main.css'>
             <!-- google fonts -->
             <link href='https://fonts.googleapis.com/css?family=Courgette' rel='stylesheet'>
             <!-- font awesome -->
             <link rel='stylesheet' href='css/all.css'>
        </head>
        <body>
        <div class='col-md-6'>
            <form action='' method='post'>
                <div class='row'>
                    <div clas='col-md-6 form-control'>
                    <select>
                        <option value=''>Select...</option>
                        
                        <option value='5'>High</option>
                    </select>
                </div>
                <div clas='col-md-6 form-control'>
                    <select>
                        <option value=''>Select...</option>
                        <option value='5'>High</option>
                        <option value='3'>Medium</option>
                        <option value='1'>Low</option>
                    </select>
                </div>
                </div>
            </form>
        </div>
        </body>
        </html>
    ";
}    

?>