<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendNewMail;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        $posts = Post::orderBy('updated_at', 'DESC')->paginate(10);
        $tags = Tag::all();
        return view('admin.posts.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $post = new Post();
        $categories = Category::all();
        $tags = Tag::all();
        $post_tags = $post->tags->pluck('id')->toArray();
        return view('admin.posts.create', compact('post', 'categories', 'tags', 'post_tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'title' => 'required|string|unique:posts|min:5|max:255',
                'image' => 'nullable|image',
                'description' => 'required|string',
                'category_id' => 'nullable|exists:categories,id',
                'tags' => 'nullable|exists:tags,id',
            ],
            [
                'required' => 'Il campo :attribute è obbligatorio!',
                'title.unique' => "Il Post $request->title è già esistente!",
                'image.unique' => "Questa immagine è già stata inserita!",
                'title.min' => "$request->title è lungo meno di 5 caratteri!",
                'tags.exists' => 'Il tag selezionato non è valido'
            ]
        );

        $data = $request->all();

        $data['slug'] = Str::slug($request->title, '-');

        if (array_key_exists('image', $data)) {
            $img_post = Storage::put('uploads_img', $data['image']);
            $data['image'] = $img_post;
        }

        $post = Post::create($data);

        if (array_key_exists('tags', $data)) $post->tags()->attach($data['tags']);

        $mail_new_post = new SendNewMail($post);
        $user = Auth::user();
        Mail::to($user->email)->send($mail_new_post);

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
        $categories = Category::all();
        $tags = Tag::all();
        $post_tags = $post->tags->pluck('id')->toArray();

        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'post_tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //

        $request->validate(
            [
                'title' => 'required|string|unique:posts|min:5|max:255',
                'image' => 'nullable|image',
                'description' => 'required|string',
                'category_id' => 'nullable|exists:categories,id',
                'tags' => 'nullable|exists:tags,id'
            ],
            [
                'required' => 'Il campo :attribute è obbligatorio!',
                'title.unique' => "Il Post $request->title è già esistente!",
                'image.unique' => "Questa immagine è già stata inserita!",
                'title.min' => "$request->title è lungo meno di 5 caratteri!",
                'tags.exists' => 'Il tag selezionato non è valido'
            ]
        );

        $data = $request->all();

        if (array_key_exists('image', $data)) {
            if ($post->image) Storage::delete($post->image);

            $img_post = Storage::put('post_image', $data['image']);
            $data['image'] = $img_post;
        }

        $data['slug'] = Str::slug($request->title, '-');
        $post->update();

        if (!array_key_exists('tags', $data)) $post->tags()->detach($data['tags']);
        else $post->tags()->sync($data['tags']);

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
        $post->delete();

        if (count($post->tags)) $post->tags()->detach();

        if ($post->image) Storage::delete($post->image);

        return redirect()->route('admin.posts.index', $post)->with('massage', 'il post $post-id è stato eliminato');
    }
}
