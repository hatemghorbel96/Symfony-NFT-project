<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
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
    private $img;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minbet;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datedeb;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datefin;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=Collect::class, inversedBy="posts")
     */
    private $collect;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $currencyv;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $view;

    /**
     * @ORM\OneToMany(targetEntity=Bet::class, mappedBy="post")
     */
    private $bets;

    /**
     * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="post")
     */
    private $activitys;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favorits")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="post")
     */
    private $likes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $typebuy;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ownpost")
     */
    private $owner;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateown;

    public function __construct()
    {
        $this->bets = new ArrayCollection();
        $this->activitys = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMinbet(): ?int
    {
        return $this->minbet;
    }

    public function setMinbet(?int $minbet): self
    {
        $this->minbet = $minbet;

        return $this;
    }

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(?\DateTimeInterface $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(?\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

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

    public function getCollect(): ?Collect
    {
        return $this->collect;
    }

    public function setCollect(?Collect $collect): self
    {
        $this->collect = $collect;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCurrencyv(): ?string
    {
        return $this->currencyv;
    }

    public function setCurrencyv(string $currencyv): self
    {
        $this->currencyv = $currencyv;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getView(): ?int
    {
        return $this->view;
    }

    public function setView(int $view): self
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @return Collection<int, Bet>
     */
    public function getBets(): Collection
    {
        return $this->bets;
    }

    public function addBet(Bet $bet): self
    {
        if (!$this->bets->contains($bet)) {
            $this->bets[] = $bet;
            $bet->setPost($this);
        }

        return $this;
    }

    public function removeBet(Bet $bet): self
    {
        if ($this->bets->removeElement($bet)) {
            // set the owning side to null (unless already changed)
            if ($bet->getPost() === $this) {
                $bet->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Activity>
     */
    public function getActivitys(): Collection
    {
        return $this->activitys;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activitys->contains($activity)) {
            $this->activitys[] = $activity;
            $activity->setPost($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activitys->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getPost() === $this) {
                $activity->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavorit($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavorit($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

        return $this;
    }

    public function getTypebuy(): ?int
    {
        return $this->typebuy;
    }

    public function setTypebuy(?int $typebuy): self
    {
        $this->typebuy = $typebuy;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getDateown(): ?\DateTimeInterface
    {
        return $this->dateown;
    }

    public function setDateown(?\DateTimeInterface $dateown): self
    {
        $this->dateown = $dateown;

        return $this;
    }
}
