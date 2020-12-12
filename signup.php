<?php
require_once 'conn.php';
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo $_POST["uname"];
    //echo $_POST["password"];
    if (!empty($_POST["name"]) && !empty($_POST["email"])) {
        if (strpos($_POST["wEmail"], '@jpischool.com') == false) {
            // redirect("signup.php?error=Only Email-ID at jpischool.com are accepted to register the user. Please Try again.");
        }
        if ($_POST["repeat"] != $_POST["password"]) {
            redirect("signup.php?error=Password did not match");
        }
        $pwd = $_POST['password'];
        if (strlen($pwd) < 8) {
            $errors = "Password too short!";
            redirect("signup.php?error=$errors");
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors = "Password must include at least one number!";
            redirect("signup.php?error=$errors");
        }

        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $errors = "Password must include at least one letter!";
            redirect("signup.php?error=$errors");
        }

        $sql = "SELECT * FROM login where uname='" . $_POST["name"] . "' and email='" . $_POST["email"] . "'";
        $stmt = $pdo->query($sql);
        if ($row = $stmt->fetch() > 0) {
            redirect("signup.php?msg=Email already Exists");
        }

        $sql = "INSERT INTO login (email,uname,password,wardemail,address,phone,pincode) VALUES (?,?,?,?,?,?,?)";
        try {
            $stmt = $pdo->prepare($sql);
            $ins = $stmt->execute([$_POST["email"], $_POST["name"], $_POST["password"], $_POST["wEmail"], $_POST["address"], $_POST["phone"], $_POST["pincode"]]);
            if ($ins) {
                redirect("login.php?msg=Registered Successfully");
            }
        } catch (PDOException $e) {
            //   die($e->getMessage());}
            redirect("signup.php?error=" . $e);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sign up</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />
    <link rel="shortcut icon" href="favicon.ico">

    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>

    </script>
</head>

<body>
    <header id="header">
        <nav class="navbar navbar-default navbar-static-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                        <a href="index.php">
                            <img src="img/logo.jpg" class="headinglogo" alt="School logo" align="left" />
                        </a>
                    </div>
                </div>
                <div class="navbar-collapse collapse">
                    <div class="menu">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation"><a href="index.php" class="active" style="display: none;">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/.container-->
        </nav>
        <!--/nav-->
    </header>
    <!--/header-->



    <section class="contact-page">
        <div class="container">
            <a href="login.php">
                <h2 align="right">Login</h2>
            </a>

            <div class="text-center">
                <h2>Register</h2>
            </div>
            <form class="text-center" method="post" action="signup.php">

                <table class="table table-striped text-right" style="width:70%;">
                    <tr>
                        <th><label>Username *</label></th>
                        <td><input type="text" value="test" name="name"></td>
                    </tr>

                    <tr>
                        <th><label>Email-ID *</label></th>
                        <td><input type="email" value="test@gmail.com" data-validation="email" name="email"></td>
                    </tr>

                    <tr>
                        <th><label>Ward's Email-ID *</label></th>
                        <td><input type="email" data-validation="email" value="testchild@schoo.com" name="wEmail"></td>
                    </tr>

                    <tr>
                        <th><label>Phone Number *</label></th>
                        <td><input type="phone" data-validation="length" value="9876549876" data-validation-length="10-12" name="phone"></td>
                    </tr>

                    <tr>
                        <th><label>Pincode *</label></th>
                        <td><input type="number" data-validation="length" value="123456" data-validation-length="6" name="pincode"></td>
                    </tr>

                    <tr>
                        <th><label>Password *</label></th>
                        <td><input name="password" value="test1234" type="password" data-validation="length" data-validation-length="min8">
                            <br><label style="font-size: 9px">Password must be minimum 8 characters in length.<br>And should also include a numeric digit in it. </label></td>
                    </tr>

                    <tr>
                        <th><label>Confirm Password *</label></th>
                        <td><input type="password" value="test1234" data-validation="confirmation" name="repeat" data-validation-confirm="password"></td>
                    </tr>

                    <tr>
                        <th><label>Address *</label></th>
                        <td><input type="text" value="jaipur" name="address"></td>
                    </tr>


                    <tr>
                        <th style=" ;float:right">
                            <input class="btn btn-primary btn-lg" type="submit">
                        </th>
                    </tr>
                </table>
            </form>

        </div>

        </form>
        </div>
        <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    <!--/#contact-page-->
    <?php if (!empty($_GET["error"])) {
        alert($_GET['error']);
    } ?>
    <?php if (!empty($_GET["msg"])) {
        alert($_GET['msg']);
    } ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script>
        $.validate({
            modules: 'toggleDisabled',
            disabledFormFilter: 'form.toggle-disabled',
            showErrorDialogs: false
        });
    </script>

    <footer>
        <div class="container">
            <div class="col-md-4 wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                <h4>About Us</h4>
                <p> My Carpool .</p>
                <div class="contact-info">
                    <ul>
                        <li><i class="fa fa-home fa"></i>Jayshree Periwal International School,Mahapura - SEZ Road, Ajmer Road, Jaipur </li>
                        <li><i class="fa fa-phone fa"></i> 0141-2726576</li>
                        <li><i class="fa fa-envelope fa"></i>MyCarpool@jpischool.com</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>