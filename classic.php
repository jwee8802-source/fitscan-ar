<?php
session_start();

if (!isset($_SESSION['user']['id'])) {
  header("Location: login.php");
  exit();
}

$mysqli = new mysqli("mysql-highdreams.alwaysdata.net", "439165", "Skyworth23", "highdreams_1");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$user_id = $_SESSION['user']['id'];
$result = $mysqli->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();


$user_email = $_SESSION['user']['email'] ?? null;

if (!$user_email) {
    die("No user logged in.");
}

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM user_reviews WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($review_count);
$stmt->fetch();
$stmt->close();

$hasReview = $review_count > 0 ? 'true' : 'false'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="image/logo1.png" type="image/png">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe Store - Minimal Interface</title>
  <style>
      * {
    margin:0;
      padding: 0;
      box-sizing: border-box;
    }

     body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      display: flex;
      flex-direction: column;
      min-height: 100vh; 
    }
    .popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.popup-content {
  background: white;
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  width: 300px;
}

.stars .star {
  font-size: 24px;
  color: #ccc;
  cursor: pointer;
}

.stars .star.selected {
  color: gold;
}

textarea {
  width: 100%;
  height: 60px;
  margin-top: 10px;
  resize: none;
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
  background-color: #000000;
  color: white;
  height: 80px;
  width: 100%; 
  position: fixed;
  top: 0;
  z-index: 1000;
}

.logo-container {
  display: flex;
  align-items: center;
  gap: 15px;
}

.logo img,
.second-logo img {  
  height: 50px; 
  margin-left: 25px; 
  border: 2px solid white; 
  border-radius: 50%; 
  padding: 5px; 
  background-color: rgba(255, 255, 255, 0.05); 
}

.header-icons{  display: flex;
  flex-wrap: nowrap; 
  justify-content: center; 
  align-items: center;
  
}
.home-logo {
    height: 40px;
      width: 40px; 
    display: block;
     margin-top:10px;
     position: fixed;
    left: 30px;
     border: 2px solid black; 
    border-radius: 10px;     
    padding: 1px;
    z-index:999;
      background:white;
}

.more-logo{
  height: 100px;
  width: auto;
  margin: 0 5px 0 0;

}
.account-logo {
  height: 40px; 
  width: auto; 
  margin-right: -10px; 
}


/* Dropdown*/
.dropdown {

  display: flex;
  flex-direction: row; 
  flex-wrap: nowrap; 

  
  
}
.dropbtn {
 
  background: none; 
  color: #000000;
  border: none; 
  cursor: pointer;
}

.dropbtn:hover {
  background-color: transparent;
}

.more-logo {
  height: 70px; 
  width: auto;  
} 

.order {
    height: 50px;
    width: auto;
    margin-right: -15px;
}
 .order, .more-logo, .account-logo, .scanner-logo img {
      margin: 0 10px; 
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: rgba(0, 0, 0, 0.4); 
  min-width: 160px;
  box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  z-index: 1;
  right: 0; 
}

.dropdown-content a {
  color: rgb(255, 255, 255);
  padding: 12px 16px;
  display: block;
  text-decoration: none;
  border-bottom: 1px solid #ffffff;
}

.dropdown-content a:hover {
  background-color: grey;
}

.dropdown:hover .dropdown-content {
  display: block;
}
.scanner-logo img {
  height: 50px; 
  width: auto; 
  margin-right: 10px; 
}

.search-bar {
  display: flex;
  align-items: center;
  justify-content: center; 
  gap: 10px;
  margin-left: auto; 
  flex-grow: 1; 
}

.search-bar input {
  padding: 10px;
  width: 300px; 
  border-radius: 20px;
  border: none;
}

.search-bar button {
  padding: 10px;
  background-color: #000000;
  color: #fdfdfd;
  border: none;
  cursor: pointer;
  border-radius: 20px;
}

.search-bar button:hover {
  background-color: #333333;
}

.user-options {
  display: flex;
  align-items: center;
   flex-direction: row;   
  flex-wrap: nowrap;
  gap: 20px; 
}

.user-options button {
  padding: 10px;
  background-color: #ffffff;
  color: #000000;
  border: none;
  cursor: pointer;
  border-radius: 20px;
}

.user-options button:hover {
  background-color: #eeeeee;
}
/*Header */
    
.quantity-selector {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 10px 0;
  gap: 10px;
}

.quantity-selector .qty-btn {
  background-color: #000;
  color: #fff;
  border: none;
  width: 25px;
  height: 25px;
  font-size: 16px;
  cursor: pointer;
  border-radius: 4px;
  line-height: 1;
  padding: 0;
}

.quantity-selector input {
  width: 40px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 4px;
  height: 25px;
  background-color: #f9f9f9;
}
.back-button-container {
  position: fixed;        
  left: 20px;             
  top: 15%;              
  transform: translateY(-50%);
}

.back-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #000;
  color: white;
  text-decoration: none;
  border-radius: 25px;
  font-size: 16px;
  transition: background-color 0.3s ease;
}

.back-button:hover {
  background-color: #333;
}

    .bulky-shoes{ 
      background-color: #f9f9f9;
      padding: 30px;
      text-align: center;
      margin-top:70px;
    }
     .bulky-shoes h2 {
      font-size: 25px;
      margin-bottom: 20px;
    }
      .product-list {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
      }

      .product-item {
      width: 250px;
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgb(0, 0, 0);
      padding: 15px;
      text-align: center;
      opacity: 0; 
      transform: translateY(30px); 
      animation: fadeInUp 0.6s ease-out forwards; 
    }
      .product-item img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      transition: transform 0.3s ease-in-out; 
    }

      .product-item img:hover {
        transform: scale(1.1); 
      }

      .product-item h3 {
        margin-top: 10px;
        font-size: 1.2rem;
      }

      .product-item p {
        margin-top: 5px;
        color: #000000;
        font-size: 1rem;
      }
      .product-item button {
      margin-top: 10px;
      padding: 10px;
      background-color: #ff0000;
      box-shadow: 0 2px 10px rgb(0, 0, 0);
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
    }

    .product-item button:hover {
      background-color: #000000;
    }

      @keyframes fadeInUp {
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      
      .preorder-form {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        justify-content: center;
        align-items: center;
        z-index: 1000;
      }

      .preorder-form .form-container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        width: 400px;
        text-align: center;
      }

.user-info {
    display: flex;
    flex-direction: column;
    display: inline-block; 
}

.user-info textarea {
   width: 210px;
}

