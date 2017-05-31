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
?>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type  ="text/css" href="myStyle.css"/>

<style>
table th {
    background-color: #4CAF50;
    color: white;
}
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
<main>
            </br></br>
    <h2><span>Your Profile Info</span></h2>
<?php
    
$name = $_SESSION['userName'];
$pwd  = $_SESSION['passWord'];
      $result = $client->run("Match (u : User)Where u.Name = '".$name."' and u.Password = '".$pwd."' Return u.Age , u.Card, u.Gender;");

      foreach($result -> getRecords() as $record)
        {
            $age = $record->value('u.Age')."";
            $card= $record->value('u.Card')."";
            $gender= $record->value('u.Gender')."";
           
         }  
?>
    </br> </br>  </br> </br>
<table class = "profile">
  <tr class = "profile">
    <th class = "profile"><img src="shoes/Profile.png" alt="Smiley face" width="100%" height="100%"></th>
      
    <th class = "profile">
    <?php
       echo 'User Name  : '.$_SESSION['userName'].'</br></br>'; 
       echo 'Password   : '.$_SESSION['passWord'].'</br></br>'; 
       echo 'Age Group  : '.$age.'</br></br>'; 
       echo 'Use Gender : '.$gender.'</br></br>'; 
       echo 'Credit Card: '.$card.'</br></br>'; 
       
    ?>
    
      </th>
   </tr>
</table>

</main>
</body>
</html>