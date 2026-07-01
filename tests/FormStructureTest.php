<?php

declare(strict_types=1);

namespace Devapress\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Step 6 — Settings page HTML structure (save button must stay inside form).
 */
class FormStructureTest extends TestCase
{
    public function test_main_settings_form_has_no_nested_forms(): void
    {
        $path = DEVAPRESS_VIEW_DIR . 'settings-page.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);

        if (!preg_match('/<form[^>]*id="devapress-settings-form"[^>]*>(.*?)<\/form>/s', $content, $matches)) {
            $this->fail('Main settings form not found.');
        }

        $inner = $matches[1];
        $this->assertStringNotContainsString('<form', $inner, 'Nested forms break the save button in browsers.');
    }

    public function test_save_button_is_inside_main_form(): void
    {
        $content = file_get_contents(DEVAPRESS_VIEW_DIR . 'settings-page.php');
        $this->assertIsString($content);

        $formPos  = strpos($content, 'id="devapress-settings-form"');
        $closePos = strpos($content, '</form>', $formPos);
        $submitPos = strpos($content, 'submit_button', $formPos);

        $this->assertNotFalse($formPos);
        $this->assertNotFalse($closePos);
        $this->assertNotFalse($submitPos);
        $this->assertLessThan($closePos, $submitPos, 'Save button must be inside the main form.');
    }

    public function test_tools_tab_is_outside_main_form(): void
    {
        $content = file_get_contents(DEVAPRESS_VIEW_DIR . 'settings-page.php');
        $this->assertIsString($content);

        $mainFormClose = strpos($content, '</form>');
        $toolsTab      = strpos($content, 'id="tab-tools"');

        $this->assertNotFalse($mainFormClose);
        $this->assertNotFalse($toolsTab);
        $this->assertGreaterThan($mainFormClose, $toolsTab, 'Tools tab forms must be outside the main settings form.');
    }
}
