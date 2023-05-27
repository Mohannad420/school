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
    
        header ('location:teacher.php');
    }
}

// Delete -----------------------------------------------------------------------------------------------------------

if(isset($_GET['del'])){
foo();
}


    // submit ----------------------------------------------------------------------------------------------------

if(isset($_POST['submit'])){ 
    @$course = $_POST['course'] ;
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    @$grade = $_POST['grade'] ;


    $error=[];

    // VALIDATE NAME 
    if(empty($name)){
        $error[] = "الرجاء ادخال الاسم";
    }elseif(strlen($name) > 40){
        $error[] = "الاسم طويل جدآ";
    }else{
                    // INSERT to DATABASE
                if(empty($error)){
                    $tm = "تم تسجيل الحساب بنجاح";

                    $stm = "INSERT INTO grade VALUES('$course','$name','$grade')";
                    $conn->prepare($stm)->execute();



                }
            
        
    }
}

// Edit -------------------------------------------------------------send-------------------------------------------------------------

if(isset($_POST['edit'])){
    @$course = $_POST['course'] ;
    $name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    @$grade = $_POST['grade'] ;

    $error=[];

    // VALIDATE NAME 
    if(empty($name)){
        $error[] = "الرجاء ادخال الاسم";
    }elseif(strlen($name) > 40){
        $error[] = "الاسم طويل جدآ";
    }else{
    // VALIDATE EMAIL

            if(empty($error)){
                // echo $id;
                
                $id = $_SESSION['id'];
                $stm = "UPDATE `grade` SET  `student` = '$course' , `cousename` = '$name' , `grade` = '$grade' WHERE `grade`.`cousename` = '$name'";
                $conn->prepare($stm)->execute();

                header ('location:teacher.php');




        
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
                $grade = $val1['grade'] ;
                $eEmail = $val1['grade'] ;


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
        <img class="me-5 ms-5" src="https://logos-world.net/wp-content/uploads/2021/01/Harvard-Logo.png" style="width: 105px;" alt="logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <a href="s3.php" class="btn btn-outline-danger me-3 ms-auto float-end" type="submit">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid row d-flex justify-content-center m-0 p-5 pt-0"  >    


                <!-- FORM -->
                    <form class=" p-4  me-2 mt-5 bg-dark text-light col-5 row row-cols-2 mt-5   " style="height:30%;" action="teacher.php" method="post" >

                    <select id="cc" name="course" class="form-select form-select- select w-75 py-1 mt-0 h-25 " aria-label=".form-select-sm example">
                                    <option disabled selected> Select course</option>


                                    <?php
                                        $conn = mysqli_connect('localhost','root','','test');
                                        $query = "SELECT name FROM `courses` GROUP BY name ;";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $resultSet = $stmt->get_result();
                                        $iddi = $resultSet->fetch_all(MYSQLI_ASSOC);
                                        foreach($iddi as $key=>$val){ 
                                            echo '<option value="'. $val['name'] .'">'. $val['name'] . '</option>' ;
                                        }
                                    ?>
                        </select>

                        <select id="cc" name="name" class="form-select form-select- select w-75 py-1 mt-2 h-25 " aria-label=".form-select-sm example">
                                    <option disabled selected> Select Students</option>


                                    <?php
                                        $conn = mysqli_connect('localhost','root','','test');
                                        $query = "SELECT name FROM `students` GROUP BY name ;";
                                        $stmt = $conn->prepare($query);
                                        $stmt->execute();
                                        $resultSet = $stmt->get_result();
                                        $iddi = $resultSet->fetch_all(MYSQLI_ASSOC);
                                        foreach($iddi as $key=>$val){ 
                                            echo '<option value="'. $val['name'] .'">'. $val['name'] . '</option>' ;
                                        }
                                    ?>
                        </select>

                        <div class="w-25  mb-3 ">
                            
                            <input type="text" class="form-control " name="grade" id="exampleInputPassword1"
                            value="<?php if(isset($eEmail)){echo $eEmail;}elseif(isset($ee)){echo $ee;} ?>" placeholder="grade:"></input>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary px-3 w-50 h-25 m-auto">Send</button>

<button type="submit" name="edit" class="h-25 m-auto w-50 btn btn-info px-3">Edit</button>




                       
                    </form>


                    <ul class="dropdown-menu p-0 m-0 w-25 ">
                                <li class="">

                                 </li>
                            </ul>


        
        <!-- database requair -->


        <div class=" col-5  ">
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
                        <th scope="col">id</th>
                        <th scope="col">Name</th>
                        <th scope="col">grade</th>

                    </tr>
                </thead>
                <tbody>


                    <?php

                

                        $conn = mysqli_connect('localhost','root','','test');
                        $query = "Select * from grade ";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $resultSet = $stmt->get_result();
                        $datas = $resultSet->fetch_all(MYSQLI_ASSOC);

                        echo '<a href="#soso"class="btn btn-sm btn-info position-relative mt-2 ">
                        grades 
                        <span class="position-absolute top-0 start-100 translate-middle badge  bg-danger">
                        '.count($datas).'
                        <span class="visually-hidden">unread messages</span>
                        </span>
                        </a>';
                        if (count($datas)> 0) { 

                            foreach($datas as $key=>$val){
                                echo '
                                <tr class="text-center">
                                <td>'.$val['student'].'</td>
                                <td>'.$val['cousename'].'</td>
                                <td>'.@$val['grade'].'</td>

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