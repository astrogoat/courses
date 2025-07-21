<?php

namespace Astrogoat\Courses\Bricks\ValueObjects;

use Astrogoat\Courses\Models\Course;
use Helix\Lego\Bricks\ValueObjects\BrickValueObject;

class CourseValueObject extends BrickValueObject
{
    public function forJavascript()
    {
        return $this->value;
    }

    public function getModel(): ?Course
    {
        return Course::find($this->getValue());
    }

    public function __get(string $name)
    {
        return $this->getModel()?->$name;
    }

    public function __call(string $name, array $arguments)
    {
        return $this->getModel()?->$name(...$arguments);
    }

    public function __toString()
    {
        return '';
    }

    public function offsetExists(mixed $offset)
    {
        // TODO: Implement offsetExists() method.
    }

    public function offsetGet(mixed $offset)
    {
        // TODO: Implement offsetGet() method.
    }

    public function offsetSet(mixed $offset, mixed $value)
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset(mixed $offset)
    {
        // TODO: Implement offsetUnset() method.
    }
}
