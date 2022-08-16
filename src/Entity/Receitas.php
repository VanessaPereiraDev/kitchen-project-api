<?php

namespace App\Entity;

use App\Repository\ReceitasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReceitasRepository::class)
 */
class Receitas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passo1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passo2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passo3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passo4;

    /**
     * @ORM\OneToOne(targetEntity=Product::class, mappedBy="receitas", cascade={"persist", "remove"})
     */
    private $product;

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

    public function getPasso1(): ?string
    {
        return $this->passo1;
    }

    public function setPasso1(string $passo1): self
    {
        $this->passo1 = $passo1;

        return $this;
    }

    public function getPasso2(): ?string
    {
        return $this->passo2;
    }

    public function setPasso2(string $passo2): self
    {
        $this->passo2 = $passo2;

        return $this;
    }

    public function getPasso3(): ?string
    {
        return $this->passo3;
    }

    public function setPasso3(string $passo3): self
    {
        $this->passo3 = $passo3;

        return $this;
    }

    public function getPasso4(): ?string
    {
        return $this->passo4;
    }

    public function setPasso4(string $passo4): self
    {
        $this->passo4 = $passo4;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        // set the owning side of the relation if necessary
        if ($product->getReceitas() !== $this) {
            $product->setReceitas($this);
        }

        $this->product = $product;

        return $this;
    }
}
