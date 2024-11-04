<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(type: "json")]
    private array $roles = [];

    /**
     * @var Collection<int, Form>
     */
    #[ORM\OneToMany(targetEntity: Form::class, mappedBy: 'user')]
    private Collection $forms;

    public function __construct()
    {
        $this->forms = new ArrayCollection();
    }

    // Implémentation de UserInterface
    public function getUserIdentifier(): string
    {
        return $this->email; // Utiliser l'email comme identifiant
    }

    // Implémentation de PasswordAuthenticatedUserInterface
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    // Nouvelle méthode pour effacer les données sensibles
    public function eraseCredentials(): void
    {
        // Si vous avez des informations sensibles à effacer après l'authentification,
        // faites-le ici. Par exemple, si vous avez un champ temporaire.
    }

    // Implémentation des autres méthodes
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection<int, Form>
     */
    public function getForms(): Collection
    {
        return $this->forms;
    }

    public function addForm(Form $form): static
    {
        if (!$this->forms->contains($form)) {
            $this->forms->add($form);
            $form->setUser($this);
        }
        return $this;
    }

    public function removeForm(Form $form): static
    {
        if ($this->forms->removeElement($form)) {
            if ($form->getUser() === $this) {
                $form->setUser(null);
            }
        }
        return $this;
    }
}
