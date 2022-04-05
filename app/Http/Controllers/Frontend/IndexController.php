<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactUs;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class IndexController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'media', 'user']);

        $posts = $posts->wherePostType('post')->wherePostStatus(1)
            ->whereHas('category', function ($query) {
                $query->whereStatus(1);
            });

        $posts = $posts->whereHas('user', function ($query) {
            $query->whereStatus(1);
        })->orderBy('id', 'desc')->paginate(5);

        return view('frontend.index', compact('posts'));
    }

    public function post_show($slug)
    {
        $post = Post::with(['category', 'media', 'user',
            'approved_comments' => function ($query) {
                $query->orderBy('id', 'desc');
            }
        ])->whereHas('category', function ($query) {
            $query->whereStatus(1);
        });
        $post = $post->whereHas('user', function ($query) {
            $query->whereStatus(1);
        });
        $post = $post->whereSlug($slug);
        $post = $post->wherePostStatus(1)->first();

        $blade = $post->post_type == 'post' ? 'post' : 'page';

        if ($post)
            return view('frontend' . '.' . $blade, compact('post'));
        else
            return redirect()->route('frontend.index');

    }

    public function store_comment(Request $request, $slug)
    {
        $validated = validator::make($request->all(), [
            'comment' => 'required|min:10',
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'nullable|url',
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $post = Post::whereSlug($slug)->wherePostType('post')->wherePostStatus(1)->first();
        if ($post) {
//            Comment::create([
//
//
//            ]);

            $userId = auth()->check() ? auth()->id() : null;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['url'] = $request->url;
            $data['ip_address'] = $request->ip();
            $data['comment'] = Purify::clean($request->comment);
            $data['post_id'] = $post->id;
            $data['user_id'] = $userId;
            $post->comments()->create($data);
            return redirect()->back()->with([
                'message' => 'Commented in successfully.',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Logged in successfully.',
            'alert-type' => 'danger'
        ]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function do_contact(Request $request)
    {
        $validated = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'mobile' => 'nullable|numeric',
            'title' => 'required',
            'message' => 'required',

        ]);
        if ($validated->fails()) {

            return redirect()->back()->withErrors($validated)->withInput();
        }
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['mobile'] = $request->mobile;
        $data['title'] = $request->title;
        $data['message'] = $request->message;
        ContactUs::create($data);
        return redirect()->back()->with([
            'message' => 'Commented in successfully.',
            'alert-type' => 'success'
        ]);
    }

    public function search(Request $request)
    {
        $keyword = isset($request->keyword) && $request->keyword != '' ? $request->keyword : null;
        $posts = Post::with(['category', 'media', 'user']);
        $posts = $posts->whereHas('category', function ($query) {
            $query->whereStatus(1);
        });
        $posts = $posts->whereHas('user', function ($query) {
            $query->whereStatus(1);
        });

        if ($keyword != null) $posts = $posts->search($keyword, null, true);
        $posts = $posts->wherePostType('post')->wherePostStatus(1)->orderBy('id', 'desc')->paginate(5);
        return view('frontend.index', compact('posts'));

    }

    protected function category($slug)
    {
        $category = Category::whereSlug($slug)->orWhere('id', $slug)->whereStatus(1)->first()->id;

        if ($category) {
            $posts = Post::with(['media', 'user', 'category'])
                ->whereCategoryId($category)
                ->wherePostType('post')
                ->wherePostStatus(1)
                ->orderBy('id', 'desc')
                ->paginate(5);

            return view('frontend.index', compact('posts'));
        }

        return redirect()->route('frontend.index');

    }

    protected function archive($date)
    {
        $exploded_date = explode('-', $date);
        $month = $exploded_date[0];
        $year = $exploded_date[1];

        $posts = Post::with(['media', 'user'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->wherePostType('post')
            ->wherePostStatus(1)
            ->orderBy('id', 'desc')
            ->paginate(5);
        return view('frontend.index', compact('posts'));

    }

    protected function author($username)
    {

        $user = User::whereUsername($username)->whereStatus(1)->first()->id;
        if ($user) {
            $posts = Post::with(['media', 'user', 'category'])
                ->withCount('approved_comments')
                ->whereUserId($user)
                ->wherePostType('post')
                ->wherePostStatus(1)
                ->orderBy('id', 'desc')
                ->paginate(5);
            return view('frontend.index', compact('posts'));

        }
        return redirect()->route('frontend.index');
    }
}
