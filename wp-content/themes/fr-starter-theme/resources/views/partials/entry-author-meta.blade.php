@php
$user = get_field('select_author', get_the_ID());
@endphp
@if($user)
  <div class="hr"></div>
  <div class="byline author vcard" >    
    <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">    
      {!! get_avatar(get_the_author_meta('ID', $user), 80) !!}
      </a>
      <div class="auth-detail">
      <h5>
        {{ get_the_author_meta('first_name', $user)}} &nbsp;{{ get_the_author_meta('last_name', $user)}}</h5>
        <p>
        {!! get_the_author_meta('description', $user) !!}
        </p>
    </div> 
  </div>
@endif