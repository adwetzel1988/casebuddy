<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Message;
use App\Models\User;
use App\Models\Note;
use App\Notifications\ComplaintUpdated;
use App\Notifications\NewNoteNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $complaints = Complaint::all();
        $stats = [
            'total' => $complaints->count(),
            'report_made' => $complaints->where('status', 'report_made')->count(),
            'detective_assigned' => $complaints->where('status', 'detective_assigned')->count(),
            'under_investigation' => $complaints->where('status', 'under_investigation')->count(),
            'warrant_issued' => $complaints->where('status', 'warrant_issued')->count(),
            'arrest_made' => $complaints->where('status', 'arrest_made')->count(),
            'transferred_to_district_attorney' => $complaints->where('status', 'transferred_to_district_attorney')->count(),
            'closed' => $complaints->where('status', 'closed')->count(),
        ];

        $latestMessages = Message::latest()->take(5)->get();
        $latestNotes = Note::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestMessages', 'latestNotes'));
    }

    public function complaintsList(Request $request)
    {
        $status = $request->query('status');
        $user = auth()->user();

        $query = Complaint::with('user', 'officer', 'witnesses')->whereHas('witnesses');

        if ($user->role === 'subadmin') {
            $query->where('assigned_to', $user->id);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $complaints = $query->get();

        return view('admin.complaints.index', compact('complaints'));
    }

    public function showComplaint(Complaint $complaint)
    {
        $subadmins = User::where('role', 'subadmin')->get();
        return view('admin.complaints.show', compact('complaint', 'subadmins'));
    }

    public function assignComplaint(Request $request, Complaint $complaint)
    {
        $validatedData = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $complaint->update([
            'assigned_to' => $validatedData['assigned_to'],
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Complaint assigned successfully.');
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:report_made,detective_assigned,under_investigation,warrant_issued,arrest_made,transferred_to_district_attorney,closed',
        ]);

        if ($complaint->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot update a completed complaint.');
        }

        $status = $validatedData['status'] === 'other' ? $validatedData['action_taken'] : $validatedData['status'];

        $complaint->update([
            'status' => $status,
        ]);

        // Notify the creator of the complaint
        if (!is_null($complaint->user)) {
            $complaint->user->notify(new ComplaintUpdated($complaint));
        }

        return redirect()->back()->with('success', 'Complaint status updated successfully.');
    }

    public function addNote(Request $request, Complaint $complaint)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,pdf,doc,docx|max:10240',
        ]);

        $note = $complaint->notes()->create([
            'user_id' => Auth::id(),
            'content' => $validatedData['content'],
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $path = $attachment->store('public');
                $note->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $note->id . '-' . $attachment->getClientOriginalName(),
                ]);
            }
        }

        // Notify the creator of the complaint
        if (!is_null($complaint->user)) {
            $complaint->user->notify(new NewNoteNotification($note));
        }

        return redirect()->back()->with('success', 'Note added successfully.');
    }}
