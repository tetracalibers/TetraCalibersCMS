@extends('back.layouts.base')
@section('title', 'ブログ記事を編集')

@section('main')
    <div class="row">
        <h1 class="col m10">「{{ $blog->title }}」を編集</h1>
        <a href="/blog/{{ $blog->id }}" target="_blank" rel="noopener noreferrer" class="col m2">
            <button class="_info _round _width100">記事を表示</button>
        </a>
    </div>
    <x-back.formResult />

    <script id="tagsJSON" type="application/json">
        <?php echo $tagsJSON; ?>
    </script>
    <script id="checkedTagsJSON" type="application/json">
        <?php echo $checkedTagsJSON; ?>
    </script>
    <div id="app">
        <form method="post" action="{{ route('back.blog.update', $blog->id) }}" id="validateform" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
            <label for="series">シリーズ</label>
            <select name="series" class="_width100">
                <option value="0" {{ $blog->series_id == 0 ? 'selected' : '' }}>該当なし</option>
                @foreach ($series as $s)
                <option value="{{ $s->id }}" {{ $blog->series_id == $s->id ? 'selected' : '' }}>{{ $s->title }}</option>
                @endforeach
            </select>

            <label for="title">タイトル</label>
            <input type="text" name="title" class="_width100" v-model="need_title" v-init:need_title="'{{ $blog->title }}'">
            <need-errors :errors="errors.title"></need-errors>

            <label for="subtitle">サブタイトル</label>
            <input type="text" name="subtitle" class="_width100" value="{{ $blog->subtitle }}">

            <label for="content">本文</label>
            <multi-image-uploader></multi-image-uploader>
            <xml-file-parser @tomixy_updatecontent="updateContent" init-content="{{ $blog->content }}"></xml-file-parser>
            <need-errors :errors="errors.content"></need-errors>

            <label for="references">参考文献</label>
            <select name="references[]" class="_width100" multiple="multiple" style="height: calc(26px * {{ $references->count() }});">
                @foreach ($references as $reference)
                <option value="{{ $reference->id }}" {{ $checkedReferences->keys()->contains($reference->id) ? 'selected' : '' }}>{{ $reference->title }}</option>
                @endforeach
            </select>

            <label for="memorize">暗記モード</label>
            <select name="memorize" class="_width100">
                <option value="0" {{ $blog->memorize == '0' ? 'selected' : '' }}>OFF</option>
                <option value="1" {{ $blog->memorize == '1' ? 'selected' : '' }}>ON</option>
            </select>

            <label for="metaimage">og:image</label>
            <div class="selectImageArea">
                <image-url-previewer input-name="metaimageURL" init-value="{{ $blog->metaimage }}"></image-url-previewer>
                <image-uploader input-name="metaimageFile"></image-uploader>
            </div>

            <label for="metadesc">og:description</label>
            <input type="text" name="metadesc" class="_width100" value="{{ $blog->metadesc }}">

            <rich-checkbox @tomixy_updatetagcount="updateTagCount"></rich-checkbox>
            <need-errors :errors="errors.tags"></need-errors>

            <button type="submit" class="_primary" @click="validate">更新</button>
            <a href="{{ route('back.blog.index') }}">
                <button type="button">一覧へ戻る</button>
            </a>
        </form>
    </div>
@endsection
