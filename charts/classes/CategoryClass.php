<?php
class Categories {
      public $title;
      public $cat_arr;
      public $cat_result;
 
    private function getCategory()
    {
        return array($this->id => $this->title);
    }
    
    private function getCategoryId()
    {
        return $this->id;
    }
    
    public function selectCategory() {
        try {
          $pdo = new PDO('mysql:host=localhost;dbname=charts;charset=utf8', 'root', 'SAMMER130687');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $result = $pdo->query('SELECT title, id FROM sl_categories');

          //Выводим результат как объект
          $result->setFetchMode(PDO::FETCH_CLASS, 'Categories');

          while($category = $result->fetch()) {
            //Вызываем наши методы
            $cat_arr[] = ($category->getCategory());
          }
          return $cat_arr;
        } catch(PDOException $e) {
          echo 'Error: ' . $e->getMessage();
        }
    }
}

?>