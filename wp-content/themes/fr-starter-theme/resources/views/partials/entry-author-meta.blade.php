<div class="byline author vcard" >
  
  <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">    
    {!! get_avatar(get_the_author_meta('ID'), 80) !!}
    </a>
    <div class="auth-detail">
    <h5>
      {{ get_the_author_meta('first_name')}} &nbsp;{{ get_the_author_meta('last_name')}}</h5>
      <p>
      {!! get_the_author_meta('description') !!}
      </p>
  </div>
 
  </div>