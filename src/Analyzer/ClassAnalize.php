<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

use Greeflas\StaticAnalyzer\ClassInfoHelper;

/**
 * Analyzer that provides analize of classes.
 *
 * @author Svitozar Kuzemkyi <svetozarrambler@gmail.com>
 */
final class ClassAnalize
{
    protected $classPath;
    protected $classInfo;
    protected $reflectionClient;

    public function __construct(string $classPath)
    {
        $this->classPath = $_SERVER['DOCUMENT_ROOT'] . $classPath;
        $this->analyze();
    }

    protected function analyze(): void
    {
        $className = ClassInfoHelper::getFullClassNameFromFile($this->classPath);
        $this->reflectionClient = new \ReflectionClass($className);
    }

    public function getClassName(): string
    {
        return $this->reflectionClient->getShortName();
    }

    public function getClassType(): string
    {
        if ($this->reflectionClient->isFinal()) {
            return 'final';
        }

        if ($this->reflectionClient->isAbstract()) {
            return 'abstract';
        }

        return 'normal';
    }

    public function getPropertiesPublic(): int
    {
        return \count($this->reflectionClient->getProperties(\ReflectionProperty::IS_PUBLIC));
    }

    public function getPropertiesPrivate(): int
    {
        return \count($this->reflectionClient->getProperties(\ReflectionProperty::IS_PRIVATE));
    }

    public function getPropertiesProtected(): int
    {
        return \count($this->reflectionClient->getProperties(\ReflectionProperty::IS_PROTECTED));
    }

    public function getMethodsPublic(): int
    {
        return \count($this->reflectionClient->getMethods(\ReflectionMethod::IS_PUBLIC));
    }

    public function getMethodsPrivate(): int
    {
        return \count($this->reflectionClient->getMethods(\ReflectionMethod::IS_PRIVATE));
    }

    public function getMethodsProtected(): int
    {
        return \count($this->reflectionClient->getMethods(\ReflectionMethod::IS_PROTECTED));
    }
}
