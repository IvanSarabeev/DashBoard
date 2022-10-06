<?php
  	session_start();
   date_default_timezone_set('Europe/Sofia');
   $date = date("Y-m-d");
   require '../dbconn.php';
   $email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="bg">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
      <link href="css/dashboard.css" rel="stylesheet">
      <link rel="shortcut icon" href="title.png">
      <link rel="stylesheet" href="css/alert.css"/>

      <script src="https://kit.fontawesome.com/d4b9f98a5c.js" crossorigin="anonymous"></script>

      <title id="changeTitle">Администраторски панел</title>
   </head>

      
   <body>
   <div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
   </div>
      <div class="modal fade" id="ordersModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Добави заявка</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="addOrder">
                  <div class="modal-body">
                     <div id="errorMessage" class="alert alert-danger d-none text-center" role="alert"></div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Име:</label>
                        <input type="text" name="name" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Адрес:</label>
                        <input type="text" name="address" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Телефон:</label>
                        <input type="text" name="phone" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Вид помещение:</label>
                        <select name="room" id="selBul" class="form-select shadow-none" aria-label="Default select example">
                           <option hidden disabled selected>Изберете помещенние</option>
                           <option value="Къща">Къща</option>
                           <option value="Офис">Офис</option>
                           <option value="Салон">Салон</option>
                        </select>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Вид оферта:</label>
                        <select name="offer" id="selOf" class="form-select shadow-none" aria-label="Default select example">
                           <option hidden disabled selected>Изберете оферта</option>
                           <option value="Основна">Основна</option>
                           <option value="Премиум">Премиум</option>
                           <option value="Вип">Вип</option>
                        </select>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Дата:</label>
                        <input type="date" name="pickDate" class="form-control shadow-none" min="<?php echo date("Y-m-d", strtotime('+1 day', time())); ?>" value="<?php echo date("Y-m-d", strtotime('+1 day', time())); ?>">
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Час на изпълнение:</label>
                        <input type="time" name="pickTime" class="form-control shadow-none" value="<?php echo date("H:i"); ?>" id="pickTimeAdd">
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">m<sup>2</sup></label>
                        <input type="text" name="m2" id="m2" class="form-control shadow-none"/>
                     </div>
                     <div id="d-noneRem" class="mb-3 d-none">
                        <label class="mb-0" for="">Планиран край:</label>
                        <input type="text" disabled id="planEndd" class="form-control shadow-none"/>
                     </div>
                     <label class="mb-0" for="">Цена: <span id="price2"></span></label>
                     <input type="hidden" name="price" class="form-control shadow-none" id="price"/>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                     <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="modal fade" id="оrderEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div id="dontChange" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Редактиране на заявка</h5>
                  <button type="button" id="closeEditModal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="updateOrder">
                  <div class="modal-body">
                     <input type="hidden" name="id" id="id">
                     <div class="alert alert-danger d-none text-center"></div>
                     <div class="d-flex justify-content-between">
                        <div class="mb-3">
                           <label class="mb-0" for="">Клиентски номер:</label>
                           <input disabled type="text" name="number" id="number" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Име:</label>
                           <input type="text" name="name" id="name" class="form-control shadow-none" />
                        </div>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Адрес:</label>
                        <input type="text" name="address" id="address" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Телефон:</label>
                        <input type="text" name="phone" id="phone" class="form-control shadow-none" />
                     </div>
                     <div class="d-flex justify-content-between">
                        <div class="mb-3">
                           <label class="mb-0" for="">Вид помещение:</label>
                           <input type="text" name="room" id="room" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Вид оферта:</label>
                           <input type="text" name="offer" id="offer" class="form-control shadow-none" />
                        </div>
                     </div>
                     <div id="datee" class="mb-3 d-none">
                        <label class="mb-0" for="">Дата и час на започване:</label>
                        <input disabled type="text" name="startDatee" id="startDatee" class="form-control shadow-none" />
                     </div>
                     <div id="dates" class="d-flex justify-content-between d-none">
                        <div class="mb-3">
                           <label class="mb-0" for="">Дата и час на започване:</label>
                           <input disabled type="text" name="startDate" id="startDate" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Дата и час на край:</label>
                           <input disabled type="text" name="EndDate" id="endDate" class="form-control shadow-none" />
                        </div>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Дата на заявка:</label>
                        <input type="date" name="pickDate" min="<?php date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" id="setDate" class="form-control shadow-none">
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Час на изпълнение:</label>
                        <input type="time" name="pickTime" id="pickTimee" class="form-control shadow-none">
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">m<sup>2</sup></label>
                        <input type="text" name="m2" class="form-control shadow-none" id="m22"/>
                     </div>
                     <label class="mb-0" for="">Цена: <span id="price3"></span></label>
                     <input type="hidden" name="price" class="form-control shadow-none" id="price1"/>
                  </div>
                  <div class="modal-footer" id="modalBtn">
                     <button id="can" data-bs-toggle="modal" data-bs-dismiss="modal" type="button" class="btn bg-gradient btn-secondary shadow-none">Откажи</button>
                     <button id="endOrder" type="button" class="btn bg-gradient btn-danger shadow-none">Край</button>
                     <button id="closeEd" type="button" class="btn bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                     <button id="submitEd" type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
               <h5 class="modal-title text-black" id="exampleModalLabel">Отказ на заявката</h5>
                  <button type="button" class="close closeCancelModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="cancelForm">
                  <div class="modal-body">
                  <div id="errMess" class="alert alert-danger d-none text-center" role="alert"></div>
                        <input type="hidden" id="canOrderID" name="id">
                        <label class="mb-0" for="">Причина за отказа:</label>
                        <textarea class="form-control shadow-none" id="text-area" name="canText" rows="3"></textarea>
                        <div class="d-flex justify-content-end"><span id='charCount'>0</span><span id='maxChar'>/150</span></div>
                  </div>
                  <div class="modal-footer" id="modalBtn">
                     <button type="button" class="closeCancelModal btn bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                     <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-body">
                     <label class="mb-0" for="">Причина за отказа:</label>
                     <textarea class="form-control shadow-none" disabled id="text-areaa" name="canText" rows="3"></textarea>
               </div>
            </div>
         </div>
      </div>
      
      <div class="wrapper">
         <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
               <a class="sidebar-brand" href="dashboard.php">
               <span class="align-middle">Админ Панел</span>
               </a>
               <ul class="sidebar-nav">
                  <li class="sidebar-header">
                     Действия
                  </li>
                  <li id="orBtn" class="sidebar-item active">
                     <a class="sidebar-link" href="#">
                     <i class="bi bi-folder"></i> <span class="align-middle">Заявки</span>
                     </a>
                  </li>
                  <li class="sidebar-header">
                     Персонал
                  </li>
                  <li id="usBtn" class="sidebar-item">
                     <a class="sidebar-link" href="#">
                     <i class="bi bi-person-fill"></i> <span class="align-middle">Потребители</span>
                     </a>
                  </li>
                  <li id="tmBtn" class="sidebar-item">
                     <a class="sidebar-link" href="#">
                     <i class="bi bi-people-fill"></i> <span class="align-middle">Екипи</span>
                     </a>
                  </li>
                  <li class="sidebar-header">
                     Номенклатури
                  </li>
                  <li id="wrBtn" class="sidebar-item">
                     <a class="sidebar-link" href="#" id="warehouse">
                     <i class="bi bi-archive"></i> <span class="align-middle">Склад</span>
                     </a>
                  </li>
                  <li id="spBtn" class="sidebar-item">
                     <a class="sidebar-link" href="#">
                     <i class="bi bi-box-seam"></i> <span class="align-middle">Доставчици</span>
                     </a>
                  </li>
                  <li id="cmBtn" class="sidebar-item">
                     <a class="sidebar-link" href="#">
                     <i class="bi bi-person-circle"></i> <span class="align-middle">Клиенти</span>
                     </a>
                  </li>
                 
               </ul>
            </div>
         </nav>
         <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg">
               <a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>
               <div class="windowsHead">Заявки</div>
               <div class="navbar-collapse collapse">
                  <ul class="navbar-nav navbar-align">
                  <li class="nav-item dropdown">
                            <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                                <div class="position-relative">
                                    <i class="align-middle" data-feather="bell"></i>
                                    <span id="notifNum" class="indicator d-none"></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                                <div class="dropdown-menu-header">
                                    Известия
                                </div>
                                <div class="list-group" id="addNoti"></div>
                                <div class="list-group" id="notNoti">Няма нови известия</div>
                            </div>
                        </li>
                     <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                        <i class="align-middle" data-feather="settings"></i>
                        </a>
                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                        
                        <?php
                              $query = "SELECT * FROM admin WHERE email = '$email'";
                              $query_run = mysqli_query($con, $query);
                                 
                              while($rows=mysqli_fetch_array($query_run))
                              {
                        if($rows["img"] != ""){ ?>
                      <img src="signIn/adminImage/<?= $rows["img"] ?>" class="updatePhoto avatar img-fluid rounded me-1"  alt="потребител"/>
                     <?php } else { ?>
                        <img src="man-profile-cartoon_18591-58482-removebg-preview.png" class="updatePhoto avatar img-fluid rounded me-1"  alt="потребител"/>
                        <?php }}?>
                        <span class="text-dark">
                           <?php 
                           $query = "SELECT * FROM admin WHERE email = '$email'";
                           $query_run = mysqli_query($con, $query);

                           while($rows=mysqli_fetch_array($query_run))
                           {
                              echo $rows['name'];
                           }
                           ?>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                           <a id="profBtn" class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="user"></i> Профил</a>
                           <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Помощ</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" id="systemExit" href="#">Изход</a>
                        </div>
                     </li>
                  </ul>
               </div>
            </nav>

            <div class="modal fade" id="setOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Назначи заявка</h5>
                        <button type="button" id="closeEditModal" class="close setOrder" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form id="setOrder">
                        <div class="modal-body">
                           <div id="setOrderErorr" class="alert alert-danger d-none text-center"></div>
                           <input type="hidden" name="teamID" id="teamIdSet">
                           <input type="hidden" name="orderID" id="orderID">
                           <input type="hidden" name="getTeamName" id="getTeamName"> 
                           <div id="errorMesSetOrder" class="alert alert-danger d-none text-center" role="alert"></div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Екип:</label>
                              <select id="selTm" class="form-select shadow-none" aria-label="Default select example"></select>
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Потребител 1</label>
                              <input type="text" id="selUser1" name="user1" class="form-control shadow-none"/>
                              <input type="hidden" id="user1id" name="userID1">
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Потребител 2</label>
                              <input type="text" id="selUser2" name="user2" class="form-control shadow-none"/>
                              <input type="hidden" id="user2id" name="userID2">
                           </div>
                        </div>
                           <div class="modal-footer">
                              <button type="button" class="btn setOrder bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                              <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                           </div>
                     </form>
                  </div>
               </div>
            </div>

            <div class="modal fade" id="reviewTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Инфомация за назначената задача</h5>
                        <button type="button" class="close reviewTeam" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form id="teamView">
                        <div class="modal-body">
                           <div class="mb-3">
                              <label class="mb-0" for="">Екип:</label>
                              <input disabled type="text" id="getTeam" class="form-control shadow-none"/>
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Потребител 1</label>
                              <input disabled type="text" id="getUser1" class="form-control shadow-none"/>
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Потребител 2</label>
                              <input disabled type="text" id="getUser2" class="form-control shadow-none"/>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <main id="orSec" class="content animate__animated animate__fadeIn mt-2">
               <div class="container-fluid p-0">
                  <div class="row">
                     <div class="col-xl-6 col-xxl-5 d-flex">
                        <div class="w-100">
                           <div class="row">
                              <div class="col-sm-5 col-lg-5 col-xl-12 col-md-5 d-flex">
                                 <div class="col-10 pl-0">
                                    <div class="card">
                                       <div class="card-body">
                                          <div class="row">
                                             <div class="col mt-0">
                                                <h5 class="card-title">Заявки</h5>
                                             </div>
                                             <div class="col-auto">
                                                <div class="stat text-primary">
                                                   <i class="bi bi-folder align-middle"></i>
                                                </div>
                                             </div>
                                          </div>
                                          <h1 id="orderCount" class="mb-1"><?php 
                                             $q="select * from orders where date='$date'";
                                             $res=mysqli_query($con,$q);
                                             echo mysqli_num_rows($res);
                                             ?></h1>
                                          <div class="mb-0">
                                             <span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i></span>
                                             <span class="text-muted today">За днес</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-10">
                                    <div class="card">
                                       <div class="card-body">
                                          <div class="row">
                                             <div class="col mt-0">
                                                <h5 class="card-title">Заявки в процес</h5>
                                             </div>
                                             <div class="col-auto">
                                                <div class="stat text-primary">
                                                   <i class="bi bi-arrow-repeat align-middle fa-lg"></i>
                                                </div>
                                             </div>
                                          </div>
                                          <h1 id="inProcessEx" class="mb-1">
                                             <?php
                                                $q="SELECT * FROM orders WHERE status = 'В процес' and date = '$date'";
                                                $res=mysqli_query($con,$q);
                                                $num= mysqli_num_rows($res);
                                                echo json_encode($num);
                                             ?>
                                          </h1>
                                          <div class="mb-0">
                                             <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i></span>
                                             <span class="text-muted today">За днес</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-10">
                                    <div class="card">
                                       <div class="card-body">
                                          <div class="row">
                                             <div class="col mt-0">
                                                <h5 class="card-title">Отработени заявки</h5>
                                             </div>
                                             <div class="col-auto">
                                                <div id="doneEx" class="stat text-primary">
                                                   <i class="fa-solid fa-check align-middle"></i>
                                                </div>
                                             </div>
                                          </div>
                                          <h1 id="finishedEx" class="mb-1">
                                             <?php
                                                $q="select * from orders where status = 'Приключена' and date = '$date'";
                                                $res=mysqli_query($con,$q);
                                                $num= mysqli_num_rows($res);
                                                echo json_encode($num);
                                                ?>
                                          </h1>
                                          <div class="mb-0">
                                             <span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i></span>
                                             <span class="text-muted today">За днес</span>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="container-fluid col-12 d-flex">
                     <div class="card flex-fill  mb-0">
                        <div class="card-header pad-y d-flex justify-content-between">
                           <h5 class="card-title">Планирани заявки</h5>
                           <div class="d-flex">
                              <div class="col-7 m-">
                                 <div class="input-group mx-2">
                                    <input type="text" class="form-control shadow-none" autocomplete="off" id="username" placeholder="Търси по клиент или номер" aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                       <span style="background: #d3e2f7;" class="input-group-text" id="basic-addon2"><i style="color: rgb(59, 125, 221);" class="bi bi-search"></i></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="input-group ml-1 mr-2 date">
                                 <input type="date" class="form-control shadow-none" value="<?php echo date('Y-m-d'); ?>" id="dateFilter">
                              </div>
                              <button title="Добави нова заявка" type="button" class="btn mr-2 bg-gradient btn-primary shadow-none" data-toggle="modal" data-target="#ordersModal"><i class="fa-solid fa-plus fa-lg"></i></button>
                              <button id="reloadBtn" title="Обнови" type="button" class="btn bg-gradient btn-success shadow-none"><i class="fa-solid rotate fa-arrows-rotate fa-lg"></i></button>
                           </div>
                        </div>
                        <div class="tableH">
                        <table id="myTable" class="table table-hover mb-0">
                           <thead>
                              <tr>
                                 <th class="column_sort" id="custNumber" name="id" data-order="desc">Номер</th>
                                 <th class="column_sort" id="customer" name="customerName" data-order="desc">Клиент</th>
                                 <th class="column_sort" id="addres" name="address" data-order="desc">Адрес</th>
                                 <th class="column_sort" id="of" name="offer" data-order="desc">Оферта</th>
                                 <th class="column_sort" id="bul" name="room" data-order="desc">Помещение</th>
                                 <th class="column_sort" id="km" name="m2" data-order="desc">m<sup>2</sup></th>
                                 <th class="column_sort" id="pri" name="price" data-order="desc">Цена</th>
                                 <th class="column_sort" id="orStatus" name="status" data-order="desc">Статус</th>
                                 <th class="column_sort" id="payStat" name="pay" data-order="desc">Пл. статус</th>
                                 <th>Назначи</th>
                              </tr>
                           </thead>
                           <tbody id="tbody">
                              <?php
                                 $query = "SELECT * FROM orders WHERE date = '$date'";
                                 $query_run = mysqli_query($con, $query);
                                 
                                 if(mysqli_num_rows($query_run) > 0)
                                 {
                                    while($rows=mysqli_fetch_array($query_run))
                                     {
                                         ?>
                              <tr>
                                 <td>
                                    <?= $rows['id'] ?>
                                 </td>
                                 <td><button class="editOrderBtn customer" type="button" value="<?= $rows['id'];?>"><?= $rows["customerName"] ?></button></td>
                                 <td>
                                    <?= $rows['address'] ?>
                                 </td >
                                 <?php
                                    if($rows['offer'] == "Премиум"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-primary px-2 py-1"><?= $rows['offer'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['offer'] == "Вип"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-info px-2 py-1"><?= $rows['offer'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['offer'] == "Основна"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-secondary px-2 py-1"><?= $rows['offer'] ?></span></td>
                                 <?php
                                    }
                                    ?>
                                 <td>
                                    <?= $rows['room'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['m2'] ?> m<sup>2</sup>
                                 </td>
                                 <td>
                                    <?= $rows['price'] .' лв.'?>
                                 </td>
                                 <?php
                                    if($rows['status'] == "Назначи"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-primary px-2 py-1"><?= $rows['status'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['status'] == "Назначена"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-info px-2 py-1"><?= $rows['status'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['status'] == "В процес"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-warning px-2 py-1"><?= $rows['status'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['status'] == "Отказана"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-danger px-2 py-1"><button class="reviewCancel customer" type="button" value="<?= $rows['id'];?>"><?= $rows['status'] ?></button></span></td>
                                 <?php
                                    }
                                    if($rows['status'] == "Приключена"){
                                        ?>
                                 <td><span class="badge bg-gradient bg-success px-2 py-1"><?= $rows['status'] ?></span></td>
                                 <?php
                                    }
                                    if($rows['status'] == "Изтекла"){
                                       ?>
                                           <td><span class="badge bg-gradient bg-secondary px-2 py-1"><?= $rows['status'] ?></span></td>
                                       <?php
                                   }
                                    ?>
                                 <td>
                                    <?= $rows['pay'] ?>
                                 </td>
                                 <?php
                                    if ($rows['status'] == "Назначи" && $rows['teamID'] == 0){
                                       ?><td><button type="button"  value="<?= $rows['id'];?>" class="btn bg-gradient setOrder btn-primary btn-sm shadow-none py-1 px-4 rounded"><i class="fa-solid fa-user-group"></i></button></td><?php
                                    } else {
                                       ?><td><button type="button" value="<?= $rows['teamID'];?>" class="btn appointedBtn bg-gradient btn-success btn-sm shadow-none py-1 px-4 rounded"><i class="fa-solid fa-check fa-lg"></i></button></td><?php
                                    }
                                 ?>
                              </tr>
                              <?php
                                 }
                              } else {
                                 ?>
                                     <tr>
                                         <th class="text-center pos position-absolute border-0" colspan="10">Няма намерени данни</th>
                                     </tr>
                                 <?php
                             }
                                 ?>
                                 
                           </tbody>           
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
         </main>
         <div class="modal fade" id="photoUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-body">
                     <form id="uploadPhoto">
                     <div class="container">
                     <div class="row">
                        <div class="col-md-12 col-md-offset-2">
                           <div class="form-group mb-0 mt-1">
                           <label for="fileField" class="attachment">
                              <div class="row btn-file">
                                 <div class="btn-file__preview"></div>
                                 <div class="btn-file__actions">
                                 <div class="btn-file__actions__item col-xs-12 text-center">
                                    <div class="btn-file__actions__item--shadow">
                                       <i class="fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>
                                       <div class="visible-xs-block"></div>
                                       Избери снимка
                                    </div>
                                 </div>
                                 </div>
                              </div>
                              <input name="img" type="file" id="fileField">
                           </label>
                           </div>
                        </div>
                     </div>
                     </div>
                     <div class="text-center" id="imageName"></div>
                  </div>
                  <?php 
                   $query = "SELECT * FROM admin WHERE email = '$email'";
                   $query_run = mysqli_query($con, $query);
                      
                   while($rows=mysqli_fetch_array($query_run))
                   {
                     ?> <input type="hidden" id="idForUpload" name="id" value="<?= $rows['id'] ?>"> <?php
                   }
                  ?>
                  <div class="modal-footer">
                  <button type="button" class="btn closeUploadModal btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                  <button type="submit" class="btn btn-primary shadow-none">Запази</button>
                  </div>
                  </form>
               </div>
            </div>
         </div>

         <main id="profSec" class="content d-none animate__animated animate__fadeIn">
         <?php 
            $query = "SELECT * FROM admin WHERE email = '$email'";
            $query_run = mysqli_query($con, $query);
               
            while($rows=mysqli_fetch_array($query_run))
            {
         ?>
         <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4 col-xlg-3 col-md-12">
              <div class="white-box">
                <div class="user-bg">
                  <img width="100%" alt="потребител" src="Wavy_Tech-28_Single-10.jpg"/>
                  <div class="overlay-box">
                    <div class="user-content">
                     <?php if($rows["img"] != ""){ ?>
                      <a class="openPhotoModal" href="#"><img src="signIn/adminImage/<?= $rows["img"] ?>" class="updatePhoto thumb-lg img-circle" alt="потребител"/></a>
                     <?php } else { ?>
                        <a class="openPhotoModal" href="#"><img src="man-profile-cartoon_18591-58482-removebg-preview.png" class="updatePhoto thumb-lg img-circle" alt="потребител"/></a>
                        <?php }?>
                        <h3 class="text-white mt-2"><?= $rows['name'] ?></h3>
                        <h4 class="text-white mt-2"><?= $rows['email'] ?></h4>
                    </div>
                  </div>
                </div>
                <div class="user-btm-box mt-5 text-center">
                  <h1><?= $rows['role'] ?></h1>
                </div>
              </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-12">
              <div class="card mb-0">
                <div class="card-body">
                  <form id="adminInfo" class="form-horizontal form-material">
                    <div class="form-group mb-4">
                      <label class="col-md-12 mb-0 p-0">Имена</label>
                      <div class="col-md-12 border-bottom p-0 d-flex">
                        <input type="hidden" id="signInPhoneID" name='id' value="<?= $rows['id'] ?>">
                        <input type="text" value="<?= $rows['name'] ?>" name="name" class="form-control p-0 border-0 shadow-none inputIsNot"/>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label for="example-email" class="col-md-12 mb-0 p-0">Имейл</label>
                      <div class="col-md-12 border-bottom p-0 shadow-none">
                        <input type="email" value="<?= $rows['email'] ?>" name="email" class="form-control p-0 border-0 shadow-none inputIsNot"/>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label class="col-md-12 mb-0 p-0 label-col-change">Парола</label>
                      <div class="col-md-12 border-bottom p-0">
                        <input type="password" name="password" placeholder="••••••••••" class="form-control p-0 border-0 bor-bot-color shadow-none"/>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label class="col-md-12 mb-0 p-0 label-col-change1">Повтори парола</label>
                      <div class="col-md-12 border-bottom p-0">
                        <input type="password" name="passwordR" placeholder="••••••••••" class="form-control p-0 border-0 bor-bot-color1 shadow-none"/>
                      </div>
                    </div>
                    <div class="form-group mb-4">
                      <label class="col-md-12 mb-0 p-0">Телефонен номер</label>
                      <div class="col-md-12 border-bottom p-0">
                        <input id="signInPhone" type="text" name="phone" placeholder="08 ........" class="form-control p-0 border-0 shadow-none"
                        <?php
                         if(!empty($rows['phone'])){
                           ?>
                              value="<?= $rows['phone'] ?>"
                           <?php
                         }
                         ?>
                        />
                      </div>
                    </div>
                    <div class="form-group mb-2">
                      <div class="col-sm-12 pl-0">
                        <button type="submit" value="<?= $rows['id'] ?>" class="btn bg-gradient shadow-none btn-success">Обнови</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
         }
         ?>
      </main>

         <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title text-black" id="exampleModalLabel">Добави потребител</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <form id="addUser">
                     <div class="modal-body">
                        <div id="errorrMessage" class="alert alert-danger d-none text-center" role="alert"></div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Име и фамилия:</label>
                           <input type="text" name="fullName" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">ЕГН:</label>
                           <input type="text" name="egn" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Телефон:</label>
                           <input type="text" name="userPhone" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Снимка:</label>
                           <input type="file" id="uplImg" name="img" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">ПИД:</label>
                           <input type="text" id="errorPid" name="pid" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Длъжност:</label>
                           <select name="position" class="form-select shadow-none" aria-label="Default select example">
                              <option hidden disabled selected>Изберете длъжност</option>
                              <option value="Шофьор">Шофьор</option>
                              <option value="Хигиенист">Хигиенист</option>
                           </select>
                        </div>
                        <div class="mb-1">
                           <label class="mb-0" for="">Постъпил считано от:</label>
                           <input type="date" name="inDate" class="form-control shadow-none" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                        <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
         
         <div class="modal fade" id="userEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <img id="userImg" src="" alt="">
                  <h5 class="modal-title text-black pt-3" id="exampleModalLabel">Редактиране на потребител</h5>
                  <button type="button" id="closeEditModal" class="close userEditModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="updateUser">
                  <div class="modal-body">
                     <input type="hidden" name="id" id="userId">
                     <div  class="alert alert-danger d-none text-center"></div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Име и фамилия:</label>
                           <input type="text" id="userNamee" name="fullName" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">ЕГН:</label>
                           <input type="text" id="egn" name="egn" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Телефон:</label>
                           <input type="text" id="userPhone" name="userPhone" class="form-control shadow-none" />
                        </div>
                        <div id="fileImgDN" class="mb-3">
                           <label class="mb-0" for="">Снимка:</label>
                           <input type="file" name="img" class="form-control shadow-none" />
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Длъжност:</label>
                           <select name="position" id="userPos" class="form-select shadow-none" aria-label="Default select example">
                              <option value="Шофьор">Шофьор</option>
                              <option value="Хигиенист">Хигиенист</option>
                           </select>
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Постъпил считано от:</label>
                           <input type="date" id="inDate" name="inDate" class="form-control shadow-none" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="mb-3">
                           <label class="mb-0" for="">Статус на потребителя:</label>
                           <select name="status" id="userStatus" class="form-select shadow-none" aria-label="Default select example">
                              <option value="Активен">Активен</option>
                              <option value="Напуснал">Напуснал</option>
                           </select>
                        </div>
                        <input type="hidden" name="getTeamID" id="setTeamID">
                        <div id="leftJob" class="mb-1 d-none">
                           <label class="mb-0" for="">Напуснал считано от:</label>
                           <input type="date" id="outDate" name="outDate" class="form-control shadow-none" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                     </div>
                     <div class="modal-footer" id="modalBtnUserEdit">
                        <button type="button" id="closeModal" class="btn userEditModal bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                        <button type="submit" id="subModal" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                     </div>
               </form>
            </div>
         </div>
      </div>

      <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Задаване на парола</h5>
                  <button type="button" id="closeEditModal" class="close setPassword" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="setPassword">
                  <div class="modal-body">
                     <div id="passErorr"  class="alert alert-danger d-none text-center"></div>
                     <input type="hidden" name="id" id="userIdIn">
                     <div  class="alert alert-danger d-none text-center"></div>
                     <div class="mb-3">
                           <label class="mb-0" for="">Потребителско име:</label>
                           <input type="text" disabled id="userNameIn" name="fullName" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Парола</label>
                        <input type="password" id="password" name="password" class="form-control shadow-none" />
                     </div>
                     <div class="mb-1">
                        <label class="mb-0" for="">Повтори парола</label>
                        <input type="password" id="repPassword" name="repPassword" class="form-control shadow-none" />
                     </div>
                  </div>
                     <div class="modal-footer">
                        <button type="button" class="btn setPassword bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                        <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                     </div>
               </form>
            </div>
         </div>
      </div>

        <main id="usSec" class="content d-none animate__animated animate__fadeIn">
               <div class="row">
                  <div class="container-fluid col-12 d-flex">
                     <div class="card flex-fill mb-0">
                        <div class="card-header pad-y d-flex justify-content-between">
                           <h5 class="card-title">Всички потребители</h5>
                           <div class="d-flex">
                              <div class="col-7">
                                 <div class="input-group mx-2">
                                    <input type="text" class="form-control shadow-none" id="namePid" placeholder="Търси по име или ПИД" aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append">
                                       <span style="background: #d3e2f7;" class="input-group-text borderNo" id="basic-addon2"><i style="color: rgb(59, 125, 221);" class="bi bi-search"></i></span>
                                    </div>
                                 </div>
                              </div>
                              <div class="input-group ml-1 mr-2">
                                 <select name="room" id="selPos" class="form-select shadow-none" aria-label="Default select example">
                                    <option hidden disabled selected>Длъжност</option>
                                    <option value="Всички">Всички</option>
                                    <option value="Шофьор">Шофьор</option>
                                    <option value="Хигиенист">Хигиенист</option>
                                 </select>
                              </div>
                              <button title="Добави нов потребител" id="openUserModal" type="button" class="btn mr-2 bg-gradient btn-primary shadow-none" data-toggle="modal" data-target="#userModal"><i class="fa-solid fa-plus fa-lg"></i></button>
                           </div>
                        </div>
                        <div class="tableM">
                        <table id="userTable" class="table table-hover mb-0">
                           <thead>
                              <tr>
                                 <th class="column_sortt" id="emId" name="id" data-order="desc">Номер</th>
                                 <th>Снимка</th>
                                 <th class="column_sortt" id="emName" name="name" data-order="desc">Име</th>
                                 <th class="column_sortt" id="emPid" name="pid" data-order="desc">ПИД</th>
                                 <th class="column_sortt" id="emEgn" name="egn" data-order="desc">ЕГН</th>
                                 <th class="column_sortt" id="emPhone" name="phone" data-order="desc">Телефон</th>
                                 <th class="column_sortt" id="emPosition" name="position" data-order="desc">Длъжност</th>
                                 <th class="column_sortt" id="emStatus" name="status" data-order="desc">Статус</th>
                                 <th>Екип</th>
                                 <th class="column_sortt" id="emDate" name="inDate" data-order="desc">Назначен</th>
                                 <th>Действия</th>
                              </tr>
                           </thead>
                           <tbody id="tbody">
                              <?php
                                 $query = "SELECT * FROM employee";
                                 $query_run = mysqli_query($con, $query);
                                 
                                 if(mysqli_num_rows($query_run) > 0)
                                 {
                                    while($rows=mysqli_fetch_array($query_run))
                                     {
                                       $team = $rows['teamID'];
                                         ?>
                              <tr>
                                 <td>
                                    <?= $rows['id'] ?>
                                 </td>
                                 <td class="py-1"><img class="rounded-circle border border-secondary" src="users/userImages/<?= $rows["image"] ?>" alt=""></td>
                                 <td><button class="editUserBtn customer" type="button" value="<?= $rows['id'];?>"><?= $rows["name"] ?></button></td>
                                 <td id="getPid">
                                    <?= $rows['pid'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['egn'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['phone'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['position'] ?>
                                 </td>
                                 <?php
                                    if ($rows['status'] == "Активен"){
                                       ?><td class="text-success"><?= $rows['status'] ?></td><?php
                                    }
                                    if ($rows['status'] == "Напуснал"){
                                       ?><td class="text-danger"><?= $rows['status'] ?></td><?php
                                    }
                                 ?>
                                 <td>
                                 <?php
                                 $queryy = "SELECT * FROM teams WHERE id='$team'";
                                 $queryy_run = mysqli_query($con, $queryy);
                                 
                                 if(mysqli_num_rows($queryy_run) > 0)
                                 {
                                    while($rowss=mysqli_fetch_array($queryy_run))
                                    {
                                       ?>
                                          <?= $rowss['name'] ?>
                                       <?php
                                    }
                                 } else {
                                    ?>
                                    Няма екип
                                    <?php
                                 }    
                                         ?>
                                 </td>
                                 <td>
                                    <?= date("d.m.y", strtotime($rows['inDate'])) ?>
                                 </td>
                                 <?php
                                    if ($rows['status'] == "Активен"){
                                       ?><td><button type="button" value="<?= $rows['id'];?>" class="btn bg-gradient btn-primary passwordBtn btn-sm shadow-none py-1 px-4 rounded">Парола<i class="fa-solid fa-unlock-keyhole ml-2"></i></button></td><?php
                                    }
                                    if ($rows['status'] == "Напуснал"){
                                       ?><td class="text-danger"><button type="button" disabled class="btn bg-gradient btn-primary passwordBtn btn-sm shadow-none py-1 px-4 rounded">Парола<i class="fa-solid fa-unlock-keyhole ml-2"></i></button></td><?php
                                    }
                                 ?>
                              </tr>
                              <?php
                                 }
                              } else {
                                 ?>
                                     <tr>
                                         <th class="text-center pos position-absolute border-0" colspan="10">Няма намерени данни</th>
                                     </tr>
                                 <?php
                             }
                                 ?>
                           </tbody>           
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
         </main>

      <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Създай екип</h5>
                  <button type="button" id="closeEditModal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="addTeam">
                  <div class="modal-body">
                     <div id="errorrMessageee" class="alert alert-danger d-none text-center" role="alert"></div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Име на екипа</label>
                        <input type="text" id="teamName" name="tmName"  autocomplete="off" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Потребител 1</label>
                        <input type="text" id="user1" name="user1"  autocomplete="off" class="form-control shadow-none" />
                        <div id="firstDrop" class="dropdownSearch d-none"></div>
                        <input type="hidden" id="firstHiddenPID" name="hidPID1">
                        <input type="hidden" id="User1ID" name="User1ID">
                     </div>
                     <div class="mb-1">
                        <label class="mb-0" for="">Потребител 2</label>
                        <input type="text" id="user2" name="user2"  autocomplete="off" class="form-control shadow-none" />
                        <div id="secondDrop" class="dropdownSearch d-none"></div>
                        <input type="hidden" id="firstHiddenPID1" name="hidPID2">
                        <input type="hidden" id="User2ID" name="User2ID">
                     </div>
                  </div>
                     <div class="modal-footer">
                        <button type="button" class="btn bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                        <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                     </div>
               </form>
            </div>
         </div>
      </div>

      <div class="modal fade" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Създай екип</h5>
                  <button type="button" id="closeEditModal" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
            </div>
         </div>
      </div>

      <div class="modal fade" id="prevORD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black" id="exampleModalLabel">Назначени задачи на избрания екип</h5>
                  <button type="button" id="closePrevORD" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
                  <input type="hidden" id="getTeamID" name="getTeamID">
                  <div class="modal-body pb-0" id="customerCard">
                             
                  </div>
            </div>
         </div>
      </div>

         <main id="tmSec" class="content d-none animate__animated animate__fadeIn">
            <div class="row">
                  <div class="container-fluid col-12 d-flex">
                     <div class="card flex-fill mb-0">
                        <div class="card-header pad-y d-flex justify-content-between">
                           <h5 class="card-title">Всички екипи</h5>
                           <div class="d-flex">
                              <div class="input-group mx-2">
                                 <input type="text" class="form-control shadow-none" id="teamNumber" placeholder="Търси по номер или име" aria-label="Username" aria-describedby="basic-addon1">
                                 <div class="input-group-append">
                                 <span style="background: #d3e2f7;" class="input-group-text" id="basic-addon2"><i style="color: rgb(59, 125, 221);" class="bi bi-search"></i></span>
                                 </div>
                              </div>
                              <button title="Добави нов екип" type="button" class="btn mr-2 bg-gradient btn-primary shadow-none" data-toggle="modal" data-target="#addTeamModal"><i class="fa-solid fa-plus fa-lg"></i></button>
                              <button id="reloadBtnUsers" title="Обнови" type="button" class="btn bg-gradient btn-success shadow-none"><i class="fa-solid rotate fa-arrows-rotate fa-lg rotate down"></i></button>
                           </div>
                        </div>
                        <div class="tableM">
                        <table id="teamTable" class="table table-hover mb-0">
                           <thead>
                              <tr>
                                 <th>Номер</th>
                                 <th>Име на екип</th>
                                 <th>Статус</th>
                                 <th>Потребител 1</th>
                                 <th>Потребител 2</th>
                                 <th>Назначени задачи</th>
                                 <th>Действия</th>
                              </tr>
                           </thead>
                           <tbody >
                              <?php
                                 $query = "SELECT * FROM teams WHERE deleteTeam <> 'yes'";
                                 $query_run = mysqli_query($con, $query);
                                 
                                 if(mysqli_num_rows($query_run) > 0)
                                 {
                                    while($rows=mysqli_fetch_array($query_run))
                                     {
                                         ?>
                              <tr>
                                 <td><?= $rows["id"] ?></td>
                                 <td>
                                    <?= $rows['name'] ?>
                                 </td>
                                 <?php if($rows['status'] == "Yes"){
                                       ?> <td class="text-center"><div class="activeStatusTeam"></div></td><?php
                                 } else {
                                       ?> <td class="text-center"><div class="deactiveStatusTeam"></div></td><?php
                                 } ?>
                                 <td>
                                    <?= $rows['user1'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['user2'] ?>
                                 </td>
                                 <td>
                                    <button type="button" value="<?= $rows['id'];?>" class="prevOrd badgee bg-primary px-2 py-1 customer ordCount">
                                 <?php
                                 $id = $rows['id'];
                                 $date_now = date("Y-m-d");

                                 $queryy = "SELECT * FROM orders WHERE teamID = '$id' AND date >= '$date_now'";
                                 $query_runn = mysqli_query($con, $queryy);
                                 
                                 if(mysqli_num_rows($query_runn) > 0)
                                 {
                                    echo mysqli_num_rows($query_runn);
                                 } else {
                                 ?>
                                    0
                                 <?php
                                 }
                                    ?>
                                    </button>
                                 </td>
                                 <td>
                                    <button type="button" value="<?= $rows['id'];?>" class="btn bg-gradient delete_team btn-danger shadow-none rounded">Изтрий<i class="bi bi-trash3 ml-2"></i></button>
                                 </td>
                              </tr>
                              <?php
                                 }
                              } else {
                                 ?>
                                     <tr>
                                         <th class="text-center pos position-absolute border-0" colspan="10">Няма намерени данни</th>
                                     </tr>
                                 <?php
                             }
                                 ?>
                           </tbody>           
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
         </main>



         <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black text-black" id="exampleModalLabel">Добави продукт</h5>
                  <button type="button" class="close closeProdModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form id="addProduct">
                  <div class="modal-body">
                     <div id="errMes" class="alert alert-danger d-none text-center" role="alert"></div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Номер:</label>
                        <input type="text" id="ProdInsertNum" name="prodNum" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Име на продукта:</label>
                        <input type="text" autocomplete="off" id="insertProdName" name="prodName" class="form-control shadow-none" />
                        <div id="nameDrop" class="prodNameSearch d-none"></div>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Количество:</label>
                        <input type="number" id="getQuan" name="prodQuantity" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Единична цена:</label>
                        <input type="text" id="onePrice" name="prodOnePrice" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Цена:</label>
                        <input type="text" id="finalPrice" name="prodPrice" class="form-control shadow-none" />
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Вид на продукта:</label>
                        <select class="form-select shadow-none" id="selKind" name="prodKind" aria-label="Default select example">
                           <option selected hidden disabled>Избери вид на продукта</option>
                           <option value="Техника">Техника</option>
                           <option value="Препарати">Препарати</option>
                           <option value="Екипировка">Екипировка</option>
                           <option value="Пособия за чистене">Пособия за чистене</option>
                        </select>
                     </div>
                     <div class="mb-3">
                        <label class="mb-0" for="">Производител:</label>
                        <input type="text" autocomplete="off" id="insertCom" name="prodCompany" class="form-control shadow-none" />
                        <div id="comDrop" class="comSearch d-none"></div>
                     </div>
                     <div>
                        <label class="mb-0" for="">Доставчик:</label>
                        <input type="text" autocomplete="off" id="insertSup" name="prodSupplier" class="form-control shadow-none" />
                        <div id="supDrop" class="supSearch d-none"></div>
                     </div>
                  </div>
                     <div class="modal-footer">
                        <button type="button" class="btn bg-gradient closeProdModal btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                        <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                     </div>
               </form>
               </div>
            </div>
         </div>                   


         <main id="wrSec" class="content d-none animate__animated animate__fadeIn">
               <div class="row">
                  <div class="container-fluid col-12 d-flex">
                     <div class="card flex-fill mb-0">
                        <div class="card-header pad-y d-flex justify-content-between">
                           <h5 class="card-title">Склад</h5>
                           <div class="d-flex">
                              <div class="input-group mx-2">
                                 <input type="text" class="form-control shadow-none" id="prodNameOrNumber" placeholder="Търси по име на продукт" aria-label="Username" aria-describedby="basic-addon1">
                                 <div class="input-group-append">
                                 <span style="background: #d3e2f7;" class="input-group-text" id="basic-addon2"><i style="color: rgb(59, 125, 221);" class="bi bi-search"></i></span>
                                 </div>
                              </div>
                              <button title="Добави нов продукт" type="button" id="openModalProd" class="btn mr-2 bg-gradient btn-primary shadow-none"><i class="fa-solid fa-plus fa-lg"></i></button>
                              <button title="Покажи списък с продукти" type="button" id="showList" class="btn mr-2 bg-gradient btn-warning shadow-none"><i class="fa-solid fa-bars fa-lg"></i></button>
                              <button title="Покажи наличности" type="button" id="showStock" class="btn mr-2 bg-gradient btn-success shadow-none"><i class="fa-solid fa-box fa-lg"></i></button>
                           </div>
                        </div>
                        <div class="tableM">
                        <table id="productTable" class="table table-hover mb-0">
                           <thead>
                              <tr>
                                 <th class="product_sort" id="prId" name="id" data-order="desc">Номер</th>
                                 <th class="product_sort" id="prName" name="name" data-order="desc">Продукт</th>
                                 <th class="product_sort" id="prQuantity" name="quantity" data-order="desc">Количество</th>
                                 <th class="product_sort" id="prOnePrice" name="onePrice" data-order="desc">Ед. цена</th>
                                 <th class="product_sort" id="prPrice" name="price" data-order="desc">Цена</th>
                                 <th class="product_sort" id="prKind" name="kind" data-order="desc">Вид</th>
                                 <th class="product_sort" id="prDate" name="date" data-order="desc">Дата</th>
                                 <th class="product_sort" id="prCompany" name="company" data-order="desc">Производител</th>
                                 <th class="product_sort" id="prSupplier" name="supplier" data-order="desc">Доставчик</th>
                                 <th>Действия</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $query = "SELECT * FROM products";
                                 $query_run = mysqli_query($con, $query);
                                 
                                 if(mysqli_num_rows($query_run) > 0)
                                 {
                                    while($rows=mysqli_fetch_array($query_run))
                                     {
                                         ?>
                                 <tr>
                                 <td><?= $rows["number"] ?></td>
                                 <td>
                                    <?= $rows['name'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['quantity'] . " бр."?>
                                 </td>
                                 <td>
                                    <?= $rows['onePrice'] . " лв." ?>
                                 </td>
                                 <td>
                                    <?= $rows['price'] . " лв." ?>
                                 </td>
                                 <td>
                                    <?= $rows['kind'] ?>
                                 </td>
                                 <td>
                                    <?= date("d.m.y", strtotime($rows['date'])) ?>
                                 </td>
                                 <td>
                                    <?= $rows['company'] ?>
                                 </td>
                                 <td>
                                    <?= $rows['supplier'] ?>
                                 </td>
                                 <td>
                                    <button type="button" value="<?= $rows['id']." ".$rows['name'];?>" class="btn bg-gradient delete_product btn-danger shadow-none rounded">Изтрий<i class="bi bi-trash3 ml-2"></i></button>
                                 </td>
                              </tr>
                              <?php
                                 }
                              } else {
                                 ?>
                                     <tr>
                                         <th class="text-center pos position-absolute border-0" colspan="10">Няма намерени данни</th>
                                     </tr>
                                 <?php
                             }
                                 ?>
                           </tbody>           
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
         </main>

         <div class="modal fade" id="setProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Назначи продукти</h5>
                        <button type="button" class="close setProductModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form id="setProduct">
                        <div class="modal-body">
                           <div id="setProductErorr" class="alert alert-danger d-none text-center"></div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Екип:</label>
                              <select id="selTmProd" name="teamName" class="form-select shadow-none" aria-label="Default select example"></select>
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Име на продукт:</label>
                              <input type="text" autocomplete="off" id="getProdName" name="name" class="form-control shadow-none"/>
                              <div id="nameDropdown" class="nameProdSearch d-none"></div>
                           </div>
                           <div class="mb-3">
                              <label class="mb-0" for="">Количество:</label>
                              <input type="number" name="quantity" class="form-control shadow-none"/>
                           </div>
                           <input type="hidden" id="getProdNameDB" name="prodKind">
                        </div>
                           <div class="modal-footer">
                              <button type="button" class="btn setProductModal bg-gradient btn-secondary shadow-none" data-dismiss="modal">Затвори</button>
                              <button type="submit" class="btn bg-gradient btn-primary shadow-none">Запази</button>
                           </div>
                     </form>
                  </div>
               </div>
            </div>

            <div class="modal fade" id="seeWhereIsProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-dialog-centered" role="document">
                  <input type="hidden" id="insertProdNameAndGet">
                  <div class="modal-content" id="insertStockProduct">
                  </div>
               </div>
            </div>

         <main id="wrSecStocks" class="content d-none animate__animated animate__fadeIn d-none">
               <div class="row">
                  <div class="container-fluid col-12 d-flex">
                     <div class="card flex-fill mb-0">
                        <div class="card-header pad-y d-flex justify-content-between">
                           <h5 class="card-title">Наличности</h5>
                           <div class="d-flex">
                              <div class="input-group mx-2">
                                 <input type="text" class="form-control shadow-none" id="prodNameOrNumber1" placeholder="Търси по име или номер" aria-label="Username" aria-describedby="basic-addon1">
                                 <div class="input-group-append">
                                 <span style="background: #d3e2f7;" class="input-group-text" id="basic-addon2"><i style="color: rgb(59, 125, 221);" class="bi bi-search"></i></span>
                                 </div>
                              </div>
                              <button title="Покажи продукт" type="button" class="btn bg-gradient mr-2 setTmProd btn-primary shadow-none rounded"><i class="fa-solid fa-user-group fa-lg"></i></button>
                              <button id="reloadBtnStock" title="Обнови" type="button" class="btn mr-2 bg-gradient btn-warning shadow-none"><i class="fa-solid rotate fa-arrows-rotate fa-lg rotate down"></i></button>
                              <button title="Покажи склад" type="button" id="showWarehouse" class="btn mr-2 bg-gradient btn-success shadow-none"><i class="fa-solid fa-arrow-left-long fa-lg"></i></button>
                           </div>
                        </div>
                        <div class="tableM">
                        <table id="stockTable" class="table table-hover mb-0">
                        <thead>
                              <tr>
                                 <th>Номер</th>
                                 <th>Продукт</th>
                                 <th>Наличност</th>
                                 <th>Вид</th>
                                 <th>Стаус</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $query = "SELECT * FROM stock";
                                 $query_run = mysqli_query($con, $query);
                                 
                                 if(mysqli_num_rows($query_run) > 0)
                                 {
                                    while($rows=mysqli_fetch_array($query_run))
                                     {
                                       $quantity = $rows['quantity'];
                                       $prodName = $rows['name'];
                                       ?>
                                 <tr>
                                 <td>
                                    <?= $rows['id'] ?>
                                 </td>
                                 <td><button class="seeWhereIs customer" type="button" value="<?=$rows['name']?>"><?= $rows["name"] ?></button></td>
                                 <td>
                                    <?= $quantity." бр."?>
                                 </td>
                                 <td>
                                    <?= $rows['kind'] ?>
                                 </td>
                                 <td>
                                    <?php
                                       $query = "SELECT SUM(quantity) as quantity_sum FROM products WHERE name = '$prodName'";
                                       $query_runn = mysqli_query($con, $query);
                                      
                                       while($rowss=mysqli_fetch_array($query_runn))                                       {

                                          $quantity1 = $rowss['quantity_sum'];
                                          $date_now = date("Y-m-d");

                                          $query = "SELECT SUM(quantity) as quantity_sum_set FROM setproducthistory WHERE productName = '$prodName' AND date = '$date_now'";
                                          $query_runnn = mysqli_query($con, $query);
                                          if(mysqli_num_rows($query_run) > 0)
                                          {
                                             while($rowsss=mysqli_fetch_array($query_runnn))
                                             {
                                                $quantity2 = $rowsss['quantity_sum_set'];
                                                if($quantity2 != 0){
                                                   if($quantity != 0 || $quantity2 != 0){
                                                      if($quantity != $quantity1){
                                                         ?><i class="fa-solid text-success fa-check fa-xl"></i><?php
                                                      } else {
                                                         ?><i class="fa-solid text-danger fa-xmark fa-xl"></i><?php
                                                      }
                                                   } else {
                                                      ?><i class="fa-solid text-danger fa-xmark fa-xl"></i><?php
                                                   }
                                                } else {
                                                   ?><i class="fa-solid text-danger fa-xmark fa-xl"></i><?php
                                                }
                                             }
                                          } else {
                                             ?><i class="fa-solid text-danger fa-xmark fa-xl"></i><?php
                                          }
                                       }
                                    ?>
                                 </td>
                              </tr>
                              <?php
                                 }
                              } else {
                                 ?>
                                     <tr>
                                         <th class="text-center pos position-absolute border-0" colspan="10">Няма намерени данни</th>
                                     </tr>
                                 <?php
                             }
                                 ?>
                           </tbody>         
                        </table>
                        </div>
                     </div>
                  </div>
               </div>
         </main>

         <div class="modal fade" id="productListModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title text-black text-black" id="exampleModalLabel">Списък с продукти</h5>
                  <button type="button" class="close productListModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <div class="modal-body">
                  <select class="form-select shadow-none" id="selKindFromList" aria-label="Default select example">
                     <option selected hidden disabled>Избери вид</option>
                     <option value="Всички">Всички</option>
                     <option value="Техника">Техника</option>
                     <option value="Препарати">Препарати</option>
                     <option value="Екипировка">Екипировка</option>
                     <option value="Пособия за чистене">Пособия за чистене</option>
                  </select>
                  <div id="insertList" class="mt-3">
                     <?php
                        $query = "SELECT * FROM stock";
                        $query_run = mysqli_query($con, $query);
                       
                        while($rows=mysqli_fetch_array($query_run))
                        {
                     ?>
                     <li class="my-2 li-list ml-1"><?= $rows['id'] ?>. <?= $rows['name'] ?></li>
                     <?php
                        }
                     ?>
                  </div>
               </div>
            </div>
         </div>               
      </div>
      </div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
      <script src="fetch.js"></script>
      <script src="dashboard.js"></script>
      <script>
 
         $("#usBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $("main").addClass('d-none');
            $("#usSec").removeClass('d-none');
            $(".windowsHead").html("Потребители");
         });

         $("#orBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $("main").addClass('d-none');
            $("#orSec").removeClass('d-none');
            $(".windowsHead").html("Заявки");
         });

         $("#tmBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $("main").addClass('d-none');
            $("#tmSec").removeClass('d-none');
            $('#teamTable').load(location.href + " #teamTable");
            $(".windowsHead").html("Екипи");
         });

         $("#wrBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $("main").addClass('d-none');
            $("#wrSec").removeClass('d-none');
            $(".windowsHead").html("Склад");
         });

         $("#cmBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $(".windowsHead").html("Клиенти");
         });

         $("#spBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $(this).addClass('active');
            $(".windowsHead").html("Доставчици");
         });

         $("#profBtn").click(function() {
            $("ul>li.active").removeClass("active");
            $("main").addClass('d-none');
            $("#profSec").removeClass('d-none');
            $(".windowsHead").html("Профил");
         });

         $("#showStock").click(function() {
            $("main").addClass('d-none');
            $("#wrSecStocks").removeClass('d-none');
            $(".windowsHead").html("Склад / Наличности");
         });
         $("#showWarehouse").click(function() {
            $("main").addClass('d-none');
            $("#wrSec").removeClass('d-none');
            $(".windowsHead").html("Склад");
         });
      </script>
      
   </body>
</html>