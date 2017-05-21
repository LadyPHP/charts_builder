<?php
class Charts {
    public $type;
    public $title;
    private $id; 
    
    public function setCharts($type, $title, $title_id) {
        $this -> type = $type; 
        $this -> title = $title; 
        $id = $type.$title_id;
        $this -> id = $id; 
    }
    
    public function getTypeCharts () {
       return $this -> type;
    }
    
    public function getTitleCharts () {
       return $this -> title;
    }
    
    public function getIdCharts () {
       return $this -> id;
    }
}

$chart1 = new Charts();
$chart1 -> setCharts("bar","E","1");
echo $chart1 -> getTypeCharts();
echo $chart1 -> getTitleCharts();
echo $chart1 -> getIdCharts();
?>