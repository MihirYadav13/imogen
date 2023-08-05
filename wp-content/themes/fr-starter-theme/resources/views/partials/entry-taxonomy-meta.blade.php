<div class ="taxo_list">
    @php($taxonomies = get_post_taxonomies())
    @forelse ($taxonomies as $i => $taxonomy)
      @if($taxonomy =='category')
        @continue;
      @endif
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