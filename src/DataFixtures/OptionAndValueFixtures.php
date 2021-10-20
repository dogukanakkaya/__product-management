<?php

namespace App\DataFixtures;

use App\Entity\Stock\Option;
use App\Entity\Stock\OptionValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionAndValueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $optionValue1 = (new OptionValue())->setName('Small');
        $optionValue2 = (new OptionValue())->setName('Medium');
        $optionValue3 = (new OptionValue())->setName('Large');
        $option1 = (new Option())
            ->setName('Size')
            ->addValue($optionValue1)
            ->addValue($optionValue2)
            ->addValue($optionValue3);

        $optionValue4 = (new OptionValue())->setName('White');
        $optionValue5 = (new OptionValue())->setName('Black');
        $optionValue6 = (new OptionValue())->setName('Red');
        $optionValue7 = (new OptionValue())->setName('Blue');
        $optionValue8 = (new OptionValue())->setName('Green');
        $option2 = (new Option())
            ->setName('Color')
            ->addValue($optionValue4)
            ->addValue($optionValue5)
            ->addValue($optionValue6)
            ->addValue($optionValue7)
            ->addValue($optionValue8);

        $manager->persist($option1);
        $manager->persist($option2);

        $manager->flush();
    }
}
