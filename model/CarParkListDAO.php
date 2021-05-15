<?php
class CarParkListDAO{
    private $baseUrl = "https://api.data.gov.sg/v1/transport/carpark-availability?date_time=";

    private $carParkList;
    
    public function __construct(){
        $this->initializeCarParkList();
    }

    public function getcarParkList(){
        return $this->carParkList;
    }

    private function initializeCarParkList() {
        
        date_default_timezone_set("Asia/Singapore");
        $date =  date('Y-m-d\TH:i:s');
       
        $date = urlencode($date);

        $url = $this->baseUrl . $date;

        $content = file_get_contents($url);
        $data = json_decode($content);

        $carpark_data_array = $data->items[0]->carpark_data;

        $this->carParkList = [];
        foreach($carpark_data_array as $carpark_data_obj) {   

            $carpark_id = $carpark_data_obj->carpark_number;
            $this->carParkList[] = $carpark_id;
        }
    }   
}
?>