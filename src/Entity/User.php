<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=40, unique=true)
     */
    private $nick;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reset_pass = true;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $signature;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_disp_topics = 20;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_disp_posts = 20;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_posts = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registered;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $reg_ip;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_login;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $login_ip;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $temp_key;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumPost", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ForumTopic", mappedBy="user")
     */
    private $topics;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->topics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    public function getResetPass(): ?bool
    {
        return $this->reset_pass;
    }

    public function setResetPass(bool $reset_pass): self
    {
        $this->reset_pass = $reset_pass;

        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;

        return $this;
    }

    public function getNumDispTopics(): ?int
    {
        return $this->num_disp_topics;
    }

    public function setNumDispTopics(int $num_disp_topics): self
    {
        $this->num_disp_topics = $num_disp_topics;

        return $this;
    }

    public function getNumDispPosts(): ?int
    {
        return $this->num_disp_posts;
    }

    public function setNumDispPosts(int $num_disp_posts): self
    {
        $this->num_disp_posts = $num_disp_posts;

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

    public function getLastPost(): ?\DateTimeInterface
    {
        return $this->last_post;
    }

    public function setLastPost(?\DateTimeInterface $last_post): self
    {
        $this->last_post = $last_post;

        return $this;
    }

    public function getRegistered(): ?\DateTimeInterface
    {
        return $this->registered;
    }

    public function setRegistered(\DateTimeInterface $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    public function getRegIp(): ?string
    {
        return $this->reg_ip;
    }

    public function setRegIp(string $reg_ip): self
    {
        $this->reg_ip = $reg_ip;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->last_login;
    }

    public function setLastLogin(?\DateTimeInterface $last_login): self
    {
        $this->last_login = $last_login;

        return $this;
    }

    public function getLoginIp(): ?string
    {
        return $this->login_ip;
    }

    public function setLoginIp(string $login_ip): self
    {
        $this->login_ip = $login_ip;

        return $this;
    }

    public function getTempKey(): ?string
    {
        return $this->temp_key;
    }

    public function setTempKey(?string $temp_key): self
    {
        $this->temp_key = $temp_key;

        return $this;
    }

    /**
     * @return Collection|ForumPost[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(ForumPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(ForumPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

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
            $topic->setUser($this);
        }

        return $this;
    }

    public function removeTopic(ForumTopic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getUser() === $this) {
                $topic->setUser(null);
            }
        }

        return $this;
    }
}
