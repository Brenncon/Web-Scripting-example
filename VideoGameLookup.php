<?php
   //start the session
   session_start();

   // put the server name into a variable 
   $servername = "localhost";

   //put the username into a variable 
   $username = "brenncon_user";

   // put the password into a variable 
   $password = "Achi11es_Heel3";

   //put the table name into a variable 
   $mydbname = "brenncon_mydb";

   //connect to the server 
   try {
       $dbh = new PDO("mysql:host=$servername;dbname=$mydbname", $username, $password);
       }
	   //catch any exceptions
   catch(PDOException $e)
       {
	   // kills the connection to the database and displays a message 
       die('Could not connect to DB: ' . $e->getMessage());
       }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
      
    </head>
    <body>

	<!--display the title-->
  <h1>Lookup Results</h1>


<?php    
	
	// Check if each field was checked and format the SQL statement.
    $sqlstmt = "select ";	
	
	if (($_POST['DisGameID'])=="Y"){
		$sqlstmt .= "GameID";
	}
	
	if (($_POST['DisTitle'])=="Y"){
		if (($_POST['DisGameID'])=="Y"){
		   $sqlstmt .= ", Title";
		}
		else {
		   $sqlstmt .= "Title";
		}
	}	
	
	if (($_POST['DisPublisher'])=="Y"){
		if (($_POST['DisGameID'])=="Y" || ($_POST['DisTitle'])=="Y"){
		   $sqlstmt .= ", Publisher";
		}
		else {
		   $sqlstmt .= "Publisher";		
        }		   
	}	

	if (($_POST['DisESBRating'])=="Y"){
		if (($_POST['DisGameID'])=="Y" || ($_POST['DisTitle'])=="Y" || ($_POST['DisPublisher'])=="Y"){		
		   $sqlstmt .= ", ESBRating";
		}
		else {
		   $sqlstmt .= "ESBRating";
		}
	}	
	
	if (($_POST['DisPlatform'])=="Y"){
		if (($_POST['DisGameID'])=="Y" || ($_POST['DisTitle'])=="Y" || ($_POST['DisPublisher'])=="Y" || ($_POST['DisESBRating'])=="Y"){
		   $sqlstmt .= ", Platform";
		}
		else {
		   $sqlstmt .= "Platform";
		}
	}	

    $sqlstmt .= " from VideoGameLibrary where ";
	
	try {
	  // If user entered a single game id, finish formating the SQL statement and run it
	  if (!($_POST['SingleID'])==""){
	      $SingleID = $_POST['SingleID'];	
          $sqlstmt .= "GameID=:SingleID";			  
	      $stmt=$dbh->prepare("$sqlstmt");
		  $stmt->bindParam(':SingleID', $SingleID);		  
	      $stmt->execute();
	   }
	   //format the SQL statement using a game ID range and run it 
	   else {
	      $StartID = $_POST['StartID'];	  
		  $EndID = $_POST['EndID'];	  
		  $sqlstmt .= "GameID between :StartID and :EndID order by GameID";
	      $stmt=$dbh->prepare("$sqlstmt");
		  $stmt->bindParam(':StartID', $StartID);
		  $stmt->bindParam(':EndID', $EndID);
	      $stmt->execute();		   
	   }
	   
	   //fetches all rows from query 
       $rowarray = $stmt->fetchAll(PDO::FETCH_ASSOC);
	   
	   //prints all columns for each row 	 
	   print "<table>";	  
	   print "<tr>\n";
	   
	   //format the display table with the appropriate headings 
	   if (($_POST['DisGameID'])=="Y"){
	      print "\t<td>Game ID</td>\n";
	   }
	   
	   if (($_POST['DisTitle'])=="Y"){
		   print "\t<td>Title</td>\n";
	   }
	   
	   if (($_POST['DisPublisher'])=="Y"){
		   print "\t<td>Publisher</td>\n";
	   }
	   
	   if (($_POST['DisESBRating'])=="Y"){
		   print "\t<td>ESB Rating</td>\n";
	   }
	   
	   if (($_POST['DisPlatform'])=="Y"){
		   print "\t<td>Platform</td>\n";
	   }
	   
	   //make a blank line
	   echo "<br>";
	   
	   //print the rows of data
	   print "</tr>\n";
	   print "<tr>\n";  
       foreach ($rowarray as $row) {
          foreach ($row as $col) {
            print "\t<td>$col</td>\n";
          }
		  //prints a blank line
	       echo "<br>";
       print "</tr>\n";
       }
	   print "</table>";

    }
	//catch any exceptions 
	catch(PDOException $e)
    {
	   // kills the connection to the database and displays a message
       die('Could not query the database: ' . $e->getMessage());
    }
	
	// Close the connection.
	$dbh=null;
?>

	<!--make a lot of new lines-->
	<br><br><br><br><br><br>
	
   <!--add a button to go back -->
   	 <form method="post" action="Connor.Brennan.Assignment8.html">
		<input type="submit" name="retmenu" value="Return To Menu">
	</form>
  
    </body> 
</html>