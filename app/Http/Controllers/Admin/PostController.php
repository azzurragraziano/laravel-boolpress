<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::all();

        $request_info = $request->all();

        $show_deleted_message = isset($request_info['deleted']) ? $request_info['deleted'] : null;
        
        $data = [
            'posts' => $posts,
            'show_deleted_message' => $show_deleted_message
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //con la funzione getValidation valido i dati che ha inserito l'utente
        $request->validate($this->getValidation());

        // se la validazione è andata a buon fine salvo i dati inseriti dall'utente in $form_data
        $form_data = $request->all();

        //creo un nuovo post
        $new_post = new Post();
        $new_post->fill($form_data);
        
        //creo automaticamente lo slug
        $new_post->slug = $this->getFreeSlug($new_post->title);
        
        //salvo il post
        $new_post->save();

        //dopodichè gli devo attaccare i tag
        if(isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        }
        
        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $data = [
            'post' => $post
        ];
        
        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //valido i dati
        $request->validate($this->getValidation());

        //se la validazione va a buon fine, leggo i dati del form
        $form_data = $request->all();

        //prendo il post da modificare 
        $post_to_update = Post::findOrFail($id);

        //sistemo lo slug nel caso in cui il titolo sia stato cambiato
        if($form_data['title'] !== $post_to_update->title) {
            $form_data['slug'] = $this->getFreeSlug($form_data['title']); //se il titolo cambia, modifico lo slug
        } else {
            $form_data['slug'] =  $post_to_update->slug; //se il titolo non cambia, lo lascio uguale
        }

        //lo aggiorno con ->update()
        $post_to_update->update($form_data);

        //aggiorno i tag
        if(isset($form_data['tags'])) {
            $post_to_update->tags()->sync($form_data['tags']);
        } else {
            $post_to_update->tags()->sync([]); 
        }

        //dopo aver aggiornato il post lo reindirizzo alla show
        return redirect()->route('admin.posts.show', ['post' => $post_to_update->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_to_delete = Post::findOrFail($id);
        $post_to_delete->tags()->sync([]); //rimuovo le relazioni prima di cancellare un post
        $post_to_delete->delete();

        return redirect()->route('admin.posts.index', ['deleted' => 'yes']);
    }

    public function getFreeSlug($title) {
        // assegno lo slug
        $slug_to_save = Str::slug($title, '-');

        //salvo lo slug base senza $counter
        $slug_base = $slug_to_save;

        //verifico se lo slug_to_save è già esistente nel db
        $existing_slug = Post::where('slug', '=', $slug_to_save)->first();

        //appendo un numero allo slug_base finché non ne trovo uno libero
        $counter = 1;
        while($existing_slug) {
            //proviamo a creare un nuovo slug con -$counter
            $slug_to_save = $slug_base . '-' . $counter;

            //verifico nuovamente se lo slug è già esistente nel db
            $existing_slug = Post::where('slug', '=', $slug_to_save)->first();

            $counter++;
        }

        return $slug_to_save;
    }

    protected function getValidation() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:60000',
            'category_id' => 'exists:categories,id',
            'tags' => 'nullable|exists:tags,id'
        ];
    }
}
