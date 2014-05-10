<?php
session_start();
require "_modules/settings.php";

require_once "_modules/account.php";

if (isset($_GET['activate'])) {
	$pageTitle = "Activate your account";
	include "_comp/header.php"; ?>
		<h1>Account Registered</h1>
		<p>Please check your email inbox for an activation email.</p>
		<br/><br/><br/><br/><br/><br/><br/><br/>
		<br/>
		
	<?php include "_comp/footer.php";
	exit;
}

$errors = "";
if (isset($_POST['action'])) {
    
    $myAccount = new Account();
	if (!isset($_POST['toc'])) $_POST['toc'] = "false";
    $errors = $myAccount->register($_POST['username'],$_POST['email'], $_POST['country'], $_POST['pass1'], $_POST['pass2'], $_POST['sec_code'], $_POST['toc'], $_POST['cellnum'], $_POST['postalAddr'], $_POST['fullname']);
    
}
$pageTitle = "Register";
include "_comp/header.php";

?>
 
<!-- Page Content
================================================== -->
<SECTION id=typography>
	<DIV class=page-header>

<p>
<?php if (isset($_POST['action']) && $errors != "") { ?>
<div class="alert alert-block alert-error fade in">
<button type="button" class="close" data-dismiss="alert">×</button>
<h4 class="alert-heading">There are errors on your form</h4>
<p><?php echo $errors; ?></p>
</div>
<?php } ?>
</p>

