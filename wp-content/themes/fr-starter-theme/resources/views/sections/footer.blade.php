<footer class="content-info">
    <div class="container">
        <div class="footer-header">
            <div class="footer-logo">
                @if(isset($logo) && isset($logo['url']))
                    <img src="{{ $logo['url'] }}" alt="{{ $logo['alt'] }}" loading="lazy">
                @endif
            </div>
            <div class="tagline">
                {!! $tagline !!}
            </div>
        </div>
        <div class="footer-content">
            <div class="footer-left footer-column">
              @if (has_nav_menu('footer_navigation'))
                {!! wp_nav_menu($footerNavigation) !!}
              @endif
            </div>
            <div class="footer-right footer-column">
                <h4>PUBLISH</h4>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copy-right-text wysiwyg-content">
              <p class="copy-r sm">&copy; {{ $copyright_text }}</p>
            </div>
            <div class="footer-page-links">
              
            </div>
        </div>
    </div>
</footer>
<div id="app-sizer"></div>