<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;
use App\Entity\Book;

class CategoryTest extends TestCase
{
    public function testGetName()
    {
        $category = new Category();
        $category->setName('name');
        $this->assertEquals('name', $category->getName());
    }

    public function testGetSubcategory()
    {
        $category = new Category();
        $category->setSubcategory('SubCategory');
        $this->assertEquals('SubCategory', $category->getSubcategory());
    }

    public function testGetBooks()
    {
        $category = new Category();
        $book = new Book();
        $category->addBook($book);
        $this->assertEquals(1, $category->getBooks()->count());
    }

    public function testAddBook()
    {
        $category = new Category();
        for ($i = 0; $i < 5; $i++) {
            $book = new Book();
            $category->addBook($book);
        }
        $this->assertCount(5, $category->getBooks());
    }

    public function testRemoveBook()
    {
        $category = new Category();
        $book = new Book();
        $category->addBook($book);
        $category->removeBook($book);
        $this->assertCount(0, $category->getBooks());
    }

    public function testGetNameCrud()
    {
        $category = new Category();
        $category->setName('name');
        $this->assertEquals('name', $category->getName());
    }

    public function testGetSubcategoryCrud()
    {
        $category = new Category();
        $category->setSubcategory('SubCategory');
        $this->assertEquals('SubCategory', $category->getSubcategory());
    }
}