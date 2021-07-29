<?php
namespace Takomo\Core;

use ReflectionClass;
use Takomo\Core\Tools\Normalize;

class Autowire
{
    private array $singletons = [
        Config::class => null
    ];

    public function di(string $class) : object
    {
        $dependencies = [];
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            $params = $constructor->getParameters();
            foreach ($params as $param) {
                $type = $param->getType()->getName();
                if (array_key_exists($type, $this->singletons)) {
                    $dependencies[] = $this->getSingleton($type);
                } else {
                    $dependencies[] = $this->di($type);
                }
            }
        }
        
        return new $class(...$dependencies);
    }

    private function getSingleton(string $type) : object
    {
        if ($this->singletons[$type] === null) {
            $this->singletons[$type] = $this->di($type);
        }

        return $this->singletons[$type];
    }
}