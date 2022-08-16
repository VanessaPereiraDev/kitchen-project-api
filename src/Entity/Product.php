<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("api_list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "O campo Nome do Produto deve conter mais de {{ limit }} caracteres",
     *      maxMessage = "O campo Nome do Produto deve conter no máximo {{ limit }} caracteres"
     * )
     * @Groups("api_list")
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank
     * @Assert\Positive(message="O campo Preço deve conter um número positivo")
     * @Groups("api_list")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_list")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=Images::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("api_list")
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity=Receitas::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $receitas;

    /**
     * @ORM\OneToOne(targetEntity=Ingredients::class, inversedBy="product", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $ingredients;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(Images $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getReceitas(): ?Receitas
    {
        return $this->receitas;
    }

    public function setReceitas(Receitas $receitas): self
    {
        $this->receitas = $receitas;

        return $this;
    }

    public function getIngredients(): ?Ingredients
    {
        return $this->ingredients;
    }

    public function setIngredients(Ingredients $ingredients): self
    {
        $this->ingredients = $ingredients;

        return $this;
    }
}
