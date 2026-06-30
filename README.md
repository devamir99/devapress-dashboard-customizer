devapress-customizer/
│
├── devapress-customizer.php        # فایل اصلی پلاگین
├── uninstall.php                   # حذف پلاگین و پاکسازی تنظیمات
├── README.md                       # توضیحات پلاگین
│
├── assets/
│   ├── css/
│   │   ├── admin.css               # استایل داشبورد و پنل تنظیمات
│   │   ├── login.css               # استایل صفحه لاگین
│   │   └── preview.css             # استایل پیش‌نمایش زنده
│   ├── js/
│   │   ├── admin.js                # جاوااسکریپت پنل تنظیمات و پیش‌نمایش
│   │   └── login.js                # JS مخصوص صفحه لاگین
│   └── fonts/                       # فونت‌های آپلود شده یا پیش‌فرض
│
├── includes/
│   ├── admin/
│   │   ├── class-admin-menu.php      # ساخت منو و زیرمنوی Settings
│   │   ├── class-admin-settings.php  # ثبت گزینه‌ها و مدیریت تنظیمات
│   │   ├── class-admin-preview.php   # پیش‌نمایش زنده تغییرات
│   │   └── class-admin-panels.php    # ساخت پنل‌های تب‌بندی یا آکاردئون
│   │
│   ├── frontend/
│   │   ├── class-dashboard-customizer.php  # اعمال فونت/رنگ روی داشبورد
│   │   └── class-login-customizer.php      # اعمال تغییرات روی صفحه لاگین
│   │
│   └── class-core.php                  # کلاس اصلی پلاگین، بارگذاری ماژول‌ها
│
└── languages/                          # فایل‌های ترجمه
