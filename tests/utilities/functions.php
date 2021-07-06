<?php

function create($class, $amount = null, $attributes = [])
{
    if ($amount === 1) $amount = null;

    return $class::factory($amount ?: $amount)->create($attributes);
}

function make($class, $amount = null, $attributes = [])
{
    if ($amount === 1) $amount = null;

    return $class::factory($amount ?: $amount)->make($attributes);
}