.user-info-item {
    font-size: 14px;
    color: #000;
    padding: 5px;
    border: 1px solid #000; 
    margin-bottom: 5px; 
    border-radius: 5px;
}

select{
  width:60%;
}
      .preorder-form button {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
      }

      .preorder-form button {
        background-color: #000000;
        color: white;
        cursor: pointer;
      }

      .preorder-form button:hover {
        background-color: #333;
      }

      .close-btn {
        background-color: red;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        margin-top: 10px;
        width: 100%;
      }
     
      .footer {
        background-color: #000000;
        color: white;
        padding: 20px;
        text-align: center;
        margin-top: auto;
      }

   
    .footer {
      background-color: #000000;
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: auto;
      width: 100%;
    }
    
    .home-logo {
    margin-top: 20px;
    position: fixed;
    left: 30px;
}
    /*Responsive */
         @media (max-width: 2561px) { 
     
        .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    
    }
.categories{
  margin-top:70px;
}
.logo img, .second-logo img {
    margin-left: 500px;
}
    .home-logo {
        margin-top: 5px;
        height:35px;
        width:35px;
    }
 .search-bar {
 margin-left: 0px;
 margin-right: 350px;
  }
  .search-bar input {
        margin-left:10px;
        width: 100%;
  }

       .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    
    }
    .home-logo {
        margin-top: 5px;
    }
  .bulky-shoes{
      margin-top:50px;

    }
    .bulky-shoes h2{
      margin-top:10px;
      width:250px;
      margin-left:620px;
      font-size:35px;
    }
       .product-item {
    width: 270px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 170px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 18px;
}
.product-item p {
    margin-top: 5px;
    margin-bottom:5px;
    color: #000000;
    font-size: 14px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
    }
 @media (max-width: 1441px) { 
     
        .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    }
.categories{
  margin-top:70px;
}
.logo img, .second-logo img {
    margin-left: 450px;
}
    .home-logo {
        margin-top: 5px;
        height:35px;
        width:35px;
    }
 .search-bar {
 margin-left: 0px;
 margin-right: 350px;
  }
  .search-bar input {
        margin-left:10px;
        width: 100%;
padding:15px;
  }
       .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    }
    .home-logo {
        margin-top: 5px;
    }
  .bulky-shoes{
      margin-top:50px;
    }
    .bulky-shoes h2{
      margin-top:10px;
      width:250px;
      margin-left:530px;
      font-size:35px;
    }
       .product-item {
    width: 270px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 170px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 18px;
}
.product-item p {
    margin-top: 5px;
    margin-bottom:5px;
    color: #000000;
    font-size: 14px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
    }
      @media(max-width:1281px){
    .second-logo img {
   margin-top: 0px;
}
 .search-bar input {
 margin-left: 10px;
    width: 100%;
padding:15px;
     }
     .search-bar {
              margin-left: 0px;
 margin-right: 350px;
    }  
        .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    }
    .home-logo {
        margin-top: 20px;
    }
  .bulky-shoes{
      margin-top:50px;

    }
    .bulky-shoes h2{
      margin-top:10px;
      width:250px;
      margin-left:480px;
      font-size:35px;
    }
       .product-item {
    width: 270px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 170px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 18px;
}
.product-item p {
    margin-top: 5px;
    margin-bottom:5px;
    color: #000000;
    font-size: 14px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 14px;
}
  }
        @media (max-width: 1040px) { 
      /* HEADER*/
    .search-bar input {
        margin-left:30px;
        width: 60%;
  }
}
    @media(max-width:1025px){
             .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    
    }
.categories{
  margin-top:70px;
}
    .home-logo {
        margin-top: 20px;
    }
     .second-logo img {
    margin-left: 320px;
    margin-bottom:0px;
}
.more-logo {
    height: 80px;
}
 .search-bar {
       margin-left: 0px;
        margin-right: 200px;
  }
  .search-bar input {
        margin-left:10px;
        width:100%;
padding:15px;
  }
  .bulky-shoes{
      margin-top:50px;

    }
    .bulky-shoes h2{
      margin-top:10px;
      width:250px;
      margin-left:360px;
      font-size:35px;
    }
       .product-item {
    width: 270px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 170px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 18px;
}
.product-item p {
    margin-top: 5px;
    margin-bottom:5px;
    color: #000000;
    font-size: 14px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 14px;
}
    }

    @media(max-width: 913px){
             .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 70px;
    margin-right: 10px;
    }

.logo img, .second-logo img {
    margin-left: 280px;
}
 .search-bar {
       margin-left: 0px;
        margin-right: 150px;
  }
  .search-bar input {
        margin-left:10px;
        width: 100%;
  }
  .bulky-shoes h2{
      margin-top:10px;
      width:250px;
      margin-left:300px;
      font-size:35px;
    }
     .product-item {
    width: 230px;
   height: auto;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 18px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 14px;
    font-weight:bold;
}
    }
    @media(max-width:854px){
 .second-logo img {
    margin-left: 250px;
   margin-top: 0px;
}
.search-bar{
margin-left:10px;
margin-right:130px;
}
 .search-bar input {
    width: 100%;
margin-left:10px;
     }
     .home-logo {
        margin-top: 20px;
    }
        .more-logo {
        height: 80px;
        margin-right: -10px;
    }
    .bulky-shoes h2 {
        margin-top: 10px;
        width: 250px;
        margin-left: 270px;
        font-size: 35px;
    }
    }  

    @media (max-width: 821px) {
  /*HEADER*/
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    padding: 10px 15px;
    height: 60px; 
    background-color: #000;
  }
   .second-logo img {
          margin-left: 260px;
        margin-top: 0px;
        height: 40px;
}
.home-logo {
    height: 30px;
    width: 30px;
    margin-left: -10px;
        margin-top: 5px;
}
.menu-btn {
 margin-top: -10px;
}
 
  .more-logo {
    height: 55px;
    margin-right: 10px;
    margin-top: -1px;
  }
  .search-bar button {
        font-size: 12px;
        margin-left: -0px;
  }

  .search-bar {
    flex: 1;
    display: flex;
    justify-content: center;
    position: static;
    margin: 0 10px;
            margin-left: 0px;
            margin-right: 170px;
  }

  .search-bar input {
    width: 100%;
    max-width: 150px;
    padding: 10px;
    font-size: 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
  }

  .user-options {
    display: flex;
    align-items: center;
    gap: 8px;
    position: static;
  }

  .dropdown, 
  .order, 
  .scanner-logo, 
  .logout {
    position: static;
  }

  /* dropdown*/
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 55px;
    margin-right: 10px;
    
    }

  .dropdown-content a {
    font-size: 12px;
    padding: 8px 10px;
    display: block;
  }

  /*PRODUCTS*/
    .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 280px;
        font-size: 25px;
    }
    .product-item h3 {
    margin-top: 1px;
    font-size: 14px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 12px;
     font-weight: bold;
}
    .product-item {
    width: 210px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 140px;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 12px;
}
  }

  @media (max-width: 769px) {
  /*HEADER*/
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    padding: 10px 15px;
    height: 60px; 
    background-color: #000; 
  }
