<?php
class Sales {
    public $store_arr;
    public $sum_arr;
    public $result_arr;
    private $goodsid;
    private $storeid;
    
    //Метод получения суммы продаж по препаратам
    private function getSaleSum()
    {
        return $this->sumsales;
    }
    
    //Метод sql запроса на выборку суммы продаж по аптеке и полученному для класса списку препаратов
    public function selectSale($storeid, $goodsid) {
        //Подготавливаем плейсхолдер, чтобы использовать в sql IN()
        $placeholder = implode(',', array_fill(0, count($goodsid), '?'));
        //Формируем массив и объединяем в нем данные из $storeid и $goodsid для передачи в execute()
        $execute_arr = $goodsid;
        array_unshift($execute_arr, $storeid);

        try {
          $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHAR, DB_USER, DB_PASS);
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $result = $pdo->prepare('SELECT SUM(qnt) AS sumsales FROM '.DB_PREFIX.'sales s
                                    LEFT JOIN '.DB_PREFIX.'billing_sales bs ON bs.sid = s.sid
                                    LEFT JOIN '.DB_PREFIX.'billings b ON b.bid = bs.bid
                                    WHERE bstatus = 1 AND b.did = ? AND guid IN ('.$placeholder.')');

          //Выводим результат как объект
          $result->setFetchMode(PDO::FETCH_CLASS, 'Sales');
          if ($result->execute($execute_arr)) {
              while($sale = $result->fetch()) {
                //Вызываем метод getSaleSum
                $sum_arr[] = ($sale->getSaleSum());
              }
          }
          return $sum_arr;
        } catch(PDOException $e) {
          echo 'По данному запросу нет данных.';
        }
    }
}
?>