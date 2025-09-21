# Sentara Admin Dashboard - Dokumentasi Lengkap

## Overview

Dashboard admin Sentara telah dikembangkan dengan fitur-fitur lengkap untuk mengelola sistem pembelajaran geografi dan sejarah. Dashboard ini menyediakan kontrol penuh atas konten, pengguna, dan pengaturan sistem.

## Fitur Utama yang Telah Diimplementasi

### 1. Content Fallback System ✅

**Fitur**: Sistem fallback konten admin ketika konten kelas tidak tersedia
**Lokasi**:

-   Model: `app/Models/AdminSetting.php`
-   Controller: `app/Http/Controllers/Admin/AdminController.php`
-   Controller: `app/Http/Controllers/MainController.php`

**Fungsi**:

-   Jika siswa tidak memiliki konten untuk kelasnya, sistem akan menampilkan konten dari admin
-   Pengaturan dapat diaktifkan/nonaktifkan melalui admin dashboard
-   Berlaku untuk Geography Models, Places, dan Stories

**Cara Kerja**:

1. Siswa mengakses halaman geografi/sejarah
2. Sistem mengecek apakah ada konten untuk kelas siswa
3. Jika tidak ada, sistem menampilkan konten admin yang bersifat public
4. Admin dapat mengatur fallback melalui settings dashboard

### 2. User Management System ✅

**Fitur**: CRUD lengkap untuk manajemen pengguna
**Lokasi**:

-   Views: `resources/views/admin/users/`
-   Controller methods: `users()`, `storeUser()`, `showUser()`, `editUser()`, `updateUser()`, `deleteUser()`

**Fungsi**:

-   Lihat semua pengguna dengan filtering berdasarkan role
-   Tambah pengguna baru (admin/educator/student)
-   Edit detail pengguna
-   Hapus pengguna
-   Bulk actions untuk multiple users
-   Statistik pengguna real-time

### 3. Content Management System ✅

**Fitur**: Manajemen konten dengan tab interface
**Lokasi**:

-   View: `resources/views/admin/content.blade.php`
-   Controller methods: `contentManagement()`, `toggleGeographyModelStatus()`, dll

**Fungsi**:

-   **Geography Models**: Toggle status active/inactive, toggle public/private, hapus model
-   **Places**: Manajemen tempat-tempat geografis, hapus places
-   **Stories**: Manajemen cerita sejarah, hapus stories
-   Filtering berdasarkan status dan visibility
-   Statistik konten per kategori

### 4. Reports & Analytics Dashboard ✅

**Fitur**: Dashboard analitik dengan charts dan metrics
**Lokasi**:

-   View: `resources/views/admin/reports.blade.php`
-   Controller method: `reports()`

**Fungsi**:

-   **User Growth Charts**: Grafik pertumbuhan pengguna menggunakan Chart.js
-   **Content Distribution**: Pie chart distribusi konten
-   **Activity Summary**: Ringkasan aktivitas terbaru
-   **System Statistics**: Metrics sistem secara keseluruhan
-   Export report functionality

### 5. Enhanced Admin Dashboard ✅

**Fitur**: Dashboard utama dengan overview sistem
**Lokasi**:

-   Controller method: `dashboard()`
-   Layout: `resources/views/layouts/admin.blade.php`

**Fungsi**:

-   Cards dengan statistik utama (users, content, classes)
-   Quick actions untuk tugas admin
-   Recent activity feed
-   System health indicators
-   Navigation yang user-friendly

## Struktur Database

### AdminSetting Model

```php
// Tabel: admin_settings
- id (primary key)
- key (unique string)
- value (text)
- type (enum: string, boolean, integer, json)
- description (text)
- timestamps
```

**Settings yang Digunakan**:

-   `content_fallback_enabled`: Enable/disable fallback system
-   `fallback_geography_enabled`: Enable geography fallback
-   `fallback_stories_enabled`: Enable stories fallback
-   `fallback_places_enabled`: Enable places fallback

## Routes yang Telah Dibuat

```php
// Admin routes group dengan middleware auth, verified, role:admin
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // User Management
    Route::get('/users', [AdminController::class, 'users']);
    Route::post('/users', [AdminController::class, 'storeUser']);
    Route::get('/users/{user}', [AdminController::class, 'showUser']);
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser']);
    Route::put('/users/{user}', [AdminController::class, 'updateUser']);
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser']);
    Route::post('/users/bulk-action', [AdminController::class, 'bulkActionUsers']);

    // Content Management
    Route::get('/content', [AdminController::class, 'contentManagement']);
    Route::post('/geography-models/{model}/toggle-status', [AdminController::class, 'toggleGeographyModelStatus']);
    Route::post('/geography-models/{model}/toggle-public', [AdminController::class, 'toggleGeographyModelPublic']);
    Route::delete('/geography-models/{model}', [AdminController::class, 'deleteGeographyModel']);
    Route::delete('/stories/{story}', [AdminController::class, 'deleteStory']);
    Route::delete('/places/{place}', [AdminController::class, 'deletePlace']);

    // Reports
    Route::get('/reports', [AdminController::class, 'reports']);

    // Settings
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::post('/content-fallback', [AdminController::class, 'updateContentFallback']);
    Route::get('/content-fallback/api', [AdminController::class, 'getContentFallbackSettings']);
});
```

## Teknologi yang Digunakan

### Backend

