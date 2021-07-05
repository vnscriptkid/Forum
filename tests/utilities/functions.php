<?php

function create($class, $amount = null, $attributes = [])
{
    return $class::factory($amount ?: $amount)->create($attributes);
}

function make($class, $amount = null, $attributes = [])
{
    return $class::factory($amount ?: $amount)->make($attributes);
}
