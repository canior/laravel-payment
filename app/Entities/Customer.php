<?php


namespace App\Entities;



use App\Entities\Traits\CreatedAtTrait;
use App\Entities\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var string
     * @ORM\Column(name="card_holder", type="string", nullable=false)
     */
    private $cardHolder;

    /**
     * @var string|null
     * @ORM\Column(name="card_number", type="string", nullable=true)
     */
    private $cardNumber;

    /**
     * @var string|null
     * @ORM\Column(name="card_expiry_month", type="string", nullable=true)
     */
    private $cardExpiryMonth;

    /**
     * @var string|null
     * @ORM\Column(name="card_expiry_year", type="string", nullable=true)
     */
    private $cardExpiryYear;


    public function __construct() {
        $now = time();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getCardHolder() {
        return $this->cardHolder;
    }

    /**
     * @param string $cardHolder
     */
    public function setCardHolder($cardHolder) {
        $this->cardHolder = $cardHolder;
    }

    /**
     * @return string|null
     */
    public function getCardNumber() {
        return $this->cardNumber;
    }

    /**
     * @param string|null $cardNumber
     */
    public function setCardNumber($cardNumber) {
        $this->cardNumber = $cardNumber;
    }

    /**
     * @return string|null
     */
    public function getCardExpiryMonth() {
        return $this->cardExpiryMonth;
    }

    /**
     * @param string|null $cardExpiryMonth
     */
    public function setCardExpiryMonth($cardExpiryMonth) {
        $this->cardExpiryMonth = $cardExpiryMonth;
    }

    /**
     * @return string|null
     */
    public function getCardExpiryYear() {
        return $this->cardExpiryYear;
    }

    /**
     * @param string|null $cardExpiryYear
     */
    public function setCardExpiryYear($cardExpiryYear) {
        $this->cardExpiryYear = $cardExpiryYear;
    }

    public function getCardExpiryYYMM() {
        return $this->getCardExpiryYear() . $this->getCardExpiryMonth();
    }

}