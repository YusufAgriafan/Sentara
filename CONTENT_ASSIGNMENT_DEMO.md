# DEMO: Content Assignment Workflow

## Scenario

Pak Guru memiliki 3 kelas:

-   **Kelas A (Grade 10)**: 25 siswa
-   **Kelas B (Grade 11)**: 30 siswa
-   **Kelas C (Grade 12)**: 28 siswa

Konten yang tersedia:

-   **Tempat**: Candi Borobudur, Candi Prambanan, Monumen Nasional
-   **Cerita**: "Sejarah Borobudur", "Legenda Prambanan", "Proklamasi di Monas"

## Step 1: Educator Assigns Content to Specific Classes

### Assignment Rules:

```
Kelas A (Grade 10):
- ✅ Candi Borobudur + Cerita Borobudur
- ❌ Tidak akses Prambanan & Monas

Kelas B (Grade 11):
- ✅ Candi Prambanan + Legenda Prambanan
- ✅ Candi Borobudur + Sejarah Borobudur
- ❌ Tidak akses Monas

Kelas C (Grade 12):
- ✅ Semua tempat + semua cerita (advanced level)
```

### Implementation in Controller:

```php
// ContentAssignmentController.php
public function setClassAssignments()
{
    // Kelas A - Hanya Borobudur
    $kelasA = ClassModel::where('name', 'Kelas A')->first();
    $borobudur = Place::where('name', 'Candi Borobudur')->first();
    $ceritaBorobudur = Story::where('title', 'Sejarah Borobudur')->first();

    $kelasA->places()->sync([$borobudur->id]);
    $kelasA->stories()->sync([$ceritaBorobudur->id]);

    // Kelas B - Borobudur + Prambanan
    $kelasB = ClassModel::where('name', 'Kelas B')->first();
    $prambanan = Place::where('name', 'Candi Prambanan')->first();
    $ceritaPrambanan = Story::where('title', 'Legenda Prambanan')->first();

    $kelasB->places()->sync([$borobudur->id, $prambanan->id]);
    $kelasB->stories()->sync([$ceritaBorobudur->id, $ceritaPrambanan->id]);

    // Kelas C - Semua konten
    $kelasC = ClassModel::where('name', 'Kelas C')->first();
    $monas = Place::where('name', 'Monumen Nasional')->first();
    $ceritaMonas = Story::where('title', 'Proklamasi di Monas')->first();

    $kelasC->places()->sync([$borobudur->id, $prambanan->id, $monas->id]);
    $kelasC->stories()->sync([$ceritaBorobudur->id, $ceritaPrambanan->id, $ceritaMonas->id]);
}
```

## Step 2: Student Access Based on Class

### Student Login Examples:

#### Siswa Kelas A (Budi):

```
Dashboard menampilkan:
- 📍 1 Tempat Tersedia: Candi Borobudur
- 📚 1 Cerita Tersedia: Sejarah Borobudur
- ❌ Prambanan & Monas tidak terlihat
```

#### Siswa Kelas B (Sari):

```
Dashboard menampilkan:
- 📍 2 Tempat Tersedia: Borobudur, Prambanan
- 📚 2 Cerita Tersedia: Sejarah Borobudur, Legenda Prambanan
- ❌ Monas tidak terlihat
```

#### Siswa Kelas C (Andi):

```
Dashboard menampilkan:
- 📍 3 Tempat Tersedia: Borobudur, Prambanan, Monas
- 📚 3 Cerita Tersedia: Semua cerita
- ✅ Akses penuh ke semua konten
```

### Implementation in Student Controller:

```php
// StudentController.php
public function dashboard()
{
    $user = Auth::user();
    $currentClass = $this->getCurrentClass($user);

    if (!$currentClass) {
        return view('student.dashboard', ['currentClass' => null]);
    }

    // HANYA ambil konten yang di-assign ke kelas ini
    $assignedPlaces = $currentClass->places()->get();
    $assignedStories = $currentClass->stories()->with('place')->get();

    return view('student.dashboard', [
        'currentClass' => $currentClass,
        'assignedPlaces' => $assignedPlaces,    // Filtered by class
        'assignedStories' => $assignedStories,  // Filtered by class
    ]);
}

public function showPlace(Place $place)
{
    $currentClass = $this->getCurrentClass(Auth::user());

    // SECURITY CHECK: Apakah place ini di-assign ke kelas student?
    $isAssigned = $currentClass->places()
        ->where('places.id', $place->id)
        ->exists();

    if (!$isAssigned) {
        abort(403, 'Tempat ini tidak tersedia untuk kelas Anda');
    }

    return view('student.places.show', compact('place'));
}
```

