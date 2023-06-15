<?php namespace Dimti\SpaceWebTest\Response\Traits;

use stdClass;

trait Castable
{
    public function cast(stdClass $object): void
    {
        foreach ($object as $key => $value) {
            if (!isset($this->$key)) {
                $this->$key = $value;
            }
        }
    }
}
