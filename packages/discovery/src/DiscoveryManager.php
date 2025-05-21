<?php

namespace Khronos\Discovery;

use ReflectionClass;

final class DiscoveryManager
{
    private array $classAgents = [];
    private array $methodAgents = [];

    public function __construct(private ClassLocator $classLocator)
    {
        //
    }

    public function addClassAgent(ClassDiscoveryAgent $agent): void
    {
        $this->classAgents[] = $agent;
    }

    public function addMethodAgent(MethodDiscoveryAgent $agent): void
    {
        $this->methodAgents[] = $agent;
    }

    public function discover(): void
    {
        foreach ($this->classLocator as $class) {
            $class = new ReflectionClass($class);
            $methods = $class->getMethods();

            foreach ($this->classAgents as $agent) {
                if ($agent->getMatchingRule()->matches($class)) {
                    $agent->onMatch($class);
                }
            }

            foreach ($this->methodAgents as $agent) {
                if ($agent->getMatchingRule()->matches($methods)) {
                    $agent->onMatch($methods);
                }
            }
        }
    }
}