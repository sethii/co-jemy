<?php

namespace Domain\CoJemy;

interface EventStorePersister
{
    public function persist(array $events);
}