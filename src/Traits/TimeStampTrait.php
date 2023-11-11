<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait
{
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $createdAt = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $updatedAt = null;

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {


        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {   
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate
     */
    
    public function preUpdate()
    {
        error_log('preUpdate called for entity: ' . get_class($this));
        $this->updatedAt = new \DateTime();
    }
}
