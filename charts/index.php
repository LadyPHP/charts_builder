<?php require ('./config/config.php'); ?>
<?php 
$category = 0;
if(isset($_GET['category'])) {
    $category = $_GET['category'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./template/style.css" rel="stylesheet" type="text/css" />
    <!-- load MUI -->
    <link href="//cdn.muicss.com/mui-0.9.16/css/mui.min.css" rel="stylesheet" type="text/css" />
    <script src="//cdn.muicss.com/mui-0.9.16/js/mui.min.js"></script>
    <!-- load highcharts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
  </head>
  <body>
    <header id="header" class="header-shadow">
        <nav id="appbar" class="mui-container-fluid">
            <li class="mui--text-right">
                <div id="appbar-social-links" class="mui--hidden-xs">
                  <a href="https://github.com/muicss/mui"><i class="icon-github"></i></a>
                  <a href="https://twitter.com/mui_css"><i class="icon-twitter"></i></a>
                  <a href="/newsletter"><i class="icon-email"></i></a>
                </div>
                <div class="mui-dropdown">
                  <a id="appbar-more-vert" data-mui-toggle="dropdown"><i class="icon-more-vert"></i></a>
                  <ul class="mui-dropdown__menu mui-dropdown__menu--right" style="top: 31px;">
                    <li><a href="/docs/v1/getting-started/introduction">Introduction</a></li>
                    <li><a href="/docs/v1/getting-started/roadmap">Roadmap</a></li>
                    <li><a href="/support">Support</a></li>
                    <li><a href="/feedback">Feedback</a></li>
                  </ul>
                </div>
          </li>
        </nav>
    </header>
    <!-- sidebar begin -->
    <?php
    require_once('./classes/CategoryClass.php');
    $cat = new Categories(); 
    $sidebarmenu = $cat -> selectCategory();  
    ?>
    <div id="sidebar">
    <nav id="sidenav" class="mui--no-user-select">
        <div class="mui--text-light mui--text-display1 mui--align-vertical">Продажи</div>
        <div class="mui-divider"></div>
        <ul>   
            <?php
            $arrOut = array();
            foreach($sidebarmenu as $subArr){
              $arrOut = ($arrOut+$subArr);
            }
            foreach ($arrOut as $key => $li) {
                echo '
                    <li>
                      <a href="?category='.$key.'"><strong class="">'.$li.'</strong></a>
                    </li>';
            }
            ?>
        </ul>
    </nav>
    </div>
    <!-- sedebar end -->
    <div id="content" class="mui-container-fluid">
      <!-- blog posts go here -->
        <div class="mui-row">
          <div class="mui-col-sm-10 mui-col-sm-offset-1">
            <br>
            <br>
            <!-- chart begin -->
            <pre>
            <?php
            require_once('./classes/MGoodsClass.php');
            require_once('./classes/SalesClass.php');
            require_once('./classes/StoreClass.php');
            require_once('./classes/DifSaleClass.php');

            //Создаем объект класса для получения списка продвигаемых товаров
            $mgoods = new MGoods();
            $cat_legend = $mgoods -> selectMGoods($category);
            //Создаем объект класса для получения списка аптек
            $store = new Store();
            $store_legend = $store -> selectStore(1);
            //Создаем объект класса для получения данных о продажах по продвигаемым товарам в наших аптеках
            $sales_dif = new DifSale();
            $dif_res = $sales_dif -> getSale($store_legend['did'], $cat_legend['goods_id']);
            $charts_res = $sales_dif -> chartsDataSale($dif_res, $store_legend['drugstore']);
            //print_r ($charts_res);
            
            ?>
            </pre>
            <div class="mui-panel">
                <div id="container" style="height: 500px; width: 98%;"></div>
            </div>
                <script type="text/javascript">
                    $(function () {
                        $('#container').highcharts({
                            chart: {
                                renderTo: 'container',
                                type: 'column'
                            },
                            title: {
                                text: 'Продажи продвигаемых препаратов'
                            },
                            xAxis: {
                                categories: ['<?php //echo join($cat_legend['goods'], "','"); ?>']
                            },
                            yAxis: {
                                title: {
                                    text: 'Объем продаж (количественный показатель)'
                                }
                            },
                            <?php echo "series: [".join($charts_res, ",")."],"; ?>
                        });
                    });
                </script>
            <!-- chart end -->
   
          </div>
        </div>
    </div>
  </body>
</html>