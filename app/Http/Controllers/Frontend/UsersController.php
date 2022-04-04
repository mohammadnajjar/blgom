<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Stevebauman\Purify\Facades\Purify;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {

//        $posts = Post::whereUserId(auth()->user());

        $posts = auth()->user()->posts()->with(['category', 'media', 'user'])->withCount('comments')->orderBy('id', 'desc')->paginate(10);

//        return $posts;
        return view('frontend.users.dashboard', compact('posts'));
    }

    public function create_post()
    {
        $categories = Category::whereStatus(1)->pluck('name', 'id');
        return view('frontend.users.create_post', compact('categories'));
    }

    public function store_post(Request $request)
    {
        $validated = validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:50',
            'comment_able' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $data['title'] = $request->title;
        $data['description'] = Purify::clean($request->description);
        $data['comment_able'] = $request->comment_able;
        $data['post_status'] = $request->status;
        $data['category_id'] = $request->category_id;
        $post = auth()->user()->posts()->create($data);
        if ($request->images && count($request->images) > 0) {
            $i = 1;
            foreach ($request->images as $file) {
                $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();
                $filesize = $file->getsize();
                $filetype = $file->getMimeType();

                $path = public_path('/assets/posts/' . $filename);

                Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);

                $post->media()->create([
                    'file_name' => $filename,
                    'file_size' => $filesize,
                    'file_type' => $filetype,
                ]);
                $i++;
            }
            if ($request->status == 1) {
                Cache::Forget('recent_post');
            }
            return redirect()->back()->with([
                'message' => 'Post created successfully.',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function edit_post($post_id)
    {

        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)
            ->whereUserId(auth()->user()->id)->first();
        if ($post) {
            $categories = Category::whereStatus(1)->pluck('name', 'id');
            return view('frontend.users.edit_post', compact('categories', 'post'));
        }
        return redirect()->route('frontend.index');
    }

    public function update_post(Request $request, $post_id)
    {
        $validated = validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:50',
            'comment_able' => 'required',
            'status' => 'required',
            'category_id' => 'required',
        ]);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->first();

        if ($post) {
            $data['title'] = $request->title;
            $data['description'] = Purify::clean($request->description);
            $data['comment_able'] = $request->comment_able;
            $data['post_status'] = $request->status;
            $data['category_id'] = $request->category_id;
            $post->update($data);
            if ($request->images && count($request->images) > 0) {
                $i = 1;
                foreach ($request->images as $file) {
                    $filename = $post->slug . '-' . time() . '-' . $i . '.' . $file->getClientOriginalExtension();

                    $file_size = $file->getSize();
                    $file_type = $file->getMimeType();
                    $path = public_path('assets/posts/' . $filename);
                    Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);

                    $post->media()->create([
                        'file_name' => $filename,
                        'file_size' => $file_size,
                        'file_type' => $file_type,
                    ]);
                    $i++;
                }
            }

            return redirect()->back()->with([
                'message' => 'Post updated successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function destroy_post_media($media_id)
    {
        $media = PostMedia::whereId($media_id)->first();

        if ($media) {
            if (File::exists('assets/posts/' . $media->file_name)) {
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;
    }

    public function destroy_post($post_id)
    {
        $post = Post::whereSlug($post_id)->orWhere('id', $post_id)->first();
        if ($post) {
            if (count($post->media) > 0) {
                foreach ($post->media as $media) {
                    if (File::exists('assets/posts/' . $media->file_name)) {
                        unlink('assets/posts/' . $media->file_name);
                    }
                    $media->delete();
                }
            }
            $post->delete();
            return redirect()->back()->with([
                'message' => 'Post Deleted successfully',
                'alert-type' => 'success',
            ]);
        }

        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function show_comments()
    {
        $posts_id = auth()->user()->posts()->pluck('id')->toArray();
        $comments = Comment::whereIn('post_id', $posts_id)->orderBy('id', 'desc')->paginate(10);

        return view('frontend.users.comments', compact('comments'));
    }

    public function edit_comment($comment_id)
    {

        $comment = Comment::whereId($comment_id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();
        if ($comment) {
            return view('frontend.users.edit_comment', compact('comment'));
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function update_comment(Request $request, $comment_id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'url' => 'nullable|url',
            'comment_status' => 'required',
            'comment' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = Comment::whereId($comment_id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();

        if ($comment) {
            $data['name'] = $request->name;
            $data['email'] = Purify::clean($request->email);
            $data['url'] = $request->url != '' ? $request->url : null;
            $data['comment_status'] = $request->comment_status;
            $data['comment'] = Purify::clean($request->comment);
            $comment->update($data);
            if ($request->comment_status == 1) {
                Cache::Forget('recent_comment');
            }
            return redirect()->back()->with([
                'message' => 'Comment Updated successfully.',
                'alert-type' => 'success'
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Something was wrong',
            'alert-type' => 'danger',
        ]);
    }

    public function destroy_comment($comment_id)
    {
        return $comment_id;
        $comment = Comment::whereId($comment_id)->whereHas('post', function ($query) {
            $query->where('posts.user_id', auth()->id());
        })->first();
        return $comment;
        if ($comment) {
            $comment->delete();
            Cache::Forget('recent_comment');
            return redirect()->back()->with([
                'message' => 'Comment Updated successfully.',
                'alert-type' => 'success'
            ]);
        }
        /* return redirect()->back()->with([
             'message' => 'Something was wrong',
             'alert-type' => 'danger',
         ]);*/
    }
}
