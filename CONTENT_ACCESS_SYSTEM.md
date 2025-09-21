# Sistem Konten Berdasarkan Kelas

## Gambaran Umum

Sistem ini menggunakan relasi many-to-many untuk mengontrol akses konten berdasarkan kelas. Setiap konten (tempat wisata dan cerita) dapat di-assign ke kelas tertentu, sehingga hanya siswa dari kelas tersebut yang dapat melihat konten.

## Struktur Database

### Tabel Utama

1. **`class`** - Data kelas
2. **`places`** - Data tempat wisata sejarah
3. **`stories`** - Data cerita sejarah
4. **`class_list`** - Daftar siswa per kelas

### Tabel Pivot (Relasi Many-to-Many)

1. **`class_places`** - Relasi kelas dengan tempat wisata
2. **`class_stories`** - Relasi kelas dengan cerita

```sql
-- Struktur tabel class_places
CREATE TABLE class_places (
    id BIGINT PRIMARY KEY,
    class_id BIGINT, -- Foreign key ke table class
    place_id BIGINT, -- Foreign key ke table places
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(class_id, place_id)
);

-- Struktur tabel class_stories
CREATE TABLE class_stories (
    id BIGINT PRIMARY KEY,
    class_id BIGINT, -- Foreign key ke table class
    story_id BIGINT, -- Foreign key ke table stories
    assigned_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE(class_id, story_id)
);
```

## Model Relationships

### ClassModel.php

```php
// Relasi dengan tempat wisata
public function places()
{
    return $this->belongsToMany(Place::class, 'class_places', 'class_id', 'place_id');
}

// Relasi dengan cerita
public function stories()
{
    return $this->belongsToMany(Story::class, 'class_stories', 'class_id', 'story_id');
}

// Helper methods untuk assignment
public function assignPlace($placeId)
{
    return $this->places()->attach($placeId);
}

public function assignStory($storyId)
{
    return $this->stories()->attach($storyId);
}
```

### Story.php

```php
// Relasi dengan kelas
public function classes()
{
    return $this->belongsToMany(ClassModel::class, 'class_stories', 'story_id', 'class_id');
}

// Cek apakah story di-assign ke kelas tertentu
public function isAssignedToClass($classId)
{
    return $this->classes()->where('class.id', $classId)->exists();
}
```

### Place.php

```php
// Relasi dengan kelas
public function classes()
{
    return $this->belongsToMany(ClassModel::class, 'class_places', 'place_id', 'class_id');
}
```

## Cara Kerja Sistem

### 1. Assignment Konten ke Kelas (Educator)

#### Manual Assignment per Item

```php
// Di StoryController
public function assignClasses(Request $request, Story $story)
{
    $validClasses = ClassModel::whereIn('id', $request->classes ?? [])
        ->where('educator_id', Auth::id())
        ->pluck('id');

    // Sync akan replace semua assignment yang ada
    $story->classes()->sync($validClasses);

    return response()->json(['success' => true]);
}
```

#### Bulk Assignment

```php
// Di ContentAssignmentController
public function bulkAssign(Request $request)
{
    $classes = ClassModel::whereIn('id', $request->classes)
        ->where('educator_id', Auth::id())
        ->get();

    foreach ($classes as $class) {
        // Assign places (tanpa menghapus yang sudah ada)
        if (!empty($request->places)) {
            $class->places()->syncWithoutDetaching($request->places);
        }

        // Assign stories (tanpa menghapus yang sudah ada)
        if (!empty($request->stories)) {
            $class->stories()->syncWithoutDetaching($request->stories);
        }
    }
}
```

### 2. Akses Konten Berdasarkan Kelas (Student)

#### Mendapatkan Kelas Siswa

```php
private function getCurrentClass($user)
{
    $classList = ClassList::where('student_id', $user->id)->first();
    return $classList ? $classList->class : null;
}
```

#### Filter Konten Berdasarkan Kelas

