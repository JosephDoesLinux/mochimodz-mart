<!-- /**
 * Logout script
 * 
 * This script handles the user logout process by:
 * 1. Starting the session
 * 2. Destroying all session data
 * 3. Redirecting user to the login page
 * 
 * After executing this script, all session variables will be removed
 * and user will be redirected to login.php
  * @author     Joseph Abou Antoun 52330567

 */ -->
<?php
session_start();
session_destroy();
header('Location: login.php');
exit;
