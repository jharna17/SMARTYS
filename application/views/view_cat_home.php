<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        
        <title><?php echo $categoryname; ?></title>
        
         <script>
            /* When the user clicks on the button,
            toggle between hiding and showing the dropdown content */
            function myFunction() {
                document.getElementById("myDropdown").classList.toggle("show");
            }

            // Close the dropdown if the user clicks outside of it
            window.onclick = function(event) {
              if (!event.target.matches('.dropbtn')) {

                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                  var openDropdown = dropdowns[i];
                  if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                  }
                }
              }
            }
        </script>
        
        <style>
            
            #sugart {
                background-color: #a3d4f5;
                color: white;
                padding: 16px;
                font-size: 20px;
                border: none;
                cursor: pointer;
                width: fit-content;
                display: inline-block;
            }
            .dropbtn {
                background-color: #4CAF50;
                color: white;
                padding: 16px;
                font-size: 16px;
                border: none;
                cursor: pointer;
                width: fit-content;
                display: inline-block;
            }

            .dropbtn:hover, .dropbtn:focus {
                background-color: #3e8e41;
            }

            .dropdown {
                position: relative;
                width: 100%;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                //position: absolute;
                background-color: #f9f9f9;
                overflow: auto;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }
            
            .category-box{
                display: inline-block;
                height: auto;
                width: 250px;
                vertical-align: top;
            }
            .category-box a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                //margin-right: 200px;
            }

            .category-box a:hover {background-color: #f1f1f1}

            .show {display:block;}
            
            #header{
                border: solid 2px black;
                height: auto;
                padding: 5px 10px;
            }

            #lefttop{
                border: solid 2px blue;
                height: auto;
                width: 175px;
                display: inline-block;
            }

            #icon{
                border: solid 1px blueviolet;
                height: 20px;
                width: 20px;
                display: inline-block;
            }
            
            #name{
                height: 25px;
                width: 70px;
                //font-size: 50px;
                font-family: sans-serif;
                display: inline-block;
            }
            
            #caption{
                height: 25px;
                width: 175px;
                display: inline-block;                
            }
            
            #righttop{
                border: solid 1px lime;
                display: inline-block;
                float: right;
            }
            
            .clear{
                clear: both;
            }
            
            #topnav{
                height: auto;
                border: solid 1px lightcoral;
                padding: 0 10px;
            }
            
            /*.dropdown{
                border: solid 2px lime;
                height: 25px;
                width: 25px;
                text-align: center;
                display: inline-block;
            }*/
            
            #righttopnav{
                display: inline-block;
                float: right;
                border: solid 1px black;
            }
            
            #homearticle{
                border: solid 2px black;
                height: auto;
                font-family: monospace;
                background: blanchedalmond;
                color: blueviolet;
                padding-left: 10px;
                padding-right: 10px;
            }
            
            #allsubcat{
                border: solid 1px blue;
                height: auto;
                width: 100%;
                background: #f6f6f6;
            }
            
            #allsubcat a{
                display: inline-block;
                width: 25%;
                margin-right: 3%;
                color: #000066;
            }
            
            #allsubcat a:hover{
                background: #ffffff;
            }
            
            #featured-articles{
                width: 80%;
                margin: 50px 10%;
                
                border: solid 1px black;
                height: auto;
            }
            #featured-articles h1{
                background: #ffff99;
                color: brown;
                height: auto;
                margin: 0;
            }
            
            #featured-articles h2{
                background: #ffffcc;
                color: brown;
                height: auto;
                margin: 0;
            }
            
            #featured-articles pre{
                background: wheat;
                color: #ff3333;
                margin: 0;
                height: 100px;
                overflow-y:  scroll;
       
            #featured-articles{
                width: 80%;
                margin: 50px 10%;
                
                border: solid 1px black;
                height: auto;
            }
            #featured-articles h1{
                background: #ffff99;
                color: brown;
                height: auto;
                margin: 0;
            }
            
            #featured-articles h2{
                background: #ffffcc;
                color: brown;
                height: auto;
                margin: 0;
            }
            
            #featured-articles pre{
                background: wheat;
                color: #ff3333;
                margin: 0;
                height: 100px;
                overflow-y:  scroll;
            }
        </style>
    </head>
    <body>
        <div id="header">
            <div id="lefttop">
                <img src="cf.jpg" id="icon" alt="">
                
                <div id="name">
                    SMARTYS.com
                </div>
                <div id="caption">
                    with the best advice here...
                </div>
            </div>
            
            <div id="righttop">
                <a id="adminlink" href="<?php echo site_url("home/adminlogin"); ?>">Admin</a>
                <a id="signuplink" href="<?php echo site_url("home/signup"); ?>">SignUp</a>
                <a id="loginlink" href="<?php echo site_url("home/userlogin"); ?>"> LogIn</a>
            </div>
           
        </div>
        <div id="topnav">
            
            
            
            <div id="righttopnav">
                <a href="<?php echo site_url("home/homepage"); ?>">Home</a>
                <a href="<?php echo site_url("home/aboutus"); ?>">About Us</a>
                <a href="<?php echo site_url("home/contacts"); ?>">Contacts</a>
            </div>            
            
            <button onclick="myFunction()" class="dropbtn">&#9776;</button>
            <div id='sugart'>
                <a>Suggest an article</a>
            </div>
            <div id="myDropdown" class="dropdown-content">
                
                    
                    <?php 
                        foreach ($allcat->result() as $row){
                    ?>
                            <div class="category-box">
                    <?php 
                                $location="home/category/".$row->categoryname;
                    ?>
                            <a href="<?php echo site_url($location);?>"> <?php echo $row->categoryname ;?></a>
                            <?php 
                            //$q=$cat_sub[$row->categoryname];
                            //print_r($q->row(0));
                            foreach ($cat_sub[$row->categoryname]->result() as $subcatofacat){
                                $location1="home/subcategory/".$subcatofacat->subcatname;
                            ?>
                                <a href="<?php echo site_url($location1);?>"><?php echo $subcatofacat->subcatname ?></a>
                            <?php 
                            }
                            ?>
                                </div>
                    <?php 
                        }
                    ?>
                
                   
            </div>       
        </div>
       
        <div id="allsubcat">
            <?php
                foreach ($cat_sub[$categoryname]->result() as $subcatofacat){
                                $location1="home/subcategory/".$subcatofacat->subcatname;
                            ?>
                                <a href="<?php echo site_url($location1);?>"><?php echo $subcatofacat->subcatname ?></a>
                            <?php 
                            }
            ?>
        </div>
            
        
        <?php print_r($this->session->userdata()); echo "<br>"; ?>
        <?php  foreach ($cat_sub[$categoryname]->result() as $subcatofacat){//loop starts for each subcategory 
            $location2="home/subcategory/".$subcatofacat->subcatname;
        ?> 
            <div id="featured-articles">
                <h1>
                    <a href="<?php echo site_url($location2)?>"><?php echo $subcatwiseart[$subcatofacat->subcatname]['subcat']; ?></a>
                    <!--Subcat name-->
                </h1>
                <h2>
                    <?php echo $subcatwiseart[$subcatofacat->subcatname]['author']; ?>
                    <!-- Heading of the aricle -->
                </h2>
                
                    <pre><?php echo $subcatwiseart[$subcatofacat->subcatname]['content']; ?>
                    <!-- Content of the article  /* max 30 words */ so then we'll remove the scrollbar -->
                    </pre>
                
            </div>    
                <?php }//loop ends?>
    </body>
</html> 