<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Command;

use Greeflas\StaticAnalyzer\Analyzer\ClassAnalize;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command for getting information about how many method and properties
 * has entered Class.
 *
 * Example of usage
 * ./bin/console analize:clsass-analize src/Analyzer/ClassAuthor.php
 *
 * @author Svitozar Kuzemkyi <svetozarrambler@gmail.com>
 */
class ClassAnalizeStat extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('analize:clsass-analize')
            ->setDescription('Shows analize of Class')
            ->addArgument(
                'fullClassName',
                InputArgument::REQUIRED,
                'Full Class Name of needed php class.'
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classPath = $input->getArgument('fullClassName');

        $analyzer = new ClassAnalize($classPath);

        $className = $analyzer->getClassName();
        $classType = $analyzer->getClassType();

        $propPublic = $analyzer->getPropertiesPublic();
        $propPrivate = $analyzer->getPropertiesPrivate();
        $propProtected = $analyzer->getPropertiesProtected();

        $methodPublic = $analyzer->getMethodsPublic();
        $methodPrivate = $analyzer->getMethodsPrivate();
        $methodProtected = $analyzer->getMethodsProtected();

        $output->writeln(\sprintf(
            '<info>Class %s is %s 
Properties:
    public: %d
    protected: %d
    private: %d
Methods:
    public: %d
    protected: %d
    private: %d
     </info>',
            $className,
            $classType,
            $propPublic,
            $propPrivate,
            $propProtected,
            $methodPublic,
            $methodPrivate,
            $methodProtected
        ));
    }
}
