<x-layout>
    <section>
        <form action="{{route('article.update',$article)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-3">
                <label for="title" class="form-label">Titolo Articolo</label>
                <input type="text" value="{{$article->title}}" class="form-control" name="title">
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Corpo Articolo</label>
                <textarea name="body" id="" cols="30" rows="10">{{$article->body}}</textarea>
            </div>
            <img src="{{Storage::url($article->image)}}" class="card-img-top" alt="...">
            <div class="mb-3">
                <label for="image" class="form-label">Copertina</label>
                <input type="file" class="form-control" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </section>
</x-layout>