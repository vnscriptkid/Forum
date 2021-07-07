<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $filters = [];
    protected $builder;
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        $this->getFilters()
            ->each(function ($value, $filter) {
                if (method_exists($this, $filter)) {
                    $this->$filter($value);
                }
            });

        return $this->builder;
    }

    private function getFilters()
    {
        return collect($this->request)->only($this->filters);
    }
}
