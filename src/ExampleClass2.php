<?php

namespace Project\Cms;

class ExampleClass2
{
    public function sub()
    {
        return "<p style='font-size: 24px;'>Hello Welcome to your new project setup current page 2!</p>";
    }
}
$exam=new ExampleClass2();
echo $exam->sub();