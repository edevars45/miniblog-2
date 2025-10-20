<?php
 
namespace App\Http\Controllers;
 
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class PostController extends Controller
{
 
    public function publicIndex()
    {
        $posts = Post::with('user')
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->paginate(10);
 
        return view('posts.public-index', compact('posts'));
    }
 
    // Liste : auteurs voient leurs posts ; éditeurs/admin voient tout
    public function index()
    {
        $query = Post::query()->with('user')->orderByDesc('created_at');
 
        if (!Auth::user()->hasRole(['editor', 'admin'])) {
            $query->where('user_id', Auth::id());
        }
 
        $posts = $query->paginate(10);
        return view('posts.index', compact('posts'));
    }
 
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('posts.create');
    }
 
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
 
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
 
        $post = new Post($data);
        $post->user_id = Auth::id();  // l’auteur = utilisateur connecté
        // status par défaut = draft (défini dans la migration)
        $post->save();
 
        return redirect()->route('posts.index')->with('status', 'Article créé (brouillon).');
    }
 
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }
 
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
 
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);
 
        $post->fill($data)->save();
 
        return redirect()->route('posts.index')->with('status', 'Article mis à jour.');
    }
 
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
 
        return redirect()->route('posts.index')->with('status', 'Article supprimé.');
    }
 
    public function publish(Post $post)
    {
        $this->authorize('publish', $post);
 
        $post->status = 'published';
        $post->published_at = now();
        $post->save();
 
        return back()->with('status', 'Article publié.');
    }
 
    public function unpublish(Post $post)
    {
        $this->authorize('publish', $post);
 
        $post->status = 'draft';
        $post->published_at = null;
        $post->save();
 
        return back()->with('status', 'Article dé-publié.');
    }
 
}
 