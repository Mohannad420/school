
<?php
session_start();


if(isset($_POST['login'])){

}


// Login and Validate and Verification Email  -------------------------------------------------------------------------------------------------------

if(isset($_POST['login2'])){
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
          $stm = "SELECT * FROM teachers WHERE email = '$valEmail'";
          $check = mysqli_query($conn , $stm);
          $result = mysqli_fetch_assoc($check);

          
          if(!$result){
              $salh = 'لا يوجد حساب استاذ بهذا الاسم';

          }else{
              $username = $result['name'];
              $encpass = $result['password'];
              if($setPassword != $encpass){
                  $salh = 'خطأ في كلمة المرور';
  
              }else{

                  $_SESSION['ok'] = $username ; 
                  $salh = " تم تسجيل الدخول بنجاح ";
                  header('location:teacher.php');

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

// Login and Validate and Verification Email  -------------------------------------------------------------------------------------------------------

if(isset($_POST['login3'])){
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
            $stm = "SELECT * FROM students WHERE email = '$valEmail'";
            $check = mysqli_query($conn , $stm);
            $result = mysqli_fetch_assoc($check);
  
            
            if(!$result){
                $salh = 'لا يوجد حساب طالب بهذا الاسم';
  
            }else{
                $username = $result['name'];
                $encpass = $result['password'];
                if($setPassword != $encpass){
                    $salh = 'خطأ في كلمة المرور';
    
                }else{
  
                    $_SESSION['ok'] = $username ; 
                    $salh = " تم تسجيل الدخول بنجاح ";
                    header('location:students.php');
  
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
<body class="p-0 m-0" style="height:100vh;">
    <div class="continer-fluid h-100 row row-cols-3 p-0 m-0">
        <a href="login.php" class="btn btn-danger h-100 text-center"><h1 class=" h-100 d-flex  justify-content-center align-items-center my-auto" >ADMIN</h1></a>
        <button  data-bs-toggle="modal" data-bs-target="#staticBackdrop2" class="btn btn-warning text-white h-100 text-center"><h1 class=" h-100 d-flex justify-content-center  align-items-center my-auto" >TEACHER</h1></button>
        <button  data-bs-toggle="modal" data-bs-target="#staticBackdrop3" class="btn btn-primary h-100 text-center"><h1 class=" h-100 d-flex justify-content-center  align-items-center my-auto" >STUDENT</h1></button>
    </div>
</body>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
     
      <div class="modal-body">
      <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="card-body p-2 mx-3 ">

          <div class="text-center">
            <img src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png"
              style="width: 155px;" alt="logo">
            <h4 class="mt-1 mb-4 pb-1">WELCOME <b>TEACHER</b> .</h4>
          </div>

          <form method="post" action="s3.php">
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
                    <button class="btn btn-primary d-block mx-auto w-100  p-3 pb-4 fa-lg gradient-custom-2 mb-3" style="border:none;" name="login2" type="submit">Login</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>
                </form>
        </div>
      </div>

    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
     
      <div class="modal-body">
      <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="card-body p-2 mx-3 ">

          <div class="text-center">
            <img src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png"
              style="width: 155px;" alt="logo">
            <h4 class="mt-1 mb-4 pb-1">WELCOME <b>STUDENT</b>.</h4>
          </div>

          <form method="post" action="s3.php">
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
                    <button class="btn btn-primary d-block mx-auto w-100  p-3 pb-4 fa-lg gradient-custom-2 mb-3" style="border:none;" name="login3" type="submit">Login</button>
                    <a class="text-muted" href="#!">Forgot password?</a>
                  </div>



                </form>
        </div>
      </div>

    </div>
  </div>
</div>



</html>



