<?php

namespace App\Tests\Entity;

use App\Entity\Book;
use App\Entity\Category;
use InvalidArgumentException;
use PHPUnit\Framework\InvalidDataProviderException;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    public function testBook()
    {
        $book = new Book();
        $book->setTitle('The Hitchhiker\'s Guide to the Galaxy');
        $book->setAuthor('Douglas Adams');
        $book->setPicture('https://images-na.ssl-images-amazon.com/images/I/51ZuFk7CKkL._SX331_BO1,204,203,200_.jpg');
        $book->setParution('1979');
        $category = new Category();
        $category->setName('Science-fiction');
        $book->setCategory($category);
        $book->setAvailable(true);
        $book->setDescription('Test description');

        $this->assertEquals('The Hitchhiker\'s Guide to the Galaxy', $book->getTitle());
        $this->assertEquals('Douglas Adams', $book->getAuthor());
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51ZuFk7CKkL._SX331_BO1,204,203,200_.jpg', $book->getPicture());
        $this->assertEquals('1979', $book->getParution());
        $this->assertEquals('Science-fiction', $book->getCategory()->getName());
        $this->assertEquals(true, $book->getAvailable());
        $this->assertEquals('Test description', $book->getDescription());
    }
}