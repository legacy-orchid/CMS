<?php

declare(strict_types=1);

namespace Orchid\Tests\Feature\Platform;

use Orchid\Tests\TestFeatureCase;

class SystemTest extends TestFeatureCase
{
    public function testRoutePlatformSystemsMenuIndex()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.menu.index'));

        $response->assertStatus(302)
            ->assertRedirect('/dashboard/press/menu/header');
    }

    public function testRoutePlatformSystemsMenuShow()
    {
        $response = $this->actingAs($this->createAdminUser())
            ->get(route('platform.systems.menu.show', 'header'));

        $response->assertOk();
        $this->assertStringContainsString('data-controller="components--menu"', $response->getContent());
    }
}
