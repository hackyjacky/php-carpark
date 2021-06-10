<?php
class CarParkDAO{
    private $baseUrl = "https://api.data.gov.sg/v1/transport/carpark-availability?date_time=";

    public function getcarParksInfo(){
        date_default_timezone_set("Asia/Singapore");
        $date =  date('Y-m-d\TH:i:s');

        $content = file_get_contents($this->baseUrl . urlencode($date));
        $data = json_decode($content);
  
        return $data->items[0]->carpark_data;
    }
}
?>