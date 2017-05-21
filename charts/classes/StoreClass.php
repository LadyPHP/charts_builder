<?php
//класс для получения списка аптек
class Store {
    public $stores_arr;
    public $id_arr;
    public $result_arr ;
    
    private function getStore()
    {
        return $this->dname;
    }
    
    private function getStoreId()
    {
        return $this->did;
    }
    
    public function selectStore($dstatus) {
        try {
          $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR, DB_USER, DB_PASS);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $result = $pdo->prepare('SELECT did, dname FROM '.DB_PREFIX.'drugstore WHERE dstatus = ?');
        
          //Выводим результат как объект
          $result->setFetchMode(PDO::FETCH_CLASS, 'Store');
          if ($result->execute([$dstatus])) {
              while($stores = $result->fetch()) {
                /* Вызываем наш методы getStore и getStoreId для получения двух отдельных массивов (названия для легенды и id - для последующей выборки продаж по аптекам) */
                $store_arr[] = ($stores->getStore());
                $id_arr[] = ($stores->getStoreId());
              }
              $result_arr = array ('drugstore' => $store_arr, 'did' => $id_arr);
          }
          return $result_arr;
        } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
        }
    }
}
?>