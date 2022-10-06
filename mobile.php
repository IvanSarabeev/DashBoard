<?php
   session_start();
   date_default_timezone_set('Europe/Sofia');
   require '../dbconn.php';
   $username = $_SESSION['username'];
   $date_now = date("Y-m-d");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
      
      <link href="css/dashboard.css" rel="stylesheet">
      <link rel="shortcut icon" href="title.png">
      <link rel="stylesheet" href="css/alert.css"/>
      <script src="https://kit.fontawesome.com/d4b9f98a5c.js" crossorigin="anonymous"></script> 
    <title>Carpet Services</title>     
</head>
<body>
    <input type="hidden" value="<?php echo $username; ?>" id="getIdForExit">
<div class="modal fade" id="sortByModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-0 border-0">
            <div class="modal-title-box"><h3 class="modal-title text-white text-center mb-1"><b><i class="fa-solid fa-sort"></i> Филтрирай по</b></h3></div>
            <div class="modal-body">
                <input type="hidden" value="id" id="checkedValueSort">
                <div class="containere">
                    <form>
                        <label>
                            <input value="id" type="radio" name="radio" checked/>
                            <span>Номер на заявка</span>
                        </label>
                        <label>
                            <input value="customerName" type="radio" name="radio"/>
                            <span>Име на клиент</span>
                        </label>
                        <label>
                            <input value="address" type="radio" name="radio"/>
                            <span>Адрес на клиент</span>
                        </label>
                    </form>
                </div>
                <div class="d-flex justify-content-between">
                    <div></div>
                    <div>
                        <button class="mdlBtn">Откажи</button>
                        <button class="mdlBtn" id="checkSortBtn">Запази</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loader-wrapper">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<main>
    <div  id="bodyColor" class="conrainer-fluid d-flex">
        <div class="slide-bar text-center">
            <div class="out-border">
                <div class="logo"><img src="title.png" alt=""></div>
            </div>
            <div class="slide-header">Carpet Services</div>
            <div id="exRotate" class="box box-btn-active">
                <i class="fa-solid fa-gear fa-xl rotate"></i>
                <div>Задачи</div>
            </div>
            <div id="werHbtn" class="box">
                <i class="fa-solid fa-box-archive fa-xl animate__animated animate__bounceIn"></i>
                <i class="fa-solid fa-box-open fa-xl d-none animate__animated animate__bounceIn"></i>
                <div>Склад</div>
            </div>
            <div class="box" id="reloadBtnn">
                <i class="fa-solid fa-arrows-rotate rotatee fa-xl"></i>
                <div>Обнови</div>
            </div>
            <div class="boxx" id="exitApp">
                <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                <div>Изход</div>
            </div>
        </div>
        <div class="main-section">
            <div class="fWindow">
                <div class="section1 d-flex justify-content-between">
                    <div></div>
                    <div class="d-flex icon-group">
                        <div class="animate__animated animate__fadeIn">
                            <input type="text" id="searchBy" class="inputSearch d-none animate__animated animate__bounceIn">
                        </div>
                        <div class="animate__animated animate__fadeIn">
                            <i id="show-input" style="color: #a6d5f6;" class="fa-solid cur fa-magnifying-glass fa-2xl"></i>
                            <i id="showSortModal" style="color: #a6d5f6;" class="fa-solid cur fa-sort fa-2xl"></i>
                        </div>
                    </div>
                </div>
                <div class="section1-1 d-none">
                </div>
                <div class="section2 animate__animated animate__fadeIn d-flex">
                    <div class="currOr button-clicked">Неприключени <span id="insertOrCount">0</span></div>
                    <div class="finishedOr">Приключени <span id="insertOrCount1">0</span></div>
                </div>
                <div class="section3 animate__animated animate__fadeIn">
                <?php
                    $query = "SELECT * FROM employee WHERE pid = '$username'";
                    $query_run = mysqli_query($con, $query);
                    
                    if(mysqli_num_rows($query_run) > 0)
                    {
                    while($rows=mysqli_fetch_array($query_run))
                        {
                            $teamID=$rows['teamID'];

                            $query = "SELECT * FROM orders WHERE teamID = '$teamID' AND (status = 'Назначена' OR status = 'В процес') AND date = '$date_now'";
                            $query_run = mysqli_query($con, $query);
                            $num = mysqli_num_rows($query_run);
                            
                            if(mysqli_num_rows($query_run) > 0)
                            {
                            while($rows=mysqli_fetch_array($query_run))
                                {
                            ?>
                            <input type="hidden" value="<?= $num ?>" id="orCount">
                    <button type="button" class="boxBtn" value="<?= $rows['id'] ?>"><div class="orBox d-flex justify-content-between">
                        <div class="d-flex">
                            <?php if($rows['room'] == "Къща"){?>
                            <div class="or-box-icon">
                                <i class="fa-solid fa-house fa-lg"></i>
                            </div>
                            <?php }?>
                            <?php if($rows['room'] == "Офис"){?>
                            <div class="or-box-icon" style="padding: 9px 10px 10px 11.1px;">
                                <i class="fa-solid fa-briefcase fa-lg"></i>
                            </div>
                            <?php }?>
                            <?php if($rows['room'] == "Салон"){?>
                            <div class="or-box-icon" style="padding: 8.6px 10px 10px 11.1px;">
                                <i class="fa-solid fa-person-shelter fa-lg"></i>
                            </div>
                            <?php }?>
                            <div>
                                <b>Почистване на: <?= $rows['room'] ?></b>
                                <div><?= $rows['customerName'] ?></div>
                                <div class="addressWidth"><?= $rows['address'] ?></div>
                            </div>
                        </div>
                        <div>
                            <b>Номер на заявка: <?= $rows['id'] ?></b>
                            <div><i class="fa-regular fa-clock text-success"></i> Час: <?= $rows['time'] ?></div>
                            <div><i class="fa-regular fa-calendar text-danger"></i> Дата: <?= date("d.m.Y", strtotime($rows['date'])) ?></div>
                        </div>
                        <div class="statusPay">
                            <div class="text-center">Статус на плащане</div>
                            <div class="text-center"><b>
                                <?php
                                    if($rows['pay'] == "В брой"){
                                        echo "В брой";
                                    } else{
                                        echo "Платена";
                                    }
                                ?>
                            </b></div>
                        </div>
                        <div>
                            <div class="dis-status"><i class="fa-solid fa-circle-exclamation"></i> <b><?= $rows['status'] ?></b></div>
                        </div>
                        <i style="color: #1090bc;" class="fa-solid icon-right fa-angle-right fa-3x"></i>
                    </div></button>
                    <?php
                                }
                            }
                            else {
                                ?>
                                <div class="text-center noResult">Няма назначени задачи на този екип</div>
                                <?php
                            }
                        }
                    }
            ?>
                </div>

                <div class="modal fade" id="cancelModalApp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content rounded-0 border-0">
                        <div class="modal-title-box modal-title-box-color"><h3 class="text-white modal-title text-center mb-1"><b><i class="bi bi-exclamation-circle"></i> ОТКАЗ НА ЗАЯВКАТА</b></h3></div>
                        <form id="cancelFormApp">
                            <div class="modal-body">
                                <div id="errMess" class="alert alert-danger d-none text-center" role="alert"></div>
                                <input type="hidden" id="orderIDget" name="id">
                                <textarea class="form-control shadow-none mt-2 rounded-0" id="text-area" name="canText" rows="3" placeholder="Забележка..."></textarea>
                                <div class="d-flex justify-content-end mt-1"><span id='charCount'>0</span><span id='maxChar'>/150</span></div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div></div>
                                    <div>
                                        <button type="button" id="closeModalCan" class="mdlBtn">Откажи</button>
                                        <button type="submit" style="margin-right: 0px;" class="mdlBtn">Запази</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


                <?php
                    $query = "SELECT * FROM orders WHERE teamID = '$teamID' AND date = '$date_now'";
                    $query_run = mysqli_query($con, $query);
                    $num2 = mysqli_num_rows($query_run);
                ?>
                <input type="hidden" value="<?= $num2 ?>" id="orCountAll">

                <div class="section5 animate__animated animate__fadeIn d-none">
                <?php
                    $query = "SELECT * FROM employee WHERE pid = '$username'";
                    $query_run = mysqli_query($con, $query);
                    
                    if(mysqli_num_rows($query_run) > 0)
                    {
                    while($rows=mysqli_fetch_array($query_run))
                        {
                            $teamID=$rows['teamID'];

                            $query = "SELECT * FROM orders WHERE (status = 'Приключена' OR status = 'Отказана') AND teamID = '$teamID' AND date = '$date_now'";
                            $query_run = mysqli_query($con, $query);
                            $num = mysqli_num_rows($query_run);
                            
                            if(mysqli_num_rows($query_run) > 0)
                            {
                            while($rows=mysqli_fetch_array($query_run))
                                {
                            ?>
                            <input type="hidden" value="<?= $num ?>" id="orCount1">
                    <button type="button" class="boxBtn" value="<?= $rows['id'] ?>"><div class="orBox d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="or-box-icon">
                                <i class="fa-solid fa-house fa-lg"></i>
                            </div>
                            <div>
                                <b>Почистване на: <?= $rows['room'] ?></b>
                                <div><?= $rows['customerName'] ?></div>
                                <div class="addressWidth"><?= $rows['address'] ?></div>
                            </div>
                        </div>
                        <div>
                            <b>Номер на заявка: <?= $rows['id'] ?></b>
                            <div><i class="fa-regular fa-clock text-success"></i> Час: <?= $rows['time'] ?></div>
                            <div><i class="fa-regular fa-calendar text-danger"></i> Дата: <?= date("d.m.Y", strtotime($rows['date'])) ?></div>
                        </div>
                        <div class="statusPay">
                            <div class="text-center">Статус на плащане</div>
                            <div class="text-center"><b>
                                <?php
                                    if($rows['pay'] == "В брой"){
                                        echo "В брой";
                                    } else{
                                        echo "Платена";
                                    }
                                ?>
                            </b></div>
                        </div>
                        <div>
                            <?php if($rows['status'] == "Отказана"){
                                ?>
                                    <div style="color: #FF3131; border-color: #FF3131;" class="dis-status"><i class="fa-solid fa-circle-exclamation"></i> <b><?= $rows['status'] ?></b></div>
                                <?php
                            }?>
                             <?php if($rows['status'] == "Приключена"){
                                ?>
                                    <div style="color: #50C878; border-color: #50C878;" class="dis-status"><i class="fa-solid fa-circle-exclamation"></i> <b><?= $rows['status'] ?></b></div>
                                <?php
                            }?>
                        </div>
                        <i style="color: #1090bc;" class="fa-solid icon-right fa-angle-right fa-3x"></i>
                    </div></button>
                    <?php
                                }
                            }
                            else {
                                ?>
                                <div class="text-center noResult">Няма назначени задачи на този екип</div>
                                <?php
                            }
                        }
                    }
            ?>
                </div>
                <div class="section4 animate__animated animate__fadeIn d-none">
                    <div class="d-flex">
                        <div id="infoBtnApp" class="sec4-head-btn button-clicked">Информация</div>
                        <div id="opBtnApp" class="sec4-head-btn">Операции</div>
                    </div>
                    <div class="main_sec_4">
                        <div class="head-sec4">Основно почистване на <span id="kindRoom"></span></div>
                        <div class="d-flex">
                            <div class="info-box d-flex">
                                <div>
                                    <i class="fa-solid fa-user fa-3x"></i>
                                </div>
                                <div class="info-box-items" style="margin-left: 28px;">
                                    <b>Клиент</b>
                                    <div id="custName"></div>
                                </div>
                            </div>
                            <div class="info-box1 d-flex" style="margin-left: 28px;">
                                <div>
                                    <i class="fa-regular fa-calendar fa-3x"></i>
                                </div>
                                <div class="info-box-items d-flex">
                                    <div class="orStart">
                                        <b>Планиран старт</b>
                                        <div class="d-flex">
                                            <span class="planStart"></span>
                                            <span id="planTime"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <b>Планиран край</b>
                                        <div class="d-flex">
                                            <span class="planStart"></span>
                                            <span id="planEnd"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="info-box d-flex">
                                <div>
                                    <i class="fa-solid fa-location-dot fa-3x"></i>
                                </div>
                                <div class="info-box-items" style="margin-left: 35px;">
                                    <b>Адрес</b>
                                    <div id="getAddress"></div>
                                </div>
                            </div>
                            <div class="info-box1 d-flex" style="margin-left: 28px;">
                                <div>
                                    <i class="fa-solid fa-m fa-3x"></i>
                                </div>
                                <div class="info-box-items">
                                    <b>M<sup>2</sup></b>
                                    <div id="getM2"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="info-box d-flex">
                                <div>
                                    <i class="fa-solid fa-comment-dollar fa-3x"></i>
                                </div>
                                <div class="info-box-items" style="margin-left: 22px;">
                                    <b>Начин на плащане</b>
                                    <div id="methodPay"></div>
                                </div>
                            </div>
                            <div class="info-box1 d-flex">
                                <div>
                                    <i class="fa-solid fa-comment-dollar fa-3x"></i>
                                </div>
                                <div class="info-box-items">
                                    <b>Цена</b>
                                    <div id="disPrice"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="info-box d-flex">
                                <div>
                                    <i class="fa-solid fa-crown fa-3x"></i>
                                </div>
                                <div class="info-box-items">
                                    <b>Вид оферта</b>
                                    <div id="getOffer"></div>
                                </div>
                            </div>
                            <div class="info-box1 d-flex" style="margin-left: 42px;">
                                <div>
                                    <i class="fa-solid fa-mobile-screen-button fa-3x"></i>
                                </div>
                                <div  class="info-box-items">
                                    <b>Телефонен номер</b>
                                    <div id="getPhone"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-ex">
                            <button id="openCanModal"><i class="fa-solid fa-xmark"></i> Откажи</button>
                            <button id="orderStartBtn"><i class="fa-solid fa-play fa-sm"></i> Започни</button>
                        </div>
                    </div>
                </div>

                <div class="section6 d-none animate__animated animate__fadeIn">
                    <div class="prof-box">
                        <div class="d-flex">
                            <div class="prof-box-info">
                                <i class="fa-solid fa-user fa-9x mt-5"></i>
                                <div class="col-sec-change">
                                    <?php
                                        $query = "SELECT * FROM employee WHERE pid = '$username'";
                                        $query_run = mysqli_query($con, $query);
                                        
                                        if(mysqli_num_rows($query_run) > 0)
                                        {
                                            while($rows=mysqli_fetch_array($query_run))
                                            {
                                    ?>
                                    <input type="hidden" id="getCurrUserID" value="<?= $rows['id'] ?>">
                                    <h1 class="text-uppercase mt-4 mb-0"><b><?= $rows['name'] ?></b></h1>
                                    <h2 class="mb-1"><?= $rows['position'] ?></h2>
                                    <h3><?= $rows['pid'] ?></h3>
                                    <h3 class="mt-5">IP ADDRESS: 10.137.217.32</h3>
                                    <h3 class="mt-4 mb-0"><b>Service Desk</b></h3>
                                    <h1 style="color: #3180a5;" class="text-uppercase mt-0 mb-0"><b>052 837 33</b></h1>
                                    <h5 class="mb-6"><b>ver 1.33 &copy; 30.09.2022</b></h5>
                                    <?php
                                            }
                                        }    
                                    ?>
                                </div>
                            </div>
                            <div class="prof-box-sec2">
                                <div class="prof-pass-box">
                                    <form id="changeUserPass">
                                        <div class="mb-4 did-floating-label-content">
                                            <input type="hidden" id="setUserID" name="id">
                                            <input name="currPass" type="password" class="bor-bot-col1 did-floating-input" placeholder=" ">
                                            <label class="did-floating-label oldPass">Текуща парола</label>
                                        </div>
                                        <div class="mb-4 did-floating-label-content">
                                            <input name="newPass" type="password" class="bor-bot-col did-floating-input" placeholder=" ">
                                            <label class="did-floating-label newPassUser">Нова парола</label>
                                        </div>
                                        <div class="mb-4 did-floating-label-content">
                                            <input name="repPass" type="password" class="bor-bot-col did-floating-input" placeholder=" ">
                                            <label class="did-floating-label newPassUser setTextInput">Повторете паролата</label>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div></div>
                                            <button type="submit" class="btnSub">ПОТВЪРДИ</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="or-count-info">
                                    <canvas id="todayOrderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="back-product-in-wr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content rounded-0 border-0">
                        <div class="modal-title-box modal-title-box-color"><h3 class="text-white modal-title text-center mb-1"><b><i class="bi bi-exclamation-circle"></i> ВЪРНИ ИЗБРАНИЯ ПРОДУКТ</b></h3></div>
                        <form id="backProductForm">
                            <div class="modal-body">
                            <input type="hidden" id="backProductName" name="name">
                                <input type="hidden" id="backProductID" name="id">
                                <div class="text-center my-4 sureText"><b>Сигурни ли сте, че искате да върнете избрания продукт ?</b></div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div></div>
                                    <div>
                                        <button type="button" class="mdlBtn back-product-in-wr">Откажи</button>
                                        <button type="submit" style="margin-right: 0px;" class="mdlBtn saveChangeBackProduct">Запази</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


                <div id="section7" class="section7 d-none animate__animated animate__fadeIn">
                <?php
                    $query = "SELECT * FROM employee WHERE pid = '$username'";
                    $query_go = mysqli_query($con, $query);
                    
                    while($rows=mysqli_fetch_array($query_go))
                    {
                        $teamID=$rows['teamID'];
                        
                        $query = "SELECT * FROM setproduct WHERE teamID = '$teamID' GROUP BY productName";
                        $query_run = mysqli_query($con, $query);

                        if(mysqli_num_rows($query_run) > 0)
                        {
                            while($rows=mysqli_fetch_array($query_run))
                            {
                                $prodName = $rows['productName'];
                                $kind = $rows['kind'];
                                $id = $rows['id'];

                                $query = "SELECT SUM(quantity) as quantity_sum FROM setproduct WHERE teamID = '$teamID' AND productName = '$prodName'";
                                $query_runn = mysqli_query($con, $query);

                                while($rowss=mysqli_fetch_array($query_runn))
                                {
                                    $quantity = $rowss['quantity_sum'];
                                    ?>
                                    <input type="hidden" value="<?= $id ?>" id="getIDsetProd">
                                    <div id="<?= str_replace(' ', '-', $prodName); ?>" class="orBox1 d-flex justify-content-between">
                                        <div class="d-flex wid-set">
                                            <div class="or-box-icon1" style="padding: 9.4px 10px 10px 11.1px;">
                                                <i class="fa-solid fa-list fa-lg"></i>
                                            </div>
                                            <div class="startText kindProd1">
                                                ТИП ПРОДУКТ
                                                <div class="text-uppercase"><b><?= $prodName ?></b></div>
                                            </div>
                                            <div class="startText kindProd">
                                                ВИД ПРОДУКТ
                                                <div class="text-uppercase"><b><?= $kind ?></b></div>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="numbCount">
                                                БРОЙ
                                                <div><b class="<?= str_replace(' ', '-', $prodName); ?>"><?= $quantity ?></b></div>
                                            </div>
                                            <div class="btn-group-mob">
                                                <button value="<?= $prodName ?>" class="back-product" style="background-color: #dc5134;"><i class="fa-solid fa-minus fa-lg"></i></button>
                                                <button value="<?= $id ?>" class="back-btn" style="background-color: #1aa758;"><i class="fa-solid fa-rotate-left fa-lg"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="noResult" class="noResult d-none">Няма намерени резултати</div>
                                    <?php
                                }
                            }
                        } else {
                            ?><div class="noResult">Няма намерени резултати</div><?php
                        }
                    }
                ?>  
                </div>

                <div class="section8 d-none animate__animated animate__fadeIn">
                    <div>
                        <div class="reloadBtnEff text-center inProcessOrder">
                            <i style="color: #3180a5;" class="fa-solid fa-house fa-10x"></i>
                            <div class="text-uppercase mt-4">ПОЧИСТВАНЕ НА <span id="kindRoomInProcess"></span></div>
                            <div>ЗАДАЧАТА Е В ПРОЦЕС</div>
                        </div>
                    </div>
                    <div class="btn-ex">
                        <button id="continueStep"><i class="fa-regular fa-circle-xmark"></i> КРАЙ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script src="fetchMobile.js"></script>
<script src="app.js"></script>

<script>

    
</script>
</body>
</html>