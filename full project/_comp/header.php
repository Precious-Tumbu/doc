<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <TITLE>Fresh one books</TITLE>
  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

  <!-- **** layout stylesheet **** -->
  <link rel="stylesheet" type="text/css" href="style/style.css" />

  <!-- **** colour scheme stylesheet **** -->
  <link rel="stylesheet" type="text/css" href="style/colour.css" />



</head>

<body>
  <div id="main">
    <div id="links">
      
    </div>
    <div id="logo">        <H1>The Fresh One Bookshop</H1></div>
    <div id="content">
      <div id="menu">
        <ul>
          <li><A id="selected" href="index.php">First-One</A></li>
          <li><A href="search.php">Search</A></li>
		  <?php if (!isset($_SESSION['user'])) {
                    	echo'<LI><A href="login.php">Login</A></LI>
                    		<LI><A href="register.php">Register</A></LI>';
					}else{
						echo '<LI><A href="logout.php">Logout</A></LI>
							<LI><A href="settings.php">Settings</A></LI>';
					} ?>
          <LI><A href="contact.php">Contact Us</A></LI>
                    <LI><A href="about.php">About Us</A></LI>
                    <LI><A href="cart.php">Shopping Cart (<?php
					if (!isset($_SESSION['user'])) {
					 if (isset($_SESSION['cart'])){require_once "_modules/productmanager.php";$manager = new ProductManager();echo $manager->tempCartTotalBooks();}else{ echo"0";}
					}else{
						$manager = new ProductManager();echo $manager->permCartTotalBooks();
					}
					 ?>)</A></LI>
        </ul>
      </div>

<div id="column1">
        <div class="sidebaritem">
          <div class="sbihead">
            <h1>Content</h1>
          </div>
          <div class="sbicontent">
            <UL class="nav nav-list bs-docs-sidenav">
              <LI><A href="catalogue.php"><I class=icon-chevron-right></I>All Catalogue (<?php require_once "_modules/productmanager.php";$manager = new ProductManager();echo $manager->countCategories();?>)</A></LI>
              <?php
			  	$categories = $manager->getRecentCategories();
				foreach($categories as $category) {
              echo '<LI><A href="catalogue.php?category='.$category->getId().'"><I class=icon-chevron-right></I>'.$category->getName().' ('.$manager->getTotalProductsPerCategory($category->getId()).')</A></LI>';
               } ?>
              <LI><A href="cart.php"><I class=icon-chevron-right></I>Shopping Cart (<?php
					if (!isset($_SESSION['user'])) {
					 if (isset($_SESSION['cart'])){require_once "_modules/productmanager.php";$manager = new ProductManager();echo $manager->tempCartTotalBooks();}else{ echo"0";}
					}else{
						$manager = new ProductManager();echo $manager->permCartTotalBooks();
					}
					 ?>)</A></LI>
            </UL>
          </div>
        </div>


      </div>
      <div id="column2">

            
