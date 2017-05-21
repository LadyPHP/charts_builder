<?php
//класс для получения списка продвигаемых препаратов (status = 2) определенной категории
class MGoods {
    public $goods_arr;
    public $id_arr;
    public $result_arr ;
    
    private function getMGoods()
    {
        return $this->guname;
    }
    
    private function getMGoodsId()
    {
        return $this->guid;
    }
    
    public function selectMGoods($category_id) {
        try {
          $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR, DB_USER, DB_PASS);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $result = $pdo->prepare('SELECT guid, guname FROM '.DB_PREFIX.'goods WHERE gustatus = 2 AND category_id = ?');
        
          //Выводим результат как объект
          $result->setFetchMode(PDO::FETCH_CLASS, 'MGoods');
          if ($result->execute([$category_id])) {
              while($goods = $result->fetch()) {
                /* Вызываем наш методы getMGoods и getMGoodsId для получения двух отдельных массивов (названия для легенды и id - для последующей выборки продаж) */
                $goods_arr[] = ($goods->getMGoods());
                $id_arr[] = ($goods->getMGoodsId());
              }
              $result_arr = array ('goods' => $goods_arr, 'goods_id' => $id_arr);
          }
          return $result_arr;
        } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
        }
    }
}
?>