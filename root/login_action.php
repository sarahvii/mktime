<?php 

// uncomment below to check error messages
ini_set('display_errors', 1);
error_reporting(E_ALL);


# PROCESS LOGIN ATTEMPT
# Check form submitted
if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' )
{
  # Open database connection.
  require ( 'connect_db.php' ) ;

  # Get connection, load, and validate functions.
  require ( 'login_tools.php' ) ;

  # Check login.
  list ( $check, $data ) = validate ( $link, $_POST[ 'email' ], $_POST[ 'password' ] ) ;

  # On success set session data and display logged in page.
  if ( $check )  
  {
    # Access session.
    session_start();
    $_SESSION[ 'user_id' ] = $data[ 'user_id' ] ;
    $_SESSION[ 'firstname' ] = $data[ 'firstname' ] ;
    $_SESSION[ 'lastname' ] = $data[ 'lastname' ] ;
   load ( 'index.php' ) ;
   
  }
  # Or on failure set errors.
  else { $errors = $data; } 

  # Close database connection.
  mysqli_close( $link ) ; 
}

# Continue to display login page on failure.
include ( 'login.php' ) ;

?>