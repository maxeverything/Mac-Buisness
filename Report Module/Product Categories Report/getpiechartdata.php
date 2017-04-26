<?php
 $q=$_GET["q"];
  $dbuser="root";
  $dbname="cms_2";
  $dbpass="";
  $dbserver="localhost";

  $sql_query = "SELECT p.productname, c.categoryName,SUM(od.amount) as 'Sale'
FROM products p,categories c, orders o, order_det od
WHERE p.productID=od.ProductID and o.orderID = od.orderID and p.categoryID = c.categoryID and DATE_FORMAT(CURDATE(),'%Y')-DATE_FORMAT(o.orderdate,'%Y')<=5 and c.categoryID='$q'
group by productName";

  $con = mysql_connect($dbserver,$dbuser,$dbpass);
  if (!$con){ die('Could not connect: ' . mysql_error()); }
  mysql_select_db($dbname, $con);
  $result = mysql_query($sql_query);
  echo "{ \"cols\": [ {\"id\":\"\",\"label\":\"Na2222bel\",\"pattern\":\"\",\"type\":\"string\"}, {\"id\":\"\",\"label\":\"AmountSale\",\"pattern\":\"\",\"type\":\"number\"} ], \"rows\": [ ";
  $total_rows = mysql_num_rows($result);
  $row_num = 0;
  while($row = mysql_fetch_array($result)){
    $row_num++;
    if ($row_num == $total_rows){
      echo "{\"c\":[{\"v\":\"" . $row['productname'] . "-" . $row['categoryName'] . "\",\"f\":null},{\"v\":" . $row['Sale'] . ",\"f\":null}]}";
    } else {
      echo "{\"c\":[{\"v\":\"" . $row['productname'] . "-" . $row['categoryName'] . "\",\"f\":null},{\"v\":" . $row['Sale'] . ",\"f\":null}]}, ";
    }
  }
  echo " ] }";
  mysql_close($con);
?>