.second-logo img {
          margin-left: 250px;
        margin-top: 0px;
        height: 40px;
}
.home-logo {
    height: 30px;
    width: 30px;
    margin-left: -10px;
        margin-top: 5px;
}
.menu-btn {
 margin-top: -10px;
}
 .bulky-shoes{
      margin-top:40px;

    }
    .bulky-shoes h1{
      margin-top:30px;
      width:200px;
      margin-left:30px;
      font-size:20px;
    }
 
  .more-logo {
    height: 55px;
    margin-right: 10px;
    margin-top: -1px;
  }
  .search-bar button {
        font-size: 12px;
        margin-left: -10px;
  }

  .search-bar {
    flex: 1;
    display: flex;
    justify-content: center;
    position: static;
    margin: 0 10px;
            margin-left: 0px;
            margin-right: 140px;
  }

  .search-bar input {
    width: 100%;
    max-width: 150px;
    padding: 10px;
    font-size: 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
  }

  .user-options {
    display: flex;
    align-items: center;
    gap: 8px;
    position: static;
  }

  .dropdown, 
  .order, 
  .scanner-logo, 
  .logout {
    position: static;
  }

  /* dropdown*/
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 55px;
    margin-right: 10px;
    }

  .dropdown-content a {
    font-size: 12px;
    padding: 8px 10px;
    display: block;
  }

  /*PRODUCTS */
        .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 260px;
        font-size: 25px;
    }
    .product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 14px;
     font-weight: bold;
}
    .product-item {
    width: 200px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 140px;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 12px;
}
  }

    @media (max-width: 695px) { 
  /* HEADER*/
  .account-logo {
    padding-left: 20px;
  }
  .search-bar {
   
    left: -10x;
    z-index: 10;
    width: 60%;
  }
  .user-options {
    
    gap: 10px;
}
}

@media (max-width: 590px) {
  /* Categories*/
 .category-list {
    display: flex;
    justify-content: center;
    gap: 90px;
    flex-wrap: nowrap;
    flex-direction: row;

}
  .category-item img {
    width: 200px;
    height: 150px;
    object-fit: contain;
    border-radius: 10px;
    transition: transform 0.3sease-in-out;
}
.categories h2 {
    font-size: 20px;
    margin-bottom: 20px;
}
.category-item {
  
    max-width: 100px;
}
  /* Product*/
.featured-products h2 {
    font-size: 40px;
    margin-bottom: 20px;
}
.product-list {
  display: grid;
    grid-template-columns: repeat(2, 1fr); 
    grid-template-rows: repeat(3, auto);   
    gap: 20px;
    justify-content: center;
}
.product-item {
    width: auto;
   height: 250px;
}
.product-item img {
    width: 100%;
    height: 150px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 12px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 12px;
}
.product-item button {
   
    padding: 5px;
  
}
/* pre-order form */
.preorder-form .form-container {
    
    width: 320px;
}
.form-container h3{
  margin-bottom: 10px;
  font-size:12px;
}
}

@media (max-width: 550px) {
   /* HEADER */
   .logo-container img,
  .account-logo,
  .order {
    height: 30px; 
  }
 
  .more-logo,
   .scanner-logo img{
    height: 40px; 
  }
  .account-logo
   {
    margin-left:15px;
  }
  .user-options {
   
   gap: 0px;
  }
 }

 @media (max-width: 541px) {
  /*HEADER*/
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    padding: 10px 15px;
    height: 60px;
    background-color: #000; 
  }
   .logo img, .second-logo img {
          margin-left: 130px;
        margin-top: 0px;
        height: 40px;
}
.home-logo {
    height: 30px;
    width: 30px;
    margin-left: -10px;
        margin-top: 5px;
}
.menu-btn {
 margin-top: -10px;
}
 .bulky-shoes{
      margin-top:40px;

    }
    .bulky-shoes h1{
      margin-top:30px;
      width:200px;
      margin-left:30px;
      font-size:20px;
    }
 
  .more-logo {
    height: 55px;
    margin-right: 1px;
    margin-top: -1px;
  }
  .search-bar button {
        font-size: 12px;
        margin-left: -10px;
       }

  .search-bar {
    flex: 1;
    display: flex;
    justify-content: center;
    position: static;
    margin: 0 10px;
            margin-left: -30px;
  }

  .search-bar input {
    width: 100%;
    max-width: 150px;
    padding: 10px;
    font-size: 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
  }

  .user-options {
    display: flex;
    align-items: center;
    gap: 8px;
    position: static;
  }

  .dropdown, 
  .order, 
  .scanner-logo, 
  .logout {
    position: static;
  }

  /* dropdown */
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 50px;
    margin-right: 10px;
    
    }

  .dropdown-content a {
    font-size: 12px;
    padding: 8px 10px;
    display: block;
  }

  /* PRODUCTS */
        .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 140px;
        font-size: 25px;
    }
    .product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 14px;
     font-weight: bold;
}
    .product-item {
    width: 230px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 140px;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
  .featured-products {
    background-color: #f9f9f9;
    padding: 20px 30px;
    text-align: center;
  }
  }

 @media (max-width: 490px) { 
  /* Categories */
 .category-list {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: nowrap;
    flex-direction: row;
}
 }
