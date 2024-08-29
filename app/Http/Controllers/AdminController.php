<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Event;
use App\Models\MentorWork;
use Illuminate\Support\Str;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function news()
    {
        $news = News::all();
        return view('admin.news', compact('news'));
    }

    public function newsCreate()
    {
        return view('admin.news-create');
    }
    public function newsStore(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            // Menggunakan storage untuk menyimpan gambar
            $photo->storeAs('news', $photoName, 'public');
        }
        $slug = Str::slug($request->title);

        $news = new News();
        $news->photo = $photoName;
        $news->title = $request->title;
        $news->content = $request->content;
        $news->author = $request->author;
        $news->status = $request->status;
        $news->slug = $slug;
        $news->save();
        return redirect()->route('admin.news')->with('success', 'News created successfully');
    }
    public function newsEdit($id)
    {
        $news = News::find($id);
        return view('admin.news-edit', compact('news'));
    }

    public function newsUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $news = News::find($request->id);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('news', $photoName, 'public');
            $news->photo = $photoName;
        }
        $news->title = $request->title;
        $news->content = $request->content;
        $news->author = $request->author;
        $news->status = $request->status;
        $news->save();
        return redirect()->route('admin.news')->with('success', 'News updated successfully');
    }
    public function newsDestroy($id)
    {
        $news = News::find($id);
        $photo = $news->photo;
        Storage::delete('public/news/' . $photo);
        $news->delete();
        return redirect()->route('admin.news')->with('success', 'News deleted successfully');
    }



    // Mentor Work
    public function mentorWork()
    {
        $mentorWork = MentorWork::all();
        return view('admin.mentor-work', compact('mentorWork'));
    }
    public function mentorWorkCreate()
    {
        $mentor = MentorWork::all();
        return view('admin.mentor-work-create', compact('mentor'));
    }

    public function mentorWorkStore(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('mentor-work', $photoName, 'public');
        }
        $slug = Str::slug($request->title);

        $mentorWork = new MentorWork();
        $mentorWork->photo = $photoName;
        $mentorWork->title = $request->title;
        $mentorWork->content = $request->content;
        $mentorWork->author = $request->author;
        $mentorWork->status = $request->status;
        $mentorWork->slug = $slug;
        $mentorWork->save();
        return redirect()->route('admin.mentor-work')->with('success', 'Mentor Work created successfully');
    }

    public function mentorWorkEdit($id)
    {
        $mentorWork = MentorWork::find($id);
        return view('admin.mentor-work-edit', compact('mentorWork'));
    }
    public function mentorWorkUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $mentorWork = MentorWork::find($request->id);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('mentor-work', $photoName, 'public');
            $mentorWork->photo = $photoName;
        }
        $mentorWork->title = $request->title;
        $mentorWork->content = $request->content;
        $mentorWork->author = $request->author;
        $mentorWork->status = $request->status;
        $mentorWork->save();
        return redirect()->route('admin.mentor-work')->with('success', 'Mentor Work updated successfully');
    }
    public function mentorWorkDestroy($id)
    {
        $mentorWork = MentorWork::find($id);
        $photo = $mentorWork->photo;
        Storage::delete('public/mentor-work/' . $photo);
        $mentorWork->delete();
        return redirect()->route('admin.mentor-work')->with('success', 'Mentor Work deleted successfully');
    }
    
    public function event()
    {
        $event = Event::all();
        return view('admin.event', compact('event'));
    }

    public function eventCreate()
    {
        return view('admin.event-create');
    }
    public function eventStore(Request $request)
    {
        $request->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('event', $photoName, 'public');
        }
        $slug = Str::slug($request->title);

        $event = new Event();
        $event->photo = $photoName;
        $event->title = $request->title;
        $event->content = $request->content;
        $event->author = $request->author;
        $event->status = $request->status;
        $event->slug = $slug;
        $event->save();
        return redirect()->route('admin.event')->with('success', 'Event created successfully');
    }
    public function eventEdit($id)
    {
        $event = Event::find($id);
        return view('admin.event-edit', compact('event'));
    }
    public function eventUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);
        $event = Event::find($request->id);
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('event', $photoName, 'public');
            $event->photo = $photoName;
        }
        $event->title = $request->title;
        $event->content = $request->content;
        $event->author = $request->author;
        $event->status = $request->status;
        $event->save();
        return redirect()->route('admin.event')->with('success', 'Event updated successfully');
    }
    public function eventDestroy($id)
    {
        $event = Event::find($id);
        $photo = $event->photo;
        Storage::delete('public/event/' . $photo);
        $event->delete();
        return redirect()->route('admin.event')->with('success', 'Event deleted successfully');
    }

    // Registration
    public function registration()
    {
        $registration = Registration::all();
        $event = Event::all();
        return view('admin.registration', compact('registration', 'event'));
    }
    public function registrationDetail($id)
    {
        $registration = Registration::where('event_id', $id)->get();
        $event = Event::find($id);
        return view('admin.registration-detail', compact('registration', 'event'));
    }

}