-   **Laravel 10+**: Framework PHP utama
-   **Eloquent ORM**: Database queries dan relationships
-   **Laravel Middleware**: Authentication dan role-based access
-   **Blade Templates**: Server-side rendering

### Frontend

-   **Tailwind CSS**: Utility-first CSS framework
-   **Alpine.js**: Lightweight JavaScript framework
-   **Font Awesome**: Icon library
-   **Chart.js**: Charts dan visualisasi data

### Database

-   **MySQL**: Primary database
-   **Laravel Migrations**: Database versioning
-   **Model Relationships**: Proper foreign key constraints

## Middleware dan Security

### Role-Based Access Control

```php
// Middleware: role:admin
// Hanya user dengan role 'admin' yang bisa mengakses admin routes
Route::middleware(['auth', 'verified', 'role:admin'])
```

### CSRF Protection

-   Semua forms menggunakan `@csrf` token
-   POST, PUT, DELETE requests diproteksi

### Input Validation

-   Request validation untuk semua user inputs
-   Sanitization untuk XSS prevention

## Testing dan Development

### Seeder Data

**File**: `database/seeders/AdminDataSeeder.php`

**Accounts untuk Testing**:

-   **Admin**: admin@sentara.com / password123
-   **Educators**: educator1@sentara.com sampai educator3@sentara.com / password123
-   **Students**: student1@sentara.com sampai student10@sentara.com / password123

**Sample Data**:

-   1 Admin user dengan konten fallback lengkap
-   3 Educator users dengan konten masing-masing
-   10 Student users
-   3 Classes (Kelas 7, 8, 9 IPS)
-   Admin content: 3 Geography Models, 4 Places, 4 Stories
-   Educator content: 1 item per kategori per educator
-   Admin settings untuk fallback system

### Command untuk Setup

```bash
# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed --class=AdminDataSeeder

# Check routes
php artisan route:list --path=admin
```

## User Interface

### Design System

-   **Color Scheme**: Primary (blue), Secondary (gradient), Quaternary (accent)
-   **Typography**: Inter font family
-   **Layout**: Responsive dengan sidebar navigation
-   **Components**: Cards, modals, tables, forms, charts

### Navigation Structure

```
Admin Dashboard
├── Dashboard (Overview & Stats)
├── Users (User Management)
├── Content Management (Geography, Places, Stories)
├── Reports & Analytics (Charts & Metrics)
├── Classes (Future implementation)
└── Settings (System configuration)
```

### Responsive Design

-   **Desktop**: Full sidebar dengan expanded navigation
-   **Mobile**: Collapsible sidebar dengan hamburger menu
-   **Tablet**: Optimized layout untuk medium screens

## Content Fallback Implementation

### Logic Flow

1. **Student accesses content page** → MainController@geografi() atau MainController@sejarah()
2. **Check student's class** → ClassList relationship
3. **Query class-specific content** → Where conditions dengan class_id
4. **If no content found** → Check AdminSetting untuk fallback
5. **If fallback enabled** → Query admin content (user_id = admin, is_public = true)
6. **Return combined results** → Class content + Admin fallback content

### Configuration

Admin dapat mengaktifkan/nonaktifkan fallback melalui Settings page:

-   `content_fallback_enabled`: Master switch
-   `fallback_geography_enabled`: Geography models fallback
-   `fallback_stories_enabled`: Stories fallback
-   `fallback_places_enabled`: Places fallback

## Performance Considerations

### Database Optimization

-   **Indexed Columns**: user_id, is_public, is_active, class_id
-   **Eager Loading**: Relationships dimuat sekaligus untuk menghindari N+1 queries
-   **Pagination**: Large datasets dipaginate untuk performance

### Caching Strategy

-   **Query Results**: AdminSetting values di-cache
-   **Static Assets**: CSS/JS files dengan versioning
-   **Database Queries**: Frequently accessed data di-cache

### Security Best Practices

-   **SQL Injection**: Prevented dengan Eloquent ORM
-   **XSS**: Input sanitization dan output escaping
-   **CSRF**: Token validation pada semua forms
-   **Authentication**: Middleware-based access control

## Maintenance dan Monitoring

### Error Handling

-   Try-catch blocks pada critical operations
-   User-friendly error messages
-   Logging untuk debugging

### Backup Considerations

-   Database backup untuk admin_settings
-   User data backup procedures
-   Content files backup (model files, images)

### Future Enhancements

1. **Advanced Analytics**: Lebih banyak metrics dan insights
2. **Content Approval Workflow**: Review process untuk educator content
3. **Bulk Content Operations**: Mass import/export content
4. **Advanced Filtering**: More granular filtering options
5. **Real-time Notifications**: Live updates untuk admin activities

## Troubleshooting

### Common Issues

1. **Routes not found**: Check `php artisan route:list --path=admin`
2. **Permission denied**: Verify user role dan middleware
3. **Database errors**: Check migrations dan relationships
4. **Frontend issues**: Verify Tailwind CSS compilation

### Debug Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check system status
php artisan about

# Run tests (if available)
php artisan test
```

---

**Status**: ✅ Semua fitur admin dashboard telah berhasil diimplementasi dan siap untuk testing.

**Next Steps**:

1. Run migrasi database
2. Run seeder untuk data testing
3. Test semua fungsi admin melalui browser
4. Deploy ke environment production jika diperlukan
