<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *  @ORM\Column(type="text", length=100)
     */
    private $title;

    /**
     *  @ORM\Column(type="text")
     */
    private $description;

    /**
     *  @ORM\Column(type="text")
     */
    private $body;

    /**
     *  @ORM\Column(type="text")
     */
    private $picture;

    /**
     *  @ORM\Column(type="array")
     */
    private $categories;

    /**
     *  @ORM\Column(type="text")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getBody(){
        return $this->body;
    }

    public function setBody($body){
        $this->body = $body;
    }

    public function getPicture(){
        return $this->picture;
    }

    public function setPicture($picture){
        $this->picture = $picture;
    }

    public function getCategories(){
        return $this->categories;
    }

    public function setCategories($categories){
        $this->categories = $categories;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }
    
}
