<html>
<head>
</head>
<body>
	<div id="topnav">        
            <div id="righttopnav">
                <a href="<?php echo site_url("member/homepage"); ?>">Home</a>
                <a href="<?php echo site_url("member/aboutus"); ?>">About Us</a>
                <a href="<?php echo site_url("member/contacts"); ?>">Contacts</a>
            </div>            
            
            <button onclick="myFunction()" class="dropbtn">&#9776;</button>
            <div id='sugart'>
                <a href="<?php echo site_url('member/suggestarticle'); ?>">Suggest an article</a>
            </div>
            <div id="myDropdown" class="dropdown-content">
                
                    
                    <?php 
                        foreach ($allcat->result() as $row){
                    ?>
                            <div class="category-box">
                    <?php 
                                $location="member/category/".$row->categoryname;
                    ?>
                            <a href="<?php echo site_url($location);?>"> <?php echo $row->categoryname ;?></a>
                            <?php 
                            //$q=$cat_sub[$row->categoryname];
                            //print_r($q->row(0));
                            foreach ($cat_sub[$row->categoryname]->result() as $subcatofacat){
                                $location1="member/subcategory/".$subcatofacat->subcatname;
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