@media (max-width: 480px) { 
  /* HEADER */
  .logo-container img,
  .account-logo,
  .order {
    height: 30px; 
  }
 
  .more-logo,
   .scanner-logo img{
    height: 35px; 
  }
  .account-logo
   {
    margin-left:15px;
  }
  .user-options {
   
   gap: 0px;
  }
  .search-bar {
   
   left: 90px;
   z-index: 10;
   width: 60%;
 }
}
@media (max-width: 455px) { 
  /* HEADER  */
  .logo-container img,
  .account-logo,
  .order {
    height: 30px; 
  }

  .ar {
    height: 30px; 
  }
 
  .more-logo,
   .scanner-logo img{
    height: 35px; 
  }
  .logo-container img,
  .account-logo,
  .order, .more-logo,
  .scanner-logo img{
    margin-right:5px;
  }
  .account-logo
   {
    margin-left:5px;
  }
  .search-bar {
   
   left: -10x;
   z-index: 10;
   width: 60%;
 }
 .user-options {
   
   gap: 5px;
  }
 
}
@media (max-width: 440px) { 
   /* HEADER */
   .logo-container img,
  .account-logo,
  .order {
    height: 30px; 
  }
  .account-logo
   {
    margin-left:5px;
  }
  .user-options {
   
    gap: 10px;
}
.search-bar {
   
   left: -10x;
   z-index: 10;
   width: 60%;
 }
 .logo-container img, .account-logo, .order, .more-logo, .scanner-logo img {
        margin-right: 0px;
 }

}
@media (max-width: 431px) {
  /* HEADER*/
  .header {
    display: flex;
    align-items: center;
    justify-content: space-between; 
    padding: 10px 15px;
    height: 60px; 
    background-color: #000; 
  }
 .second-logo img {
          margin-left: 80px;
        margin-top: 0px;
        height: 40px;
}
.home-logo {
    height: 30px;
    width: 30px;
    margin-left: -10px;
        margin-top: 5px;
}
.menu-btn {
 margin-top: -10px;
}
 .bulky-shoes{
      margin-top:40px;
    }

  .more-logo {
    height: 55px;
    margin-right: -10px;
    margin-top: -1px;
  }
  .search-bar button {
        font-size: 12px;
        margin-left: -10px;
 }

  .search-bar {
    flex: 1;
    display: flex;
    justify-content: center;
    position: static;
    margin: 0 10px;
            margin-left: 10px;
  }

  .search-bar input {
    width: 100%;
    max-width: 150px;
    padding: 10px;
    font-size: 12px;
    border-radius: 20px;
    border: 1px solid #ccc;
  }

  .user-options {
    display: flex;
    align-items: center;
    gap: 8px;
    position: static;
  }
  .dropdown, 
  .order, 
  .scanner-logo, 
  .logout {
    position: static;
  }
  /* dropdown */
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 55px;
    margin-right: 10px;
    }

  .dropdown-content a {
    font-size: 12px;
    padding: 8px 10px;
    display: block;
  }

  /* PRODUCTS */
   .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 90px;
        font-size: 25px;
    }
    .product-item {
    width: 180px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 120px;
}
.product-item h3 {
    margin-top: 3px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
    margin-bottom: 5px;
    color: #000000;
    font-size: 12px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 12px;
}
  }

@media (max-width: 415px) { 
  /* HEADER*/
  .second-logo img {
        margin-left: 70px;
        margin-top: 0px;
        height: 40px;
      }
  .search-bar {
   margin-left:0px;
        z-index: 10;
    }
      .search-bar input {
   margin-left:0px;
        z-index: 10;
      width:65%;
      border-radius:20px;s
    }
 .dropdown-content a {
        font-size:12px;
    }
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 55px;
    margin-right: 12px;
    }

      .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 80px;
        font-size: 25px;
    }
    .product-item {
    width: 170px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 120px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
     margin-bottom: 5px;
    color: #000000;
    font-size: 12px;
     font-weight: bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
     font-size: 12px;
}
}

@media (max-width: 413px) { 
  /* HEADER*/
.second-logo{
  margin-top:0px;
  margin-bottom:0px;
  margin-right:10px;
}
    .search-bar input {
        width: 100%;
        max-width: 150px;
        padding: 10px;
        font-size: 12px;
        border-radius: 20px;
        border: 1px solid #ccc;
    }
    .more-logo {
      height:55px;
    }
      .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 80px;
        font-size: 25px;
    }
    .product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 14px;
     font-weight: bold;
}    
  .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 80px;
        font-size: 25px;
    }
    .product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 14px;
     font-weight: bold;
}
    .product-item {
    width: 170px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 120px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
        margin-bottom: 5px;
    color: #000000;
    font-size: 14px;
     font-weight: bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
}

@media (max-width: 395px) { 
  /* HEADER*/
  .logo-container img
   {
   margin-left:0px;
  }
  .logo-container img,
  .account-logo,
  .order {
    height: 30px; 
  }
 
  .more-logo,
   .scanner-logo img{
    height: 35px; 
  }

  .account-logo
   {
    margin-left:5px;
  }
  .user-options {
   
    gap: 5px;
}
 .category-list {
    margin:10px;
  }

.search-bar {
   
   left: 70px;
   z-index: 10;
   width: 60%;
 }
 /* Categories*/
 .category-list {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: nowrap;
    flex-direction: row;
}
  .category-item img {
    width: 100px;
    height: 100px;
    object-fit: contain;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}
.categories h2 {
    font-size: 20px;
    margin-bottom: 20px;
}
.category-item {
  
    max-width: 100px;
}
}

@media (max-width: 391px) { 
  /*Header*/
  .second-logo{
    margin-right:0px;
  }
  .second-logo img{
    margin-right:10px;
      margin-left:80px;
      margin-top:0px;
  }
  /*Header*/
  .search-bar {
  margin-left: 0px;
 margin-right: 0px;
 }
.search-bar input {
  width:100%;
  font-size:10px;
   border-radius: 20px;
   padding: 10px;
}
  .dropdown{
top:20px;
gap:10px;
 }
 .dropdown-content a {
        font-size:12px;
    }
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 50px;
    margin-right: 12px;
    }
   .order {
        top: 55px;
        right: 138px;
        position: absolute;
    }
        .more-logo {
       margin-right: 1px;
        height: 50px;
        margin-top: -5px;
    }
        .logout{
  margin-left:15px;
 }
  /*Header*/
    .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 70px;
        font-size: 25px;
    }
.product-item {
    width: 160px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 80px;
  }
