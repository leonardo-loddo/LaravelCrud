nel progetto laravel implementare tutta la logica del CRUD

index

create

store

show

edit

update

delete



duplico la vista article.create e la rinomino edit

nel controller creo la funzione edit che ritorna la vista article.edit

come la show questa sará una rotta parametrica per cui vado a passare article come parametro tramite dependecy injaction e lo restituisco nel return
    public function edit(Article $article){
        return view('article.edit', compact('article'));
    }

creo la rotta
    Route::get('/article/{article}/edit', [ArticleController::class, 'edit'])->name('article.edit');

nel dettaglio dell'articolo aggiungo il bottone per andare alla vista edit
    <a href="{{route('article.edit', ['article' => $article['id']])}}" class="btn btn-primary">Modifica {{$article->title}}</a>

do come value ai campi del form gli attributi attuali dell'articolo
    <div class="mb-3">
        <label for="title" class="form-label">Titolo Articolo</label>
        <input type="text" value="{{$article->title}}" class="form-control" name="title">
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Corpo Articolo</label>
        <textarea name="body" id="" cols="30" rows="10">{{$article->body}}</textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Copertina</label>
        <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

aggiungo al form un elemento img per mostrare la copertina attuale
    <div class="mb-3">
        <label for="title" class="form-label">Titolo Articolo</label>
        <input type="text" value="{{$article->title}}" class="form-control" name="title">
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Corpo Articolo</label>
        <textarea name="body" id="" cols="30" rows="10">{{$article->body}}</textarea>
    </div>
    <img src="{{Storage::url($article->image)}}" class="card-img-top" alt="..."> //qua
    <div class="mb-3">
        <label for="image" class="form-label">Copertina</label>
        <input type="file" class="form-control" name="image">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

creo la  rotta update
    Route::put('/article/{article}/update', [ArticleController::class, 'update'])->name('article.update');

creo la funzione update nel controller

lancio php artisan make:request ArticleUpdateRequest
vado sulla request creata e metto authorize a true
cambio le rules
    public function rules(): array
    {
        return [
            'title' => 'required',
            'body' => 'required',
            'image' => 'mimes:jpg,jpeg,bmp,png|max:2048',
        ];
    }

utilizzo questa request per la dependency injection della update
    public function update(ArticleUpdateRequest $request, Article $article){

vado sulla vista edit e modifico la action in modo da passare il parametro article per comunicare allaa funzione che articolo modificare, cambio anche il @method in PUT
    <form action="{{route('article.update',$article)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

creo la rotta destroy
    Route::delete('/article/{article}/destroy', [ArticleController::class, 'destroy'])->name('article.destroy');

creo la funzione destroy nel controller
    public function destroy(Article $article){
        $article->delete();
        return redirect()->route('article.index')->with('success', 'Libro Eliminato');
    }

nella vista show creo il form per eliminare un'articolo
    <form action="{{route('article.destroy',$article)}}" method="POST">
        @csrf
        @method('DELETE')
        <button class="text-danger" type="submit">Elimina {{$article->title}}</button>
    </form>

posso anche non andare a scriver tutte le singole rotte del crud in quanto c'é una particolare rotta che mi permette di sostituire tutte le rotte appena viste
    Route::resource('article', ArticleController::class);


per la creazione del modello delle migrazioni del controller e delle request che abbiamo creato durante lo sviluppo del crud possiamo utilizzare il comando all in one
    php artisan make:model Test -mcrR
in cquesto modo ci resteranno da creare solo le rotte ma abbiamo gia visto come farlo in modo semplificato e le relative view

lancio il comandfo all in one per creare il crud di Author
    php artisan make:model Author -mcrR

creo le rotte attraverso questo metodo
    Route::resource('author', AuthorController::class);