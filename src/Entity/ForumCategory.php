<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ForumCategoryRepository")
 */
class ForumCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $redirect_url;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_topics = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_posts = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $sort = 20;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumTopic", mappedBy="category")
     */
    private $topics;

    /**
     * @ORM\Column(type="boolean")
     */
    private $locked = false;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles_read = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles_create = ['ROLE_USER'];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles_mod = ['ROLE_ADMIN'];

    public function __construct()
    {
        $this->topics = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirect_url;
    }

    public function setRedirectUrl(?string $redirect_url): self
    {
        $this->redirect_url = $redirect_url;

        return $this;
    }

    public function getNumTopics(): ?int
    {
        return $this->num_topics;
    }

    public function setNumTopics(int $num_topics): self
    {
        $this->num_topics = $num_topics;

        return $this;
    }

    public function getNumPosts(): ?int
    {
        return $this->num_posts;
    }

    public function setNumPosts(int $num_posts): self
    {
        $this->num_posts = $num_posts;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return Collection|ForumTopic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(ForumTopic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setCategory($this);
        }

        return $this;
    }

    public function removeTopic(ForumTopic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getCategory() === $this) {
                $topic->setCategory(null);
            }
        }

        return $this;
    }

    public function getLocked(): ?bool
    {
        return $this->locked;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;

        return $this;
    }

    public function getRolesRead(): ?array
    {
        return $this->roles_read;
    }

    public function setRolesRead(?array $roles_read): self
    {
        $this->roles_read = $roles_read;

        return $this;
    }

    public function getRolesCreate(): ?array
    {
        return $this->roles_create;
    }

    public function setRolesCreate(?array $roles_create): self
    {
        $this->roles_create = $roles_create;

        return $this;
    }

    public function getRolesMod(): ?array
    {
        return $this->roles_mod;
    }

    public function setRolesMod(?array $roles_mod): self
    {
        $this->roles_mod = $roles_mod;

        return $this;
    }
}