.product-item h3 {
    margin-top: 3px;
    font-size: 14px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 12px;
    font-weight:bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
    .featured-products {
    padding-top: 10px;
    padding-right: 30px;
    padding-bottom: 30px;
    padding-left: 30px;
    text-align: center;
}
.categories {
   
    padding-top: 30px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
    text-align: center;
    margin-top: 30px;
}
.featured-products h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    .menu-btn {
  font-size: 35px;
  background: none;
  border: none;
  color: gray;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
/* LOGO */
.logo {
  margin: 0 auto;
  font-size: 20px;
  font-weight: bold;
}
}

@media (max-width: 376px) { 
  /*Header*/
  .second-logo{
    margin-right:0px;
  }
   .second-logo img{
    margin-top:0px;
    margin-right:10px;
margin-left:50px;
  }
  /*Header*/
  .search-bar {
  margin-left: 0px;
  margin-right:0px;
 }
.search-bar input {
  width:100%;
  font-size:10px;
   border-radius: 20px;
}
  .dropdown{
top:20px;
gap:10px;
 }
 .dropdown-content a {
       
        font-size:12px;
    }
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 50px;
    margin-right: 12px;
    
    }
   .order {
        top: 55px;
        right: 138px;
        position: absolute;
    }
        .more-logo {
       margin-right: 1px;
        height: 50px;
        margin-top: -5px;
    }
    
        .logout{
  margin-left:15px;
 }
  /*Header*/
      .bulky-shoes h2 {
        margin-top: 10px;
        width: 200px;
        margin-left: 60px;
        font-size: 25px;
    }
.product-item {
    width: 150px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 80px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 12px;
     font-weight: bold;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
    font-size: 12px;
}
    .featured-products {
    padding-top: 10px;
    padding-right: 30px;
    padding-bottom: 30px;
    padding-left: 30px;
    text-align: center;
}
.categories {
   
    padding-top: 30px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
    text-align: center;
    margin-top: 30px;
}
.featured-products h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    .menu-btn {
  font-size: 35px;
  background: none;
  border: none;
  color: gray;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
/* LOGO*/
.logo {
  margin: 0 auto;
  font-size: 20px;
  font-weight: bold;
}
}

@media (max-width: 361px) { 
  /*Header*/
  .second-logo{
    margin-right:0px;
  }
  .second-logo img{
    margin-right:10px;
     margin-left:60px;
     margin-top:0px;
  }
  /*Header*/
  .search-bar {
  margin-right: -10px;
  margin-left:0px;
 }
.search-bar input {
  width:70%;
  font-size:10px;
   border-radius: 20px;
}
  .dropdown{
top:20px;

gap:10px;
 }
 .dropdown-content a {
       
        font-size:12px;
    }
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 50px;
    margin-right: 12px;
    
    }
   .order {
        top: 55px;
        right: 138px;
        position: absolute;
    }
        .more-logo {
       margin-right: 1px;
        height: 50px;
        margin-top: -5px;
    }
    
        .logout{
  margin-left:15px;
 }
  /*Header*/
.product-item {
    width: 150px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 100px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 16px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 12px;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
    .featured-products {
    padding-top: 10px;
    padding-right: 30px;
    padding-bottom: 30px;
    padding-left: 30px;
    text-align: center;
}
.categories {
    padding-top: 30px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
    text-align: center;
    margin-top: 30px;
}
.featured-products h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    .menu-btn {
  font-size: 35px;
  background: none;
  border: none;
  color: gray;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
/* LOGO */
.logo {
  margin: 0 auto;
  font-size: 20px;
  font-weight: bold;
}
}

@media (max-width: 345px) { 
  /*Header*/
  .second-logo{
    margin-right:0px;
  }
  .second-logo img{
    margin-right:0px;
    margin-left:50px;
    margin-top:0px;
  }
  /*Header*/
  .search-bar {
  margin-right: -10px;
    margin-left: 10px;
 }
.search-bar input {
  width:100%;
  font-size:10px;
   border-radius: 20px;
}
  .dropdown{
top:20px;

gap:10px;
 }
 .dropdown-content a {
        font-size:12px;
    }
  .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 50px;
    margin-right: 12px;
    
    }
   .order {
        top: 55px;
        right: 138px;
        position: absolute;
    }
        .more-logo {
       margin-right: -5px;
        height: 55px;
        margin-top: -5px;
    }
    
        .logout{
  margin-left:15px;
 }
  /*Header*/
.product-item {
    width: 140px;
   height: auto;
}
.product-item img {
    width: 100%;
    height: 100px;
}
.product-item h3 {
    margin-top: 1px;
    font-size: 14px;
}
.product-item p {
    margin-top: 5px;
    color: #000000;
    font-size: 12px;
}
.product-item button {
    padding: 5px;
    margin-top:3px;
}
    .featured-products {
    padding-top: 10px;
    padding-right: 30px;
    padding-bottom: 30px;
    padding-left: 30px;
    text-align: center;
}
.categories {
   
    padding-top: 30px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
    text-align: center;
    margin-top: 30px;
}
.featured-products h2 {
        font-size: 20px;
        margin-bottom: 20px;
    }
    .menu-btn {
  font-size: 35px;
  background: none;
  border: none;
  color: gray;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
/*  LOGO */
.logo {
  margin: 0 auto;
  font-size: 20px;
  font-weight: bold;
}
}

@media (max-width:321px){
    .home-logo{
  margin-top: 5px;
    }
    .more-logo {
  margin-left: 10px;
        height: 50px;
        margin-top: -15px;

}

    .header-icons{
       position: absolute;
  top: 60px;
  left: 10px;
    }
  
   .search-bar {
    margin-left: -200px;
 }
     .order {
        top: 60px;
        right: 110px;
        position: absolute;
    }
     .logout{
position: relative;
        top: -20px;
        left:10px;
 }
  .user-options .scanner-logo{
position: relative;
        top: -20px;
        left: 0px;
 }
   .dropdown{
     position: absolute;
          margin-top: -4px;
        margin-left: 230px;
 }
       .dropdown-content {
    display: none;
    position: absolute;
    min-width: 130px;
    box-shadow: 0px 8px 16px rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    margin-top: 40px;
    margin-right: 5px;
    }
 /*header*/
    .bulky-shoes{
      margin-top:20px;
    }
    .bulky-shoes h1{
      margin-top:30px;
      width:200px;
      margin-left:30px;
      font-size:20px;
    }
     .product-item {
        width: 130px;
        height: 180px;
    }
        .product-item button {
        padding: 3px;
    }
     .product-item img {
    
        height: 80px;
    }
    .product-item p {
        margin-top: 5px;
        color: #000000;
        font-size: 12px;
    }
        .preorder-form .form-container {
        width: 280px;
    }
        .search-bar input {
        font-size: 9px;
        margin-left: -30px;
        width: 50%;
        border-radius: 12px;
        }
            .search-bar button {
        font-size: 10px;
                margin-left: -10px;
    }
  }

@media (max-width: 2560px) {
  .menu-btn { display: block; }
.menu-btn {
  font-size: 28px;
  background: none;
  border: none;
  color: gray;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
.sidebar {
  position: fixed;
  top: 0;
  left: -260px;
  width: 260px;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.4); 
  color: white;
  transition: all 0.4s ease;
  z-index: 9999;
  padding-top: 60px;
  border-top-right-radius: 30px;
  border-bottom-right-radius: 30px;
  box-shadow: 4px 0 15px rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 25px; 
}

.sidebar .close-btn {
  position: absolute;
  top: 15px;
  right: 20px;
  left: auto !important; 
  background: none;
  border: none;
  color: white;
  font-size: 26px;
  cursor: pointer;
  transition: transform 0.2s ease;
  margin: 0;
  padding: 0;
  width: auto;
  height: auto;
}

.sidebar .close-btn:hover {
  transform: rotate(90deg);
  color: #ffffff;
}
.sidebar.active {
  left: 0;
  backdrop-filter: blur(5px);
}

.sidebar a {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 5px;
  width: 80%;
  padding: 10px 0;
  text-decoration: none;
  color: white;
  font-size: 15px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  border-left: 4px solid transparent;
  border-radius: 10px;
  transition: all 0.3s ease;
}

.sidebar a img {
  width: 30px;
  height: 30px;
}
.menu-btn {
  font-size: 28px;
  background: none;
  border: none;
  color: #bebcbaff;
  cursor: pointer;
  display: none;
  position: absolute;
  left: 20px;
  transition: transform 0.2s ease;
}
.sidebar a:hover {
  background-color: rgba(255,255,255,0.1);
  border-left: 4px solid white;
  transform: translateX(5px);
}
.menu-btn:hover {
  transform: scale(1.2);
  color: white;
}
}

@media (max-width: 2560px) {
  .menu-btn {
     display: block; 
  }.logout-btn {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
  padding: 10px 25px;
  background-color: transparent; 
  color: white;
  border: 2px solid rgba(255, 255, 255, 0.7); 
  border-radius: 50px; 
  cursor: pointer;
  font-weight: bold;
  text-align: center;
  font-size: 14px;
  transition: all 0.3s ease;
}
.logout-btn:hover {
  background-color: rgba(255, 255, 255, 0.1); 
  transform: scale(1.05);
}
}
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.88);
  display: none;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  z-index: 9999;
}

