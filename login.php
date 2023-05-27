
<?php
session_start();


if(isset($_POST['login'])){

}


// Login and Validate and Verification Email  -------------------------------------------------------------------------------------------------------

if(isset($_POST['login'])){
  $setPassword0 = $_POST['password'];
  $setPassword = filter_var($setPassword0,FILTER_SANITIZE_EMAIL);

  $Email = $_POST['email'];
  $sanEmail = filter_var($Email,FILTER_SANITIZE_EMAIL);
  $valEmail = filter_var($sanEmail,FILTER_VALIDATE_EMAIL);

  
// $hashed_password = password_hash($password, PASSWORD_DEFAULT); تشفير كلمة المرور
// $TRUE/FALSE = password_verify($setPassword,$password_hash) ; فك تشفير كلمة المرور والمقارنه

  if(!empty($Email) and !empty($setPassword0)){
      if($valEmail != false){
          // الاتصال والمقارنه مع الداتا بيس
          // $stm = "SELECT * FROM users WHERE email = '$valEmail'";
          // $q=$db->prepare($stm);
          // $q->execute();
          // $data=$q->fetch();
          
          // الاتصال والمقارنه مع الداتا بيس

          $conn = mysqli_connect('localhost','root','','test');
          $stm = "SELECT * FROM users WHERE Email = '$valEmail'";
          $check = mysqli_query($conn , $stm);
          $result = mysqli_fetch_assoc($check);

          
          if(!$result){
              $salh = 'لا يوجد حساب بهذا الاسم';

          }else{
              $username = $result['Name'];
              $encpass = $result['Password'];
              if(md5($setPassword) != $encpass){
                  $salh = 'خطأ في كلمة المرور';
  
              }else{

                  $_SESSION['ok'] = $username ; 
                  $salh = " تم تسجيل الدخول بنجاح ";
                  header('location:admin1.php');

                  if(isset($_POST['check'])){
                      setcookie("password", $setPassword , time() + 6000 ) ;
                      setcookie("Email", $valEmail , time() + 6000 ) ;
                  }
              }
          }
          

          
      }else{
          $salh = 'البريد غير صالح';
      }

  }else{
      $salh = " الرجاء ادخال البريد الالكتروني وكلمة المرور";
  }
}else{
}





if(isset($_POST['singin'])){
  $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
  $emai = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
  $email = filter_var($emai,FILTER_VALIDATE_EMAIL);

  $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
  $password1 = filter_var($_POST['password1'],FILTER_SANITIZE_STRING);
  $error=[];

  // VALIDATE NAME 
  if(empty($name)){
      $error[] = "الرجاء ادخال الاسم";
  }elseif(strlen($name) > 40){
      $error[] = "الاسم طويل جدآ";
  }

  // VALIDATE EMAIL
  if(empty($emai)){
      $error[]="الرجاء ادخال البريد الالكتروني";
  }elseif($email == false){
      $error[]= "البريد الالكتروني غير صالح";
  }
include 'conn.php';
  $stm = "SELECT email FROM users WHERE email = '$email'";
  $q=$conn->prepare($stm);
  $q->execute();
  $data=$q->fetch();

  if($data){
      $error[] = "البريد الالكتروني مستخدم بالفعل";
  }

  // VALIDATE PASSWORD 
  if(empty($password) or empty($password1)){
      $error[]= "الرجاء ادخال كلمة المرور";
  }else{
      if(strlen($password) <= 20 and strlen($password) >= 6  ){
          if($password != $password1){
              $error[]= "كلمة المرور غير متطابقة";
          }
      }elseif(strlen($password) < 6 and strlen($password) != 0){
          $error[]= "كلمة المرور قصيرة جدآ";
      }else{
          $error[]= "كلمة المرور طويل جدآ";
      }
  }

  // INSERT to DATABASE
  if(empty($error)){
      $hashed_password = md5($password);

      $stm = "INSERT INTO users VALUES('','$name','$email','$hashed_password')";

      $conn->prepare($stm)->execute();
      $_SESSION['ok'] = $name; 
      $salh = " تم تسجيل الدخول بنجاح ";
      header('location:admin1.php');


  }
}
if(isset($salh)){
  echo "<script type='text/javascript'>alert('$salh');</script>";
}
if(isset($error)){
  echo '
  <div class="alert m-0 p-2 alert-danger" role="alert">
  <i class=" me-2 fa-solid fa-circle-exclamation fa-beat fa-lg"></i>'.$error[0].'
</div>';
}
 ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM</title>
    <link rel="stylesheet" href="css2.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
.gradient-custom-2 {
/* fallback for old browsers */
background: #fccb90;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

@media (min-width: 768px) {
.gradient-form {
height: 100vh !important;
}
}
@media (min-width: 769px) {
.gradient-custom-2 {
border-top-right-radius: .3rem;
border-bottom-right-radius: .3rem;
}
}
    </style>
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-4 mx-md-4">

                <div class="text-center">
                  <img src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-4 pb-1">WELCOME <b>ADMIN</b></h4>
                </div>

                <form method="post" action="login.php">
                  <p>Please login to your account</p>

                  <div class="form-outline mb-2">
                    <input type="email" name="email" id="form2Example11" class="form-control"
                      placeholder="email address" />
                    <label class="form-label" for="form2Example11">Username</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="password" id="form2Example22" class="form-control"  />
                    <label class="form-label" for="form2Example22">Password</label>
                  </div>

                  <div class="text-center pt-1 mb-4 pb-1">
                    <button class="btn btn-primary d-block mx-auto w-100  p-3 pb-4 fa-lg gradient-custom-2 mb-3" style="border:none;" name="login" type="submit">Login</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>



                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                <h4 class="mb-4 ">The History of the School</h4>
                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                  exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                  <button type="button" class="btn w-100 mt-4 fs-5 border-bottom text-white " style="background:#0000001f;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                      Create New Account
                  </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Vertically centered modal -->



<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
     
      <div class="modal-body">
      <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="card-body p-2 mx-3 ">

          <div class="text-center">
            <img src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png"
              style="width: 155px;" alt="logo">
            <h4 class="mt-1 mb-4 pb-1">Join us and create a new account.</h4>
          </div>

          <form method="post" action="login.php">
            
            <div class="form-outline mb-2">
            <input type="text" name="name" id="form2Example111" class="form-control" placeholder="Username" />
              <label class="form-label" for="form2Example111">Username</label>
            </div>

            <div class="form-outline mb-2">
              <input type="email" name="email" id="form2Example11" class="form-control" placeholder="email address" />

              <label class="form-label" for="form2Example11">Email</label>
            </div>
            
            <div class="row">
              <div class="form-outline col-6 mb-4">
                <input type="password" name="password" id="form2Example22" class="form-control"  />
                <label class="form-label" for="form2Example22">Password</label>
              </div>
              <div class="form-outline col-6 mb-4">
                <input type="password" name="password1" id="form2Example22" class="form-control"  />
                <label class="form-label" for="form2Example22">Password</label>
              </div>
            </div>

            <div class="text-center pt-1 mb-4 pb-1">
              <button class="btn btn-primary d-block mx-auto w-100 p-3 pb-4 fa-lg gradient-custom-2 mt-2 mb-3" style="border:none;" name="singin" type="submit">Sign in</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>


</body>
</html>



