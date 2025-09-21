# CRUD Konten Kelas - Panduan Educator

## Overview

Fitur CRUD (Create, Read, Update, Delete) konten kelas memungkinkan educator untuk mengelola tempat wisata sejarah dan cerita yang tersedia untuk setiap kelas secara terpisah.

## Fitur yang Tersedia

### 1. Dashboard Konten Kelas

-   **Route**: `/educator/classes/{class}/content`
-   **Method**: `GET`
-   **Controller**: `ClassController@manageContent`

**Fitur:**

-   Menampilkan statistik konten (jumlah tempat, cerita, tersedia)
-   Daftar tempat yang sudah di-assign ke kelas
-   Preview cerita untuk setiap tempat
-   Aksi untuk menghapus konten dari kelas

### 2. Tambah Konten ke Kelas

-   **Route**: `/educator/classes/{class}/content/create`
-   **Method**: `GET`
-   **Controller**: `ClassController@createContent`

**Fitur:**

-   Filter dan pencarian tempat
-   Filter berdasarkan era (prasejarah, kerajaan, penjajahan, kemerdekaan)
-   Preview cerita untuk setiap tempat
-   Bulk selection (pilih semua/batal pilih)
-   Real-time counter tempat yang dipilih

### 3. Simpan Konten ke Kelas

-   **Route**: `/educator/classes/{class}/content`
-   **Method**: `POST`
-   **Controller**: `ClassController@storeContent`

**Request Data:**

```php
[
    'place_ids' => [1, 2, 3, ...] // Array of place IDs
]
```

### 4. Hapus Konten dari Kelas

-   **Route**: `/educator/classes/{class}/content/{place}`
-   **Method**: `DELETE`
-   **Controller**: `ClassController@destroyContent`

### 5. Sync Konten Kelas (Bulk Update)

-   **Route**: `/educator/classes/{class}/content/sync`
-   **Method**: `PUT`
-   **Controller**: `ClassController@syncContent`

**Request Data:**

```php
[
    'place_ids' => [1, 2, 3, ...] // Array of place IDs (akan replace semua)
]
```

### 6. Get Data Konten (AJAX)

-   **Route**: `/educator/classes/{class}/content/data`
-   **Method**: `GET`
-   **Controller**: `ClassController@getContentData`

**Response:**

```json
{
    "assigned_places": [...],
    "available_places": [...]
}
```

## Penggunaan UI

### Dari Halaman Kelas

1. Masuk ke "Kelas Saya" di dashboard educator
2. Klik tombol **"Kelola Konten"** pada kartu kelas
3. Akan diarahkan ke dashboard konten kelas

### Dashboard Konten

1. **Statistik**: Melihat ringkasan konten (tempat, cerita, tersedia)
2. **Daftar Konten**: Menampilkan tempat yang sudah di-assign
3. **Lihat Cerita**: Klik untuk toggle preview cerita
4. **Hapus Konten**: Konfirmasi sebelum menghapus

### Tambah Konten

1. Klik **"Tambah Konten"** dari dashboard konten
2. **Filter**: Gunakan pencarian dan filter era
3. **Pilih Tempat**: Centang kotak pada tempat yang diinginkan
4. **Bulk Action**: "Pilih Semua" atau "Batal Pilih"
5. **Submit**: Tombol "Tambah ke Kelas" akan aktif jika ada yang dipilih

## Validasi dan Security

### Authorization

```php
// Semua method memvalidasi ownership
if ($class->educator_id !== auth()->id()) {
    abort(403);
}
```

### Validation Rules

```php
// Store Content
$request->validate([
    'place_ids' => 'required|array',
    'place_ids.*' => 'exists:places,id'
]);

// Sync Content
$request->validate([
    'place_ids' => 'array',
    'place_ids.*' => 'exists:places,id'
]);
```

## JavaScript Functionality

### Filter Places

```javascript
function filterPlaces() {
    // Filter berdasarkan nama, lokasi, dan era
    // Show/hide no results message
}
```

### Selection Management

```javascript
function selectAll()       // Pilih semua tempat yang visible
function deselectAll()     // Batal pilih semua
function updateSelectedCount() // Update counter dan enable/disable submit
```

### Toggle Stories

```javascript
function toggleStories(placeId)      // Toggle cerita di index
function togglePlaceStories(placeId) // Toggle cerita di create form
```

## Database Operations

### Model Relationships

```php
// ClassModel
$class->places()           // BelongsToMany
$class->stories            // HasManyThrough via places
$class->assignPlace($id)   // Helper method
$class->syncPlaces($ids)   // Helper method

// Place
$place->classes()          // BelongsToMany
Place::forClass($classId)  // Scope filter
Place::notInClass($classId) // Scope filter

// Story
Story::forClass($classId)  // Scope filter via place
$story->isAvailableForClass($classId) // Helper method
```

### Query Examples

```php
// Get all content for a class
$class = ClassModel::with(['places.stories'])->find($id);

// Get available places (not assigned to class)
$available = Place::notInClass($classId)->with('coordinate')->get();

// Get stories for a class
$stories = Story::forClass($classId)->get();
```

## Error Handling

### Common Errors

1. **403 Forbidden**: Class bukan milik educator yang login
2. **404 Not Found**: Class atau Place tidak ditemukan
3. **422 Validation Error**: Data tidak sesuai validation rules

### User Feedback

-   Success messages via session flash
-   Confirmation dialogs untuk aksi delete
-   Real-time validation di form
-   Loading states untuk AJAX requests

## Best Practices

### Performance

-   Eager loading dengan `with()` untuk menghindari N+1 queries
-   Pagination untuk dataset besar (jika diperlukan)
-   Index database pada foreign keys

### UX

-   Konfirmasi sebelum delete
-   Real-time feedback (counter, enable/disable buttons)
-   Search dan filter untuk kemudahan navigasi
-   Bulk actions untuk efisiensi

### Security

-   Authorization checks di setiap method
-   CSRF protection
-   Input validation
-   Sanitized output di views
