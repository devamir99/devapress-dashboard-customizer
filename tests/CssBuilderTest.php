<?php

declare(strict_types=1);

namespace Devapress\Tests;

use Devapress_Css_Builder;
use Devapress_Dashboard_Customizer;
use Devapress_Login_Customizer;
use Devapress_Presets;
use Devapress_Settings;
use PHPUnit\Framework\TestCase;

/**
 * Step 4 — CSS generation (styles actually apply).
 */
class CssBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        devapress_test_reset_options();
    }

    private function dashboardSettings(string $preset, array $overrides = []): array
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = $preset;
        $settings['dashboard']['overrides'] = $overrides;
        update_option(Devapress_Settings::OPTION_KEY, $settings);
        return Devapress_Settings::get_resolved('dashboard');
    }

    private function loginSettings(string $preset, array $overrides = []): array
    {
        $settings = Devapress_Settings::defaults();
        $settings['login']['preset'] = $preset;
        $settings['login']['overrides'] = $overrides;
        update_option(Devapress_Settings::OPTION_KEY, $settings);
        return Devapress_Settings::get_resolved('login');
    }

    public function test_dashboard_css_empty_when_no_settings(): void
    {
        $css = Devapress_Css_Builder::dashboard([]);
        $this->assertSame('', $css);
    }

    public function test_dashboard_css_contains_menu_color(): void
    {
        $resolved = $this->dashboardSettings('minimal-dark');
        $css = Devapress_Dashboard_Customizer::compile_dashboard_css($resolved);

        $this->assertStringContainsString('#1d2327', $css);
        $this->assertStringContainsString('#adminmenu', $css);
    }

    public function test_dashboard_css_reflects_override(): void
    {
        $resolved = $this->dashboardSettings('minimal-dark', ['menu_color' => '#ff5500']);
        $css = Devapress_Dashboard_Customizer::compile_dashboard_css($resolved);

        $this->assertStringContainsString('#ff5500', $css);
        $this->assertStringNotContainsString('#1d2327', $css);
    }

    public function test_login_css_contains_gradient_for_glass_modern(): void
    {
        $resolved = $this->loginSettings('glass-modern');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('6366f1', $css);
        $this->assertStringContainsString('loginform', $css);
        $this->assertStringContainsString('devapress-customized', $css);
    }

    public function test_login_css_contains_button_color(): void
    {
        $resolved = $this->loginSettings('gradient-bold');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('#ec4899', $css);
    }

    public function test_login_css_glass_effect_when_enabled(): void
    {
        $resolved = $this->loginSettings('classic-clean', ['login_form_glass' => true]);
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('backdrop-filter', $css);
    }

    public function test_login_css_split_layout_structure(): void
    {
        $resolved = $this->loginSettings('glass-modern');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('devapress-layout-split', $css);
        $this->assertStringContainsString('position: fixed', $css);
        $this->assertStringContainsString('left: 0', $css);
        $this->assertStringContainsString('right: 0', $css);
    }

    public function test_login_css_fullscreen_layout_structure(): void
    {
        $resolved = $this->loginSettings('gradient-bold');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('devapress-layout-fullscreen', $css);
        $this->assertStringContainsString('background-attachment: fixed', $css);
    }

    public function test_login_css_center_layout_structure(): void
    {
        $resolved = $this->loginSettings('classic-clean');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringContainsString('devapress-layout-center', $css);
        $this->assertStringContainsString('max-width: 420px', $css);
    }

    public function test_login_css_no_glass_for_classic(): void
    {
        $resolved = $this->loginSettings('classic-clean');
        $css = Devapress_Login_Customizer::compile_login_css($resolved);

        $this->assertStringNotContainsString('backdrop-filter', $css);
        $this->assertStringContainsString('#ffffff', $css);
    }

    public function test_css_builder_wrapper_matches_direct_compile(): void
    {
        $resolved = $this->loginSettings('classic-clean');
        $this->assertSame(
            Devapress_Login_Customizer::compile_login_css($resolved),
            Devapress_Css_Builder::login($resolved)
        );
    }

    public function test_all_presets_produce_non_empty_css(): void
    {
        foreach (array_keys(Devapress_Presets::dashboard_presets()) as $id) {
            $resolved = $this->dashboardSettings($id);
            $css = Devapress_Css_Builder::dashboard($resolved);
            $this->assertNotEmpty($css, "Dashboard preset {$id} produced empty CSS");
        }

        foreach (array_keys(Devapress_Presets::login_presets()) as $id) {
            $resolved = $this->loginSettings($id);
            $css = Devapress_Css_Builder::login($resolved);
            $this->assertNotEmpty($css, "Login preset {$id} produced empty CSS");
        }
    }
}
