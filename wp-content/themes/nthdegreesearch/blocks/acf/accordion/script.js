class ACCORDION {

  constructor(container) {
    this.container = container;
    if (!this.container) return

    this.SELECTORS = {
      item: '.nds_accordion-item',
      btn: '.nds_accordion-item--btn',
      panel: '.nds_accordion-item--content',
    };


    this.init();
  }


  init() {
    this.container.addEventListener('click', (e) => {
      const btn = e.target.closest(this.SELECTORS.btn);
      if (!btn || !this.container.contains(btn)) return;


      const item = btn.closest(this.SELECTORS.item);
      const panel = item.querySelector(this.SELECTORS.panel);

      this.toggle(btn, panel);


    })
  }

  toggle(btn, panel) {
    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
    if (isExpanded) {
      this.close(btn, panel);
    } else {
      this.open(btn, panel);
    }
  }


  open(btn, panel) {

    this.closeAllExcept(panel)
    // Prepare for animation
    panel.style.maxHeight = '0px';
    // Set expanded state
    btn.setAttribute('aria-expanded', 'true');
    // Measure & animate
    const target = panel.scrollHeight;
    requestAnimationFrame(() => {
      panel.style.maxHeight = `${target}px`;
    });

    // Cleanup inline style after transition (so dynamic content can grow)
    panel.addEventListener('transitionend', function onEnd(e) {
      if (e.propertyName !== 'max-height') return;
      panel.style.maxHeight = 'none';
      panel.removeEventListener('transitionend', onEnd);
    });
  }

  close(btn, panel) {
    // If it's 'none', set it to the current height first to animate down
    if (panel.style.maxHeight === '' || panel.style.maxHeight === 'none') {
      panel.style.maxHeight = `${panel.scrollHeight}px`;
    }

    // Force reflow so the browser registers the current value
    // eslint-disable-next-line no-unused-expressions
    panel.offsetHeight;

    btn.setAttribute('aria-expanded', 'false');

    requestAnimationFrame(() => {
      panel.style.maxHeight = '0px';
    });

    panel.addEventListener('transitionend', function onEnd(e) {
      if (e.propertyName !== 'max-height') return;
      panel.removeEventListener('transitionend', onEnd);
    });
  }

  closeAllExcept(skipPanel) {
    this.container.querySelectorAll(this.SELECTORS.item).forEach((item) => {
      const btn = item.querySelector(this.SELECTORS.btn);
      const panel = item.querySelector(this.SELECTORS.panel);
      if (panel !== skipPanel && btn.getAttribute('aria-expanded') === 'true') {
        this.close(btn, panel);
      }
    });
  }

}

document.addEventListener('DOMContentLoaded', function () {

  const accordionContainer = document.querySelectorAll('.nds_js-accordion.nds_accordion-container--list');

  accordionContainer.forEach(container => {
    new ACCORDION(container)
  })


})