.loader-logo-container {
  position: relative;
  width: 120px;
  height: 120px;
}

.loader-logo-container img {
  width: 85px;
  height: 85px;
  object-fit: contain;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  filter: drop-shadow(0 0 3px white);
}

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.88);
  display: none;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  z-index: 9999;
}

.loader-logo-container {
  position: relative;
  width: 130px;   
  height: 130px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader-logo-container img.loader-logo {
  width: 85px;
  height: 85px;
  object-fit: contain;
  z-index: 2; 
}

.rotate-ring {
  position: absolute;
  width: 130px;
  height: 130px;
  border-radius: 50%;
  border: 5px solid transparent;
  background: conic-gradient(
      from 0deg,
      rgba(255,255,255,0.1),
      white,
      rgba(255,255,255,0.1)
  );
  animation: spin 0.9s linear infinite;
  mask: radial-gradient(circle, transparent 60%, black 61%);
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.loading-text {
  margin-top: 25px;
  color: white;
  font-size: 22px;
  font-weight: 500;
  letter-spacing: 2px;
  text-shadow: 0 0 10px rgba(255,255,255,0.6);
}

  </style>
</head>
<body>

  <header class="header">
        <button class="menu-btn" onclick="toggleSidebar()">☰</button>

      <div class="second-logo">
        <img src="image/logo1.png" alt="Shoe Store Logo" />
      </div>

   <form class="search-bar" method="GET" action="">
  <input type="text" name="search" placeholder="Search for shoes..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
  <button type="submit">Search</button>
</form>

  <div class="dropdown">
   
       <button class="dropbtn">
    <img src="image/more.png" alt="More Options" class="more-logo">
  </button>

  <div class="dropdown-content">
    <a href="classic.php">Classic Shoes</a>
    <a href="basketball.php">Basketball Shoes</a>
    <a href="running.php">Running Shoes</a>
    <a href="slide.php">Slides</a>
  </div>
  </div>

<div id="reviewModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999;">
  <div style="background: rgba(0, 0, 0, 0.2);

 padding:20px; max-width:400px; margin: 150px auto; border-radius:8px; text-align:center; position:relative; z-index:10000;">
    
    <button id="closeModal" style="position:absolute; top:10px; right:10px; background:none; border:none; color:white; font-size:24px; cursor:pointer;">&times;</button>

    <h2>Rate your experience</h2>
    
    <div id="starRating" style="font-size:30px; cursor:pointer; color:yellow;">
      <span data-value="1">&#9734;</span>
      <span data-value="2">&#9734;</span>
      <span data-value="3">&#9734;</span>
      <span data-value="4">&#9734;</span>
      <span data-value="5">&#9734;</span>
    </div>
    
    <textarea id="comment" placeholder="Write your comment here..." style="width:100%; margin-top:15px;" rows="4"></textarea>
    
    <button id="submitReview" style="margin-top:15px;">Submit Review & Logout</button>
  </div>
</div>

<script>

function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("active");
}
function toggleSidebar() {
  document.getElementById("sidebar").classList.toggle("active");
}

document.addEventListener("click", function(event) {
  const sidebar = document.getElementById("sidebar");
  const menuBtn = document.querySelector(".menu-btn");

  if (
    sidebar.classList.contains("active") &&
    !sidebar.contains(event.target) &&
    !menuBtn.contains(event.target)
  ) {
    sidebar.classList.remove("active");
  }
});

  document.addEventListener("DOMContentLoaded", function () {
    const email = "<?php echo $_SESSION['user']['email']; ?>";
    const hasReview = <?php echo $hasReview === 'true' ? 'true' : 'false'; ?>;

    const logoutBtn = document.getElementById('logout-button');
    const modal = document.getElementById('reviewModal');
    const stars = document.querySelectorAll('#starRating span');
    const commentInput = document.getElementById('comment');
    const submitBtn = document.getElementById('submitReview');
    const closeModalBtn = document.getElementById('closeModal');

    let selectedRating = 0;

    logoutBtn.addEventListener('click', function (e) {
      e.preventDefault(); 

      if (hasReview) {
        const confirmLogout = confirm("Do you want to logout?");
        if (confirmLogout) {
          window.location.href = "login.php";
        }
      } else {
        modal.style.display = 'block';
      }
    });

    closeModalBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    stars.forEach(star => {
      star.addEventListener('mouseover', () => {
        const val = star.getAttribute('data-value');
        highlightStars(val);
      });
      star.addEventListener('mouseout', () => {
        highlightStars(selectedRating);
      });
      star.addEventListener('click', () => {
        selectedRating = star.getAttribute('data-value');
        highlightStars(selectedRating);
      });
    });

    function highlightStars(rating) {
      stars.forEach(star => {
        star.innerHTML = star.getAttribute('data-value') <= rating ? '★' : '☆';
        star.style.color = star.getAttribute('data-value') <= rating ? 'gold' : 'gray';
      });
    }

    submitBtn.addEventListener('click', () => {
      if (selectedRating === 0) {
        alert('Please select a star rating.');
        return;
      }
      const comment = commentInput.value.trim();

      fetch('user_reviews.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: email,
          rating: selectedRating,
          comment: comment
        })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          alert("Thank you for your review! You will now be logged out.");
          window.location.href = "login.php";
        } else {
          alert("Failed to submit review.");
        }
      })
      .catch(err => {
        alert("Error submitting review.");
        console.error(err);
      });
    });
  });

