@php
    use App\Models\Blog;
    use App\Models\BlogCategory;
    use App\Services\TranslationService;
    use App\Services\MediaService;
    $bread_crumb['page_main_bread_crumb'] = labels('front_messages.blogs', 'Blogs');
    $language_code = app(TranslationService::class)->getLanguageCode();
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero Banner (Offers-style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 360px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 800px; padding: 30px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                NOTRE <span style="color: {{ $auroraOrange }};">BLOG</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 600px; font-size: 1.1rem; line-height: 1.7;">
                Découvrez nos articles, conseils et actualités. Restez informé des dernières tendances.
            </p>
        </div>
    </div>

    <div class="container-fluid" style="padding: 30px 0 50px;">
        <div class="row g-4">
            {{-- Sidebar --}}
            <div class="col-lg-3 col-md-12">
                <div style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; padding: 22px; box-shadow: 0 2px 12px rgba(0,0,0,0.04);">
                    <h3 style="font-size: 16px; font-weight: 700; color: #1a1a2e; margin: 0 0 16px 0; letter-spacing: 0.3px; padding-bottom: 12px; border-bottom: 2px solid #f5f5f5;">
                        {{ labels('front_messages.categories', 'Categories') }}
                    </h3>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 2px;">
                            <a href="javascript:void(0)" wire:click.prevent="$set('category_id', '')"
                                class="site-nav {{ $category_id == '' ? 'active' : '' }}"
                                style="display: block; padding: 8px 10px; border-radius: 6px; font-size: 13px; color: {{ $category_id == '' ? '#fff' : '#555' }}; background: {{ $category_id == '' ? $auroraOrange : 'transparent' }}; text-decoration: none; transition: all 0.2s; font-weight: {{ $category_id == '' ? '600' : '400' }};"
                                onmouseover="this.style.background='{{ $category_id == '' ? $auroraDark : '#fff5ed' }}';this.style.color='{{ $category_id == '' ? '#fff' : $auroraOrange }}'"
                                onmouseout="this.style.background='{{ $category_id == '' ? $auroraOrange : 'transparent' }}';this.style.color='{{ $category_id == '' ? '#fff' : '#555' }}'">
                                {{ labels('front_messages.all_categories', 'All Categories') }}
                            </a>
                        </li>
                        @foreach ($categories as $category)
                            <li style="margin-bottom: 2px;" wire:key="category-{{ $category->id }}">
                                <a href="javascript:void(0)"
                                    wire:click.prevent="$set('category_id', {{ $category->id }})"
                                    class="site-nav {{ $category_id == $category->id ? 'active' : '' }}"
                                    style="display: block; padding: 8px 10px; border-radius: 6px; font-size: 13px; color: {{ $category_id == $category->id ? '#fff' : '#555' }}; background: {{ $category_id == $category->id ? $auroraOrange : 'transparent' }}; text-decoration: none; transition: all 0.2s; font-weight: {{ $category_id == $category->id ? '600' : '400' }};"
                                    onmouseover="this.style.background='{{ $category_id == $category->id ? $auroraDark : '#fff5ed' }}';this.style.color='{{ $category_id == $category->id ? '#fff' : $auroraOrange }}'"
                                    onmouseout="this.style.background='{{ $category_id == $category->id ? $auroraOrange : 'transparent' }}';this.style.color='{{ $category_id == $category->id ? '#fff' : '#555' }}'">
                                    {{ app(TranslationService::class)->getDynamicTranslation(BlogCategory::class, 'name', $category->id, $language_code) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-lg-9 col-md-12">
                {{-- Toolbar --}}
                <div style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0; padding: 14px 20px; box-shadow: 0 1px 6px rgba(0,0,0,0.03); margin-bottom: 24px;">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 text-left d-flex justify-content-center justify-content-sm-start mb-2 mb-sm-0">
                            <div class="search-form" style="max-width: 280px; width: 100%; position: relative;">
                                <input wire:model.live.debounce.250ms="search" class="search-input" type="text"
                                    placeholder="Rechercher un article..."
                                    value="{{ $search }}"
                                    style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 8px 35px 8px 12px; font-size: 13px; color: #555; width: 100%; background: #fafafa;">
                                <button wire:ignore class="search-btn" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #999; cursor: pointer; padding: 0; display: flex; align-items: center;">
                                    <ion-icon name="search-outline" class="icon fs-5"></ion-icon>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 text-right d-flex justify-content-center justify-content-sm-end">
                            <div class="d-flex align-items-center gap-2">
                                <label for="ShowBy" style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; margin: 0;">Afficher :</label>
                                <select name="ShowBy" id="perPage" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555; background: #fafafa; cursor: pointer;">
                                    <option value="9" {{ $perPage == '9' ? 'selected' : '' }}>9</option>
                                    <option value="18" {{ $perPage == '18' ? 'selected' : '' }}>18</option>
                                    <option value="27" {{ $perPage == '27' ? 'selected' : '' }}>27</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($blogs_count >= 1)
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                        @foreach ($blogs['listing'] as $blog)
                            @php
                                $blogItem = is_array($blog) ? (object) $blog : $blog;
                                $blogId = is_array($blog) ? $blog['id'] ?? null : $blog->id ?? null;
                                $blogSlug = is_array($blog) ? $blog['slug'] ?? '' : $blog->slug ?? '';
                                $blogImage = is_array($blog)
                                    ? (isset($blog['image']) && is_string($blog['image'])
                                        ? $blog['image']
                                        : '')
                                    : (isset($blog->image) && is_string($blog->image)
                                        ? $blog->image
                                        : '');
                                $blogCreatedAt = is_array($blog)
                                    ? $blog['created_at'] ?? ''
                                    : $blog->created_at ?? '';
                                $blogShortDesc = is_array($blog)
                                    ? $blog['short_description'] ?? ''
                                    : $blog->short_description ?? '';
                                $blogDescription = is_array($blog)
                                    ? $blog['description'] ?? ''
                                    : $blog->description ?? '';
                                $image =
                                    !empty($blogImage) && is_string($blogImage)
                                        ? app(MediaService::class)->dynamic_image($blogImage, 600)
                                        : '';
                            @endphp
                            <div class="col">
                                <div style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; overflow: hidden; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s ease; display: flex; flex-direction: column;"
                                    onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'"
                                    onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                                    <div style="width: 100%; height: 200px; overflow: hidden;">
                                        @if (!empty($image))
                                            <a wire:navigate href="{{ customUrl('blogs/' . $blogSlug) }}">
                                                <img style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s;"
                                                    src="{{ $image }}"
                                                    alt="{{ app(TranslationService::class)->getDynamicTranslation(Blog::class, 'title', $blogId, $language_code) }}"
                                                    loading="lazy"
                                                    onmouseover="this.style.transform='scale(1.06)'"
                                                    onmouseout="this.style.transform='scale(1)'">
                                            </a>
                                        @else
                                            <div style="width:100%;height:100%;background:#f5f5f5;display:flex;align-items:center;justify-content:center;color:#ccc;">Image</div>
                                        @endif
                                    </div>
                                    <div style="padding: 18px; display: flex; flex-direction: column; flex: 1;">
                                        <div style="font-size: 11px; color: #999; margin-bottom: 6px;">
                                            <ion-icon name="time-outline" style="vertical-align: middle; margin-right: 4px;"></ion-icon>
                                            <time datetime="{{ $blogCreatedAt }}">{{ $blogCreatedAt }}</time>
                                        </div>
                                        <h2 style="font-size: 16px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; line-height: 1.3;">
                                            <a wire:navigate href="{{ customUrl('blogs/' . $blogSlug) }}" style="color: #1a1a2e; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='{{ $auroraOrange }}'" onmouseout="this.style.color='#1a1a2e'">
                                                {{ app(TranslationService::class)->getDynamicTranslation(Blog::class, 'title', $blogId, $language_code) }}
                                            </a>
                                        </h2>
                                        <p style="font-size: 13px; color: #888; line-height: 1.6; flex: 1; margin: 0 0 14px 0;">
                                            @if (!empty($blogShortDesc))
                                                {{ \Illuminate\Support\Str::limit($blogShortDesc, 100) }}
                                            @else
                                                {{ \Illuminate\Support\Str::limit(strip_tags($blogDescription), 100) }}
                                            @endif
                                        </p>
                                        <a wire:navigate href="{{ customUrl('blogs/' . $blogSlug) }}"
                                            style="display: inline-block; background: {{ $auroraOrange }}; color: #fff; padding: 8px 20px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; text-align: center; transition: all 0.3s; align-self: flex-start;"
                                            onmouseover="this.style.background='{{ $auroraDark }}';this.style.boxShadow='0 3px 10px rgba(230,81,0,0.25)'"
                                            onmouseout="this.style.background='{{ $auroraOrange }}';this.style.boxShadow='none'">
                                            {{ labels('front_messages.read_more', 'Read more') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <nav class="mt-5">
                        {!! $blogs['links'] !!}
                    </nav>
                @else
                    @php $title = labels('front_messages.no_blog_found', 'No Blog Found'); @endphp
                    <x-utility.others.not-found :$title />
                @endif
            </div>
        </div>
    </div>
    <style>
    .pagination .page-item .page-link { border-radius: 6px !important; margin: 0 3px; font-size: 13px; font-weight: 600; color: #555; border: 1px solid #eee; background: #fff; padding: 8px 14px; transition: all 0.2s; }
    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover { background: {{ $auroraOrange }} !important; color: #fff !important; border-color: {{ $auroraOrange }} !important; }
    </style>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const perPageSelect = document.getElementById('perPage');
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('perPage', this.value);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        });
    }
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
});
</script>
