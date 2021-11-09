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
        $book->setDescription('The Hitchhiker\'s Guide to the Galaxy is a science fiction comedy series created by Douglas Adams and published in 1979. It was the first of five books in the Hitchhiker\'s Guide to the Galaxy comedy series, and the first of the series to be adapted into a film. The series was originally broadcast on BBC Radio 1 from 1979 to 1982, and was later adapted into a number of films, including the 1978 film of the same name, the 1979 film of the same name, the 1980 film of the same name, the 1981 film of the same name, and the 1982 film of the same name. The series was originally broadcast on BBC Radio 1 from 1979 to 1982, and was later adapted into a number of films, including the 1978 film of the same name, the 1979 film of the same name, the 1980 film of the same name, the 1981 film of the same name, and the 1982 film of the same name.');

        $this->assertEquals('The Hitchhiker\'s Guide to the Galaxy', $book->getTitle());
        $this->assertEquals('Douglas Adams', $book->getAuthor());
        $this->assertEquals('https://images-na.ssl-images-amazon.com/images/I/51ZuFk7CKkL._SX331_BO1,204,203,200_.jpg', $book->getPicture());
        $this->assertEquals('1979', $book->getParution());
        $this->assertEquals('Science-fiction', $book->getCategory()->getName());
        $this->assertEquals(true, $book->getAvailable());
        $this->assertEquals('The Hitchhiker\'s Guide to the Galaxy is a science fiction comedy series created by Douglas Adams and published in 1979. It was the first of five books in the Hitchhiker\'s Guide to the Galaxy comedy series, and the first of the series to be adapted into a film. The series was originally broadcast on BBC Radio 1 from 1979 to 1982, and was later adapted into a number of films, including the 1978 film of the same name, the 1979 film of the same name, the 1980 film of the same name, the 1981 film of the same name, and the 1982 film of the same name. The series was originally broadcast on BBC Radio 1 from 1979 to 1982, and was later adapted into a number of films, including the 1978 film of the same name, the 1979 film of the same name, the 1980 film of the same name, the 1981 film of the same name, and the 1982 film of the same name.', $book->getDescription());
    }

}