(function ($) {

  window.ndsIsInViewport = function (el) {
    const rect = el.getBoundingClientRect();
    return (
      rect.top < window.innerHeight &&
      rect.bottom > 0 &&
      rect.left < window.innerWidth &&
      rect.right > 0
    );
  };

  function ndsSiteMenu() {

    $('.primary-menu-toggle').click(function (e) {
      e.preventDefault();
      $('body').toggleClass('nds-mobile-menu-open overflow-hidden');
    });

    $('.nds-mobile-menu--backdrop').click(function (e) {
      e.preventDefault();
      $('body').removeClass('nds-mobile-menu-open overflow-hidden');
    });


    $('.nds-mobile-primary-menu > ul > li.menu-item-has-children > a[href="#"], .nds-mobile-primary-menu > ul > li.menu-item-has-children > a > .arrow').click(function (e) {
      e.preventDefault();
      e.stopPropagation();

      let parentItem = $(this).closest('.menu-item-has-children');

      if (parentItem.hasClass('active')) {
        parentItem.removeClass('active');
        parentItem.children('.sub-menu').slideUp(300);
      } else {
        $('.nds-mobile-menu-wrapper .menu-item-has-children').removeClass('active');
        $('.nds-mobile-menu-wrapper .sub-menu').slideUp(300);
      }

      parentItem.addClass('active');
      parentItem.children('.sub-menu').slideDown(300);
    });

  }

  window.ndsBlockSection = function (scope = document) {
    if (!scope.querySelector('.nds-lazyvideo')) return;

    let hasInteracted = false;

    function loadAndPlayVideos() {
      $(scope).find('.nds-lazyvideo').each(function () {
        let $el = $(this);

        // YouTube iframe
        if ($el.is('iframe') && $el.data('src')) {
          let iframe = this;

          if (!iframe.src) {
            iframe.src = $el.data('src');
          }

          if (window.YT && YT.Player) {
            new YT.Player(iframe, {
              events: {
                onReady: function (event) {
                  event.target.mute();
                  event.target.playVideo();
                }
              }
            });
          }
        }

        // Local video
        if ($el.is('video') && $el.data('src')) {
          let video = this;

          if (!$el.data('loaded')) {
            let source = document.createElement('source');
            source.src = $el.data('src');
            source.type = $el.data('type') || 'video/mp4';
            video.appendChild(source);
            $el.data('loaded', true);
            video.load();
          }

          video.play().catch(err => console.log('Video play error:', err));
        }
      });
    }

    function loadYouTubeAPI() {
      if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
        let tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        let firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
      }
    }

    function triggerOnce() {
      if (!hasInteracted) {
        hasInteracted = true;
        loadAndPlayVideos();
      }
    }

    // Load YT API in case YouTube videos exist
    if ($(scope).find('iframe.nds-lazyvideo[data-src]').length > 0) {
      loadYouTubeAPI();
    }

    // Trigger on user interaction
    $(window).one('click scroll mousemove touchstart', triggerOnce);

    // Fallback autoplay after 8 seconds
    setTimeout(triggerOnce, 8000);
  }

  window.ndsYoutubeEmbed = function (scope = document) {
    // Exit early in WordPress admin/editor
    if (document.body.classList.contains('wp-admin') || document.body.classList.contains('block-editor-page')) {
      return;
    }

    let youtubeEmbedBlock = $(scope).find('.nds-youtube-embed');
    let $wrapper = youtubeEmbedBlock.find('.yt-wrapper');
    let $container = youtubeEmbedBlock.find('.yt-container');
    let videoId = $container.data('youtube-id');
    let loaded = false;
    let played = false;

    function loadYouTubeIframe(autoplay = false) {
      if (!videoId) return;

      let iframe = `<iframe
                        src="https://www.youtube.com/embed/${videoId}?autoplay=${autoplay ? 1 : 0}&enablejsapi=1&rel=0&playsinline=1&modestbranding=1&showinfo=0"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="w-full h-full"
                  ></iframe>`;

      $container.html(iframe);
      loaded = true;
    }

    function preloadIframe() {
      if (!loaded) loadYouTubeIframe(false);
    }

    $wrapper.on('click', function () {
      if (played) return;
      loadYouTubeIframe(true);
      played = true;
      youtubeEmbedBlock.addClass('video-active');
    });

    let userEvents = ['scroll', 'mousemove', 'touchstart'];
    userEvents.forEach(event =>
      window.addEventListener(event, preloadIframe, {once: true})
    );

    setTimeout(preloadIframe, 10000);
  };


  $(document).ready(function () {
    ndsSiteMenu();
    ndsBlockSection();
    ndsYoutubeEmbed();
  });

})(window.jQuery || window.$);


// Backend editor support
if (typeof wp !== 'undefined' && wp.domReady) {
  const observer = new MutationObserver(() => {
    ndsBlockSection();
    ndsYoutubeEmbed();
  });
  observer.observe(document.body, {childList: true, subtree: true});
}


// JS FOR FORM 7
class Form7Toggle {
  constructor(form) {
    this.form = form;
    this.SELECTEDITEM = 'contact-reason'; // CF7 field name
    if (!form) return;
    this.init();
  }

  init() {
    const wrapper = this.form.querySelector(`[data-name="${this.SELECTEDITEM}"]`);
    if (!wrapper) return;

    const select = wrapper.querySelector('select');
    if (!select) return;

    // Your container (currently id="contact-reason")
    const container = this.form.querySelector(`#${this.SELECTEDITEM}`);
    if (!container) return;

    // The textarea inside it
    const otherField = container.querySelector('[name="other-text-field"], textarea');
    if (!otherField) return;

    // Bind + set initial state
    const toggle = () => this.toggleOther(container, otherField, select.value === 'Others');
    select.addEventListener('change', toggle);
    toggle();
  }

  toggleOther(container, input, isOther) {
    // Show/hide
    container.style.display = isOther ? '' : 'none';

    // Form behaviour
    input.disabled = !isOther;    // disabled fields are not submitted
    input.required = isOther;     // only required when visible
    if (!isOther) input.value = ''; // clear if user changed their mind
  }
}


document.addEventListener('DOMContentLoaded', () => {
  const wpcf7Forms = document.querySelectorAll('.wpcf7-form')
  wpcf7Forms.forEach(wpcf7Form =>
    new Form7Toggle(wpcf7Form)
  )
});