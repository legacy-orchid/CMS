<?php

declare(strict_types=1);

use Orchid\Alert\Alert;
use Orchid\Screen\Builder;
use Illuminate\Support\Str;
use Orchid\Screen\Repository;
use Orchid\Filters\HttpFilter;
use Orchid\Support\Facades\Setting;
use Symfony\Component\Finder\Finder;
use Orchid\Support\Facades\Dashboard;


if (! function_exists('generate_form')) {
    /**
     * @deprecated
     *
     * Generate a ready-made html form for display to the user.
     *
     * @param array                 $fields
     * @param array|Repository|null $data
     * @param string|null           $language
     * @param string|null           $prefix
     *
     *@throws \Throwable
     *
     * @return string
     */
    function generate_form(array $fields, $data = [], string $language = null, string $prefix = null)
    {
        if (is_array($data)) {
            $data = new Repository($data);
        }

        return (new Builder($fields, $data))
            ->setLanguage($language)
            ->setPrefix($prefix)
            ->generateForm();
    }
}