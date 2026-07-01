<?php

declare(strict_types=1);

namespace Devapress\Tests;

use Devapress_Settings;
use PHPUnit\Framework\TestCase;

/**
 * Step 2 — Settings storage, opt-in, merge, sanitize.
 */
class SettingsTest extends TestCase
{
    protected function setUp(): void
    {
        devapress_test_reset_options();
    }

    public function test_defaults_use_none_preset(): void
    {
        $defaults = Devapress_Settings::defaults();
        $this->assertSame('none', $defaults['dashboard']['preset']);
        $this->assertSame('none', $defaults['login']['preset']);
    }

    public function test_is_active_false_when_preset_none(): void
    {
        update_option(Devapress_Settings::OPTION_KEY, Devapress_Settings::defaults());
        $this->assertFalse(Devapress_Settings::is_active('dashboard'));
        $this->assertFalse(Devapress_Settings::is_active('login'));
    }

    public function test_is_active_true_when_preset_selected(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = 'minimal-dark';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        $this->assertTrue(Devapress_Settings::is_active('dashboard'));
        $this->assertFalse(Devapress_Settings::is_active('login'));
    }

    public function test_get_resolved_empty_when_preset_none(): void
    {
        update_option(Devapress_Settings::OPTION_KEY, Devapress_Settings::defaults());
        $this->assertSame([], Devapress_Settings::get_resolved('dashboard'));
        $this->assertSame([], Devapress_Settings::get_resolved('login'));
    }

    public function test_get_resolved_merges_preset_values(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = 'ocean-blue';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        $resolved = Devapress_Settings::get_resolved('dashboard');
        $this->assertSame('#0a2540', $resolved['menu_color']);
        $this->assertSame('#1e88e5', $resolved['menu_active_color']);
    }

    public function test_get_resolved_override_wins_over_preset(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = 'minimal-dark';
        $settings['dashboard']['overrides']['menu_color'] = '#ff0000';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        $resolved = Devapress_Settings::get_resolved('dashboard');
        $this->assertSame('#ff0000', $resolved['menu_color']);
    }

    public function test_sanitize_rejects_invalid_preset(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'hacked-preset';

        $result = Devapress_Settings::sanitize($input);
        $this->assertSame('none', $result['dashboard']['preset']);
    }

    public function test_sanitize_accepts_valid_presets(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'warm-light';
        $input['login']['preset'] = 'gradient-bold';

        $result = Devapress_Settings::sanitize($input);
        $this->assertSame('warm-light', $result['dashboard']['preset']);
        $this->assertSame('gradient-bold', $result['login']['preset']);
    }

    public function test_sanitize_strips_override_matching_preset_value(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'minimal-dark';
        $input['dashboard']['overrides']['menu_color'] = '#1d2327';

        $result = Devapress_Settings::sanitize($input);
        $this->assertArrayNotHasKey('menu_color', $result['dashboard']['overrides']);
    }

    public function test_sanitize_keeps_different_override(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'minimal-dark';
        $input['dashboard']['overrides']['menu_color'] = '#abcdef';

        $result = Devapress_Settings::sanitize($input);
        $this->assertSame('#abcdef', $result['dashboard']['overrides']['menu_color']);
    }

    public function test_sanitize_login_color_overrides(): void
    {
        $input = Devapress_Settings::defaults();
        $input['login']['preset'] = 'classic-clean';
        $input['login']['overrides']['login_btn_bg'] = '#000000';

        $result = Devapress_Settings::sanitize($input);
        $this->assertSame('#000000', $result['login']['overrides']['login_btn_bg']);
    }

    public function test_sanitize_rejects_invalid_hex_color(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'minimal-dark';
        $input['dashboard']['overrides']['menu_color'] = 'not-a-color';

        $result = Devapress_Settings::sanitize($input);
        $this->assertArrayNotHasKey('menu_color', $result['dashboard']['overrides']);
    }

    public function test_sanitize_persists_login_font_enable_checkbox(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['login_font_enable'] = '1';

        $result = Devapress_Settings::sanitize($input);
        $this->assertTrue($result['dashboard']['login_font_enable']);
    }

    public function test_sanitize_persists_media_ids(): void
    {
        $input = Devapress_Settings::defaults();
        $input['login']['preset'] = 'classic-clean';
        $input['login']['bg_image_id'] = '42';
        $input['login']['logo_id'] = '99';

        $result = Devapress_Settings::sanitize($input);
        $this->assertSame(42, $result['login']['bg_image_id']);
        $this->assertSame(99, $result['login']['logo_id']);
    }

    public function test_reset_section_restores_defaults_for_dashboard(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = 'ocean-blue';
        $settings['dashboard']['overrides']['menu_color'] = '#ff0000';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        Devapress_Settings::reset_section('dashboard');
        $all = Devapress_Settings::get_all();

        $this->assertSame('none', $all['dashboard']['preset']);
        $this->assertSame([], $all['dashboard']['overrides']);
    }

    public function test_full_save_cycle_via_update_option(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'minimal-dark';
        $input['login']['preset'] = 'glass-modern';
        $input['dashboard']['overrides']['font_size'] = 16;

        $sanitized = Devapress_Settings::sanitize($input);
        update_option(Devapress_Settings::OPTION_KEY, $sanitized);

        $this->assertTrue(Devapress_Settings::is_active('dashboard'));
        $this->assertTrue(Devapress_Settings::is_active('login'));

        $resolved = Devapress_Settings::get_resolved('dashboard');
        $this->assertSame(16, $resolved['font_size']);
    }
}
