<!DOCTYPE html>
<html>
<link rel="stylesheet" type  ="text/css" href="login.css"/>

 <body onload="document.getElementById('id01').style.display='block'">

<div id="id01" class="modal">
  
  <form class="modal-content animate" action="loginAction.php" method = "POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="shoes/logo.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pwd" required>
        
      <button type="submit">Login</button>
      <input type="checkbox" checked="checked"> Remember me
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
	  <button type="button" onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="cancelbtn" >Create Account</button>
     </div>
  </form>
</div>


<div id="id02" class="modal">
  
  <form class="modal-content animate" action="NewAccount.php" method = "POST">
    <div class="imgcontainer">
      <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
      <img src="shoes/logo2.jpg" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
	  </br>
	 <label><b>Gender</b></label>
	<select class="listing" name="gender">
	  <option value="male">Men</option>
	  <option value="female">Women</option>
  	</select></br>
	  
	  <label><b>Age</b></label></br>
	<select class="listing" name="age" >
	  <option value="kid">Below 15</option>
	  <option value="young">From 15 To 25 </option>
	  <option value="mature young">From 26 To 39</option>
	  <option value="old">Over 40</option>
 	</select></br>   
	  <label><b>Credit/Debit Card</b></label>
      <input type="Password" placeholder="Enter your Credit/Debit Card Number" name="card" required>
	  
      <button type="submit">Create</button>
     </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
      </div>
  </form>
</div>



</body>
</html>

