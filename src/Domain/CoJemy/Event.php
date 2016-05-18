<?php

namespace Domain\CoJemy;

interface Event
{
    public function getType();
    public function getParametersBag();
}
