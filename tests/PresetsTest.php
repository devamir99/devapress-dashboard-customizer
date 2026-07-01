<?php

declare(strict_types=1);

namespace Devapress\Tests;

use Devapress_Presets;
use PHPUnit\Framework\TestCase;

/**
 * Step 1 — Preset definitions.
 */
class PresetsTest extends TestCase
{
    public function test_dashboard_has_three_presets(): void
    {
        $presets = Devapress_Presets::dashboard_presets();
        $this->assertCount(3, $presets);
        $this->assertArrayHasKey('minimal-dark', $presets);
        $this->assertArrayHasKey('ocean-blue', $presets);
        $this->assertArrayHasKey('warm-light', $presets);
    }

    public function test_login_has_three_presets(): void
    {
        $presets = Devapress_Presets::login_presets();
        $this->assertCount(3, $presets);
        $this->assertArrayHasKey('glass-modern', $presets);
        $this->assertArrayHasKey('classic-clean', $presets);
        $this->assertArrayHasKey('gradient-bold', $presets);
    }

    public function test_get_returns_preset_without_meta_fields(): void
    {
        $preset = Devapress_Presets::get('dashboard', 'minimal-dark');
        $this->assertNotNull($preset);
        $this->assertSame('#1d2327', $preset['menu_color']);
        $this->assertArrayHasKey('label', $preset);
    }

    public function test_get_returns_null_for_invalid_preset(): void
    {
        $this->assertNull(Devapress_Presets::get('dashboard', 'invalid-id'));
        $this->assertNull(Devapress_Presets::get('login', 'invalid-id'));
    }

    public function test_each_dashboard_preset_has_required_color_keys(): void
    {
        $required = [
            'menu_color', 'menu_hover_color', 'menu_active_color',
            'font_color', 'icon_color',
        ];

        foreach (Devapress_Presets::dashboard_presets() as $id => $preset) {
            foreach ($required as $key) {
                $this->assertArrayHasKey($key, $preset, "Preset {$id} missing {$key}");
                $this->assertNotEmpty($preset[$key], "Preset {$id} has empty {$key}");
            }
        }
    }

    public function test_glass_modern_login_preset_has_glass_enabled(): void
    {
        $preset = Devapress_Presets::get('login', 'glass-modern');
        $this->assertTrue($preset['login_form_glass']);
        $this->assertTrue($preset['bg_gradient_enable']);
    }
}
