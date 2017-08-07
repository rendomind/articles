@php
    $title = ($item->id) ? 'Редактирование статьи' : 'Добавление статьи';
@endphp

@extends('admin::layouts.app')

@section('title', $title)

@section('styles')
    <!-- SELECT2 -->
    <link href="{!! asset('admin/css/plugins/select2/select2.min.css') !!}" rel="stylesheet">

    <!-- ICHECK -->
    <link href="{!! asset('admin/css/plugins/iCheck/custom.css') !!}" rel="stylesheet">

    <!-- DATETIMEPICKER -->
    <link href="{!! asset('admin/css/plugins/datetimepicker/jquery.datetimepicker.css') !!}" rel="stylesheet">

    <!-- CROPPER -->
    <link href="{!! asset('admin/css/plugins/cropper/cropper.min.css') !!}" rel="stylesheet">

    <!-- JSTREE -->
    <link href="{!! asset('admin/css/plugins/jstree/style.min.css') !!}" rel="stylesheet">

    <style>
        .jstree-open > .jstree-anchor > .fa-folder:before {
            content: "\f07c";
        }

        .jstree-default .jstree-icon.none {
            width: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-12">
            <h2>
                {{ $title }}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ url('/back/') }}">Главная</a>
                </li>
                <li>
                    <a href="{{ route('back.articles.index') }}">Статьи</a>
                </li>
                <li class="active">
                    <strong>
                        {{ $title }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (!$item->id) ? route('back.articles.store') : route('back.articles.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('article_id', (!$item->id) ? '' : $item->id) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="metaAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#metaAccordion" href="#collapseMeta" aria-expanded="false" class="collapsed">Мета теги</a>
                                </h5>
                            </div>
                            <div id="collapseMeta" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body">

                                    {!! Form::string('meta[title]', $item->getMeta('title'), [
                                        'label' => [
                                            'title' => 'Title',
                                        ],
                                    ]) !!}

                                    {!! Form::string('meta[description]', $item->getMeta('description'), [
                                        'label' => [
                                            'title' => 'Description',
                                        ],
                                    ]) !!}

                                    {!! Form::string('meta[keywords]', $item->getMeta('keywords'), [
                                        'label' => [
                                            'title' => 'Keywords',
                                        ],
                                    ]) !!}

                                    {!! Form::radios('meta[robots]', $item->getMeta('robots'), [
                                        'label' => [
                                            'title' => 'Индексировать',
                                        ],
                                        'radios' => [
                                            [
                                                'label' => 'Да',
                                                'value' => 'index, follow',
                                                'options' => [
                                                    'class' => 'i-checks',
                                                ],
                                            ],
                                            [
                                                'label' => 'Нет',
                                                'value' => 'noindex, nofollow',
                                                'options' => [
                                                    'class' => 'i-checks',
                                                ],
                                            ],
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="socialMetaAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#socialMetaAccordion" href="#collapseSocialMeta" aria-expanded="false" class="collapsed">Социальные мета теги</a>
                                </h5>
                            </div>
                            <div id="collapseSocialMeta" class="panel-collapse collapse" aria-expanded="false">
                                <div class="panel-body">

                                    {!! Form::string('meta[og:title]', $item->getMeta('og:title'), [
                                        'label' => [
                                            'title' => 'og:title',
                                        ],
                                    ]) !!}

                                    {!! Form::string('meta[og:description]', $item->getMeta('og:description'), [
                                        'label' => [
                                            'title' => 'og:description',
                                        ],
                                    ]) !!}

                                    @php
                                        $ogImageMedia = $item->getFirstMedia('og_image');
                                    @endphp

                                    {!! Form::crop('og_image', $ogImageMedia, [
                                        'label' => [
                                            'title' => 'og:image',
                                        ],
                                        'image' => [
                                            'src' => isset($ogImageMedia) ? url($ogImageMedia->getUrl()) : '',
                                            'type' => 'single',
                                        ],
                                        'crops' => [
                                            [
                                                'title' => 'Размер 968х475',
                                                'name' => 'default',
                                                'ratio' => '968/475',
                                                'value' => isset($ogImageMedia) ? $ogImageMedia->getCustomProperty('crop.default') : '',
                                            ],
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::string('title', $item->title, [
                                        'label' => [
                                            'title' => 'Заголовок',
                                        ],
                                        'field' => [
                                            'class' => 'form-control slugify',
                                            'data-slug-url' => route('back.articles.getSlug'),
                                            'data-slug-target' => 'slug',
                                        ],
                                    ]) !!}

                                    {!! Form::string('slug', $item->slug, [
                                        'label' => [
                                            'title' => 'URL',
                                        ],
                                        'field' => [
                                            'class' => 'form-control slugify',
                                            'data-slug-url' => route('back.articles.getSlug'),
                                            'data-slug-target' => 'slug',
                                        ],
                                    ]) !!}

                                    @php
                                        $previewImageMedia = $item->getFirstMedia('preview');
                                    @endphp

                                    {!! Form::crop('preview', $previewImageMedia, [
                                        'label' => [
                                            'title' => 'Превью',
                                        ],
                                        'image' => [
                                            'src' => isset($previewImageMedia) ? url($previewImageMedia->getUrl()) : '',
                                            'type' => 'single',
                                        ],
                                        'crops' => [
                                            [
                                                'title' => 'Размер 3х4',
                                                'name' => '3_4',
                                                'ratio' => '3/4',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.3_4') : '',
                                            ],
                                            [
                                                'title' => 'Размер 3х2',
                                                'name' => '3_2',
                                                'ratio' => '3/2',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('crop.3_2') : '',
                                            ],
                                        ],
                                        'additional' => [
                                            [
                                                'title' => 'Описание',
                                                'name' => 'description',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('description') : '',
                                            ],
                                            [
                                                'title' => 'Copyright',
                                                'name' => 'copyright',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('copyright') : '',
                                            ],
                                            [
                                                'title' => 'Alt',
                                                'name' => 'alt',
                                                'value' => isset($previewImageMedia) ? $previewImageMedia->getCustomProperty('alt') : '',
                                            ],
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('description', $item->description, [
                                        'label' => [
                                            'title' => 'Лид',
                                        ],
                                        'field' => [
                                            'class' => 'tinymce-simple',
                                            'type' => 'simple',
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('content', $item->content, [
                                        'label' => [
                                            'title' => 'Содержимое',
                                        ],
                                        'field' => [
                                            'class' => 'tinymce',
                                        ],
                                    ]) !!}

                                    <div class="form-group ">

                                        <label for="title" class="col-sm-2 control-label">Категории</label>

                                        <div class="col-sm-10">
                                            @if (count($categories) > 0)
                                                <div class="jstree-list" data-target="categories" data-multiple="true" data-cascade="up">
                                                    <ul>
                                                        @foreach ($categories as $category)
                                                            @include('admin.module.categories::pages.categories.partials.form_category', [
                                                                'id' => 'сategoryId',
                                                                'item' => $category,
                                                                'currentId' => $item->id,
                                                                'selected' => $item->categories()->pluck('id')->toArray(),
                                                            ])
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <p>Список категорий пуст.</p>
                                            @endif

                                            {!! Form::hidden('categories', '') !!}

                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>

                                    {!! Form::dropdown('tags[]', $item->tags()->pluck('id')->toArray(), [
                                        'label' => [
                                            'title' => 'Теги',
                                        ],
                                        'field' => [
                                            'class' => 'select2 form-control',
                                            'data-placeholder' => 'Выберите теги',
                                            'style' => 'width: 100%',
                                            'multiple' => 'multiple',
                                            'data-source' => route('back.tags.getSuggestions'),
                                        ],
                                        'options' => (old('tags')) ? \InetStudio\Tags\Models\TagModel::whereIn('id', old('tags'))->pluck('name', 'id')->toArray() : $item->tags()->pluck('name', 'id')->toArray(),
                                    ]) !!}

                                    {!! Form::datepicker('publish_date', ($item->publish_date) ? date('d.m.Y H:i', strtotime($item->publish_date)) : '', [
                                        'label' => [
                                            'title' => 'Дата публикации',
                                        ],
                                        'field' => [
                                            'class' => 'datetimepicker form-control',
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::buttons('', '', ['back' => 'back.tags.index']) !!}

        {!! Form::close()!!}
    </div>

    {!! Form::modals_crop() !!}

@endsection

@section('scripts')
    <!-- SELECT2 -->
    <script src="{!! asset('admin/js/plugins/select2/select2.full.min.js') !!}"></script>
    <script src="{!! asset('admin/js/plugins/select2/i18n/ru.js') !!}"></script>

    <!-- ICHECK -->
    <script src="{!! asset('admin/js/plugins/iCheck/icheck.min.js') !!}"></script>

    <!-- CROPPER -->
    <script src="{!! asset('admin/js/plugins/cropper/cropper.min.js') !!}"></script>

    <!-- JSTREE -->
    <script src="{!! asset('admin/js/plugins/jstree/jstree.min.js') !!}"></script>

    <!-- DATETIMEPICKER -->
    <script src="{!! asset('admin/js/plugins/datetimepicker/jquery.datetimepicker.full.min.js') !!}"></script>

    <!-- TINYMCE -->
    <script src="{!! asset('admin/js/plugins/tinymce/tinymce.min.js') !!}"></script>
@endsection
