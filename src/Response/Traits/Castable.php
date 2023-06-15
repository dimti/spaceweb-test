<?php namespace Dimti\SpaceWebTest\Response\Traits;

use stdClass;

trait Castable
{
    protected function cast(stdClass $object): void
    {
        foreach ($object as $key => $value) {
            if (!isset($this->$key)) {
                $this->$key = $value;
            }
        }
    }
}
