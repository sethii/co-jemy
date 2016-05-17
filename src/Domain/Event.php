<?php

namespace Domain;

interface Event
{
    public function getType();
    public function getParametersBag();
}
