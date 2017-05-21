<?php 
class DifSale {
    private $sales_arr;
    public $store;
    
    public function getSale($stores_d, $goods_d) {
        $sales =  new Sales();
        foreach ($stores_d as $store_did) {
            $sales_arr[] = $sales -> selectSale($store_did, $goods_d);
            //print_r($sales_arr);
        }
        return $sales_arr;
    }
    
    public function chartsDataSale($sales_arr,$store_name) {
        $i = 0;
        foreach ($sales_arr as $result_val) {
            $store[] = "{
                                name: '".$store_name[$i]."',
                                data: [".join($result_val, ',')."]
                            }";
        $i++;
        }
        return $store;
    }
}
?>