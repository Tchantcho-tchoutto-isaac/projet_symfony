<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use App\Traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]

/**
 * @ORM\HasLifecycleCallbacks()
 */

class Profile
{
    Use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 50)]
    private ?string $rs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getRs(): ?string
    {
        return $this->rs;
    }

    public function setRs(string $rs): static
    {
        $this->rs = $rs;

        return $this;
    }
    
    public function __toString()
    {
        return $this->rs."".$this->url; // ou une autre propriété que vous souhaitez utiliser comme représentation de chaîne
    }
}
