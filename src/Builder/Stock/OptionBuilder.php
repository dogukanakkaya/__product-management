<?php

namespace App\Builder\Stock;

class OptionBuilder
{
    public function combinations(array $options, array $combinations = [], array $group = [], $value = null, $i = 0): array
    {
        $keys = array_keys($options);
        if (isset($value)) {
            array_push($group, $value);
        }

        if ($i === count($options)) {
            array_push($combinations, $group);
        } else {
            $optionValues = $options[$keys[$i]];
            foreach ($optionValues as $optionValue) {
                $combinations = $this->combinations($options, $combinations, $group, $optionValue, $i + 1);
            }
        }

        return $combinations;
    }
}