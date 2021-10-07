<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Book::class, mappedBy="category", orphanRemoval=true)
     */
    private $books;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subCategory;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameCrud;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subCategoryCrud;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName().' '.$this->getSubCategory();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->setCategory($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getCategory() === $this) {
                $book->setCategory(null);
            }
        }

        return $this;
    }

    public function getSubCategory(): ?string
    {
        return $this->subCategory;
    }

    public function setSubCategory(?string $subCategory): self
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    public function getNameCrud(): ?string
    {
        return $this->nameCrud;
    }

    public function setNameCrud(string $nameCrud): self
    {
        $this->nameCrud = $nameCrud;

        return $this;
    }

    public function getSubCategoryCrud(): ?string
    {
        return $this->subCategoryCrud;
    }

    public function setSubCategoryCrud(?string $subCategoryCrud): self
    {
        $this->subCategoryCrud = $subCategoryCrud;

        return $this;
    }
}
