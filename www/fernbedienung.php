<!DOCTYPE html>
<html manifest="/cache.manifest">
<head>

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="viewport" content="user-scalable=0, initial-scale=1.0, maximum-scale=1">
    <link rel="apple-touch-icon">
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"/>
    <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

    <style>
        /*.ui-header .ui-title {
            overflow: visible !important;
            white-space: normal !important;
        }*/
        .ui-header .ui-title, .ui-footer .ui-title {
            text-align: center;
            font-size: 16px;
            display: block;
            margin: .6em 90px .8em;
            padding: 0;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            outline: 0 !important;
        }
        /*.ui-header {
            background: #a7c942 !important;
            border: 1px solid #5b6e24 !important;
        }
        .ui-page{
            background: #d7ffb0 !important;
        }
        .ui-btn{
            background: #f5ffeb !important;
        }*
    </style>

    <script>

        $(document).ready(function () {

            <?php

            include('db.php');

            // Generiere Funktionen für Einzelne Steckdosen
            $sql="SELECT S.Id,S.UId,S.SysCode,H.Codename,S.Intervall FROM Steckdosen S INNER JOIN Hersteller H ON H.Id=S.Hersteller";

            //$result = mysqli_query($con,$sql);

            $result = mysqli_query($con,$sql);

            while($row = mysqli_fetch_array($result)){

                    echo "$(\"#Funk".$row['Id']."0\").click(function(){
                        $.ajax({
                            type: \"POST\",
                            url: \"Funk.php\",
                            datatype: 'json',
                            async: false,
                            data: {'hersteller': '".$row['Codename']."','uid': '".$row['UId']."','scode': '".$row['SysCode']."','modus': '-f'},
                            success: function(data){
                            }
                        });
                    });\n";

               if($row['Intervall']==NULL){
                    echo "$(\"#Funk".$row['Id']."1\").click(function(){
                        $.ajax({
                            type: \"POST\",
                            url: \"Funk.php\",
                            datatype: 'json',
                            async: false,
                            data: {'hersteller': '".$row['Codename']."','uid': '".$row['UId']."','scode': '".$row['SysCode']."','modus': '-t'},
                            success: function(){
                            }
                        });
                    });\n";
                } else{
                    echo "$(\"#Funk".$row['Id']."1\").click(function(){
                            $.ajax({
                                type: \"POST\",
                                url: \"FunkAutomatic.php\",
                                datatype: 'json',
                                async: false,
                                data: {'hersteller': '".$row['Codename']."','uid': '".$row['UId']."','scode': '".$row['SysCode']."','modus': '-t','id': '".$row['Id']."', 'on': 't'},
                                success: function(data){
                                }
                            });
                        });\n";
                    echo "$(\"#Funk".$row['Id']."2\").click(function(){
                            $.ajax({
                                type: \"POST\",
                                url: \"FunkAutomatic.php\",
                                datatype: 'json',
                                async: false,
                                data: {'hersteller': '".$row['Codename']."','uid': '".$row['UId']."','scode': '".$row['SysCode']."','modus': '-t','id': '".$row['Id']."', 'on': 'f'},
                                success: function(data){
                                }
                            });
                        });\n";
                }

            }
            // Generiere Funktionen für Profile
            $sql2="SELECT Id,Name FROM Profil WHERE Name!='Panik'";
            $result2 = mysqli_query($con,$sql2);

            while($row2=mysqli_fetch_array($result2)){

            echo "$(\"#Profil".$row2['Id']."0\").click(function(){
                    $.ajax({
                        type: \"POST\",
                        url: \"FunkProfil.php\",
                        datatype: 'json',
                        async: false,
                        data: {'id': '".$row2['Id']."','modus': '-f'},
                        success: function(data){
                        }
                    });
                });\n";
                echo "$(\"#Profil".$row2['Id']."1\").click(function(){
                    $.ajax({
                        type: \"POST\",
                        url: \"FunkProfil.php\",
                        datatype: 'json',
                        async: false,
                        data: {'id': '".$row2['Id']."','modus': '-t'},
                        success: function(){
                        }
                    });
                });\n";
            }
            ?>
            jQuery('#Groups').on("swipeleft", function (event) {
                $.mobile.changePage("#Single", {
                    allowSamePageTransistion: "true",
                    transition: "slide",
                    changeHash: false
                });
            });
            jQuery('#Single').on("swiperight", function (event) {
                $.mobile.changePage("#Groups", {
                    allowSamePageTransistion: "true",
                    transition: "slide",
                    changeHash: false,
                    reverse: "true"
                });
            });

            document.onkeydown = function (e) {
                switch (e.keyCode) {
                    case 39:
                        $.mobile.changePage("#Single", {
                            allowSamePageTransistion: "true",
                            transition: "slide",
                            changeHash: false
                        });
                        break;
                    case 37:
                        $.mobile.changePage("#Groups", {
                            allowSamePageTransistion: "true",
                            transition: "slide",
                            changeHash: false,
                            reverse: "true"
                        });
                        break;
                }
            };

            $('#Notaus').click(function () {
                $.ajax({
                    type: "POST",
                    url: "shutOffAll.php",
                    datatype: 'json',
                    async: false,
                    success: function (data) {}

                });
            });

            $('#Panik').click(function () {
                $.ajax({
                    type: "POST",
                    url: "Panik.php",
                    datatype: 'json',
                    async: false,
                    success: function (data) {}

                });
            });
        });

    </script>

    <title id="title">Funksteckdosen</title>
</head>
<body>

<div data-role="page" id="Groups" data-title="Fernbedienung">
    <div data-role="header">
        <h1>Gruppen</h1>
    </div>
    <table>

        <?php
        include('db.php');

        $sql = "SELECT Id,Name FROM Profil WHERE Name!='Panik'";

        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>
                <td><h4>" . $row['Name'] . ":</h4></td>
                <td><div data-role=\"controlgroup\" data-type=\"horizontal\">
                    <a href=\"#\" id=\"Profil" . $row['Id'] . "1\" class=\"ui-btn\">An</a>
                    <a href=\"#\" id=\"Profil" . $row['Id'] . "0\" class=\"ui-btn\">Aus</a>
                </div></td>
                </tr>";
        }

        $sql = "SELECT * FROM Steckdosen S WHERE S.Id NOT IN (SELECT PS.SteckdosenId FROM ProfilSteckdosen PS WHERE PS.SteckdosenId=S.Id)";
        $result = mysqli_query($con, $sql);


        while ($row = mysqli_fetch_array($result)) {
            if ($row['Intervall'] == NULL) {
                echo "<tr>
                    <td><h4>" . $row['Name'] . ":</h4></td>
                    <td><div data-role=\"controlgroup\" data-type=\"horizontal\">
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "1\" class=\"ui-btn\">An</a>
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "0\" class=\"ui-btn\">Aus</a>
                    </div></td>
                    </tr>";
            } else {
                echo "<tr>
                    <td><h4>" . $row['Name'] . ":</h4></td>
                    <td><div data-role=\"controlgroup\" data-type=\"horizontal\">
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "1\" class=\"ui-btn\"> An </a>
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "0\" class=\"ui-btn\">Aus</a>
                         <a href=\"#\" id=\"Funk" . $row['Id'] . "2\" class=\"ui-btn\"> " . $row['Intervall'] . " m</a>
                    </div></td>
                    </tr>";
            }
        }
        ?>
    </table>
    <a href="#" id="Notaus" class="ui-btn">Notaus</a>

    <?php
    include("db.php");
    $sql="SELECT Id FROM Profil WHERE NAME='Panik'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0) {
        echo "<a href=\"#\" id=\"Panik\" class=\"ui-btn\" style=\"background-image: -webkit-gradient(linear,left top,left bottom,from(#ff9a9a), to(#ff4040)) !important;\">Panik</a>";
    }
    ?>


</div>

<div data-role="page" id="Single" data-title="Fernbedienung">
    <div data-role="header">
        <h1>Einzel Steckdosen </h1>
    </div>

    <table>
        <?php
        $sql = "SELECT S.Id,S.Name,S.Intervall FROM Steckdosen S WHERE S.Id IN (SELECT PS.SteckdosenId FROM ProfilSteckdosen PS WHERE PS.SteckdosenId=S.Id)";
        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($result)) {
            if ($row['Intervall'] == NULL) {
                echo "<tr>
                    <td><h4>" . $row['Name'] . ":</h4></td>
                    <td><div data-role=\"controlgroup\" data-type=\"horizontal\">
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "1\" class=\"ui-btn\">An</a>
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "0\" class=\"ui-btn\">Aus</a>
                    </div></td>
                    </tr>";
            } else {
                echo "<tr>
                    <td><h4>" . $row['Name'] . ":</h4></td>
                    <td><div data-role=\"controlgroup\" data-type=\"horizontal\">
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "1\" class=\"ui-btn\"> An </a>
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "0\" class=\"ui-btn\">Aus</a>
                        <a href=\"#\" id=\"Funk" . $row['Id'] . "2\" class=\"ui-btn\"> " . $row['Intervall'] . " m</a>
                    </div></td>
                    </tr>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>