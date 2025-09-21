<?php

namespace App\Http\Controllers\Educator;

use App\Http\Controllers\Controller;
use App\Models\ClassDiscussion;
use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassDiscussionController extends Controller
{
    public function index()
    {
        $discussions = ClassDiscussion::with(['class', 'educator', 'student'])
            ->where('educator_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('educator.discussions.index', compact('discussions'));
    }

    public function create()
    {
        $classes = ClassModel::where('educator_id', Auth::id())->get();
        return view('educator.discussions.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'name' => 'required|string|max:255',
            'class_discussion_message' => 'required|string',
        ]);

        ClassDiscussion::create([
            'class_id' => $request->class_id,
            'educator_id' => Auth::id(),
            'name' => $request->name,
            'class_discussion_message' => $request->class_discussion_message,
        ]);

        return redirect()->route('educator.discussions.index')
            ->with('success', 'Discussion berhasil dibuat!');
    }

    public function show(ClassDiscussion $discussion)
    {
        $discussion->load(['class', 'educator', 'student']);
        
        // Get all messages in this discussion
        $messages = ClassDiscussion::where('class_id', $discussion->class_id)
            ->where('name', $discussion->name)
            ->with(['student', 'educator'])
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('educator.discussions.show', compact('discussion', 'messages'));
    }

    public function edit(ClassDiscussion $discussion)
    {
        $classes = ClassModel::where('educator_id', Auth::id())->get();
        return view('educator.discussions.edit', compact('discussion', 'classes'));
    }

    public function update(Request $request, ClassDiscussion $discussion)
    {
        $request->validate([
            'class_id' => 'required|exists:class,id',
            'name' => 'required|string|max:255',
            'class_discussion_message' => 'required|string',
        ]);

        $discussion->update([
            'class_id' => $request->class_id,
            'name' => $request->name,
            'class_discussion_message' => $request->class_discussion_message,
        ]);

        return redirect()->route('educator.discussions.index')
            ->with('success', 'Discussion berhasil diperbarui!');
    }

    public function destroy(ClassDiscussion $discussion)
    {
        // Delete all related messages in this discussion
        ClassDiscussion::where('class_id', $discussion->class_id)
            ->where('name', $discussion->name)
            ->delete();

        return redirect()->route('educator.discussions.index')
            ->with('success', 'Discussion berhasil dihapus!');
    }

    public function reply(Request $request, ClassDiscussion $discussion)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $discussion->update([
            'reply' => $request->reply,
        ]);

        return redirect()->route('educator.discussions.show', $discussion)
            ->with('success', 'Balasan berhasil dikirim!');
    }
}
