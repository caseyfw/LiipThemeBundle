<?php

namespace Liip\ThemeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Liip\ThemeBundle\Entity\SiteRepository")
 */
class Site
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255)
     */
    private $domain;

    /**
     * @ORM\ManyToOne(targetEntity="Theme", inversedBy="sites")
     * @ORM\JoinColumn(name="themeId", referencedColumnName="id")
     */
    protected $theme;


    public function __construct($domain = null, $theme = null)
    {
      $this->domain = $domain;
      $this->theme = $theme;
    }

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
     * Set domain
     *
     * @param string $domain
     * @return Site
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    
        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set theme
     *
     * @param \Liip\ThemeBundle\Entity\Theme $theme
     */
    public function setTheme(\Liip\ThemeBundle\Entity\Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Get theme
     *
     * @return \Liip\ThemeBundle\Entity\Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }
}
