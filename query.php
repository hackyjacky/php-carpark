<?php
    spl_autoload_register(function($class){
        require_once "model/$class.php";
    });

    $cpldao = new CarParkListDAO;
?>

<html>
    <head>
        <title>Car Park Information</title>
        <style>
            body {
                background-image: url("./image/parkhappy.png");
            }
            table {
                border: 1px solid black;
            }
            th,td {
                border: 1px solid black;
                text-align: center;
            }
        </style>
    </head>

    <body>
        <h1>Carpark Availability</h1>
        <form method='post'>
            <select name="cpid">
                <?php
                    foreach ($cpldao->getcarParkList() as $cpid){
                        echo "<option value=$cpid";
                        if (isset($_POST['cpid']) && $cpid == $_POST['cpid']){
                            echo ' selected';
                        }
                        echo ">$cpid</option>";
                    }
                ?>
            </select>
            <input type="submit" value='Get Parking Lot Availability'>
        </form>
        
        <?php
            if (isset($_POST['cpid'])){
                $cpidao = new CarParkInfoDAO($_POST['cpid']);
                echo "<table border=1>
                    <tr><td>Carpark ID</td><td>Total Lots</td><td>Lot Type</td><td>Available Lots</td></tr>
                    <tr><td>{$_POST['cpid']}</td><td>{$cpidao->getcarParkInfo()['total_lots']}</td><td>{$cpidao->getcarParkInfo()['lot_type']}</td><td>{$cpidao->getcarParkInfo()['lots_available']}</td></tr>
                    </table>";
            }
        ?>
    </body>
</html>