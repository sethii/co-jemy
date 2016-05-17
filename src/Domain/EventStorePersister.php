<?php
/**
 * Created by PhpStorm.
 * User: suro
 * Date: 17/05/16
 * Time: 11:33
 */

namespace Domain;


interface EventStorePersister
{
    public function persist(array $events);
}