</script>

    </div>
  </header>


  <div id="sidebar" class="sidebar">
  <button class="close-btn" onclick="toggleSidebar()">×</button>
  <a id="angular" href="angular-ar/index.html"><img src="image/try1.png" alt="Try On"><span>Try On</span></a>
  <a id="addtocart" href="addtocart.php"><img src="image/cart.png" alt="Cart"><span>Cart</span></a>
  <a id="orderuser" href="orderuser.php"><img src="image/orders.png" alt="Orders"><span>Orders</span></a>
  <a id="scan" href="scan.php"><img src="image/logo4.png" alt="Scan"><span>Scan</span></a>
  <a id="account" href="account.php"><img src="image/account.png" alt="Profile"><span>My Info</span></a>
  <div class="logout-container">
  <button class="logout-btn" id="logout-button">Logout</button>
</div>

</div>

 <section class="bulky-shoes" id="classic-feet">
  
<a href="home.php">
    <img src="image/home1.png" alt="home-logo" class="home-logo">
  </a>
  <h2>Classic Shoes</h2>
  <div class="product-list">
    <?php
    $search = isset($_GET['search']) ? $mysqli->real_escape_string($_GET['search']) : '';
    $query = "SELECT * FROM inventory WHERE shoe_type LIKE '%classic%'";
    if (!empty($search)) {
      $query .= " AND shoe_name LIKE '%$search%'";
    }
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="product-item">
          <img src="' . htmlspecialchars($row['shoe_image']) . '" alt="' . htmlspecialchars($row['shoe_name']) . '">
          <h3>' . htmlspecialchars($row['shoe_name']) . '</h3>
          <p>SRP: ' . htmlspecialchars($row['price']) . '</p>

          <!-- Hidden fields -->
          <span class="shoe-id" hidden>' . htmlspecialchars($row['id']) . '</span>
          <span class="shoe-type" hidden>' . htmlspecialchars($row['shoe_type']) . '</span>

          <button class="inquire-btn"
            data-id="' . htmlspecialchars($row['id']) . '"
            data-name="' . htmlspecialchars($row['shoe_name']) . '"
            data-type="' . htmlspecialchars($row['shoe_type']) . '"
            data-price="' . htmlspecialchars($row['price']) . '"
            data-image="' . htmlspecialchars($row['shoe_image']) . '">
            Inquire
          </button>
        </div>';
      }
    } else {
      echo '<p>No Classic shoes matched your search.</p>';
    }
    ?>
  </div>
</section>

<div class="preorder-form" id="preorder-form" style="display:none;">
  <div class="form-container">
    <h3>Pre-Order for <span id="product-name"></span></h3>
    <form id="preorder-form-content" method="POST" action="submit_inquiry.php">
      <div class="user-info">
        <div class="user-info-item">
          <span class="text">Name: <?php echo htmlspecialchars($user['username']); ?></span>
          <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
          <input type="hidden" name="province" value="<?php echo htmlspecialchars($user['province']); ?>">
          <input type="hidden" name="municipality" value="<?php echo htmlspecialchars($user['municipality']); ?>">
          <input type="hidden" name="barangay" value="<?php echo htmlspecialchars($user['barangay']); ?>">
          <input type="hidden" name="street" value="<?php echo htmlspecialchars($user['street']); ?>">
        </div>
        <div class="user-info-item">
          <span class="text">Email: <?php echo htmlspecialchars($user['email']); ?></span>
          <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
        </div>
        <div class="user-info-item">
          <span class="text">Contact Number: <?php echo htmlspecialchars($user['phone']); ?></span>
          <input type="hidden" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
        </div>

        <div class="user-info-item">
          <span class="text">Unit Price: ₱<span id="unit-price-display">0.00</span></span>
        </div>

        <div class="user-info-item">
          <span class="text"><strong>Total Price: ₱<span id="total-price">0.00</span></strong></span>
        </div>

        <div class="user-info-item1">
          <textarea name="message" placeholder="Your Message"></textarea>
        </div>

        <select name="size" required>
          <option value="" disabled selected>Select Shoe Size</option>
        </select>

        <div class="quantity-selector">
          <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>
          <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
          <button type="button" class="qty-btn" onclick="increaseQty()">+</button>
        </div>
      </div>

      <input type="hidden" id="shoe_id" name="shoe_id">
      <input type="hidden" id="shoe_type" name="shoe_type">
      <input type="hidden" id="shoe_name" name="shoe_name">
      <input type="hidden" id="price" name="price">
      <input type="hidden" id="shoe_image" name="shoe_image">
       <input type="hidden" name="return_url" value="classic.php">

      <button type="submit">Submit Pre-Order</button>
      <button type="button" id="add-to-cart-modal-btn">Add to Cart</button>
    </form>

    <button class="close-btn" onclick="closeForm()">Close</button>
  </div>
</div>

<footer class="footer">
  <p>&copy; DEFINE YOUR STYLE WALK WITH CONFIDENCE.</p>
</footer>

<script>
let maxStock = 1;

function increaseQty() {
  const qtyInput = document.getElementById('quantity');
  const currentQty = parseInt(qtyInput.value);
  if (currentQty < maxStock) {
    qtyInput.value = currentQty + 1;
    updateTotalPrice();
  }
}

function decreaseQty() {
  const qtyInput = document.getElementById('quantity');
  const currentQty = parseInt(qtyInput.value);
  if (currentQty > 1) {
    qtyInput.value = currentQty - 1;
    updateTotalPrice();
  }
}

