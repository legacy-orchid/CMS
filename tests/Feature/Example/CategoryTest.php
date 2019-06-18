<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Example;

use Orchid\Press\Models\Taxonomy;
use Orchid\Press\Models\Term;
use Orchid\Tests\TestFeatureCase;

class CategoryTest extends TestFeatureCase
{
    /**
     * @return array
     */
    private function createTaxonomyWithChildren()
    {
        $taxonomy = factory(Taxonomy::class)->create([
            'taxonomy' => 'category',
            'term_id'  => function () {
                return factory(Term::class)->create()->id;
            },
        ]);

        $taxonomys[] = $taxonomy;

        for ($i = 1; $i <= 3; $i++) {
            $taxonomys[] = factory(Taxonomy::class)->create([
                'taxonomy'  => 'category',
                'parent_id' => $taxonomy->id,
                'term_id'   => function () {
                    return factory(Term::class)->create()->id;
                },
            ]);
        }

        return $taxonomys;
    }

    public function testRouteSystemsCategory()
    {
        $this->createTaxonomyWithChildren();
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.category'));
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();

        $response
            ->assertOk()
            ->assertSee($taxonomy->term->getContent('name'));
    }

    public function testRouteSystemsCategoryEdit()
    {
        $this->createTaxonomyWithChildren();
        $taxonomy = Taxonomy::where('parent_id', null)->get()->first();

        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.category.edit', $taxonomy->id));

        $response
            ->assertOk()
            ->assertSee($taxonomy->term->getContent('name'));
    }
}