## Step 3: Real-time Assignment Interface

### Educator Assignment Interface:

```html
<!-- Di stories/index.blade.php -->
<div class="story-card">
    <h3>Sejarah Borobudur</h3>
    <p>Assigned to: {{ $story->classes->count() }} kelas</p>

    <button onclick="openAssignModal({{ $story->id }})">Atur Kelas</button>
</div>

<!-- Assignment Modal -->
<div id="assignModal">
    <form onsubmit="assignStory(event)">
        <h3>Assign "Sejarah Borobudur" ke Kelas:</h3>

        <label>
            <input type="checkbox" name="classes[]" value="1" />
            Kelas A (25 siswa)
        </label>

        <label>
            <input type="checkbox" name="classes[]" value="2" checked />
            Kelas B (30 siswa) ✓ Currently assigned
        </label>

        <label>
            <input type="checkbox" name="classes[]" value="3" />
            Kelas C (28 siswa)
        </label>

        <button type="submit">Update Assignment</button>
    </form>
</div>
```

### JavaScript Assignment Logic:

```javascript
function assignStory(event) {
    event.preventDefault();

    const formData = new FormData(event.target);
    const selectedClasses = formData.getAll("classes[]");

    fetch("/educator/stories/123/assign-classes", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({ classes: selectedClasses }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Update UI to show new assignment
                updateAssignmentDisplay(data.assignedClasses);
                closeModal();
            }
        });
}
```

## Step 4: Database State After Assignment

### class_places table:

```
| id | class_id | place_id | created_at |
|----|----------|----------|------------|
| 1  | 1        | 1        | 2025-09-19 | Kelas A -> Borobudur
| 2  | 2        | 1        | 2025-09-19 | Kelas B -> Borobudur
| 3  | 2        | 2        | 2025-09-19 | Kelas B -> Prambanan
| 4  | 3        | 1        | 2025-09-19 | Kelas C -> Borobudur
| 5  | 3        | 2        | 2025-09-19 | Kelas C -> Prambanan
| 6  | 3        | 3        | 2025-09-19 | Kelas C -> Monas
```

### class_stories table:

```
| id | class_id | story_id | assigned_at |
|----|----------|----------|-------------|
| 1  | 1        | 1        | 2025-09-19  | Kelas A -> Cerita Borobudur
| 2  | 2        | 1        | 2025-09-19  | Kelas B -> Cerita Borobudur
| 3  | 2        | 2        | 2025-09-19  | Kelas B -> Cerita Prambanan
| 4  | 3        | 1        | 2025-09-19  | Kelas C -> All stories
| 5  | 3        | 2        | 2025-09-19  |
| 6  | 3        | 3        | 2025-09-19  |
```

## Step 5: Security & Access Control

### URL Access Examples:

```
✅ ALLOWED:
- Siswa Kelas A akses: /student/places/1 (Borobudur)
- Siswa Kelas B akses: /student/stories/2 (Prambanan)
- Siswa Kelas C akses: /student/places/3 (Monas)

❌ FORBIDDEN (403 Error):
- Siswa Kelas A akses: /student/places/2 (Prambanan)
- Siswa Kelas A akses: /student/places/3 (Monas)
- Siswa Kelas B akses: /student/places/3 (Monas)
```

### Error Handling:

```php
// Jika student coba akses unauthorized content
if (!$isAssigned) {
    return redirect()->route('student.dashboard')
        ->with('error', 'Konten ini tidak tersedia untuk kelas Anda. Hubungi guru jika ini adalah kesalahan.');
}
```

## Result: Class-Specific Content Access

### Kelas A Dashboard:

```
🎓 Kelas A - Grade 10
📊 Konten Tersedia:
   📍 1 Tempat Wisata
   📚 1 Cerita Sejarah
   💬 2 Diskusi Aktif

📋 Daftar Konten:
✅ Candi Borobudur
✅ Sejarah Borobudur
❌ [Konten lain tersembunyi]
```

Dengan implementasi ini, **konten benar-benar hanya muncul di kelas tertentu** dengan kontrol akses yang ketat di level database, controller, dan UI.
