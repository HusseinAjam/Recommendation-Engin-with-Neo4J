<!DOCTYPE html>
<?php
session_start();
if (empty($_SESSION['passWord'])) 
   {
           header("Location: login.php");
   }
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
    ->build();


if($_GET["Type"] == "Men")
{
$Type = "Men";
$SearchFor =  $_GET["Category"];
}
if($_GET["Type"] == "Female")
{
$Type = "Women";
$SearchFor =  $_GET["Category"];
}

if($_GET["Type"] == "Kids")
{
$Type = "Kids";
$SearchFor =  $_GET["SubType"];
}
if($_GET["Type"] == "Sports")
{
$Type = "Sports";
$SearchFor =  $_GET["SubCategory"];
}
if($_GET["Type"] == "Others")
{
$Type = "Others";
$SearchFor =  "";
}
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type  ="text/css" href="myStyle.css"/>

<style>

</style>

<body>
<ul class = "TopMenu">
  <li><a class ="BestChoice">BestChoice</a></li>
    <?php
    
     if (!empty($_SESSION['userName']))
     {
         $x = 'Hi '.$_SESSION['userName'];
       echo '<li><a class ="BestChoice">'.$x.'</a></li>';  
       echo '<li><a class ="BestChoice" href = "distroy.php">Log off</a></li>';  
     }
    
    ?>
  <li><a href="contact.html" class ="normalList" >Contact Us</a></li>
  <li><a href="WishList.php" class ="normalList">Wish List</a></li>
  <li><a href="purchaseList.php" class ="normalList">Purchase List</a></li>
  <li><a href="profile.php" class ="normalList">My Profile</a></li>
  <li><a href="index.php" class ="normalList">Home</a></li>
</ul>
            </br></br>
    <h2><span> Searching Results </span></h2>
<navigation>
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="CloseMenue" onclick="closeNav()">&times;</a>
      <a href="Searching.php?Category=0&Type=Men" class = "MainCategory">Men</a>
        <ul class = "categories">
          <li><a href="Searching.php?Category=Formal&Type=Men">Formal</a></li>
          <li><a href="Searching.php?Category=Fashion&Type=Men">Fashion</a></li>
          <li><a href="Searching.php?Category=Boots&Type=Men">Boots</a></li>
          <li><a href="Searching.php?Category=Casual&Type=Men">Casual</a></li>
          <li><a href="Searching.php?Category=Sandals&Type=Men">Sandals</a></li>
         </ul>
      <a href="Searching.php?Category=0&Type=Female" class = "MainCategory">Women</a>
         <ul class = "categories">
          <li><a href="Searching.php?Category=Formal&Type=Female">Formal</a></li>
          <li><a href="Searching.php?Category=Fashion&Type=Female">Fashion</a></li>
          <li><a href="Searching.php?Category=Boots&Type=Female">Boots</a></li>
          <li><a href="Searching.php?Category=Casual&Type=Female">Casual</a></li>
          <li><a href="Searching.php?Category=Sandals&Type=Female">Sandals</a></li>
        </ul>
       <a href="Searching.php?SubType=0&Type=Kids" class = "MainCategory">Kids</a>
         <ul class = "categories">
          <li><a href="Searching.php?SubType=Boys&Type=Kids">Boys</a></li>
          <li><a href="Searching.php?SubType=Girls&Type=Kids">Girls</a></li>
        </ul>
        <a href="Searching.php?Type=Sports&SubCategory=0" class = "MainCategory">Sports/Trainers</a>
         <ul class = "categories">
          <li><a href="Searching.php?SubCategory=Basketball&Type=Sports">Basketball</a></li>
          <li><a href="Searching.php?SubCategory=Boxing&Type=Sports">Boxing</a></li>
          <li><a href="Searching.php?SubCategory=Cycling&Type=Sports">Cycling</a></li>
          <li><a href="Searching.php?SubCategory=Football&Type=Sports">Football</a></li>
          <li><a href="Searching.php?SubCategory=Gym&Type=Sports">Gym</a></li>
          <li><a href="Searching.php?SubCategory=Golf&Type=Sports">Golf</a></li>   
          <li><a href="Searching.php?SubCategory=Rugby&Type=Sports">Rugby</a></li>
          <li><a href="Searching.php?SubCategory=Running&Type=Sports">Running</a></li>
          <li><a href="Searching.php?SubCategory=Skiing&Type=Sports">Skiing</a></li>
          <li><a href="Searching.php?SubCategory=Tennis&Type=Sports">Tennis</a></li>
        </ul>
         <a href="Searching.php?Type=Others&SubCategory=0" class = "MainCategory">Other Products</a>
     </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Search</span>

    <script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
    </script>
