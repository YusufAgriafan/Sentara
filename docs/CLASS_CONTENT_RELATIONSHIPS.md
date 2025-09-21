# Relasi Class-Content (Places & Stories)

## Overview

Struktur database telah diperbaiki untuk memungkinkan konten (places dan stories) yang berbeda untuk setiap kelas. Sekarang educator dapat mengatur konten historis yang spesifik untuk setiap kelas yang mereka ajar.

## Struktur Database

### Tabel Baru

-   `class_places` - Tabel pivot untuk relasi many-to-many antara `class` dan `places`

### Relasi

1. **Class ↔ Places** (Many-to-Many)
    - Satu class bisa memiliki banyak places
    - Satu place bisa dimiliki oleh banyak class
2. **Class → Stories** (HasManyThrough via Places)
    - Stories dapat diakses melalui places yang terkait dengan class

## Cara Penggunaan

### 1. Assign Places ke Class

```php
$class = ClassModel::find(1);

// Assign single place
$class->assignPlace($placeId);

// Assign multiple places
$class->syncPlaces([1, 2, 3]);

// Assign dengan attach
$class->places()->attach($placeId);
```

### 2. Get Content untuk Class Tertentu

```php
$class = ClassModel::find(1);

// Get semua places untuk class ini
$places = $class->places;

// Get semua stories untuk class ini (melalui places)
$stories = $class->stories;

// Atau menggunakan attribute accessor
$stories = $class->getStoriesAttribute();
```

### 3. Filter Content berdasarkan Class

```php
// Get places yang tersedia untuk class tertentu
$placesForClass = Place::forClass($classId)->get();

// Get places yang belum di-assign ke class tertentu
$availablePlaces = Place::notInClass($classId)->get();

// Get stories untuk class tertentu
$storiesForClass = Story::forClass($classId)->get();
```

### 4. Check Availability

```php
$story = Story::find(1);

// Cek apakah story ini tersedia untuk class tertentu
if ($story->isAvailableForClass($classId)) {
    // Story tersedia untuk class ini
}
```

## Contoh Implementasi di Controller

### Educator Controller

```php
public function assignContent(Request $request, $classId)
{
    $class = ClassModel::findOrFail($classId);
    $placeIds = $request->input('place_ids');

    // Sync places ke class
    $class->syncPlaces($placeIds);

    return redirect()->back()->with('success', 'Content assigned successfully');
}

public function getClassContent($classId)
{
    $class = ClassModel::with(['places.stories'])->findOrFail($classId);

    return response()->json([
        'places' => $class->places,
        'stories' => $class->stories
    ]);
}
```

### Student Controller

```php
public function viewContent($classId)
{
    // Pastikan student terdaftar di class ini
    $class = ClassModel::whereHas('classLists', function($q) {
        $q->where('student_id', auth()->id());
    })->findOrFail($classId);

    $places = $class->places()->with('stories')->get();

    return view('student.content', compact('places'));
}
```

## Migration Commands

```bash
# Jalankan migration baru
php artisan migrate

# Jalankan seeder (opsional untuk testing)
php artisan db:seed --class=ClassPlacesSeeder
```

## Benefits

1. **Konten Terkustomisasi**: Setiap class bisa memiliki konten yang berbeda
2. **Fleksibilitas**: Educator dapat mengatur materi sesuai kurikulum kelas
3. **Scalability**: Mudah menambah atau mengubah konten tanpa affect class lain
4. **Data Integrity**: Relasi foreign key memastikan konsistensi data

## Database Schema

```
class (1) ←→ (M) class_places (M) ←→ (1) places (1) ←→ (M) stories
     ↑                                        ↑
     └────────── class_discussions            └── coordinate
     └────────── class_list
```
