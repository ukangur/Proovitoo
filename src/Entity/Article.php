<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;

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
     *  @ORM\Column(type="text",nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $categories;

    /**
     *  @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="Article")
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }
    
}
