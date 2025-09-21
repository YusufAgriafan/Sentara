# Sistem Content Fallback Admin - Sentara

## Overview

Sistem Content Fallback Admin memungkinkan administrator untuk mengatur konten default yang akan ditampilkan di halaman main ketika sebuah kelas tidak memiliki konten yang diassign oleh educator.

## Fitur Utama

### 1. Dashboard Admin dengan Pengaturan Content Fallback

-   **Lokasi**: `/admin/settings`
-   **Fungsi**: Mengatur konten fallback yang akan ditampilkan jika kelas tidak memiliki konten
-   **Konten yang dapat diatur**:
    -   Geography Models (model 3D geografi)
    -   Places (tempat bersejarah)
    -   Stories (cerita sejarah)

### 2. Logika Content Fallback

**Cara Kerja:**

1. **Student Login**: Ketika student mengakses halaman `/geografi` atau `/sejarah`
2. **Cek Assignment**: Sistem mengecek apakah kelas student memiliki konten yang diassign
3. **Fallback**: Jika tidak ada konten, sistem menampilkan konten fallback dari admin
4. **Public Access**: Non-student/guest tetap melihat konten public

### 3. Model dan Database

#### AdminSetting Model

```php
// Struktur tabel admin_settings
- id (primary key)
- key (string, unique) - nama setting
- value (text) - nilai setting
- type (string) - tipe data (string, boolean, json, etc.)
- description (text) - deskripsi setting
- is_active (boolean) - status aktif
- timestamps
```

#### Setting Keys yang Digunakan:

-   `content_fallback_enabled`: Boolean untuk mengaktifkan/menonaktifkan fallback
-   `fallback_geography_models`: Array ID model geografi untuk fallback
-   `fallback_places`: Array ID tempat untuk fallback
-   `fallback_stories`: Array ID cerita untuk fallback

## Implementasi

### 1. Controller Updates

#### AdminController

-   `settings()`: Menampilkan halaman pengaturan dengan data fallback
-   `updateContentFallback()`: Update pengaturan fallback
-   `getContentFallbackSettings()`: API endpoint untuk mendapatkan pengaturan

#### MainController

-   `geografi()`: Logic fallback untuk halaman geografi
-   `sejarah()`: Logic fallback untuk halaman sejarah
-   `showStory()`: Akses control untuk story individual

### 2. View Updates

#### Admin Settings Page

-   Form untuk enable/disable content fallback
-   Checkbox selection untuk Geography Models, Places, dan Stories
-   Real-time preview dari konten yang dipilih

#### Main Pages (Geografi & Sejarah)

-   Dynamic content loading berdasarkan user role dan class assignment
-   Fallback ke konten admin jika tidak ada assignment
-   Tetap menampilkan static content untuk guest users

### 3. Routes

```php
// Admin routes
Route::post('/admin/content-fallback', [AdminController::class, 'updateContentFallback'])
    ->name('admin.content-fallback.update');
Route::get('/admin/content-fallback/api', [AdminController::class, 'getContentFallbackSettings'])
    ->name('admin.content-fallback.api');
```

## Penggunaan

### Untuk Admin:

1. Login sebagai admin
2. Akses `/admin/settings`
3. Enable "Content Fallback"
4. Pilih konten yang ingin dijadikan fallback
5. Save settings

### Untuk Student:

1. Login sebagai student
2. Join kelas yang tidak memiliki konten assigned
3. Akses halaman `/geografi` atau `/sejarah`
4. Akan melihat konten fallback yang diatur admin

### Untuk Educator:

1. Educator dapat assign konten ke kelas mereka
2. Jika ada konten assigned, fallback tidak akan digunakan
3. Jika tidak ada konten assigned, student akan melihat fallback admin

## Database Migration

```bash
# Jalankan migration untuk membuat tabel admin_settings
php artisan migrate

# Jalankan seeder untuk data default (opsional)
php artisan db:seed --class=AdminSettingSeeder
```

## File Structure

```
app/
├── Models/
│   └── AdminSetting.php
├── Http/Controllers/
│   ├── Admin/AdminController.php
│   └── MainController.php
resources/views/
├── admin/
│   ├── dashboard.blade.php
│   └── settings.blade.php
├── main/
│   ├── geografi.blade.php
│   ├── sejarah.blade.php
│   └── story.blade.php
database/
├── migrations/
│   └── create_admin_settings_table.php
└── seeders/
    └── AdminSettingSeeder.php
```

## Benefits

1. **Flexibility**: Admin dapat mengatur konten default tanpa coding
2. **User Experience**: Student selalu melihat konten meskipun kelas belum diatur
3. **Content Management**: Centralized control untuk konten fallback
4. **Scalability**: Mudah menambah tipe konten baru untuk fallback

## Technical Notes

-   Menggunakan JSON storage untuk array IDs di database
-   Implementasi caching bisa ditambahkan untuk performa
-   Settings dapat di-extend untuk fallback berdasarkan grade atau subject
-   Compatible dengan existing content assignment system
