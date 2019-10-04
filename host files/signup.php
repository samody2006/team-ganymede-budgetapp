<?php 
session_start();

ob_start();
require 'connect.php';

$error = '';
if (isset($_POST['submit'])) {

    //echo " received";

$name = $username = $email = $password = '';


if($_POST['password'] == $_POST['confirmPassword']) {
    //store details in a variable
    $name = mysqli_real_escape_string($conn, $_POST["fname"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
}
   
//check if account exist

$query = "SELECT * FROM users WHERE email = '$email'";
$query_result = mysqli_query($conn, $query);

if(mysqli_num_rows($query_result) > 0){
   $user = mysqli_fetch_all($query_result, MYSQLI_ASSOC); 
}

//$user = mysqli_fetch_assoc($query_result);
//print_r($user);

if(!$user) {    
     	
$sql = "INSERT INTO users(username, password_hash, email) VALUES('$username','$password', '$email')";
$add_user = mysqli_query($conn, $sql); 
$_SESSION['name'] = $username;
$_SESSION['email'] = $email;

header("Location: userpage.php");
} else {
    $error = 'This account exists. Please log in';
}

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="newcss.css">
    <link rel="stylesheet" href="./css/terms.css">

    <title>Sign Up</title>

  </head>
  <body>       
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #32465a;">
            <a class="navbar-brand" href="index.html"><img
					src="https://res.cloudinary.com/angelae/image/upload/v1569493481/Start-ng-Pre-internship/n2mmwn3pvnbjuaqjjkj3.png"
					alt="Logo"
					style="width: 63px; height: 63px; padding: 10px;"
				/></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
              <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                  <a class="nav-link py-md-3 px-4" href="#">Why SpendLess?</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link py-md-3 px-4" href="#">Solutions</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link py-md-3 px-4" href="#">Resources</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link py-md-3 px-4" href="#">How it Works</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link py-md-3 px-4" href="#">Support</a>
                </li>
                <a href="login.php" class="nav-item py-md-3 px-4 btn btn-outline-warning">LOG IN</a>

              </ul>
              
            </div>
          </nav>
            <section class="modal-dark">
              <div class="modal-container">
                <header>
                  <h4>
                  Terms of service
                  <span>x</span>
                  </h4>
                </header>
                <main>
                  <h6>Welcome to SpendLess</h6>
                  <p>1. Accepting the Terms <br>

1.1 In order to use the Services, you must first agree to the Terms. You may not use the Services if you do not accept the Terms. <br> 

1.2 You can accept the Terms by: <br>

(A) clicking to accept or agree to the Terms, where this option is made available to you by Spendless in the user interface for any Service. <br> <br>

2. Use of the Services by you <br>

2.1 In order to access certain Services, you may be required to provide information about yourself (such as identification or contact details) as part of the registration process for the Service. You agree that any registration information you give to Spendless will always be accurate, correct and up to date. <br> <br>

3. Your passwords and account security <br>
3.1 Accordingly, you agree that you will be solely responsible to Google for all activities that occur under your account.

                </p>
                </main>
              </div>
            </section>

            <section class="signup">
                <div class="container h-100">
                        
                    <div cs="row h-100 justify-content-center align-items-center" class="signup-content">
                        
                        <form class="formSize" method="POST" action="signup.php" onsubmit="return Validate()" name="signupForm">
                          <h4 id="error"><?php echo $error; ?></h4>
                                <div class="formHeader col-12">Welcome </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <label for="inputName">Name</label>
                                <input type="text" class="form-control" name="fname" id="inputName" placeholder="Enter Name">
                                <div class="errorMessage" id="name_error"></div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <label for="inputUsername">Username</label>
                                <input type="text" class="form-control" name="username" id="inputUsername" placeholder="Enter Username">
                                <div class="errorMessage" id="username_error" ></div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Enter Email" >
                                <div class="errorMessage" id="email_error"></div>
                            </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <label for="inputPassword">Password</label>
                                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                                <div class="errorMessage" id="password_error"></div>
                            </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                                <div id="confirmPassword_error"></div>
                            </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-12">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" required="required"/>
                                <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                              </div>
                            </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-outline-warning btn-lg btn-block " name="submit">Sign Up</button>
                            </div>
                        </div>
                        </form>
                        
                    </div>
                </div>
            </section>
    
       
               
                 
        <footer class="footer">
                <div class="footerText"> Team Ganymede - HNGi6 &copy; 2019.  <a href="#"><i class="fa fa-angle-double-up fa-2x"></i></a></div>
                
               
            </footer>
         

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="newjs.js"></script>
    <script src="terms.js"></script>
</body>
</html>