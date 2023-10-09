<x-layout>
    <section>
        <x-card :item="$article"/>
        <a href="{{route('article.edit', ['article' => $article['id']])}}" class="btn btn-primary">Modifica {{$article->title}}</a>
        <form action="{{route('article.destroy',$article)}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="text-danger" type="submit">Elimina {{$article->title}}</button>
        </form>
    </section>
</x-layout>