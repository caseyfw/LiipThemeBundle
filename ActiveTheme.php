<?php

/*
 * This file is part of the Liip/ThemeBundle
 *
 * (c) Liip AG
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Liip\ThemeBundle;

use Doctrine\ORM\EntityManager;
use Liip\ThemeBundle\Entity\Site;
use Liip\ThemeBundle\Entity\Theme;

/**
 * Contains the currently active theme and allows to change it.
 *
 * This is a service so we can inject it as reference to different parts of the application.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
class ActiveTheme
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $themes;

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var Site
     */
    protected $site;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, $domain = null)
    {
        $this->em = $em;

        if (array_key_exists('SERVER_NAME', $_SERVER) || isset($domain)) {
            // cheap and nasty way of determine current domain
            $domain = isset($domain) ? $domain : $_SERVER["SERVER_NAME"];

            // determine theme for site, based on domain
            $this->site = $this->em->getRepository('LiipThemeBundle:Site')->findOneByDomain($domain);

            $this->theme = $this->site->getTheme();

            // convert current theme back to boring text version
            $this->name = $this->theme->getSlug();
        }
            
        // fetch list of themes
        $this->themes = $this->em->getRepository('LiipThemeBundle:Theme')->findAll();
    }

    public function getThemes()
    {
        $themeSlugs = array();
        foreach($this->themes as $theme) {
            $themeSlugs[] = $theme->getSlug();
        }
        return (array) $themeSlugs;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * This is basically only used by the CacheWarmer to "temporarily" set the
     * current theme so that when it calls the FileLocator it can look for each
     * theme's files in turn.
     * 
     * Not an authority on which theme is currently active - use
     * getTheme->getName() instead.
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getTheme() {
        return $this->theme;
    }
    
    public function setTheme(Theme $theme) {
        
        if ($this->site) $this->site->setTheme($theme);
        $this->theme = $theme;
        $this->em->flush();
    }
    
    public function __sleep() {
        return array();
    }
}
