<?php

namespace App\Entities\Traits;

trait CreatedAtTrait
{
    /**
     * @var int
     * @ORM\Column(name="created_at", type="integer", nullable=false)
     */
    private $createdAt;

    /**
     * @return int
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @param int $createdAt
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
    }

}
