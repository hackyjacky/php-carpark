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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    </head>

    <body>
        <h1>Carpark Availability</h1>
        <form method='post'>
            Select a carpark: <input id='carparks' name='carpark'>
            <script>
            $.getJSON('https://data.gov.sg/api/action/datastore_search?resource_id=139a3035-e624-4f56-b63f-89ae28d4ae4c&limit=3000', function(data){
                add = [];
                carparks = data.result.records
                for (var i = 0, len = carparks.length; i < len; i++){
                    add.push(carparks[i].address + ' - ' + carparks[i].car_park_no);
                }
                $('#carparks').autocomplete({
                    source: add
                });
            })
            </script>
            <input type="submit" value='Get Parking Lot Availability'>
        </form>
        
        <?php
            if (isset($_POST['carpark'])){
                require_once "model/CarParkDAO.php";
                $dao = new CarParkDAO;
                foreach ($dao->getcarParksInfo() as $info){
                    if ($info->carpark_number == explode(' - ', $_POST['carpark'])[1]){
                        echo "<table border=1>
                            <tr><td>Carpark ID</td><td>Total Lots</td><td>Lot Type</td><td>Available Lots</td></tr>
                            <tr><td>{$info->carpark_number}</td><td>{$info->carpark_info[0]->total_lots}</td><td>{$info->carpark_info[0]->lot_type}</td><td>{$info->carpark_info[0]->lots_available}</td></tr>
                            </table>";
                        break;
                    }
                }
            }
        ?>
    </body>
</html>