<div class="container">
<article @php(post_class())>
@include('partials.entry-taxonomy-meta')
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
