<?php
session_start();
require "_modules/settings.php";
require_once "_modules/account.php";
require_once "_modules/productmanager.php";


if(isset($_POST['SignIn']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	
	$account = new Account();
	$mess = $account->login($email, $password);
	
	
}

$pageTitle = "Login";
include "_comp/header.php";
?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>
<p>
<?php if ((isset($_POST['SignIn']) && $mess != "") ) { ?>
<div class="alert alert-block alert-error fade in">
<button type="button" class="close" data-dismiss="alert">×</button>
<h4 class="alert-heading">Sign In Error</h4>
<p><?php if ($mess=="") echo $errors; else echo $mess; ?></p>
</div>
<?php } ?>
</p>
<H1>Account Login</H1></DIV>
<form action="login.php" method="post" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" name="email" id="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" name="password" id="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="remember"> Remember me
      </label>
      <button type="submit" name = "SignIn" class="btn">Sign in</button>
    </div>
  </div>
</form>
</SECTION>

<?php
include "_comp/footer.php";
?>