<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Please provide a title for the game!")
     * @Assert\Length(max={255})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\Length(max={255})
     * @ORM\Column(type="text", nullable=true)
     */
    private $overview;

    /**
     * @Assert\Range(min="0", max="10", notInRangeMessage="You are not in range dude!")
     * @ORM\Column(type="decimal", precision=3, scale=1)
     */
    private $vote;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $platform;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genres;

    /**
     * @Assert\LessThanOrEqual("today", message="La date de publication doit être inférieure ou égale à la date actuelle.")
     * @ORM\Column(type="date")
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $backdrop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $poster;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateModified;

    /**
     * @ORM\OneToMany(targetEntity=Walkthrough::class, mappedBy="game")
     */
    private $walkthroughs;

    public function __construct()
    {
        $this->walkthroughs = new ArrayCollection();
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

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): self
    {
        $this->overview = $overview;

        return $this;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getGenres(): ?string
    {
        return $this->genres;
    }

    public function setGenres(string $genres): self
    {
        $this->genres = $genres;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getBackdrop(): ?string
    {
        return $this->backdrop;
    }

    public function setBackdrop(string $backdrop): self
    {
        $this->backdrop = $backdrop;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(?\DateTimeInterface $dateModified): self
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * @return Collection<int, Walkthrough>
     */
    public function getWalkthroughs(): Collection
    {
        return $this->walkthroughs;
    }

    public function addWalkthrough(Walkthrough $walkthrough): self
    {
        if (!$this->walkthroughs->contains($walkthrough)) {
            $this->walkthroughs[] = $walkthrough;
            $walkthrough->setGame($this);
        }

        return $this;
    }

    public function removeWalkthrough(Walkthrough $walkthrough): self
    {
        if ($this->walkthroughs->removeElement($walkthrough)) {
            // set the owning side to null (unless already changed)
            if ($walkthrough->getGame() === $this) {
                $walkthrough->setGame(null);
            }
        }

        return $this;
    }
}
