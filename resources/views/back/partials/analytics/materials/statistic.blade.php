@inject('articlesService', 'InetStudio\Articles\Contracts\Services\Back\ArticlesServiceContract')

@php
    $articles = $articlesService->getArticlesStatisticByStatus();
@endphp

<li>
    <small class="label label-default">{{ $articles->sum('total') }}</small>
    <span class="m-l-xs">Статьи</span>
    <ul class="todo-list m-t">
        @foreach ($articles as $article)
            <li>
                <small class="label label-{{ $article->status->color_class }}">{{ $article->total }}</small>
                <span class="m-l-xs">{{ $article->status->name }}</span>
            </li>
        @endforeach
    </ul>
</li>
