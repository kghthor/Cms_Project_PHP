<?php

namespace Project\Cms;

class ExampleClass1
{
    public function add()
    {
        return "<p style='font-size: 24px;'>Hello Welcome to your new project setup Curent page 1!</p>";
    }
}
$exam=new ExampleClass1();
echo $exam->add();