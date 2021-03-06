@extends('front.layouts.base')
@section('meta')
<meta property="og:title" content="{{ $article->title . ($article['subtitle'] ? "〜" . $article['subtitle'] . "〜" : "") }}" />
<meta property="og:image" content="{{ $article->metaimage }}" />
<meta property="og:type" content="article" />
<meta property="og:description" content="{{ $article->metadesc }}" />
<mata name="description" content="{{ $article->metadesc }}" />
@endsection

@if ($series)
    @section('title', $article->title . ($article['subtitle'] ? "〜" . $article['subtitle'] . "〜" : "") . ' <- ' .  $series['title'] . ' <- TetraCalibers')
@else
    @section('title', $article->title . ($article['subtitle'] ? "〜" . $article['subtitle'] . "〜" : "") . ' <- TetraCalibers')
@endif

@section('main')
<article class="blogContainer" id="particles_blog">
    <div class="titles">
        @if ($series)
        <div class="seriesTitle">
            {!! $series['title'] !!} - {{ $article->series_pos + 1 }}
        </div>
        @endif
        <div class="articleTitle">
            {!! $article->title !!}
        </div>
        @if ($article->subtitle)
        <div class="articleSubTitle">
            {!! $article->subtitle !!}
        </div>
        @endif
    </div>
    <time class="articleDate">
        <div>公開日==&#39;{{ $article->created_at }}&#39;;</div>
        @if ($article->created_at != $article->updated_at)
        <div>最終更新日==&#39;{{ $article->updated_at }}&#39;;</div>
        @endif
    </time>
    @if ($seriesArticles)
    <div class="seriesMapWrapper">
        <ul class="seriesMap">
            @foreach ($seriesArticles as $sArticle)
            <li>
                @if ($sArticle->series_pos == $article->series_pos)
                {{ $sArticle->series_pos + 1 . ' => ' . $sArticle->title }}<i class="fas fa-arrow-left"></i>現在地
                @else
                <a href="{{ route('front.blog.show', $sArticle->id)}}">{{ $sArticle->series_pos + 1 . ' => ' . $sArticle->title }}</a>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="tocWrapper">
        <div class="tocContent">
            <div class="tocTitle"></div>
            <ul class="toc"></ul>
        </div>
    </div><!-- END tocWrapper -->
    <div class="blogContents">
        @if ($article->memorize)
        <div class="annkiDesc">
            この記事は一問一答問題集としても使えます。<br>
            画面左下の<i class="fas fa-puzzle-piece fa-2x"></i>ボタンを押すと、<span class="annkiWord">桃色の文字</span>が塗りつぶされます。
            （もう一度押すと元に戻ります。）
        </div>
        @endif
        {!! $article->content !!}
        @if (count($references) > 0)
        <div class="referenceList">
            <div class="i-sankobunken">
                <i class="fas fa-book"></i>
                <span class="i-sankobunken-text">参考文献</span>
            </div>
            @foreach ($references as $ref_title => $ref_url)
            <a href="{{ $ref_url }}" class="i-link i-block" target="_blank rel="noopener noreferrer>
                <i class="fas fa-link"></i>
                {{ $ref_title }}
            </a>
            @endforeach
        </div>
        @endif
    </div><!-- END blogContents -->
    <div class="categoryList">
        <div class="categoryBack fluid"></div>
        <div class="categoryListText">
            <div class="categoryListTitle">Category</div>
            <ul>
            @foreach($tags as $name => $slug)
                <li>
                    <a href="/tags/{{ $slug }}">
                        {{ str_replace("<wbr>", "", $name) }}
                    </a>
                </li>
            @endforeach
            </ul>
        </div>
    </div><!-- END categoryList -->
    @if ($next)
    <div class="nextArticle">
        <a class="i-next" href="{{ route('front.blog.show', $next->id) }}">
            <div class="i-next-text">
                <span>n</span>
                <span>e</span>
                <span>x</span>
                <span>t</span>
            </div>
            <span class="i-next-title">{{ $next->title }}</span>
            <i class="fas fa-chevron-right"></i>
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    @endif
    <x-front.affiliate />
    <div class="toTopButton"><i class="fas fa-chevron-up fa-2x"></i></div>
    @if ($article->memorize)
    <div class="memorizeToggle">
        <i class="fas fa-puzzle-piece fa-2x"></i>
        <span class="annkiLabel">隠す</span>
    </div>
    @endif
</article>
@endsection