```php
public function places(): View
{
    $currentClass = $this->getCurrentClass(Auth::user());

    if (!$currentClass) {
        return redirect()->route('student.dashboard')
            ->with('error', 'Anda belum terdaftar di kelas manapun');
    }

    // Hanya tampilkan places yang di-assign ke kelas ini
    $places = $currentClass->places()
        ->with('coordinate')
        ->orderBy('name')
        ->get();

    return view('student.places.index', compact('places', 'currentClass'));
}
```

#### Validasi Akses Individual Item

```php
public function showStory(Story $story): View
{
    $currentClass = $this->getCurrentClass(Auth::user());

    // Cek apakah story ini di-assign ke kelas siswa
    $isAssigned = $currentClass->stories()->where('stories.id', $story->id)->exists();

    if (!$isAssigned) {
        return redirect()->route('student.stories')
            ->with('error', 'Cerita ini tidak tersedia untuk kelas Anda');
    }

    return view('student.stories.show', compact('story', 'currentClass'));
}
```

## Implementasi di View

### Educator: Assignment Interface

```blade
<!-- Quick assign modal di stories/index.blade.php -->
<button onclick="openAssignModal('{{ $story->id }}', '{{ $story->title }}')"
        class="text-blue-600 hover:text-blue-800 text-sm font-medium">
    <i class="fas fa-plus mr-1"></i>Atur Kelas
</button>

<script>
function assignClasses(event, storyId) {
    const formData = new FormData(event.target);
    const classes = formData.getAll('classes[]');

    fetch(`/educator/stories/${storyId}/assign-classes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ classes: classes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
```

### Student: Filtered Content Display

```blade
<!-- Hanya tampilkan content yang di-assign ke kelas -->
@forelse($assignedStories as $story)
    <div class="story-card">
        <h3>{{ $story->title }}</h3>
        <p>{{ $story->place->name }}</p>
        <a href="{{ route('student.stories.show', $story) }}">Baca Cerita</a>
    </div>
@empty
    <p>Belum ada cerita yang di-assign ke kelas Anda</p>
@endforelse
```

## Keamanan

### 1. Authorization Checks

-   Educator hanya bisa assign konten ke kelas mereka sendiri
-   Student hanya bisa akses konten dari kelas mereka
-   Validasi ownership di setiap endpoint

### 2. Route Protection

```php
// Di routes/web.php
Route::middleware(['auth', 'verified', 'role:educator,admin'])->group(function () {
    // Educator routes
});

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    // Student routes
});
```

### 3. Database Constraints

```sql
-- Unique constraints untuk prevent duplicate assignments
UNIQUE(class_id, place_id)
UNIQUE(class_id, story_id)

-- Foreign key constraints dengan cascade delete
FOREIGN KEY (class_id) REFERENCES class(id) ON DELETE CASCADE
```

## Contoh Penggunaan

### Educator Workflow

1. Buat tempat wisata dan cerita
2. Pilih konten yang ingin di-assign
3. Pilih kelas target
4. Lakukan assignment (manual atau bulk)
5. Monitor distribusi konten via dashboard

### Student Experience

1. Join kelas menggunakan token
2. Lihat dashboard dengan konten yang di-assign ke kelas
3. Akses hanya konten yang tersedia untuk kelas
4. Ikut diskusi dan aktivitas kelas

## Database Queries Optimization

### Eager Loading

```php
// Load relasi sekaligus untuk avoid N+1 query
$stories = $currentClass->stories()->with('place')->get();
$places = $currentClass->places()->with('coordinate')->get();
```

### Indexing

```sql
-- Index untuk performance
CREATE INDEX idx_class_places_class_id ON class_places(class_id);
CREATE INDEX idx_class_places_place_id ON class_places(place_id);
CREATE INDEX idx_class_stories_class_id ON class_stories(class_id);
CREATE INDEX idx_class_stories_story_id ON class_stories(story_id);
```

Sistem ini memastikan bahwa konten hanya dimunculkan di kelas tertentu melalui:

1. **Relasi Database**: Many-to-many dengan tabel pivot
2. **Authorization**: Cek ownership dan membership
3. **Filtering**: Query hanya data yang relevan
4. **Validation**: Cek akses di setiap endpoint
