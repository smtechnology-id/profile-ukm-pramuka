<?php

namespace App\Http\Controllers;

use App\Models\CommentMemberWork;
use App\Models\CommentMentorWork;
use App\Models\Discussion;
use App\Models\Event;
use App\Models\MemberWork;
use App\Models\MentorWork;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->take(3)->get(); // Mengambil 3 berita terbaru
        return view('index', compact('news'));
    }

    // Register
    public function register()
    {
        return view('register');
    }
    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
        ]);
        $user = new User();
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->storeAs('user', $photoName, 'public');
            $user->photo = $photoName;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->level = 'user';
        $user->save();
        return redirect()->route('login')->with('success', 'Register Berhasil, Silahkan Login');
    }

    public function login()
    {
        return view('login');
    }

    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->level == 'admin') {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/');
            }
        }

        return redirect('/login')->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // about
    public function about()
    {
        return view('about');
    }

    // Berita
    public function berita()
    {
        $news = News::orderBy('created_at', 'desc')->where('status', 'active')->get();
        return view('berita', compact('news'));
    }

    // Event
    public function event()
    {
        $events = Event::orderBy('created_at', 'desc')->where('status', 'active')->get();
        return view('event', compact('events'));
    }

    // eventShow
    public function eventShow($slug)
    {
        $event = Event::where('slug', $slug)->first();
        return view('event-show', compact('event'));
    }
    // news
    public function newsShow($slug)
    {
        $news = News::where('slug', $slug)->first();
        return view('news-show', compact('news'));
    }


    // mentor work
    public function pojokPembina()
    {
        $mentorWork = MentorWork::orderBy('created_at', 'desc')->where('status', 'active')->get();
        return view('mentor-work', compact('mentorWork'));
    }
    public function mentorWorkShow($slug)
    {
        $id = MentorWork::where('slug', $slug)->first()->id;
        $comments = CommentMentorWork::where('mentor_work_id', $id)->orderBy('created_at', 'desc')->get();
        $mentorWork = MentorWork::where('slug', $slug)->first();
        $mentorWorks = MentorWork::orderBy('created_at', 'desc')->where('status', 'active')->take(3)->get();
        return view('mentor-work-show', compact('mentorWork', 'mentorWorks', 'comments'));
    }

    // member work
    public function pojokAnggota()
    {
        $memberWork = MemberWork::orderBy('created_at', 'desc')->where('status', 'active')->get();
        return view('member-work', compact('memberWork'));
    }
    public function memberWorkShow($slug)
    {
        $id = MemberWork::where('slug', $slug)->first()->id;
        $comments = CommentMemberWork::where('member_work_id', $id)->orderBy('created_at', 'desc')->get();
        $memberWork = MemberWork::where('slug', $slug)->first();
        $memberWorks = MemberWork::orderBy('created_at', 'desc')->where('status', 'active')->take(3)->get();
        return view('member-work-show', compact('memberWork', 'memberWorks', 'comments'));
    }

    // Diskusi
    public function diskusi() {
        $diskusi = Discussion::latest()->get();
        return view('diskusi', compact('diskusi'));
    }
}
