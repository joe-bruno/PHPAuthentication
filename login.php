<?php
  // Utilize sessions for cross page communication (and authentication)
  session_start();

  // Define the constants
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'Authentication');
  DEFINE('DB_TABLE', 'USERS');

  // Create the connection
  $mysqliobj = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if(mysqli_connect_errno()) {
    die("Error connecting to the database.");
  }

  //echo "Connected to database successfully.\r\n";

  // Parameters were submitted successfully
  if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Will be used to compare credentials
    $hashPass = sha1($password);
  
    // Setup our query to check if there is a row in the Users table with a matching username
    $sqlquery = "SELECT * FROM Users WHERE Username = '".$username."'";

    // Run query and see if a row was returned
    $result = mysqli_query($mysqliobj, $sqlquery);
    $count = mysqli_num_rows($result);

    // If there was a matching field
    if($count == 1) {
      $row = mysqli_fetch_assoc($result);

      // Check to see if the password matches
      if($row['Password'] == $hashPass) {
        // Since we have logged in...create session data to continue with us to the members page
        // If this is set then we are logged in
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password; // Note when resubmitting...will have to rehash
        echo 'Logged in as '.$username.' successfully!';
        $_SESSION['loggedIn'] = 'yes';
      } else {
        echo 'Invalid password for user: '.$username;
        header("index.php");
      }
    } 

  } else { echo 'No data was posted'; }

  // Close connection after
  $mysqliobj->close();
?>
