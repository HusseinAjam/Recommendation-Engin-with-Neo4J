<!DOCTYPE html>
<?php
session_start();
require_once 'vendor/autoload.php';
use GraphAware\Neo4j\Client\ClientBuilder;
$client = ClientBuilder::create()
    ->addConnection('default', 'http://neo4j:123456789ha@localhost:7474') 
    ->build();
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type  ="text/css" href="myStyle.css"/>

<style>

</style>

<body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script language='javascript' src='ajaxTest.js'></script>

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

     <p>Randum Gap</p>
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
    $x = "x";
    $y = "y";
    $z = "z";

    ?>
    <div class="slideshow-container">

    <div class="mySlides fade">
      <div class="numbertext">1 / 3</div>
      <img src="<?php  echo $x; ?>" style="width:100%">
      <div class="text">On Sale / New models</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">2 / 3</div>
      <img src="<?php  echo $y; ?>" style="width:100%">
      <div class="text">Caption Two</div>
    </div>

    <div class="mySlides fade">
      <div class="numbertext">3 / 3</div>
      <img src="<?php  echo $z; ?>" style="width:100%">
      <div class="text">Caption Three</div>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>

    </div>
    <br>

    <div style="text-align:center">
      <span class="dot" onclick="currentSlide(1)"></span>
      <span class="dot" onclick="currentSlide(2)"></span>
      <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <script>
    var slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
      showSlides(slideIndex += n);
    }

    function currentSlide(n) {
      showSlides(slideIndex = n);
    }

    function showSlides(n) {
      var i;
      var slides = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("dot");
      if (n > slides.length) {slideIndex = 1}
      if (n < 1) {slideIndex = slides.length}
      for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
      }
      slides[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " active";
    }
    </script>

    <?php
    
        /* For Recommendation Purposes, Set the similarity relationship between this user and all others.
        This step Should be done every sometime, big companies put this step on their servers and run it 
        By triger every specific period of time, but I don't need that so I place it in my home page from the website  */
    
        $resultsUpdate = $client->run(" MATCH (u1:User)-[firstUserRelation:interested]->(s:Shoes)<-[SecondUserRelation:interested]-(u2:User)
                                        WITH SUM(firstUserRelation.rate * SecondUserRelation.rate) AS RatingSummation,
                                        SQRT(REDUCE(x = 0.0, a IN COLLECT(firstUserRelation.rate) | x + a^2)) AS firstRate,
                                        SQRT(REDUCE(y = 0.0, b IN COLLECT(SecondUserRelation.rate) | y + b^2)) AS secondRate, u1, u2
                                        MERGE (u1)-[s:similarity]-(u2)
                                        SET s.similarity_rate = RatingSummation / (firstRate * secondRate);");  

    if (isset($_SESSION['userName']))      
    {
     $IDsArray = array();
     $PriceArray = array();
      $name = $_SESSION['userName'];
            $result = $client->run("Match (u:User)-[i:interested]->(s:Shoes)
                                    Match (u)-[sim:similarity]-(me:User {Name:'".$name."'})
                                    Where Not((me)-[:interested]->(s))
                                    With s, sim.similarity_rate AS similarity_rate, i.rate AS howMuchInterested
                                    Order By id(s), similarity_rate DESC
                                    With s as Shoes,  COLLECT(howMuchInterested)[0..5] AS interests
                                    With Shoes,  REDUCE(s = 0, i IN interests | s + i) as sumOfInterests
                                    Order By sumOfInterests DESC  Return  id(Shoes), Shoes.Price ,  sumOfInterests limit 6");
         
          $i=0;
             foreach($result -> getRecords() as $record)
            {
                $IDsArray[$i] = $record->value('id(Shoes)')."";
                $PriceArray[$i] = $record->value('Shoes.Price')."";
                $i++;
             }

        $resultArray = onDTo2D($IDsArray, 4);
        $resultArray2 = onDTo2D($PriceArray, 4);
     echo '<h2><span> Collaborative Filtering Recommendations </span></h2>';
        echo '<table style="width:100%">';
        $rows = count($resultArray);
         for ($row = 0; $row < $rows; $row++) {
          echo '<tr>';
         $cols = count($resultArray[$row]);
         for($column = 0; $column < $cols; $column++ ) {


            $pic = "shoes/".$resultArray[$row][$column]."";
            $price = $resultArray2[$row][$column];
            $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
            $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];

            echo 
           '<th> 
           <h2><span> '.$price.' £'.'</span></h2>
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
        
  echo '<h2><span> Still Interested in Your Wish List? </span></h2>';
        
      $IDsArray = array();
      $PriceArray = array();
      $name = $_SESSION['userName'];
            $result = $client->run("Match (u : User {Name:'".$name."'})-[r: wish]->(s : Shoes)
                                    Return id(s), s.Price limit 6;");
         
          $i=0;
             foreach($result -> getRecords() as $record)
            {
                $IDsArray[$i] = $record->value('id(s)')."";
                $PriceArray[$i] = $record->value('s.Price')."";
                $i++;
             }

        $resultArray = onDTo2D($IDsArray, 4);
        $resultArray2 = onDTo2D($PriceArray, 4);
        
        echo '<table style="width:100%">';
        $rows = count($resultArray);
         for ($row = 0; $row < $rows; $row++) {
          echo '<tr>';
         $cols = count($resultArray[$row]);
         for($column = 0; $column < $cols; $column++ ) {


            $pic = "shoes/".$resultArray[$row][$column]."";
            $price = $resultArray2[$row][$column];
            $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
            $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];

            echo 
           '<th> 
           <h2><span> '.$price.' £'.'</span></h2>
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
        
        
          echo '<h2><span> You May Like These For Your Self</span></h2>';
        
      $IDsArray2 = array();
      $PriceArray2 = array();
        
      $name = $_SESSION['userName'];
            $result = $client->run("Match (u:User {Name : '".$name."'})-[i:interested]->(s:Shoes)-[r]->(c : Category)
                                    With c, s, i.rate AS howMuchInterested
                                    With c,  s as Shoes,  COLLECT(howMuchInterested)[0..5] AS interests
                                    With c,  Shoes,  REDUCE(s = 0, i IN interests | s + i) as sumOfInterests
                                    Order By sumOfInterests DESC  Return  c.cateIs limit 1");
         
           $favouritCategory = "";
              foreach($result -> getRecords() as $record)
            {
                $favouritCategory = $record->value('c.cateIs')."";
             }
    
        // Find the User's favourit colour
         $favouritColour = "";
         $userGender = "";
             $resultC = $client->run("Match (u: User{Name :'".$name."'})-[uCat]->(c : Category), 
                                    (u)-[fc : favourit_colour]-(f : FavouriteColour)
                                    With f, fc, u
                                    Order By fc.counter DESC
                                    Return distinct f.colourIs , u.Gender limit 1 ;");
        
            foreach($resultC -> getRecords() as $record)
            {
                $favouritColour = $record->value('f.colourIs')."";
                $userGender = $record->value('u.Gender')."";
            }

        // Now We find all Shoes of the favourit category, favourit colour and for the User type (Male ,  Female)
        
           $resultF = $client->run("Match (c : Category {cateIs : '".$favouritCategory."'})<-[r]-(s: Shoes)-[r2]->(t : Type )
                                    Where s.colour = '".$favouritColour."' AND t.typeIs = '".$userGender."'
                                    Return id(s), s.Price;");
        
          $i=0;
                foreach($resultF -> getRecords() as $record)
            {
                    $IDsArray2[$i] = $record->value('id(s)')."";
                    $PriceArray2[$i] = $record->value('s.Price').""; 
                    $i++;   
            }
        
        $resultArray = onDTo2D($IDsArray2, 4);
        $resultArray2 = onDTo2D($PriceArray2, 4);
        
        echo '<table style="width:100%">';
        $rows = count($resultArray);
         for ($row = 0; $row < $rows; $row++) {
          echo '<tr>';
         $cols = count($resultArray[$row]);
         for($column = 0; $column < $cols; $column++ ) {


            $pic = "shoes/".$resultArray[$row][$column]."";
            $price = $resultArray2[$row][$column];
            $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
            $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];

            echo 
           '<th> 
           <h2><span> '.$price.' £'.'</span></h2>
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
        
        // Sports time
        
        
      $IDsArray3 = array();
      $PriceArray3 = array();
        
      $name = $_SESSION['userName'];
            $result = $client->run("Match (s : Shoes)-[r: has_SubCategory]->(sub : SubCategory)<-[f : favourit_SubCategory]-(u : User {Name :                              '".$name."'}) With f.lastUpdateTime As RecentAccess, u, sub Order By RecentAccess DESC limit 1 return                                    sub.subIs");
         
           $LastTrainersAccessed = "";
              foreach($result -> getRecords() as $record)
            {
                $LastTrainersAccessed = $record->value('sub.subIs')."";
                 echo '<h2><span>Interested in '. $LastTrainersAccessed .' Trainers!</span></h2>';
             }
        
    
        // Find All Trainers Relating to the last accessed Sport
           $resultF = $client->run("Match (s : Shoes)-[r: has_SubCategory]->(sub : SubCategory {subIs : '".$LastTrainersAccessed."'}) 
                                    return id(s), s.Price;");
        
          $i=0;
                foreach($resultF -> getRecords() as $record)
            {
                    $IDsArray3[$i] = $record->value('id(s)')."";
                    $PriceArray3[$i] = $record->value('s.Price').""; 
                    $i++;   
            }
        
        $resultArray = onDTo2D($IDsArray3, 4);
        $resultArray2 = onDTo2D($PriceArray3, 4);
        
        echo '<table style="width:100%">';
        $rows = count($resultArray);
         for ($row = 0; $row < $rows; $row++) {
          echo '<tr>';
         $cols = count($resultArray[$row]);
         for($column = 0; $column < $cols; $column++ ) {


            $pic = "shoes/".$resultArray[$row][$column]."";
            $price = $resultArray2[$row][$column];
            $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
            $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];

            echo 
           '<th> 
           <h2><span> '.$price.' £'.'</span></h2>
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
        
        // Family or Friends
      $IDsArray4 = array();
      $PriceArray4 = array();
        
      $name = $_SESSION['userName'];
            $result = $client->run("Match (u : User {Name: '".$name."'})-[r : favourit_type]->(t: Type)
                                    Where t.typeIs 	<> u.Gender
                                    With r.lastUpdateTime as LastUpdate , t
                                    Order By LastUpdate DESC limit 1
                                    return  t.typeIs;");
         
           $LastOtherGenderAccessed = "";
              foreach($result -> getRecords() as $record)
            {
                $LastOtherGenderAccessed = $record->value('t.typeIs')."";
                 echo '<h2><span>For Family or Friends</span></h2>';
             }
        
    
        // Find all pairs in that category for the selected type and from my favourit colour
           $resultF = $client->run("Match (s: Shoes)-[r2]->(t : Type )
                                    Where s.colour = '".$favouritColour."' AND t.typeIs = '".$LastOtherGenderAccessed."'
                                    Return id(s), s.Price;");
        
          $i=0;
                foreach($resultF -> getRecords() as $record)
            {
                    $IDsArray4[$i] = $record->value('id(s)')."";
                    $PriceArray4[$i] = $record->value('s.Price').""; 
                    $i++;   
            }
        
        $resultArray = onDTo2D($IDsArray4, 4);
        $resultArray2 = onDTo2D($PriceArray4, 4);
        
        echo '<table style="width:100%">';
        $rows = count($resultArray);
         for ($row = 0; $row < $rows; $row++) {
          echo '<tr>';
         $cols = count($resultArray[$row]);
         for($column = 0; $column < $cols; $column++ ) {


            $pic = "shoes/".$resultArray[$row][$column]."";
            $price = $resultArray2[$row][$column];
            $path  = 'purchase.php?x='.$resultArray[$row][$column].'&y='.$resultArray2[$row][$column];
            $path2  = 'addToWishList.php?id='.$resultArray[$row][$column];

            echo 
           '<th> 
           <h2><span> '.$price.' £'.'</span></h2>
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
        

        
    }
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

    ?>
</main>
</body>
</html>

