<?php



function useCodeFrom($filePath) {
    $filePath = __DIR__ . '/' . ltrim($filePath, '/');
    
    // Check if the file exists
    if (file_exists($filePath)) {
        // Include the file
        echo "done";
        include $filePath;
        // return true;
    } else {
        // Throw an error or return false if the file does not exist
        trigger_error("The file '$filePath' does not exist.", E_USER_ERROR);
        echo "fail";
        return false;
    }
  }

  
?>