<H1>Account Registration</H1></DIV>
<form action="register.php" method="post" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" name="email" id="inputEmail" placeholder="example@host.com" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">New password</label>
    <div class="controls">
      <input type="password" name="pass1" id="inputPassword" placeholder="example123" value="<?php if (isset($_POST['pass1']))echo $_POST['pass1']; ?>">
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputPassword2">Re-enter password</label>
    <div class="controls">
      <input type="password" name="pass2" id="inputPassword2" placeholder="example123" value="<?php if (isset($_POST['pass2'])) echo $_POST['pass2']; ?>">
    </div>
  </div>
  
   <!-- Country --> 
 <div class="control-group">  
  <label class="control-label" for="inputCountry">Country</label>
    <div class="controls">
      <select name="country" id="inputCountry">
          <option value="Afghanistan">Afghanistan</option>
          <option value="Albania">Albania</option>
          <option value="Algeria">Algeria</option>
          <option value="Andorra">Andorra</option>
          <option value="Anguila">Anguila</option>
          <option value="Antarctica">Antarctica</option>
          <option value="Antigua and Barbuda">Antigua and Barbuda</option>
          <option value="Argentina">Argentina</option>
          <option value="Armenia ">Armenia </option>
          <option value="Aruba">Aruba</option>
          <option value="Australia">Australia</option>
          <option value="Austria">Austria</option>
          <option value="Azerbaidjan">Azerbaidjan</option>
          <option value="Bahamas">Bahamas</option>
          <option value="Bahrain">Bahrain</option>
          <option value="Bangladesh">Bangladesh</option>
          <option value="Barbados">Barbados</option>
          <option value="Belarus">Belarus</option>
          <option value="Belgium">Belgium</option>
          <option value="Belize">Belize</option>
          <option value="Bermuda">Bermuda</option>
          <option value="Bhutan">Bhutan</option>
          <option value="Bolivia">Bolivia</option>
          <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
          <option value="Brazil">Brazil</option>
          <option value="Brunei">Brunei</option>
          <option value="Bulgaria">Bulgaria</option>
          <option value="Cambodia">Cambodia</option>
          <option value="Canada">Canada</option>
          <option value="Cape Verde">Cape Verde</option>
          <option value="Cayman Islands">Cayman Islands</option>
          <option value="Chile">Chile</option>
          <option value="China">China</option>
          <option value="Christmans Islands">Christmans Islands</option>
          <option value="Cocos Island">Cocos Island</option>
          <option value="Colombia">Colombia</option>
          <option value="Cook Islands">Cook Islands</option>
          <option value="Costa Rica">Costa Rica</option>
          <option value="Croatia">Croatia</option>
          <option value="Cuba">Cuba</option>
          <option value="Cyprus">Cyprus</option>
          <option value="Czech Republic">Czech Republic</option>
          <option value="Denmark">Denmark</option>
          <option value="Dominica">Dominica</option>
          <option value="Dominican Republic">Dominican Republic</option>
          <option value="Ecuador">Ecuador</option>
          <option value="Egypt">Egypt</option>
          <option value="El Salvador">El Salvador</option>
          <option value="Estonia">Estonia</option>
          <option value="Falkland Islands">Falkland Islands</option>
          <option value="Faroe Islands">Faroe Islands</option>
          <option value="Fiji">Fiji</option>
          <option value="Finland">Finland</option>
          <option value="France">France</option>
          <option value="French Guyana">French Guyana</option>
          <option value="French Polynesia">French Polynesia</option>
          <option value="Gabon">Gabon</option>
          <option value="Germany">Germany</option>
          <option value="Gibraltar">Gibraltar</option>
          <option value="Georgia">Georgia</option>
          <option value="Greece">Greece</option>
          <option value="Greenland">Greenland</option>
          <option value="Grenada">Grenada</option>
          <option value="Guadeloupe">Guadeloupe</option>
          <option value="Guatemala">Guatemala</option>
          <option value="Guinea-Bissau">Guinea-Bissau</option>
          <option value="Guinea">Guinea</option>
          <option value="Haiti">Haiti</option>

          <option value="Honduras">Honduras</option>
          <option value="Hong Kong">Hong Kong</option>
          <option value="Hungary">Hungary</option>
          <option value="Iceland">Iceland</option>
          <option value="India">India</option>
          <option value="Indonesia">Indonesia</option>
          <option value="Ireland">Ireland</option>
          <option value="Israel">Israel</option>
          <option value="Italy">Italy</option>
          <option value="Jamaica">Jamaica</option>
          <option value="Japan">Japan</option>
          <option value="Jordan">Jordan</option>
          <option value="Kazakhstan">Kazakhstan</option>
          <option value="Kenya">Kenya</option>
          <option value="Kiribati ">Kiribati </option>
          <option value="Kuwait">Kuwait</option>
          <option value="Kyrgyzstan">Kyrgyzstan</option>
          <option value="Lao People's Democratic Republic">Lao People's Democratic 
            Republic</option>
          <option value="Latvia">Latvia</option>
          <option value="Lebanon">Lebanon</option>
          <option value="Liechtenstein">Liechtenstein</option>
          <option value="Lithuania">Lithuania</option>
          <option value="Luxembourg">Luxembourg</option>
          <option value="Macedonia">Macedonia</option>
          <option value="Madagascar">Madagascar</option>
          <option value="Malawi">Malawi</option>
          <option value="Malaysia ">Malaysia </option>
          <option value="Maldives">Maldives</option>
          <option value="Mali">Mali</option>
          <option value="Malta">Malta</option>
          <option value="Marocco">Marocco</option>
          <option value="Marshall Islands">Marshall Islands</option>
          <option value="Mauritania">Mauritania</option>
          <option value="Mauritius">Mauritius</option>
          <option value="Mexico">Mexico</option>
          <option value="Micronesia">Micronesia</option>
          <option value="Moldavia">Moldavia</option>
          <option value="Monaco">Monaco</option>
          <option value="Mongolia">Mongolia</option>
          <option value="Myanmar">Myanmar</option>
          <option value="Nauru">Nauru</option>
          <option value="Nepal">Nepal</option>
          <option value="Netherlands Antilles">Netherlands Antilles</option>
          <option value="Netherlands">Netherlands</option>
          <option value="New Zealand">New Zealand</option>
          <option value="Niue">Niue</option>
          <option value="North Korea">North Korea</option>
          <option value="Norway">Norway</option>
          <option value="Oman">Oman</option>
          <option value="Pakistan">Pakistan</option>
          <option value="Palau">Palau</option>
          <option value="Panama">Panama</option>
          <option value="Papua New Guinea">Papua New Guinea</option>
          <option value="Paraguay">Paraguay</option>
          <option value="Peru ">Peru </option>
          <option value="Philippines">Philippines</option>
          <option value="Poland">Poland</option>
          <option value="Portugal ">Portugal </option>
          <option value="Puerto Rico">Puerto Rico</option>
          <option value="Qatar">Qatar</option>
          <option value="Republic of Korea Reunion">Republic of Korea Reunion</option>
          <option value="Romania">Romania</option>
          <option value="Russia">Russia</option>
          <option value="Saint Helena">Saint Helena</option>
          <option value="Saint kitts and nevis">Saint kitts and nevis</option>
          <option value="Saint Lucia">Saint Lucia</option>
          <option value="Samoa">Samoa</option>
          <option value="San Marino">San Marino</option>
          <option value="Saudi Arabia">Saudi Arabia</option>
          <option value="Seychelles">Seychelles</option>
          <option value="Singapore">Singapore</option>
          <option value="Slovakia">Slovakia</option>
          <option value="Slovenia">Slovenia</option>
          <option value="Solomon Islands">Solomon Islands</option>
          <option value="South Africa" selected="selected">South Africa</option>
          <option value="Spain">Spain</option>
          <option value="Sri Lanka">Sri Lanka</option>
          <option value="St.Pierre and Miquelon">St.Pierre and Miquelon</option>
          <option value="St.Vincent and the Grenadines">St.Vincent and the Grenadines</option>
          <option value="Sweden">Sweden</option>
          <option value="Switzerland">Switzerland</option>
          <option value="Syria">Syria</option>
          <option value="Taiwan ">Taiwan </option>
          <option value="Tajikistan">Tajikistan</option>
          <option value="Thailand">Thailand</option>
          <option value="Trinidad and Tobago">Trinidad and Tobago</option>
          <option value="Turkey">Turkey</option>
          <option value="Turkmenistan">Turkmenistan</option>
          <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
          <option value="Ukraine">Ukraine</option>
          <option value="UAE">UAE</option>
          <option value="UK">UK</option>
          <option value="USA">USA</option>
          <option value="Uruguay">Uruguay</option>
          <option value="Uzbekistan">Uzbekistan</option>
          <option value="Vanuatu">Vanuatu</option>
          <option value="Vatican City">Vatican City</option>
          <option value="Vietnam">Vietnam</option>
          <option value="Virgin Islands (GB)">Virgin Islands (GB)</option>
          <option value="Virgin Islands (U.S.) ">Virgin Islands (U.S.) </option>
          <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
          <option value="Yemen">Yemen</option>
          <option value="Yugoslavia">Yugoslavia</option>
        </select>
    </div>
  </div>
  
   <div class="control-group">
    <label class="control-label" for="inputNames">Full names</label>
    <div class="controls">
      <input type="text" name="fullname" id="inputNames" placeholder="Gary Wilder" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>">
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputPostal">Postal address</label>
    <div class="controls">
      <textarea name="postalAddr" id="inputPostal" placeholder="130 Esselen Street
      Sunnyside                                
      Pretoria 0001" rows="3"><?php if (isset($_POST['postalAddr'])) echo $_POST['postalAddr']; ?></textarea>
    </div>
  </div>
   <div class="control-group">
    <label class="control-label" for="inputCell">Cell number</label>
    <div class="controls">
      <input type="text" name="cellnum" id="inputCell" placeholder="1234567890" value="<?php if (isset($_POST['cellnum'])) echo $_POST['cellnum']; ?>">
    </div>
  </div>
  
  <!-- spam filter -->
  <div>
    <label class="control-label" for="inputSpamfilter">Spam Filter</label>
    <div class="controls">
    	<img src="apps/secimg.php" class="img-rounded"><br/>
      <input name="sec_code" type="text" id="inputSpamfilter" placeholder="Enter the code in the image">
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox" name="toc" value="true"> I accept the terms and conditions
      </label>
      <button type="submit" class="btn" name="action">Sign in</button>
    </div>
  </div>
</form>
</SECTION>

<?php
include "_comp/footer.php";
?>