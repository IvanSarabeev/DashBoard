<?php
include '../dbconn.php';
date_default_timezone_set('Europe/Sofia');

$query = "SELECT * FROM orders WHERE view = '1'";
$query_run = mysqli_query($con,$query);

if(mysqli_num_rows($query_run) > 0)
    {
    while($rows=mysqli_fetch_array($query_run))
        {
            ?>
                <a href="#" class="list-group-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-2">
                            <i class="text-primary bg-gradient bi bi-folder-plus fa-2x"></i>
                        </div>
                        <div class="col-10">
                            <div class="text-dark">Нова заявка с номер <?= $rows['id'] ?></div>
                            <div class="text-muted small mt-1">Дата на заявка <?= date('d.m.Y', strtotime($rows['date']));  ?></div>
                            <div class="text-muted small mt-1">
                            <?php
                                $datetimeago = date("Y-m-d H:i:s");
                                $diff = strtotime($datetimeago) - strtotime($rows['addDate']);
                                $sec = $diff;
                                $min = round($diff / 60 );
                                $hrs = round($diff / 3600);
                                $days = round($diff / 86400 );
                                $weeks = round($diff / 604800);
                                $mnths = round($diff / 2600640 );
                                $yrs = round($diff / 31207680 );

                                if($sec <= 60) {
                                    $bleh = "Добавена преди по-малко от минута";
                                }
                                // Check for minutes
                                else if ($min <= 60) {
                                if  ($min==1) {
                                    $bleh = "Добавена преди минута";
                                }
                                else {
                                    $bleh = "Добавено преди $min минути";
                                }
                                }
                                // Check for hours
                                else if ($hrs <= 24) {
                                if  ($hrs == 1) {
                                    $bleh = "Добавена преди час";
                                }
                                else {
                                    $bleh = "Добавена преди $hrs часа";
                                }
                                }
                                // Check for days
                                else if ($days <= 7) {
                                if  ($days == 1) {
                                    $bleh = "Добавена вчера";
                                }
                                else {
                                    $bleh = "Добавена преди $days дни";
                                }
                                }
                                // Check for weeks
                                else if ($weeks <= 4.3) {
                                if ($weeks == 1) {
                                    $bleh = "Добавена преди седмица";
                                }
                                else {
                                    $bleh = "Добавена преди $weeks седмици";
                                }
                                }
                                // Check for months
                                else if ($mnths <= 12) {
                                if  ($mnths == 1) {
                                    $bleh = "Добавена преди месец";
                                }
                                else {
                                $bleh = "Добавена преди $mnths месеца";
                                }
                                }
                                // Check for years
                                else {
                                if ($yrs == 1) {
                                    $bleh = "Добавена преди година";
                                }
                                else {
                                    $bleh = "Добавена преди $yrs години";
                                }
                                }
                                echo $bleh;
                            ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
        }
    }

    $query1 = "SELECT * FROM orders WHERE view = '2'";
    $query_run1 = mysqli_query($con,$query1);

    if(mysqli_num_rows($query_run1) > 0)
        {
        while($rowss=mysqli_fetch_array($query_run1))
            {
                ?>
                    <a href="#" class="list-group-item">
                        <div class="row g-0 align-items-center">
                            <div class="col-2">
                                <i class="text-primary bg-gradient bi bi-check-circle fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="text-dark">Заявка с номер <?= $rowss['id'] ?> е приключена</div>
                                <div class="text-muted small mt-1">Име на клиент: <?=$rowss['customerName'] ?></div>
                                <div class="text-muted small mt-1">
                                <?php
                                    $datetimeago = date("Y-m-d H:i:s");
                                    $diff = strtotime($datetimeago) - strtotime($rowss['endDate']);
                                    $sec = $diff;
                                    $min = round($diff / 60 );
                                    $hrs = round($diff / 3600);
                                    $days = round($diff / 86400 );
                                    $weeks = round($diff / 604800);
                                    $mnths = round($diff / 2600640 );
                                    $yrs = round($diff / 31207680 );

                                    if($sec <= 60) {
                                        $bleh = "Преди по-малко от минута";
                                    }
                                    // Check for minutes
                                    else if ($min <= 60) {
                                    if  ($min==1) {
                                        $bleh = "Преди минута";
                                    }
                                    else {
                                        $bleh = "Преди $min минути";
                                    }
                                    }
                                    // Check for hours
                                    else if ($hrs <= 24) {
                                    if  ($hrs == 1) {
                                        $bleh = "Преди час";
                                    }
                                    else {
                                        $bleh = "Преди $hrs часа";
                                    }
                                    }
                                    // Check for days
                                    else if ($days <= 7) {
                                    if  ($days == 1) {
                                        $bleh = "Прикючена вчера";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $days дни";
                                    }
                                    }
                                    // Check for weeks
                                    else if ($weeks <= 4.3) {
                                    if ($weeks == 1) {
                                        $bleh = "Прикючена преди седмица";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $weeks седмици";
                                    }
                                    }
                                    // Check for months
                                    else if ($mnths <= 12) {
                                    if  ($mnths == 1) {
                                        $bleh = "Прикючена преди месец";
                                    }
                                    else {
                                    $bleh = "Прикючена преди $mnths месеца";
                                    }
                                    }
                                    // Check for years
                                    else {
                                    if ($yrs == 1) {
                                        $bleh = "Прикючена преди година";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $yrs години";
                                    }
                                    }
                                    echo $bleh;
                                ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
            }



    } 


    $query1 = "SELECT * FROM orders WHERE view = '3'";
    $query_run1 = mysqli_query($con,$query1);

    if(mysqli_num_rows($query_run1) > 0)
        {
        while($rowss=mysqli_fetch_array($query_run1))
            {
                ?>
                    <a href="#" class="list-group-item">
                        <div class="row g-0 align-items-center">
                            <div class="col-2">
                                <i class="text-primary bg-gradient bi bi-arrow-repeat fa-2x"></i>
                            </div>
                            <div class="col-10">
                                <div class="text-dark">Заявка с номер <?= $rowss['id'] ?> е стартирана</div>
                                <div class="text-muted small mt-1">Име на клиент: <?=$rowss['customerName'] ?></div>
                                <div class="text-muted small mt-1">
                                <?php
                                    $datetimeago = date("Y-m-d H:i:s");
                                    $diff = strtotime($datetimeago) - strtotime($rowss['startDate']);
                                    $sec = $diff;
                                    $min = round($diff / 60 );
                                    $hrs = round($diff / 3600);
                                    $days = round($diff / 86400 );
                                    $weeks = round($diff / 604800);
                                    $mnths = round($diff / 2600640 );
                                    $yrs = round($diff / 31207680 );

                                    if($sec <= 60) {
                                        $bleh = "Преди по-малко от минута";
                                    }
                                    // Check for minutes
                                    else if ($min <= 60) {
                                    if  ($min==1) {
                                        $bleh = "Преди минута";
                                    }
                                    else {
                                        $bleh = "Преди $min минути";
                                    }
                                    }
                                    // Check for hours
                                    else if ($hrs <= 24) {
                                    if  ($hrs == 1) {
                                        $bleh = "Преди час";
                                    }
                                    else {
                                        $bleh = "Преди $hrs часа";
                                    }
                                    }
                                    // Check for days
                                    else if ($days <= 7) {
                                    if  ($days == 1) {
                                        $bleh = "Прикючена вчера";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $days дни";
                                    }
                                    }
                                    // Check for weeks
                                    else if ($weeks <= 4.3) {
                                    if ($weeks == 1) {
                                        $bleh = "Прикючена преди седмица";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $weeks седмици";
                                    }
                                    }
                                    // Check for months
                                    else if ($mnths <= 12) {
                                    if  ($mnths == 1) {
                                        $bleh = "Прикючена преди месец";
                                    }
                                    else {
                                    $bleh = "Прикючена преди $mnths месеца";
                                    }
                                    }
                                    // Check for years
                                    else {
                                    if ($yrs == 1) {
                                        $bleh = "Прикючена преди година";
                                    }
                                    else {
                                        $bleh = "Прикючена преди $yrs години";
                                    }
                                    }
                                    echo $bleh;
                                ?>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php
            }


            
    } 

    
?>