<?php
/**
 * Created by PhpStorm.
 * Ticket: Neok
 * Date: 15/02/2018
 * Time: 23:15
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Loader\NativeLoader;

/**
 * Class AppFixtures
 */
final class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile(__DIR__.'/fixtures.yml', [

        ]);
        foreach ($objectSet->getObjects() as $object) {
            $manager->persist($object);
        }
        $manager->flush();
    }
}
