class SplideCarousel {
  constructor(element, userOptions = {}) {
    this.element = element
    this.userOptions = userOptions
    if (!this.element) return

    this.defaultOptions = {
      perPage: 4,
      gap: 24,
      arrows: false,
      pagination: false,
      breakpoints: {
        768: {perPage: 2},
        480: {perPage: 1}
      }
    };

    this.options = {
      ...this.defaultOptions,
      ...this.userOptions,
      breakpoints: {
        ...this.defaultOptions.breakpoints,
        ...this.userOptions.breakpoints
      }
    }

    this.splideInstance = null;
    this.init()
  }

  init() {
    this.mountSplide()
  }

  mountSplide() {
    this.splideInstance = new Splide(this.element, this.options)
    this.splideInstance.mount()
  }

  // Add these methods for autoplay control
  play() {
    if (this.splideInstance && this.splideInstance.Components.Autoplay) {
      this.splideInstance.Components.Autoplay.play()
    }
  }

  pause() {
    if (this.splideInstance && this.splideInstance.Components.Autoplay) {
      this.splideInstance.Components.Autoplay.pause()
    }
  }

  toggleAutoplay() {
    if (this.splideInstance && this.splideInstance.Components.Autoplay) {
      const autoplay = this.splideInstance.Components.Autoplay
      if (autoplay.isPaused()) {
        autoplay.play()
      } else {
        autoplay.pause()
      }
    }
  }

  destroy() {
    if (this.splideInstance) {
      this.splideInstance.destroy()
      this.splideInstance = null
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {

  const carousels = document.querySelectorAll('.nds_testimonial_carousel')
  carousels.forEach((carousel) => {
    new SplideCarousel(carousel, {
      perPage: 3,
      type: 'loop',
      pagination: false,
      arrows: true,
      breakpoints: {
        1024: {perPage: 2},
        768: {perPage: 1},
      }
    })
  })
})