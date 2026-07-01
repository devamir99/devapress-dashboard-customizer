<?php

declare(strict_types=1);

namespace Devapress\Tests;

use Devapress_Export_Import;
use Devapress_Settings;
use PHPUnit\Framework\TestCase;

/**
 * Step 3 — Export / import JSON packages.
 */
class ExportImportTest extends TestCase
{
    protected function setUp(): void
    {
        devapress_test_reset_options();
    }

    public function test_build_export_package_structure(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['dashboard']['preset'] = 'minimal-dark';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        $package = Devapress_Export_Import::build_export_package();

        $this->assertSame('devapress-export', $package['schema']);
        $this->assertSame(1, $package['export_version']);
        $this->assertArrayHasKey('settings', $package);
        $this->assertArrayHasKey('media_urls', $package);
        $this->assertSame('minimal-dark', $package['settings']['dashboard']['preset']);
    }

    public function test_export_includes_media_urls_when_ids_set(): void
    {
        $settings = Devapress_Settings::defaults();
        $settings['login']['preset'] = 'classic-clean';
        $settings['login']['bg_image_id'] = 10;
        $settings['login']['logo_id'] = 20;
        $settings['dashboard']['font_file'] = 'http://example.com/font.woff2';
        update_option(Devapress_Settings::OPTION_KEY, $settings);

        $package = Devapress_Export_Import::build_export_package();

        $this->assertSame('http://example.com/font.woff2', $package['media_urls']['font_file']);
        $this->assertStringContainsString('image-10', $package['media_urls']['bg_image']);
        $this->assertStringContainsString('image-20', $package['media_urls']['logo']);
    }

    public function test_import_package_success(): void
    {
        $data = [
            'schema'   => 'devapress-export',
            'settings' => [
                'dashboard' => [
                    'preset'    => 'ocean-blue',
                    'overrides' => [],
                    'font_file' => '',
                    'login_font_enable' => false,
                ],
                'login' => [
                    'preset'      => 'gradient-bold',
                    'overrides'   => [],
                    'bg_image_id' => 0,
                    'logo_id'     => 0,
                ],
            ],
        ];

        $result = Devapress_Export_Import::import_package($data);
        $this->assertTrue($result['success']);

        $all = Devapress_Settings::get_all();
        $this->assertSame('ocean-blue', $all['dashboard']['preset']);
        $this->assertSame('gradient-bold', $all['login']['preset']);
    }

    public function test_import_rejects_invalid_json_structure(): void
    {
        $result = Devapress_Export_Import::import_package(null);
        $this->assertFalse($result['success']);

        $result = Devapress_Export_Import::import_package(['schema' => 'wrong']);
        $this->assertFalse($result['success']);
    }

    public function test_import_rejects_wrong_schema(): void
    {
        $data = [
            'schema'   => 'other-plugin',
            'settings' => Devapress_Settings::defaults(),
        ];

        $result = Devapress_Export_Import::import_package($data);
        $this->assertFalse($result['success']);
    }

    public function test_demo_json_files_are_valid(): void
    {
        $demos = ['demo-minimal', 'demo-modern', 'demo-bold'];

        foreach ($demos as $demo) {
            $path = DEVAPRESS_PLUGIN_DIR . 'assets/demo/' . $demo . '.json';
            $this->assertFileExists($path, "Demo file missing: {$demo}");

            $data = json_decode(file_get_contents($path), true);
            $this->assertIsArray($data);

            $result = Devapress_Export_Import::import_package($data);
            $this->assertTrue($result['success'], "Demo import failed: {$demo}");

            devapress_test_reset_options();
        }
    }

    public function test_demo_presets_returns_three_items(): void
    {
        $this->assertCount(3, Devapress_Export_Import::demo_presets());
    }
}
