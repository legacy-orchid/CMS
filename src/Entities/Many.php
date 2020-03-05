<?php

declare(strict_types=1);

namespace Orchid\Press\Entities;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Collection;
use Orchid\Press\Models\Post;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

abstract class Many implements EntityContract, UrlRoutable
{
    use Structure;
    use Actions;
    /**
     * Eloquent Eager Loading.
     *
     * @var array
     */
    public $with = [];

    /**
     * @var null
     */
    public $slugFields;

    /**
     * Registered fields to display in the table.
     *
     * @return array
     */
    abstract public function grid(): array;

    /**
     * HTTP data filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * @return \Illuminate\Contracts\Pagination\Paginator
     */
    public function get(): Paginator
    {
        return Post::type($this->slug)
            ->filtersApplyDashboard($this->slug)
            ->filters()
            ->with($this->with)
            ->defaultSort('id', 'desc')
            ->paginate();
    }

    /**
     * Get all the filters.
     *
     * @return Collection
     */
    public function getFilters(): Collection
    {
        $filters = collect();
        foreach ($this->filters() as $filter) {
            $filter = new $filter($this);
            $filters->push($filter);
        }

        return $filters;
    }

    /**
     * Registered fields for main.
     *
     * @throws \Throwable|\Orchid\Press\Exceptions\EntityTypeException
     *
     * @return array
     */
    public function main(): array
    {
        return [
            Input::make('slug')
                ->type('text')
                ->name('slug')
                ->max(255)
                ->title(__('Semantic URL'))
                ->placeholder(__('Unique name')),

            DateTimer::make('publish_at')
                ->title(__('Time of publication')),

            Select::make('status')
                ->options($this->status())
                ->title(__('Status')),
        ];
    }
}
