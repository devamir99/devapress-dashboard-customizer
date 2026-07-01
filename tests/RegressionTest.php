<?php

declare(strict_types=1);

namespace Devapress\Tests;

use Devapress_Settings;
use PHPUnit\Framework\TestCase;

/**
 * Step 5 — Regression tests for common "changes not applying" bugs.
 */
class RegressionTest extends TestCase
{
    protected function setUp(): void
    {
        devapress_test_reset_options();
    }

    /**
     * Bug: plugin applied CSS on activation with default get_option fallbacks.
     * Fix: preset must be explicitly selected.
     */
    public function test_fresh_install_does_not_apply_styles(): void
    {
        update_option(Devapress_Settings::OPTION_KEY, Devapress_Settings::defaults());

        $this->assertFalse(Devapress_Settings::is_active('dashboard'));
        $this->assertFalse(Devapress_Settings::is_active('login'));
        $this->assertSame([], Devapress_Settings::get_resolved('dashboard'));
        $this->assertSame([], Devapress_Settings::get_resolved('login'));
    }

    /**
     * Simulates form submit: user selects preset only (no overrides in POST).
     */
    public function test_save_preset_only_without_overrides(): void
    {
        $input = [
            'dashboard' => [
                'preset'            => 'minimal-dark',
                'overrides'         => [],
                'font_file'         => '',
                'login_font_enable' => false,
            ],
            'login' => [
                'preset'      => 'classic-clean',
                'overrides'   => [],
                'bg_image_id' => 0,
                'logo_id'     => 0,
            ],
        ];

        $sanitized = Devapress_Settings::sanitize($input);
        update_option(Devapress_Settings::OPTION_KEY, $sanitized);

        $this->assertTrue(Devapress_Settings::is_active('dashboard'));
        $this->assertSame('#1d2327', Devapress_Settings::get_resolved('dashboard')['menu_color']);
    }

    /**
     * Simulates form submit with color fields matching preset (should not bloat overrides).
     */
    public function test_form_submit_with_preset_default_colors_strips_redundant_overrides(): void
    {
        $preset = \Devapress_Presets::get('dashboard', 'ocean-blue');

        $input = [
            'dashboard' => [
                'preset'    => 'ocean-blue',
                'overrides' => [
                    'menu_color'       => $preset['menu_color'],
                    'menu_hover_color' => $preset['menu_hover_color'],
                    'font_color'       => '#ff0000',
                ],
                'font_file'         => '',
                'login_font_enable' => false,
            ],
            'login' => [
                'preset'      => 'none',
                'overrides'   => [],
                'bg_image_id' => 0,
                'logo_id'     => 0,
            ],
        ];

        $sanitized = Devapress_Settings::sanitize($input);

        $this->assertArrayNotHasKey('menu_color', $sanitized['dashboard']['overrides']);
        $this->assertArrayNotHasKey('menu_hover_color', $sanitized['dashboard']['overrides']);
        $this->assertSame('#ff0000', $sanitized['dashboard']['overrides']['font_color']);
    }

    /**
     * Unchecked checkbox must not enable login_font_enable.
     */
    public function test_unchecked_login_font_enable(): void
    {
        $input = Devapress_Settings::defaults();
        $input['dashboard']['preset'] = 'minimal-dark';
        unset($input['dashboard']['login_font_enable']);

        $sanitized = Devapress_Settings::sanitize($input);
        $this->assertFalse($sanitized['dashboard']['login_font_enable']);
    }

    /**
     * Changing only login preset must not reset dashboard preset.
     */
    public function test_partial_update_preserves_other_section(): void
    {
        $stored = Devapress_Settings::defaults();
        $stored['dashboard']['preset'] = 'warm-light';
        update_option(Devapress_Settings::OPTION_KEY, $stored);

        $input = Devapress_Settings::get_all();
        $input['login']['preset'] = 'glass-modern';

        $sanitized = Devapress_Settings::sanitize($input);
        update_option(Devapress_Settings::OPTION_KEY, $sanitized);

        $all = Devapress_Settings::get_all();
        $this->assertSame('warm-light', $all['dashboard']['preset']);
        $this->assertSame('glass-modern', $all['login']['preset']);
    }

    public function test_invalid_sanitize_input_returns_current_settings(): void
    {
        $stored = Devapress_Settings::defaults();
        $stored['dashboard']['preset'] = 'minimal-dark';
        update_option(Devapress_Settings::OPTION_KEY, $stored);

        $result = Devapress_Settings::sanitize('not-an-array');
        $this->assertSame('minimal-dark', $result['dashboard']['preset']);
    }
}
