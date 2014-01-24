<?php

namespace PGSDoctrineTest\Assets\Entity;

use Zend\Form\Annotation as Form;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Form\Name("address")
 *
 * @ORM\Entity()
 * @ORM\Table(name="address")
 */
class Address
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Form\Type("Hidden")
     *
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", nullable=true)
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"Name"})
     */
    protected $name;

    /**
     * @ORM\Column(name="street_name", type="string", nullable=true)
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"Street"})
     */
    protected $streetName;

    /**
     *
     * @ORM\Column(name="house_number", type="string", length=16, nullable=true)
     *
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"House number"})
     */
    protected $houseNumber;

    /**
     * @ORM\Column(name="city_name", type="string", nullable=true)
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"City"})
     */
    protected $cityName;

    /**
     * @ORM\Column(name="postal_code", type="string", length=32, nullable=true)
     *
     * @Form\Type("Text")
     * @Form\Options({"label":"Postal"})
     */
    protected $postalCode;

    /**
     * @ORM\Column(name="country_name", type="string", nullable=true)
     *
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Country"})
     */
    protected $countryName;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Form\Type("Hidden")
     * @Form\Attributes({
     *        "type":"hidden",
     *        "id":"longitude"
     * })
     */
    protected $longitude;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Form\Type("Hidden")
     * @Form\Attributes({
     *        "id":"latitude"
     * })
     */
    protected $latitude;

    /**
     * @param mixed $cityName
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * @param mixed $countryName
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
    }

    /**
     * @return mixed
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * @param mixed $houseNumber
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    /**
     * @return mixed
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param mixed $streetName
     */
    public function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    /**
     * @return mixed
     */
    public function getStreetName()
    {
        return $this->streetName;
    }


}

?>
