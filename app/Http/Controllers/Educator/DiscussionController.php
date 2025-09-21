<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassDiscussion;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DiscussionController extends Controller
{
    /**
     * Display all discussions across classes
     */
    public function index(Request $request): View
    {
        $query = ClassDiscussion::with(['class', 'educator', 'student'])
            ->where('educator_id', auth()->id());

        // Filter by class if provided
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Search by name or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('class_discussion_message', 'like', "%{$search}%");
            });
        }

        // Filter by status (has student messages, no replies, etc.)
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $query->whereNotNull('message')->whereNull('reply');
                    break;
                case 'replied':
                    $query->whereNotNull('reply');
                    break;
                case 'no_responses':
                    $query->whereNull('message');
                    break;
                case 'active':
                    $query->whereNotNull('class_discussion_message');
                    break;
                case 'closed':
                    // Assuming a closed status exists or can be determined
                    $query->where('status', 'closed');
                    break;
            }
        }

        // Sort options
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('name', 'asc');
                break;
            case 'most_responses':
                $query->withCount(['student' => function($q) {
                    $q->whereNotNull('message');
                }])->orderBy('student_count', 'desc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $discussions = $query->paginate(15);
        
        // Get my classes for filter
        $myClasses = ClassModel::where('educator_id', auth()->id())->get();

        return view('educator.discussions.index', compact('discussions', 'myClasses'));
    }

    /**
     * Show the form for creating a new discussion
     */
    public function create(): View
    {
        $myClasses = ClassModel::where('educator_id', auth()->id())->get();
        return view('educator.discussions.create', compact('myClasses'));
    }

    /**
     * Store a newly created discussion
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'name' => 'required|string|max:255',
            'class_discussion_message' => 'required|string',
        ]);

        // Verify class belongs to current educator
        $class = ClassModel::where('id', $request->class_id)
            ->where('educator_id', auth()->id())
            ->firstOrFail();

        ClassDiscussion::create([
            'class_id' => $request->class_id,
            'educator_id' => auth()->id(),
            'name' => $request->name,
            'class_discussion_message' => $request->class_discussion_message,
        ]);

        return redirect()->route('educator.discussions.index')
            ->with('success', 'Diskusi berhasil dibuat');
    }

    /**
     * Display the specified discussion
     */
    public function show(ClassDiscussion $discussion): View
    {
        // Ensure discussion belongs to current educator
        if ($discussion->educator_id !== auth()->id()) {
            abort(403);
        }

        $discussion->load(['class.classLists.student', 'student']);
        
        // Get all student responses for this discussion
        $responses = ClassDiscussion::where('class_id', $discussion->class_id)
            ->where('name', $discussion->name)
            ->whereNotNull('student_id')
            ->with('student')
            ->get();

        return view('educator.discussions.show', compact('discussion', 'responses'));
    }

    /**
     * Reply to a student message
     */
    public function reply(Request $request, ClassDiscussion $discussion): RedirectResponse
    {
        // Ensure discussion belongs to current educator
        if ($discussion->educator_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'reply' => 'required|string',
        ]);

        $discussion->update([
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Balasan berhasil dikirim');
    }

    /**
     * Get discussion statistics
     */
    public function stats(): View
    {
        $stats = [
            'total_discussions' => ClassDiscussion::where('educator_id', auth()->id())
                ->whereNull('student_id')->count(),
            'pending_replies' => ClassDiscussion::where('educator_id', auth()->id())
                ->whereNotNull('message')->whereNull('reply')->count(),
            'total_responses' => ClassDiscussion::where('educator_id', auth()->id())
                ->whereNotNull('student_id')->count(),
            'active_classes' => ClassModel::where('educator_id', auth()->id())
                ->whereHas('discussions')->count(),
        ];

        return view('educator.discussions.stats', compact('stats'));
    }
}
