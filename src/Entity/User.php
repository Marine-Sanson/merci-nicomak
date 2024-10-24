<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $avatar = null;

    /**
     * @var Collection<int, Merci>
     */
    #[ORM\OneToMany(targetEntity: Merci::class, mappedBy: 'author')]
    private Collection $givenMercis;

    /**
     * @var Collection<int, Merci>
     */
    #[ORM\OneToMany(targetEntity: Merci::class, mappedBy: 'recipient')]
    private Collection $receivedMercis;

    public function __construct()
    {
        $this->givenMercis = new ArrayCollection();
        $this->receivedMercis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Merci>
     */
    public function getGivenMercis(): Collection
    {
        return $this->givenMercis;
    }

    public function addGivenMerci(Merci $givenMerci): static
    {
        if (!$this->givenMercis->contains($givenMerci)) {
            $this->givenMercis->add($givenMerci);
            $givenMerci->setAuthor($this);
        }

        return $this;
    }

    public function removeGivenMerci(Merci $givenMerci): static
    {
        if ($this->givenMercis->removeElement($givenMerci)) {
            // set the owning side to null (unless already changed)
            if ($givenMerci->getAuthor() === $this) {
                $givenMerci->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Merci>
     */
    public function getReceivedMercis(): Collection
    {
        return $this->receivedMercis;
    }

    public function addReceivedMerci(Merci $receivedMerci): static
    {
        if (!$this->receivedMercis->contains($receivedMerci)) {
            $this->receivedMercis->add($receivedMerci);
            $receivedMerci->setRecipient($this);
        }

        return $this;
    }

    public function removeReceivedMerci(Merci $receivedMerci): static
    {
        if ($this->receivedMercis->removeElement($receivedMerci)) {
            // set the owning side to null (unless already changed)
            if ($receivedMerci->getRecipient() === $this) {
                $receivedMerci->setRecipient(null);
            }
        }

        return $this;
    }
}
