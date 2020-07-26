<?php

namespace App\Entity;

use App\Repository\FavoritesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FavoritesRepository::class)
 */
class Favorites
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Recipe::class)
     */
    private $recipe_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getRecipeId(): ?Recipe
    {
        return $this->recipe_id;
    }

    public function setRecipeId(?Recipe $recipe_id): self
    {
        $this->recipe_id = $recipe_id;

        return $this;
    }
}
