<?php

include 'connect.php';

$bugetItems = "SELECT subcategory_name FROM budget_subcategory";
				$budgetitemQuery = mysqli_query($conn, $bugetItems);
        
            if(mysqli_num_rows($budgetitemQuery) > 0){
			 	while($row = mysqli_fetch_array($budgetitemQuery)){
					echo "<option value=".$row['subcategory_name'].">".$row['subcategory_name']."</option>";	
				}
            }
?>