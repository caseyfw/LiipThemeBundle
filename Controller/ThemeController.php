<?php

namespace Liip\ThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class ThemeController extends Controller
{
    /**
     * @Route("/setTheme/{themeSlug}")
     * @Template()
     */
    public function setThemeAction($themeSlug)
    {
        if (!$newTheme = $this->getDoctrine()->getRepository('LiipThemeBundle:Theme')->findOneBySlug($themeSlug)) {
            throw $this->createNotFoundException(sprintf('The requested theme %s does not exist', $themeSlug));
        }
        
        $at = $this->get('liip_theme.active_theme');
        
        $oldTheme = $at->getTheme();
        $at->setTheme($newTheme);
        
        return $this->redirect($this->getRequest()->getSchemeAndHttpHost());
    }

}
