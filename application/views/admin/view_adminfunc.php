<html>
    <head>
        <title>Admin Functions</title>
    <script>
        function loadallusers(){
            var xhttp;
            xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function(){
                //document.getElementById("allusers").innerHTML= "<?//php echo 'rf3rf3'; ?>"
              if(xhttp.readyState===4 && xhttp.status===200){
                  document.getElementById("allusers").innerHTML=xhttp.responseText;
              }
              else{
                  document.getElementById("allusers").innerHTML= (xhttp.readyState)+" <?php echo 'rf3rf3'; ?> "+(xhttp.status);
              }
            };
            document.getElementById("allusers").innerHTML= "<?php echo 'czsxhgkj'; ?>"
            xhttp.open("GET", "<?php echo site_url('admin/viewallusers'); ?>", true);
            xhttp.send();
        }
        
        function loadallauthors(){
            var xhttp;
            xhttp=new XMLHttpRequest();
            xhttp.onreadystatechange=function(){
                //document.getElementById("allusers").innerHTML= "<?//php echo 'rf3rf3'; ?>"
              if(xhttp.readyState===4 && xhttp.status===200){
                  document.getElementById("allauthors").innerHTML=xhttp.responseText;
              }
              else{
                  document.getElementById("allauthors").innerHTML= (xhttp.readyState)+" <?php echo 'rf3rf3'; ?> "+(xhttp.status);
              }
            };
            document.getElementById("allauthors").innerHTML= "<?php echo 'czsxhgkj'; ?>"
            xhttp.open("GET", "<?php echo site_url('admin/viewallauthors'); ?>", true);
            xhttp.send();
        }
    </script>
    </head>
    <body>
       
        <button type="button" onclick="loadallusers()">
            View all users
        </button>
        <p id="allusers">
            
        </p>
        
        <button type="button" onclick="loadallauthors()">
            View all authors
        </button>
        <p id="allauthors">
            
        </p>
        
        <button type="button" onclick="loadallarticles()">
            View all articles
        </button>
        <table id="allarticles">
            
        </table>
        
    </body>
</html>