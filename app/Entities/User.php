<?php

namespace App\Entities;


use App\Entities\Traits\CreatedAtTrait;
use App\Entities\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Env;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    const PAYMENT_GATEWAY_MONERIS = 'moneris';

    use UpdatedAtTrait;
    use CreatedAtTrait;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="payment_gateway", type="string", nullable=false)
     */
    private $paymentGateway;

    /**
     * @var string|null
     * @ORM\Column(name="moneris_store_id", type="string", nullable=true)
     */
    private $monerisStoreId;

    /**
     * @var string|null
     * @ORM\Column(name="moneris_api_token", type="string", nullable=true)
     */
    private $monerisApiToken;

    /**
     * @var string|null
     * @ORM\Column(name="moneris_country_code", type="string", nullable=true)
     */
    private $monerisCountryCode;

    /**
     * @var boolean|null
     * @ORM\Column(name="moneris_test_mode", type="boolean", nullable=true)
     */
    private $monerisTestMode;


    public function __construct() {
        $now = time();
        $this->setCreatedAt($now);
        $this->setUpdatedAt($now);
        $this->paymentGateway = Env::get('default_payment');
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
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPaymentGateway() {
        return $this->paymentGateway;
    }

    /**
     * @param string $paymentGateway
     */
    public function setPaymentGateway($paymentGateway) {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * @return string|null
     */
    public function getMonerisStoreId() {
        return $this->monerisStoreId;
    }

    /**
     * @param string|null $monerisStoreId
     */
    public function setMonerisStoreId($monerisStoreId) {
        $this->monerisStoreId = $monerisStoreId;
    }

    /**
     * @return string|null
     */
    public function getMonerisApiToken() {
        return $this->monerisApiToken;
    }

    /**
     * @param string|null $monerisApiToken
     */
    public function setMonerisApiToken($monerisApiToken) {
        $this->monerisApiToken = $monerisApiToken;
    }

    /**
     * @return string|null
     */
    public function getMonerisCountryCode() {
        return $this->monerisCountryCode;
    }

    /**
     * @param string|null $monerisCountryCode
     */
    public function setMonerisCountryCode($monerisCountryCode) {
        $this->monerisCountryCode = $monerisCountryCode;
    }

    /**
     * @return bool|null
     */
    public function getMonerisTestMode() {
        return $this->monerisTestMode;
    }

    /**
     * @param bool|null $monerisTestMode
     */
    public function setMonerisTestMode($monerisTestMode) {
        $this->monerisTestMode = $monerisTestMode;
    }

}