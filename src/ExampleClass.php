<?php
namespace Project\Cms;
require 'vendor/autoload.php';
use Config\Database;

class ExampleClass
{
    public function greet()
    {
        $db = new Database();
        $connectionStatus = $db->checkConnection();

        // Return the connection status message
        echo "<p style='font-size: 24px;'>$connectionStatus</p>";
    }
}
?>