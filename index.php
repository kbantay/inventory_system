<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> IGSL SAMS</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="dist/css/login.css">
</head>

<body class="hold-transition login-page">
  <!--=========== PHP ERROR VALIDATIONS =============-->
  <?php
    if (isset($_GET['error'])) {
      if ($_GET['error']=="nouserfound"){
        //echo '<p class="error"> * Invalid username! Please try again. </p>';
        echo '<div id="alert" class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='.'none'.';">&times;</span> 
                Sorry, the username you entered do not exists! Please try again.
              </div>';
      }

      elseif ($_GET['error']=="invalidusername"){
        //echo '<p class="error"> * Invalid username! Please try again. </p>';
        echo '<div id="alert" class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='.'none'.';">&times;</span> 
                Invalid username! Please try again.
              </div>';
      }

      elseif ($_GET['error']=="invalidpassword"){
        //echo '<p class="error"> * Invalid username! Please try again. </p>';
        echo '<div id="alert" class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='.'none'.';">&times;</span> 
                Invalid password! Please try again.
              </div>';
      }
    }
  ?>
  <!--=========== END OF PHP ERROR VALIDATIONS =============-->


  <br>
  <div class="login">
    <h1>IGSL SAMS</h1>

    <form class="form" method="POST" action="pages/includes/handlers/login_handler.php">

      <p class="field">
        <input type="text" name="username" id="username" placeholder="Username" required/>
        <i class="fa fa-user"></i>
      </p>

      <p class="field">
        <input type="password" name="password" placeholder="Password" required/>
        <i class="fa fa-lock"></i>
      </p>

      <p class="submit"><input type="submit" name="login" value="Login"></p>

      <div class="text-center" style="text-align:center">
        <label class="control-label"><a href="pages/forgotpassword"> Forgot password?</a> </label>
      </div>
      
    </form>
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Login JS -->
<script src="pages/includes/js/login.js"></script>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
