<?php

namespace WorkShopBundle\ProjectSymfonyBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Products
 *
 * @UniqueEntity("nombre")
 * @UniqueEntity("code")
 * @ORM\Table(name="products", uniqueConstraints={@ORM\UniqueConstraint(name="code", columns={"code"}), @ORM\UniqueConstraint(name="code_name", columns={"code", "nombre"}) }, indexes={@ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="brand_id", columns={"brand_id"})})
 * @ORM\Entity
 */
class Products
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(min = 4, max = 100, minMessage = "El nombre debe tener minimo {{ limit }} caracteres", maxMessage = "El nombre debe tener maximo {{ limit }} caracteres")
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nombre;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex("/^\w+/")
     * @Assert\Length(min = 5, max = 100, minMessage = "La descripcion debe tener minimo {{ limit }} caracteres", maxMessage = "La descripcion debe tener maximo {{ limit }} caracteres")
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(
     *     pattern="/^\w(\w)*(-{1})?(\w)*\w$/",
     *     match=true,
     *     message="Ingrese una cadena de texto sin caracteres especiales ni espacios"
     * )
     * @Assert\Length(min = 4, max = 10, minMessage = "El codigo debe tener minimo {{ limit }} caracteres", maxMessage = "El codigo debe tener maximo {{ limit }} caracteres")
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $code;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(message="El valor no es numerico", type="numeric" )
     * @Assert\GreaterThan(message="Ingrese un valor  mayor a cero",value=0)
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=15, scale=2, nullable=false, unique=false)
     */
    private $price;

    /**
     * @var \WorkShopBundle\ProjectSymfonyBundle\Entity\Brand
     *
     * @ORM\ManyToOne(targetEntity="WorkShopBundle\ProjectSymfonyBundle\Entity\Brand")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="brand_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $brand;

    /**
     * @var \WorkShopBundle\ProjectSymfonyBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="WorkShopBundle\ProjectSymfonyBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $category;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Products
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Products
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Products
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set brand
     *
     * @param \WorkShopBundle\ProjectSymfonyBundle\Entity\Brand $brand
     * @return Products
     */
    public function setBrand(\WorkShopBundle\ProjectSymfonyBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \WorkShopBundle\ProjectSymfonyBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set category
     *
     * @param \WorkShopBundle\ProjectSymfonyBundle\Entity\Category $category
     * @return Products
     */
    public function setCategory(\WorkShopBundle\ProjectSymfonyBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \WorkShopBundle\ProjectSymfonyBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
