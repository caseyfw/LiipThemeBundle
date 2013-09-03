<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Liip\ThemeBundle\Tests;

use Liip\ThemeBundle\Tests\TestBaseManager;
use Liip\ThemeBundle\Locator\FileLocator;
use Liip\ThemeBundle\ActiveTheme;
use Liip\ThemeBundle\Entity\Theme;
use Liip\ThemeBundle\Entity\Site;

class ActiveThemeTest extends TestBaseManager
{
    /**
     * @covers Liip\ThemeBundle\ActiveTheme::__construct
     * @covers Liip\ThemeBundle\ActiveTheme::getName
     * @covers Liip\ThemeBundle\ActiveTheme::getTheme
     */
    public function testGetName()
    {
        $this->setupFixtures();

        $at = new ActiveTheme($this->em, 'example.com');

        $this->assertEquals("foo", $at->getName());
        $this->assertEquals("Foo", $at->getTheme()->getName());
        $this->assertEquals("foo", $at->getTheme()->getSlug());
    }

    /**
     * @covers Liip\ThemeBundle\ActiveTheme::getThemes
     */
    public function testGetThemes()
    {
        $this->setupFixtures();

        $at = new ActiveTheme($this->em, 'example.com');

        $this->assertCount(2, $at->getThemes());
    }
    
    private function setupFixtures() {
        $themeFoo = new Theme('Foo', 'foo');
        $this->em->persist($themeFoo);
        $themeBar = new Theme('Bar', 'bar');
        $this->em->persist($themeBar);
        $site = new Site('example.com', $themeFoo);
        $this->em->persist($site);
        $this->em->flush();
    }
}
