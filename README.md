# Devapress Dashboard Customizer

WordPress plugin to customize the **admin dashboard** and **login page** with presets, live preview, and full override control.

| | |
|---|---|
| **Version** | 2.2.0 |
| **Author** | Amir Falahi |
| **Text Domain** | `devapress-customizer` |
| **Requires WordPress** | 5.0+ |
| **Requires PHP** | 7.4+ |
| **License** | GPL v2+ |

---

## Features

### Dashboard (3 presets)
- **Minimal Dark** — professional dark sidebar
- **Ocean Blue** — dark menu with blue accent
- **Warm Light** — light sidebar for bright environments

### Login page (3 presets)
- **Glass Modern** — purple gradient + glass form
- **Classic Clean** — standard WordPress-style login
- **Gradient Bold** — bold pink/red gradient

### Customization
- Custom font upload (`ttf`, `otf`, `woff`, `woff2`)
- Menu colors, icon colors, typography
- Login background image, logo, gradients, glass effect
- **Opt-in:** no styles applied until a preset is selected

### Admin experience
- Live mock preview while editing
- Real login preview via admin-ajax iframe
- **Export / Import** settings as JSON
- One-click **demo bundles**
- Preset gallery with SVG screenshots

---

## Installation

1. Copy `devapress-dashboard-customizer` to `wp-content/plugins/`
2. Activate from **Plugins**
3. Go to **Settings → شخصی‌ساز دواپرس**

---

## Usage

| Tab | Description |
|---|---|
| **Dashboard** | Pick a menu preset + customize colors/fonts |
| **Login** | Pick a login preset + background, form, button |
| **About** | Gallery of all presets with quick-apply buttons |
| **Tools** | Export JSON, import settings, load demo bundles |
| **Reset** | Reset dashboard, login, or all settings |

Click **ذخیره تغییرات** to apply changes to the live site.

---

## Export / Import

Export downloads a JSON file including:
- All `devapress_settings` (presets + overrides)
- Media URLs (font, background, logo) for cross-site migration

Import optionally downloads remote media from exported URLs.

Demo files in `assets/demo/`:
- `demo-minimal.json` — Minimal Dark + Classic Clean
- `demo-modern.json` — Ocean Blue + Glass Modern
- `demo-bold.json` — Warm Light + Gradient Bold

---

## Project structure

```
devapress-dashboard-customizer/
├── devapress-customizer.php
├── class-core.php
├── uninstall.php
├── assets/
│   ├── css/ admin.css, login.css
│   ├── js/  admin.js, preview.js
│   ├── demo/          # importable demo JSON
│   └── images/presets/ # SVG gallery assets
├── includes/
│   ├── class-devapress-presets.php
│   ├── class-devapress-settings.php
│   ├── class-devapress-css-builder.php
│   ├── admin/
│   └── frontend/
└── views/
    ├── admin/
    └── preview/
```

---

## Development

### Main classes
- `Devapress_Core` — bootstrap
- `Devapress_Settings` — unified settings storage
- `Devapress_Presets` — preset definitions
- `Devapress_Export_Import` — JSON export/import
- `Devapress_Admin_Preview` — live preview AJAX
- `Devapress_Dashboard_Customizer` / `Devapress_Login_Customizer` — frontend CSS

### Constants
`DEVAPRESS_PLUGIN_DIR`, `DEVAPRESS_PLUGIN_URL`, `DEVAPRESS_VERSION`, `DEVAPRESS_VIEW_DIR`

---

## Changelog

### 2.2.0
- Export / import settings (JSON)
- Demo bundles for quick setup
- Preset gallery with SVG screenshots
- Tools tab, uninstall cleanup, `.gitignore`

### 2.1.0
- Live preview (mock + login iframe)
- Enhanced preset thumbnails
- About tab, two-column settings layout

### 2.0.0
- Preset system (6 presets)
- Opt-in styling (no change until preset selected)
- Unified settings API, migration from v1 options

### 1.0.0
- Initial release

---

## فارسی

پلاگین **شخصی‌ساز دواپرس** برای سفارشی‌سازی داشبورد و صفحه ورود وردپرس با ۶ طرح آماده، پیش‌نمایش زنده، و خروجی/ورود JSON طراحی شده است.

مسیر تنظیمات: **تنظیمات → شخصی‌ساز دواپرس**

---

## License

GPL v2 or later.
