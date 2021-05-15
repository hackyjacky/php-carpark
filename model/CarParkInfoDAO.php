<?php
  class CarParkInfoDAO{
    private $baseUrl = "https://api.data.gov.sg/v1/transport/carpark-availability?date_time=";
    private $id;
    private $carParkInfo;

    public function __construct($id){
      $this->id = $id;
      $this->initializeInfo();
    }
    
    public function getcarParkInfo(){
      return $this->carParkInfo;
    }
    
    private function initializeInfo() {
      date_default_timezone_set("Asia/Singapore");
      $date =  date('Y-m-d\TH:i:s');

      $date = urlencode($date);

      $url = $this->baseUrl . $date;
      $content = file_get_contents($url);
      $data = json_decode($content);

      $carpark_data_array = $data->items[0]->carpark_data;
      foreach ($carpark_data_array as $carpark_data_obj){
        if ($carpark_data_obj->carpark_number == $this->id){
          $this->carParkInfo['total_lots'] = $carpark_data_obj->carpark_info[0]->total_lots;
          $this->carParkInfo['lot_type'] = $carpark_data_obj->carpark_info[0]->lot_type;
          $this->carParkInfo['lots_available'] = $carpark_data_obj->carpark_info[0]->lots_available;
        }
      }
      
    }
  }
?>