<?php
  $q=$_GET["q"];
  $dbuser="root";
  $dbname="cms_2";
  $dbpass="";
  $dbserver="localhost";

  $sql_query = "SELECT o.orderID,o.orderdate,p.ProductName,p.Unitprice,od.quantity_order,od.amount
  				FROM products p,categories c,order_det od,orders o
				WHERE p.categoryID=c.categoryID AND c.categoryID='$q' AND p.productID=od.productID and od.productID=p.productID AND o.orderID=od.orderID
				ORDER BY o.orderID";

  $sql_query2 = "SELECT  c.categoryName,SUM(od.amount) as Category_Sale
				 FROM products p,categories c, orders o, order_det od
				 WHERE p.productID=od.ProductID and od.productID=p.productID and o.orderID = od.orderID and p.categoryID = c.categoryID and DATE_FORMAT(CURDATE(),'%Y')-DATE_FORMAT(o.orderdate,'%Y')<=5 AND c.categoryID='$q'
group by c.categoryName ";

  $con = mysql_connect($dbserver,$dbuser,$dbpass);
  if (!$con){ die('Could not connect: ' . mysql_error()); }
  mysql_select_db($dbname, $con);
  
  $result = mysql_query($sql_query);

  echo "{ \"cols\": [ {\"id\":\"\",\"label\":\"order ID\",\"pattern\":\"\",\"type\":\"number\"},
  		{\"id\":\"\",\"label\":\"Order Date\",\"pattern\":\"\",\"type\":\"number\"},
 		 {\"id\":\"\",\"label\":\"Product Name\",\"pattern\":\"\",\"type\":\"number\"},
 		 {\"id\":\"\",\"label\":\"UnitPrice\",\"pattern\":\"\",\"type\":\"number\"},
		 {\"id\":\"\",\"label\":\"Quantity order\",\"pattern\":\"\",\"type\":\"number\"},
		 {\"id\":\"\",\"label\":\"amount sale\",\"pattern\":\"\",\"type\":\"number\"} ],
		  \"rows\": [ ";

  $total_rows = mysql_num_rows($result);
  while($row = mysql_fetch_array($result)){
    echo "{\"c\":[{\"v\":\"" . $row['orderID'] . "\",\"f\":null},{\"v\":\"" . $row['orderdate'] . "\",\"f\":null},{\"v\":\"" . $row['ProductName'] . "\",\"f\":null},{\"v\":\"" . $row['Unitprice'] . "\",\"f\":null},{\"v\":\"" . $row['quantity_order'] . "\",\"f\":null},{\"v\":\"" . $row['amount'] . "\",\"f\":null}]}, ";
  }

  $result = mysql_query($sql_query2);
  while($row = mysql_fetch_array($result)){
    echo "{\"c\":[{\"v\":\"" . $row['categoryName'] . "\",\"f\":null},{\"v\":\"" . "\",\"f\":null},{\"v\":\"" . "\",\"f\":null},{\"v\":\" Total \",\"f\":null},{\"v\":\"" . $row['Category_Sale'] . "\",\"f\":null}]}";
  }

  echo " ] }";
  mysql_close($con);
?>