</navigation>
<main>
    <?php
     $IDsArray = array();
     $CatesArray = array();
     $PriceArray = array();
    if(($Type =="Men" || $Type =="Women") && ($SearchFor == "0")) 
    {
        $result = $client->run("MATCH (n:Shoes), (b:Type {typeIs : '".$Type."'}), (c:Category) MATCH (n)-[r:has_type]->(b),(n)-[r2:has_category]-> (c)   with collect(c) as col , ID(n) As ids , n.Price as price Return col, ids, price;");
       $test = "";
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('cateIs')) ."  ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
    }
    
    
    else if(($Type =="Men" || $Type =="Women") && ($SearchFor != "0")) 
    {
        $test = "";
       $result = $client->run("MATCH (n:Shoes), (b:Type {typeIs : '".$Type."'}), (c:Category {cateIs : '".$SearchFor."'}) MATCH (n)-[r:has_type]->(b),(n)-[r2:has_category]-> (c) MATCH (n)-[r3]->(k : Category) with collect(k) as col , ID(n) As ids, n.Price as price  Return col, ids, price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('cateIs')) ."  ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
      
    }
    
    else if($SearchFor =="Boys" || $SearchFor =="Girls") 
    {
        $test = "";
       $result = $client->run("MATCH (a : Shoes), (b : Type {typeIs : '".$SearchFor."'}),(c : Type) 
       MATCH (a)-[r:has_type]-(b) match(a)-[r2]-(c)  with collect(c) as col  ,ID(a) as ids, a.Price as price RETURN col,ids, price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('typeIs')) ."  ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
      
    }
    
    else if($Type == "Kids") 
    {
        $test = "";
       $result = $client->run("MATCH (a : Shoes), (b : Type )
                 where b.typeIs = 'Boys' OR b.typeIs = 'Girls'
                 MATCH (a)-[r:has_type]-(b)  with collect(b) as col  ,ID(a) as ids, a.Price as price RETURN col,ids, price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('typeIs')) ." ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
      
    }
    
        else if($Type == "Sports" && $SearchFor !="0") 
    {
        $test = "";
       $result = $client->run("MATCH (a : Shoes), (b : SubCategory {subIs : '".$SearchFor."'} )
                              MATCH (a)-[r:has_SubCategory]-(b)  with collect(b) as col  ,ID(a) as ids, a.Price as price RETURN col,ids, price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('subIs')) ." ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
      
    }
    
            else if($Type == "Sports" && $SearchFor =="0") 
    {
        $test = "";
       $result = $client->run("MATCH (a : Shoes), (b : SubCategory), (c : Category {cateIs : 'Sport'}) MATCH (a)-[r:has_SubCategory]->(b) match (c)-[r2:hasSubCategory]->(b)
                 with collect(b) as col  ,ID(a) as ids, a.Price as price RETURN col,ids, price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ids')."";
            $PriceArray[$i] = $record->value('price')."";
            foreach ($record->get('col') as $coll) {
                $test = $test . sprintf('%s', $coll->value('subIs')) ." ";
            }
            $CatesArray[$i] = $test;
            $test = "";
            $i++;
         }
      
    }
    
     else if($Type == "Others") 
    {
        $result = $client->run("Match (a : Others)Return a.Product ,  ID(a), a.Price as price;");
        $i=0;
         foreach($result -> getRecords() as $record)
        {
            $IDsArray[$i] = $record->value('ID(a)')."";
            $PriceArray[$i] = $record->value('price')."";
            $CatesArray[$i] =  $record->value('a.Product')."";
             $i++;
         }
      
    }
    
    
    $resultArray = onDTo2D($IDsArray, 4);
    $resultArray2 = onDTo2D($CatesArray, 4);
    $resultArray3 = onDTo2D($PriceArray, 4);
    echo '<table style="width:100%">';

    $rows = count($resultArray);
     for ($row = 0; $row < $rows; $row++) {
      echo '<tr>';
     $cols = count($resultArray[$row]);
     for($column = 0; $column < $cols; $column++ ) {
         

        $pic = "shoes/".$resultArray[$row][$column]."";
        $cat = $resultArray2[$row][$column];
        $price = $resultArray3[$row][$column];
        $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
        $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];
         
        echo 
       '<th> 
       <h2><span>'.$cat.', '.$price.' £'.'</span></h2>
       <img src="'.$pic.'" alt="Mountain View" style="width:100%;height:100%;" > 
       <a class="specbutt" style="vertical-align:middle" href="'.$path.'">
       <span>View</span></a>
        <a class="specbutt2" style="vertical-align:middle" href="'.$path2.'">
       <span>Add to Wish List</span></a>
        </th>';
           
       }
      echo '</tr>';
      }
    echo '</table>';
    
    
    
    function onDTo2D ($array, $col_count=2){
    
	$result = false;
	if(!empty($array) && is_array($array)){
		$row_count = ceil( count($array) / $col_count);
		$pointer = 0;
		for($row=0; $row < $row_count; $row++) {
			for($col=0; $col < $col_count; ++$col){
				if(isset($array[$pointer])) {
					$result[$row][$col] = $array[$pointer];
					$pointer++;
				}
			}
		}
	}
	return $result;
}
    
    // For Reccommendation purposes
    if (($Type == "Men") or ($Type == "Women"))
    {
        // add 1 for favourit type, or create new relation if not exsist
        $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (t:Type {typeIs : '".$Type."'})
                                Merge (u)-[r:favourit_type]->(t)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP();");
        
        // add 1 for favourit category, or create new relation if not exsist
        $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (c:Category {cateIs : '".$SearchFor."'})
                                Merge (u)-[r:favourit_category]->(c)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP();");

        
    }
    
    if ($Type == "Kids")
    {
        // add 1 for favourit type (Boys or Girls or both)
      if (($SearchFor == "Boys") or ($SearchFor == "Girls"))
      {
        $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (t:Type {typeIs : '".$SearchFor."'})
                                Merge (u)-[r:favourit_type]->(t)
                                On create set r.counter = 1 , r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP() ;");
      }
      else if($SearchFor == "0")
      {
         $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (t:Type)
                                where t.typeIs = 'Girls' OR t.typeIs = 'Boys'
                                Merge (u)-[r:favourit_type]->(t)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP() 
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP();"); 
      }
        
     }
    
        if (($Type == "Sports"))
    {
        // add 1 for favourit Category (Sport)
        $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (c:Category {cateIs : 'Sport'})
                                Merge (u)-[r:favourit_category]->(c)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP() ;");
        if($SearchFor != "0")
        {
        // add 1 for favourit subcategory
        $result = $client->run("Match (u:User {Name : '".$_SESSION['userName']."'}) 
                                Match (s:SubCategory {subIs : '".$SearchFor."'})
                                Merge (u)-[r:favourit_SubCategory]->(s)
                                On create set r.counter = 1, r.lastUpdateTime = TIMESTAMP()
                                On match set r.counter = r.counter + 1, r.lastUpdateTime = TIMESTAMP() ;");
        }
    }
    
    ?>
</main>
</body>
</html>

