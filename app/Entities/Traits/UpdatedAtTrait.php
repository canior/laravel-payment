<?php

namespace App\Entities\Traits;

trait UpdatedAtTrait
{
    /**
     * @var int
     * @ORM\Column(name="updated_at", type="integer", nullable=false)
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    /**
     * @param int $updatedAt
     */
    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}