<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type: 'integer')
     */
    private $id;

    /**
     * @ORM\Column(type: 'string', length: 255)
     */
    private $title;

    /**
     * @ORM\Column(type: 'text')
     */
    private $content;

    /**
     * @ORM\Column(type: 'string', length: 255, nullable: true)
     */
    private $brandCar;

    /**
     * @ORM\Column(type: 'string', length: 255, nullable: true)
     */
    private $nameCar;

    /**
    * @ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'posts')
    * @ORM\JoinColumn(nullable: false)
    */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getBrandCar(): ?string
    {
        return $this->brandCar;
    }

    public function setBrandCar(?string $brandCar): self
    {
        $this->brandCar = $brandCar;

        return $this;
    }

    public function getNameCar(): ?string
    {
        return $this->nameCar;
    }

    public function setNameCar(?string $nameCar): self
    {
        $this->nameCar = $nameCar;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
