<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // $posts = PostResource::collection(Post::latest()->paginate(3));
        $search = $request->input('search');

        $query = Post::query()
            ->where('user_id', auth()->user()->id)
            ->when($search, function ($query, $search) {
                // Memecah kata kunci pencarian menjadi array
                $searchTerms = explode(' ', $search);

                foreach ($searchTerms as $term) {
                    // Menggunakan where untuk setiap kata kunci
                    $query->where('title', 'like', "%{$term}%");
                }
            })
            ->latest()->paginate(3);

        $posts = PostResource::collection($query);

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
            'filters' => $request->only(['search'])
        ]);
    }

    public function show(Post $post)
    {
        $post->image_url = asset('storage/' . $post->image);

        $post->category;
        $post->user;

        $post->create_format = Carbon::parse($post->created_at)
            ->locale('id')
            ->translatedFormat('l, d F Y H:i');


        return Inertia::render('Posts/Show', [
            'post' => $post,

        ]);
    }

    public function create()
    {
        return Inertia::render('Posts/Create', [
            'categories' => Category::all()
        ]);
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // 'slug' => 'required|unique:posts',
            'image' => 'image|file|max:1024|nullable',
            'category_id' => 'required',
            'body' => 'required'
        ]);

        if ($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->title);

        Post::create($validatedData);

        return redirect(route('posts.index'))->with('message', 'Created is success!');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'image' => 'image|file|max:1024|nullable',
            'body' => 'required'
        ];


        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('post-images');
        } else {

            $validatedData['image'] = $request->oldImage;
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['slug'] = Str::slug($request->title);


        Post::where('id', $post->id)
            ->update($validatedData);

        return redirect("/posts")->with('message', 'Updated is success!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::delete($post->image);
        }
        Post::destroy($post->id);
        return redirect('posts')->with('success', 'post has been deleted!');
    }
}
