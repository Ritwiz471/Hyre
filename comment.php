<?php

session_start() ; 
include 'config.php' ; 

$workerID ="" ;
if( isset($_GET['workerID'] ) ){ 
    $workerID = $_GET['workerID'] ; 
}

$jobID = 0 ;
if( isset($_GET['jobID'] ) ){ 
    $jobID = $_GET['jobID'] ; 
}


if( $_SESSION['userType'] == "C" ){
    if(isset($_POST['submit'])){ 

        $workerID = $_POST['workerID'] ;
        
        //we can another query here to check if the job matches with the worker.
        //have to implement this later.

        $query = "SELECT * FROM worker WHERE workerID = '$workerID' " ; 
        $result = $conn->query($query) ; 

        if( $result->num_rows ){ // ($resultSet->num_rows != 0)
            //If there exist a worker with that id, continue.

            $row = mysqli_fetch_assoc($result) ; 
            $workerID = $_POST['workerID'] ; 
            $description = $_POST['description'] ;
            $jobID = $_POST['jobID'] ;
            $clientID = $_SESSION['ID'] ;
            echo $workerID . "-------" ;
            echo $clientID . "-------" ;
            echo $description . "-------" ;
            echo $jobID ;
            //not working.
            $insertCommentQuery = "INSERT INTO comment (jobID, workerID, clientID, description) values($jobID, '$workerID', '$clientID', '$description') "  ; 
            $in = "insert into comment values(1,'sdff','asdf',adf') ";
            $result2 = $conn->query($insertCommentQuery) ;
            echo("Error description: " . $conn->error);
            if( $result2  ){ 
                echo "hellw" ;
                echo"<script>alert('Comment made successfully. Redirecting to worker's profile.') </script>" ; 
                echo"<script>document.location='workerProfile.php?workerID=$workerID'</script>" ;

            }else{ 
                echo"<script>alert('Comment made successfully. Redirecting to worker's profile.') </script>" ; 
                //echo"<script>alert('Unable to make a comment. Try again Late.Redirecting to main lobby.')</script>" ; 
                //echo"<script>document.location='mainlobby.php'</script>" ;
            }  

        }
        else{ 
            //echo mysqli_error($conn);
            $error = 'Invalid workerID. Try again.' ; 
            //echo"<script>document.location='jointeam.php'</script>" ; 
        }   
        $conn->close();
    }   
}
else if( $_SESSION['userType'] == "W" ){
    header("location:mainlobby.php") ;
}
else{ 
    header("location:index.html") ; 
}

?>



<!DOCTYPE html>
<html>
  <head>
    <title>Comment</title>
    <link rel="stylesheet" type="text/css" href="1Level/darkTheme.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   
    <script src="1Level/validation.js"></script>
  </head>


  <body onload="newCaptcha()">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!--navbar-expand aligns all components horizontally displayed-->
        <a class="navbar-brand ms-4" href="index.html">Hyre</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleButton" aria-controls="navbarToggleButton" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <div class="collapse navbar-collapse" id="navbarToggleButton">
          <ul class="navbar-nav px-4 ms-auto"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="index.html">About</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
          <li class="nav-item"><a class="nav-link" href="1Level/contact.html">Contact</a></li>
      </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="1Level/login.php">Login</a></li>
        </ul>
        <ul class="navbar-nav px-4"> <!--from documentation-->
            <li class="nav-item"><a class="nav-link" href="1Level/signup.php">Signup</a></li>
        </ul>
       
        </div>
        <!--COMPLETE THIS REPORT AND SIGN OUT WITH NAVEEN -->
    </nav>
    <form action="" method="POST" autocomplete="off" >
      <div class="form">

        <h2>(to be filled)</h2>
        <p><?php echo $error ; ?></p>
            
        <div class="fname">
          <label for="workerID">Worker ID</label><br>
          <input type = "text" id="workerID" name="workerID" placeholder="Eg: fhsd8sfdfkj242Gsf23423" value='<?php echo $workerID ?>' required readonly> <br>
        </div>
        <div class="fname">
          <label for="jobID">Job ID</label><br>
          <input type = "text" id="jobID" name="jobID"  value='<?php echo $jobID ?>' required readonly> <br>
        </div>

        <label for="description">Comment Description</label><br>
        <textarea id="description" name="description" required rows="10" cols="40"style="width:100%; height:200px" ></textarea><br>

        <button type="button" onclick="newCaptcha()" id="cap" title="Give a new Captcha." style="height:47px; margin-top: 25px;border-radius:5px">New Captcha</button>
        <input type="text"  id="captcha" class="searchBox" readonly>
        <input type="text" id="enteredCaptcha" placeholder="Enter Above Captcha" style="text-align:center; font-size: 17px;"><br><br>
        
        <button type="submit" onclick="return checkCaptcha()" name="submit" id="submit-button" style="border-radius:5px">Submit Comment</button>
        
        

      </div> 
    </form>
  </body>
</html>