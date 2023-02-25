<?php

namespace App\models;

class Book
{
    private $title;
    private $author;
    private $book_description;

    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $val)
    {
        return $this->$attr = $val;
    }
}