function updateTotalPrice() {
  const price = parseFloat(document.getElementById('price').value) || 0;
  const quantity = parseInt(document.getElementById('quantity').value);
  const total = price * quantity;
  document.getElementById('total-price').innerText = total.toFixed(2);
  document.getElementById('unit-price-display').innerText = price.toFixed(2);
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById('add-to-cart-modal-btn').addEventListener('click', () => {
    const shoeId = document.getElementById('shoe_id').value;
    const shoeName = document.getElementById('shoe_name').value;
    const shoeType = document.getElementById('shoe_type').value;
    const sizeSelect = document.querySelector('#preorder-form select[name="size"]');
    const quantity = document.getElementById('quantity').value;
    const price = document.getElementById('price').value;
    const shoeImage = document.getElementById('shoe_image').value;

    if (!sizeSelect || !sizeSelect.value) {
      alert("Please select a size before adding to cart.");
      return;
    }

    const size = sizeSelect.value;
    const formData = new FormData();
    formData.append('shoe_id', shoeId);
    formData.append('shoe_name', shoeName);
    formData.append('shoe_type', shoeType);
    formData.append('size', size);
    formData.append('quantity', quantity);
    formData.append('price', price);
    formData.append('shoe_image', shoeImage);

    fetch('addtocart.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(() => {
      alert(`${shoeName} (Size: ${size}, Qty: ${quantity}) has been added to your cart.`);
      document.getElementById('preorder-form').style.display = 'none';
    })
    .catch(error => {
      console.error('Error adding to cart:', error);
      alert('Failed to add to cart. Please try again.');
    });
  });

  const inquireButtons = document.querySelectorAll('.inquire-btn');
  const preorderForm = document.getElementById('preorder-form');
  const productNameSpan = document.getElementById('product-name');

  inquireButtons.forEach(button => {
    button.addEventListener('click', async () => {
      const shoeId = button.dataset.id;
      const shoeName = button.dataset.name;
      const shoeType = button.dataset.type;
      const price = button.dataset.price;
      const image = button.dataset.image;

      productNameSpan.textContent = shoeName;

      try {
        const response = await fetch(`get_sizes.php?shoe_id=${shoeId}&shoename=${encodeURIComponent(shoeName)}&shoetype=${encodeURIComponent(shoeType)}`);
        if (!response.ok) throw new Error("Failed to fetch sizes.");
        const sizesHTML = await response.text();

        const form = document.querySelector('#preorder-form form');
        const existingDropdown = form.querySelector('select[name="size"]');
        if (existingDropdown) existingDropdown.remove();

        const messageBox = form.querySelector('textarea');
        if (messageBox) {
          messageBox.insertAdjacentHTML('beforebegin', sizesHTML);
        }

        form.querySelector('#shoe_id').value = shoeId;
        form.querySelector('#shoe_type').value = shoeType;
        form.querySelector('#shoe_name').value = shoeName;
        form.querySelector('#price').value = price;
        form.querySelector('#shoe_image').value = image;

        document.getElementById('quantity').value = 1;
        maxStock = 1;
        updateTotalPrice();
        preorderForm.style.display = 'flex';

        const sizeSelect = form.querySelector('select[name="size"]');
        sizeSelect.addEventListener('change', function () {
          const selectedOption = sizeSelect.selectedOptions[0];
          maxStock = parseInt(selectedOption.dataset.stock || "1");
          document.getElementById("quantity").value = 1;
          updateTotalPrice();
        });

      } catch (error) {
        alert('Error loading sizes. Please try again.');
        console.error(error);
      }
    });
  });
});

function closeForm() {
  document.getElementById('preorder-form').style.display = 'none';
}
</script>

<div class="loading-overlay" id="loadingScreen">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text">Directing to Try On...</div>
</div>

<script>
const btn = document.getElementById("angular");
const loading = document.getElementById("loadingScreen");
window.addEventListener('pageshow', function () {
    loading.style.display = 'none';
    sessionStorage.removeItem('loadingAngular');
});
btn.addEventListener("click", function(e) {
    e.preventDefault();
    loading.style.display = "flex";
    sessionStorage.setItem('loadingAngular', 'true');
    setTimeout(() => {
        window.location.href = btn.href;
    }, 200);
});
</script>

<div class="loading-overlay" id="loadingScreenAddCart">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text">Directing to Cart...</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById("addtocart");
    const loading = document.getElementById("loadingScreenAddCart");

    window.addEventListener('pageshow', function () {
        loading.style.display = 'none';
        sessionStorage.removeItem('loadingAddCart');
    });

    btn.addEventListener("click", function(e) {
        e.preventDefault();
        loading.style.display = "flex";
        sessionStorage.setItem('loadingAddCart', 'true');
        setTimeout(() => {
            window.location.href = btn.href;
        }, 200);
    });
});
</script>

<div class="loading-overlay" id="loadingScreenOrders">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text">Directing to Orders...</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnOrders = document.getElementById("orderuser");
    const loadingOrders = document.getElementById("loadingScreenOrders");

    window.addEventListener('pageshow', function () {
        loadingOrders.style.display = 'none';
        sessionStorage.removeItem('loadingOrders');
    });

    btnOrders.addEventListener("click", function(e) {
        e.preventDefault();
        loadingOrders.style.display = "flex";
        sessionStorage.setItem('loadingOrders', 'true');
        setTimeout(() => {
            window.location.href = btnOrders.href;
        }, 200);
    });
});
</script>

<div class="loading-overlay" id="loadingScreenScan">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text">Directing to Scan...</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnScan = document.getElementById("scan");
    const loadingScan = document.getElementById("loadingScreenScan");

    window.addEventListener('pageshow', function () {
        loadingScan.style.display = 'none';
        sessionStorage.removeItem('loadingScan');
    });

    btnScan.addEventListener("click", function(e) {
        e.preventDefault();
        loadingScan.style.display = "flex";
        sessionStorage.setItem('loadingScan', 'true');
        setTimeout(() => {
            window.location.href = btnScan.href;
        }, 200);
    });
});
</script>

<div class="loading-overlay" id="loadingScreenAccount">
    <div class="loader-logo-container">
        <img src="image/logo1.png" alt="Logo">
        <div class="rotate-ring"></div>
    </div>
    <div class="loading-text">Directing to My Info...</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAccount = document.getElementById("account");
    const loadingAccount = document.getElementById("loadingScreenAccount");

    window.addEventListener('pageshow', function () {
        loadingAccount.style.display = 'none';
        sessionStorage.removeItem('loadingAccount');
    });

    btnAccount.addEventListener("click", function(e) {
        e.preventDefault();
        loadingAccount.style.display = "flex";
        sessionStorage.setItem('loadingAccount', 'true');
        setTimeout(() => {
            window.location.href = btnAccount.href;
        }, 200);
    });
});
</script>

</body>
</html>
