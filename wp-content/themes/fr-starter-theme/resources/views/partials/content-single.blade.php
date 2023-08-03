<div class="container">
<article @php(post_class())>
  <div class ="taxo_list">
  @php($taxonomies = get_post_taxonomies())
  @forelse ($taxonomies as $i => $taxonomy)
  @php($cat_array = ( get_the_terms( get_the_ID(), $taxonomy) ))
  @forelse ($cat_array as $j => $cat)  
  <span class="program">{{ $cat->name }}</span>
  @if ($i < (count($taxonomies)-1))
  &nbsp;/&nbsp;
  @endif
  @empty
  @endforelse
  @empty
  @endforelse
  </div>
  <header>
    <h3 class="entry-title">
      {!! $title !!}
    </h3>   
  </header>
  <div class="post-meta-data">
    @include('partials.entry-meta')
    <x-share-button />
  </div>
  <div class="entry-content">
    @if(has_post_thumbnail())
    {{ the_post_thumbnail('full') }}
    @endif
  
    @php(the_content())
    <div class="hr"></div>
  </div>
  
  @include('partials.entry-author-meta')
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>

</article>
</div>
