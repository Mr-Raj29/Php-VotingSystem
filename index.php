<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <h3>Voting System</h3>
                <div class="d-flex justify-content-end social_icon">
                    <span><i class="fab fa-facebook-square"></i></span>
                    <span><i class="fab fa-google-plus-square"></i></span>
                    <span><i class="fab fa-twitter-square"></i></span>
                </div>
            </div>
            <?php
            if(isset($_GET['sign-up'])){
            ?>
            <div class="card-body">
                <form method="POST">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="su_user" placeholder="username" required />
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="text" class="form-control" name="su_contactno" placeholder="Contact" required />
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="password" class="form-control" name="su_passworduser" placeholder="Password" required />
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" name="su_retypepassword" placeholder="Re-Type password" required />
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Sign-Up" name="sign_up_btn" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Already have an account?<a href="index.php">Sign In</a>
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="card-body">
                <form method="POST">
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="contact no" name="contact_no" required />
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" class="form-control" placeholder="password" name="password" required />
                    </div>
                    <div class="row align-items-center remember">
                        <input type="checkbox">Remember Me
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Login" class="btn float-right login_btn" name="login_btn">
                    </div>     
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Don't have an account?<a href="?sign-up=1">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center">
                    <a href="#">Forgot your password?</a>
                </div>
            </div>
            <?php
            }
            ?>
            
            <?php 
                    if(isset($_GET['registered']))
                    {
                ?>
                        <span class="bg-white text-success text-center my-3"> Your account has been created successfully! </span>
                <?php
                    }else if(isset($_GET['invalid'])) {
                ?>
                        <span class="bg-white text-danger text-center my-3"> Passwords mismatched, please try again! </span>
                <?php
                    }else if(isset($_GET['not_registered'])) {
                ?>
                                <span class="bg-white text-warning text-center my-3"> Sorry, you are not registered! </span>
                <?php
                    }else if(isset($_GET['invalid_access'])) {
                ?>
                                <span class="bg-white text-danger text-center my-3"> Invalid username or password! </span>
                <?php
                            }
                ?>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
require_once("admin/inc/config.php");

if(isset($_POST['sign_up_btn'])){
    $su_username = mysqli_real_escape_string($db, $_POST['su_user']);
    $su_contact_no = mysqli_real_escape_string($db, $_POST['su_contactno']);
    $su_password = mysqli_real_escape_string($db, sha1($_POST['su_passworduser']));
    $su_retype_password = mysqli_real_escape_string($db, sha1($_POST['su_retypepassword']));
    $user_role = "Voter"; 

    if($su_password == $su_retype_password)
    {
        // Insert Query 
        mysqli_query($db, "INSERT INTO users (username, contact_no, password, user_role) VALUES('". $su_username ."', '". $su_contact_no ."', '". $su_password ."', '". $user_role ."')") or die(mysqli_error($db));
    ?>
        <script> location.assign("index.php?sign-up=1&registered=1"); </script>
    <?php
    } else {
    ?>
        <script> location.assign("index.php?sign-up=1&invalid=1"); </script>
    <?php
    }
    }else if(isset($_POST['login_btn']))
    {
        $contact_no = mysqli_real_escape_string($db, $_POST['contact_no']);
        $password = mysqli_real_escape_string($db, sha1($_POST['password']));
        $fetchingData = mysqli_query($db, "SELECT * FROM users WHERE contact_no = '". $contact_no ."'") or die(mysqli_error($db));

        if(mysqli_num_rows($fetchingData) > 0){
            $data = mysqli_fetch_assoc($fetchingData);
            if($contact_no == $data['contact_no'] AND $password == $data['password']){

                session_start();
                $_SESSION['user_role'] = $data['user_role'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['user_id'] = $data['id'];

                if($data['user_role'] == "Admin"){
                    $_SESSION['key'] = "AdminKey";
                 ?>
                 <script >location.assign("admin/index.php?homepage=1");</script>
                 <?php
                }else{
                    $_SESSION['key'] = "VotersKey";
                 ?>
                     <script >location.assign("voters/index.php");</script>
                 <?php
                }

            }else{
                ?>
                 <script> location.assign("index.php?&invalid_access=1"); </script>
                <?php
            }
        }else{
        ?>
          <script> location.assign("index.php?sign-up=1&not_registered=1"); </script>
        <?php
        }
    }

   

?>
