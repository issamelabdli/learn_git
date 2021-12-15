<?php

namespace App\Entity\Produits;

use App\Entity\Mediatheque;
use App\Entity\Produits\Categorie;
use App\Repository\Produits\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 * @UniqueEntity("titre")
 * @Vich\Uploadable
 */
class SousCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="image_souscategorie", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $switcher;

    /**
     * @Vich\UploadableField(mapping="switcher_souscategorie", fileNameProperty="switcher")
     * @var File
     */
    private $switcherFile;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $publier;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoTitre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $seoDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seoKeywords;

    /**
     * @Gedmo\Slug(fields={"titre"}, updatable=true, separator="-")
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="sousCategories")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="sousCategorie")
     */
    private $produits;

    /**
     * @ORM\OneToMany(targetEntity=Mediatheque::class, mappedBy="sousCategorie")
     */
    private $mediatheques;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->mediatheques = new ArrayCollection();
    }

    public function __toString(){
        return $this->titre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSwitcher(): ?string
    {
        return $this->switcher;
    }

    public function setSwitcher(?string $switcher): self
    {
        $this->switcher = $switcher;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getPublier(): ?bool
    {
        return $this->publier;
    }

    public function setPublier(?bool $publier): self
    {
        $this->publier = $publier;

        return $this;
    }

    public function getSeoTitre(): ?string
    {
        return $this->seoTitre;
    }

    public function setSeoTitre(?string $seoTitre): self
    {
        $this->seoTitre = $seoTitre;

        return $this;
    }

    public function getSeoDescription(): ?string
    {
        return $this->seoDescription;
    }

    public function setSeoDescription(?string $seoDescription): self
    {
        $this->seoDescription = $seoDescription;

        return $this;
    }

    public function getSeoKeywords(): ?string
    {
        return $this->seoKeywords;
    }

    public function setSeoKeywords(?string $seoKeywords): self
    {
        $this->seoKeywords = $seoKeywords;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setSousCategorie($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getSousCategorie() === $this) {
                $produit->setSousCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mediatheque[]
     */
    public function getMediatheques(): Collection
    {
        return $this->mediatheques;
    }

    public function addMediatheque(Mediatheque $mediatheque): self
    {
        if (!$this->mediatheques->contains($mediatheque)) {
            $this->mediatheques[] = $mediatheque;
            $mediatheque->setSousCategorie($this);
        }

        return $this;
    }

    public function removeMediatheque(Mediatheque $mediatheque): self
    {
        if ($this->mediatheques->removeElement($mediatheque)) {
            // set the owning side to null (unless already changed)
            if ($mediatheque->getSousCategorie() === $this) {
                $mediatheque->setSousCategorie(null);
            }
        }

        return $this;
    }


    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setSwitcherFile(File $switcher = null)
    {
        $this->switcherFile = $switcher;
        if ($switcher) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getSwitcherFile()
    {
        return $this->switcherFile;
    }
}
