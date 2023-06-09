<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accessories</title>
    <link rel="icon" href="images/allite-logo-2-black-icon.png"/>
    <!--main design css file-->
    <link rel="stylesheet" href="css/Allite.css" />
    <!--render all elements normally-->
    <link rel="stylesheet" href="css/normalize.css" />
    <!--Font Awesome library-->
    <link rel="stylesheet" href="css/all.min.css" />
    <!--google fonts-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <!-- header section starts  -->
    
    <header>
        <a href="User-Home.html" class="logo"><img src="images/allite-logo-2-black.png" alt="logo"></a>

        <nav class="navbar">
            <a href="Phones.html"><i class="fa-solid fa-mobile-button"></i> Phones</a>
            <a href="Laptops.html"><i class="fa-solid fa-laptop"></i> Laptops</a>
            <a href="Accessories.html" style="color: #B8072D;"><i class="fa-solid fa-headphones"></i> Accessories</a>
            <a href="wishlist.html"><i class="fa-regular fa-heart"></i></a>
        </nav>

        <div class="icons"  >
            <span>
                 <div class="user-im">
                    <a href="user-profile.html" ><img src="images/Avatar/403019_avatar_male_man_person_user_icon.png" alt="">
                        <h3 style="font-size:11px ;">Hi Mohamed</h3>  </a>
        </div>
            </span>
            <i class="fas fa-bars toggle-menu"></i>
            <ul>
                <li><a href="Phones.html"> Phones</a></li>
                <li><a href="Laptops.html">Laptops</a></li>
                <li><a href="Accessories.html"> Accessories</a></li>
                <li><a href="wishlist.html">Wish list</a></li>
                <li><a href="user-profile.html"> user profile </a></li>
            </ul>
        </div>
       

    
    </header>
    
    <!-- header section ends -->
    
    <!-- home section starts  --> 
    
    <div class="filters-nave" >
    
            <a href="accessories-highest-rating.html"><i class="fa-sharp fa-solid fa-star"></i> Highest Rating</a>
            <a href="accessories-best-seller.html"><i class="fa-solid fa-tags"></i> Best Seller</a>
           <div class="store"> 
            <a href="#"><i class="fa-sharp fa-solid fa-store"></i> Stores</a>
            <ul>
                <li><a href="accessories-stores-amazon.html"> Amazon</a></li>
                <li><a href="accessories-stores-jumia.html">Jumia</a></li>
                <li><a href="accessories-stores-noon.html"> Noon</a></li>
                <li><a href="accessories-stores-2b.html">2B</a></li>
                
            </ul>
        </div>
       
        
    </div>

    <!-- home section end -->
    
    <!-- prodcuts section starts  -->
    
    <section class="products" id="products">
    
        <h1 class="heading"> latest <span>products</span> </h1>
    
      
        <div class="box-container">
      
      
      
      
      
      
      
        <?php

$username = "root";
$password = "";
$database = new PDO("mysql:host=localhost; dbname=allite;",$username,$password);

$sql =$database->prepare("SELECT * FROM product WHERE product_type='accessorie' AND rating='5' "); 

$sql->execute();




$id_user = 1;    // sission_id        مؤقته

//  

// 


$sql =$database->prepare("SELECT * FROM wishlist WHERE user_id=$user_id");       $sql->execute();
 foreach ($sql as $value) {

    $sql_2 =$database->prepare("SELECT * FROM product WHERE product_id=$value->product_id"); 
    $sql_2->execute();
 }



foreach($sql AS $result){
    echo '
    <div class="box">
    <span class="discount">-15%</span>
    <div class="image">
    <img src= ' . $result["photo"] .' alt="">
   
                <div class="icons">

                <style>
                
                .div_favorite{
                    background: #B8072D;
                    width: 35%;


                }
                .div_favorite:hover{
                  
                    background-color: #333;


                }
                .div_favorite button{
                    font-size: 38px;
                    border: none;
                    background: none;
                    color: white;
                }
                </style>


                <div  class="div_favorite">
                

                            <form action="wishlist.php" method="POST">
                            

                            <input type="hidden" name="id_prodect" value="'.$result['product _id'].'">
                            <input type="hidden" name="id_user" value="'.$id_user.'">
                            <button type="submit" name="favorite" class="favorite_btn"> <i class="ri-heart-line"></i></button>
                        
                            </form>
                </div>


                <a href="Compare.html">Compare</a>
                <a  href= ' . $result["link"] .'  target="_Blank">Buy Now</a>
                </div>
        </div>
        <div class="content">
            <p> ' . $result["product_name"] .'</p>
            <h3 style="padding: 0 0 5px 0;">' . $result["store_name"] .' </h3>

            
                <span style="color:#f6b01e;">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>                    

                <span> (' . $result["rating"] .'/5) </span>
               </span>
               
               <div class="price"> ' .$result["price"] . ' </div>

               
        </div>
            </div>
  '; 
}

    


 ?>

 

            
    
           
        </div>
    
    </section>
    
    <!-- prodcuts section ends -->
    
<!--Footer-->
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>Sections</h4>
                <ul>
                    <li><a href="index.php">home</a></li>
                    <li><a href="about-us.php">about us</a></li>
                    <li><a href="user-profile.php">profile</a></li>
                    <li><a href="wishlist.php">wishlist</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>categories</h4>
                <ul>
                    <li><a href="Phones.php">Phones</a></li>
                    <li><a href="Laptops.php">Laptops</a></li>
                    <li><a href="Accessories.php">Accessories</a></li>
                    <li><a href="User-Home.php">Search</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>follow us</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>
    <!--Footer End-->
    
    
    
    
    
    
    
    
    
    
    
    
        
    </body>
    </html>