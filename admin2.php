<?php
    session_start();

// connect data base
include 'conn.php';
if(isset($_GET['id'])){
    $GLOBALS['a'] = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
    $id = $GLOBALS['a'];
 
    $_SESSION['id'] = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

}

// Delete Funcyion ----------------------------------------------------------------------

function foo() 
{

    $id = $GLOBALS['a'];

    $conn = mysqli_connect('localhost','root','','test');

    $stm = "SELECT * FROM students WHERE id = '$id'";
    $q=$conn->prepare($stm);
    $q->execute();
    $data=$q->fetch();
    if($data){
    
        $conn = mysqli_connect('localhost','root','','test');
    
        $dell = "DELETE FROM students WHERE id = $id ";
        $conn->prepare($dell)->execute();
    
        header ('location:admin2.php');
    }

}

// Delete -----------------------------------------------------------------------------------------------------------

if(isset($_GET['del'])){
foo();
}


    // submit ----------------------------------------------------------------------------------------------------

if(isset($_POST['submit'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $emai = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $email = filter_var($emai,FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $file = $_POST['file'];

    $error=[];

    // VALIDATE NAME 
    if(empty($name)){
        $error[] = "الرجاء ادخال الاسم";
    }elseif(strlen($name) > 40){
        $error[] = "الاسم طويل جدآ";
    }else{
        // VALIDATE EMAIL
        if(empty($emai)){
            $error[]="الرجاء ادخال البريد الالكتروني";
        }elseif($email == false){
            $error[]= "البريد الالكتروني غير صالح";
        }else{
            $stm = "SELECT email FROM students WHERE email = '$email'";
            $q=$conn->prepare($stm);
            $q->execute();
            $data=$q->fetch();
            if($data){
                // foo();
        
                // $sstm = "INSERT INTO students VALUES('','$name','$email','0000')";
        
                // $conn->prepare($sstm)->execute();
                $error[] = "البريد الالكتروني موجود بالفعل";
                $js = 'ok';
                $nn = $name;
                $ee = $email;
                // $stm = "UPDATE `students` SET `Name` = '$name', `Email` = '$email' WHERE `users`.`ID` = '$id'";
                // $conn->prepare($stm)->execute();
            }else{
                    // INSERT to DATABASE
                if(empty($error)){
                    $tm = "تم تسجيل الحساب بنجاح";

                    $stm = "INSERT INTO students VALUES('','$name','$email','$phone','$password','$file')";
                    $conn->prepare($stm)->execute();



                }
            }
        }
    }
}

// Edit -------------------------------------------------------------send-------------------------------------------------------------

if(isset($_POST['edit'])){
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $emai = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    $email = filter_var($emai,FILTER_VALIDATE_EMAIL);
    $phone = filter_var($_POST['phone'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $file = $_POST['file'];
    $error=[];

    // VALIDATE NAME 
    if(empty($name)){
        $error[] = "الرجاء ادخال الاسم";
    }elseif(strlen($name) > 40){
        $error[] = "الاسم طويل جدآ";
    }else{
    // VALIDATE EMAIL
        if(empty($emai)){
            $error[]="الرجاء ادخال البريد الالكتروني";
        }elseif($email == false){
            $error[]= "البريد الالكتروني غير صالح";
        }else{
            if(empty($error)){
                // echo $id;
                
                $id = $_SESSION['id'];
                $stm = "UPDATE `students` SET `name` = '$name', `email` = '$email' ,`phone` = '$phone' , `password` = '$password' , `img` = '$file'  WHERE `students`.`id` = '$id'";
                $conn->prepare($stm)->execute();

                header ('location:admin2.php');




        
            }
        }
    }




}

//  Get Name and Email --------------------------------------------------------------------------------------------------------------

if(!empty($id) and !empty($_SESSION['id'])){
    $id = $_SESSION['id'];
    $conn = mysqli_connect('localhost','root','','test');
    $query = "SELECT * FROM students WHERE id = '$id'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $resultSet = $stmt->get_result();
    $iddi = $resultSet->fetch_all(MYSQLI_ASSOC);

    if (count($iddi)> 0) { 
        if(!empty($iddi)){
            $js = 'ok';
            foreach($iddi as $key=>$val1){
                $eName = $val1['name'] ;
                $eEmail = $val1['email'] ;
                $ephone = $val1['phone'];
                $epassword = $val1['password'];

            }
        }
    }
}

if(isset($_GET['tm'])){
    $tm = "تم تعديل الحساب بنجاح";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body style="background-image: linear-gradient(#77bbff, hotpink);  min-height: 100vh;">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <img class="me-5 ms-4" src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png" style="width: 105px;" alt="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link fw-bold" aria-current="page" href="admin1.php">Teachers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold active border-bottom border-danger border-top" href="admin2.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold" href="admin3.php">Courses</a>
                </li>

            </ul>
            <form class="d-flex">
            <a href="exit.php" class="btn btn-outline-danger me-3" type="submit">Logout</a>
            </form>
            </div>
        </div>
    </nav>


    <div class="container-fluid row row-cols-2 d-flex justify-content-center m-0 p-5 "  >    

                <!-- FORM -->
                    <form class=" py-4 me-2 mt-5 bg-dark text-light col-4 row row-cols-1    " style="height:30%;" action="admin2.php" method="post" >
                        <div class="mb-3 ">
                            <label for="exampleInputEmail1" class="form-label">Name (max:40)</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" 
                            value="<?php if(isset($eName)){echo $eName;}elseif(isset($nn)){echo $nn;} ?>">
                        </div>
                        <div class="mb-3 ">
                            <label for="exampleInputPassword1"  class="form-label">Email (max:40)</label>
                            <input type="email" class="form-control" name="email" id="exampleInputPassword1"
                            value="<?php if(isset($eEmail)){echo $eEmail;}elseif(isset($ee)){echo $ee;} ?>"></input>
                        </div>
                        <div class="mb-3 ">
                            <label for="exampleInputPassword1"  class="form-label">phone</label>
                            <input type="tel" class="form-control" name="phone" id="exampleInputPassword1"
                            value="<?php if(isset($ephone)){echo $ephone;}elseif(isset($ee)){echo $ee;} ?>"></input>
                        </div>
                        <div class="mb-3 ">
                            <label for="exampleInputPassword1"  class="form-label col-2 my-1">password:</label>
                            <input class=" mb-2  form-control" type="password" name="password" id="" value="<?php if(isset($epassword)){echo $epassword;}elseif(isset($ee)){echo $ee;} ?>">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary px-3 w-25 me-2">Send</button>
                        <?php if(isset($js)){ echo '<button type="submit" name="edit" class=" w-25 btn btn-info px-3">Edit</button>';} ?>
                        <input class="col-5 ms-auto pt-1" type="file" name="file" id="www" >




                       
                    </form>


                    <ul class="dropdown-menu p-0 m-0 w-25 ">
                                <li class="">

                                 </li>
                            </ul>


        
        <!-- database requair -->


        <div class=" col-8  ">
        <h2 id="x" class=" text-center  mt-5 mb-2  <?php if(isset($tm)){echo 'ok';}elseif(!empty($error)){echo 'no'; } ?> ">
        <?php 
        if(isset($_POST['submit']) && !empty($error)){
            echo $error[0] . '<br><i class="fa-solid fa-triangle-exclamation pt-2 text-warning "></i>' ;
        }elseif(isset($tm)){
            echo $tm ;
        }else{echo "_ students _";} ?>
        </h2>
            <table class="  table table-dark table-striped   ">
                <thead class="d-stcky top-0 ">
                    <tr class="text-center">
                        <th scope="col">img</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">phone</th>
                        <th scope="col">password</th>
                        <th scope="col">Edit // delete</th>
    
                    </tr>
                </thead>
                <tbody>


                    <?php

                

                        $conn = mysqli_connect('localhost','root','','test');
                        $query = "Select * from students";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $resultSet = $stmt->get_result();
                        $datas = $resultSet->fetch_all(MYSQLI_ASSOC);

                        echo '<a href="#soso"class="btn btn-sm btn-info position-relative mt-2 ">
                        students 
                        <span class="position-absolute top-0 start-100 translate-middle badge  bg-danger">
                        '.count($datas).'
                        <span class="visually-hidden">unread messages</span>
                        </span>
                        </a>';
                        if (count($datas)> 0) { 

                            foreach($datas as $key=>$val){
                                echo '
                                <tr class="text-center">
                                <td><img src="http://www.landscapingbydesign.com.au/wp-content/uploads/2018/11/img-person-placeholder.jpg" width="35" class="" alt="..."></td>
                                <td>'.$val['name'].'</td>
                                <td>'.$val['email'].'</td>
                                <td>'.$val['phone'].'</td>
                                <td>'.$val['password'].'</td>
                                <td >

                                    <a href="admin2.php?id= '. $val['id'].' " type="button" class="btn btn-sm btn-primary"  >
                                    Edit
                                    </a>

                                    <div class="dropdown dropend d-inline">
                                        <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-bs-toggle="dropdown">
                                            Delete
                                        </button>
                                        <ul class="dropdown-menu p-0 m-0 w-25 ">
                                        <li class=""><a href="admin2.php?id='. $val['id'].'&del=1" class=" text-center dropdown-item btn btn-sm btn-Warning " >Confirm Deletion</a></li>
                    
                                        </ul>
                                    </div>
                                
                                </td>
                                </tr>
                                ';
                                }
                        
                    }
                    ?>

                </tbody>
            </table> 
        </div>

    </div>





<p id="soso"></p>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>