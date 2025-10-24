class TableOfContents {

  constructor(container) {
    this.container = container;

    if (!this.container) return;

    this.list = this.container.querySelector('.nds_tob_aside--list');
    this.body = this.container.querySelector('.nds_tob_main');

    this.init()


  }

  init() {
    if (!this.list || !this.body) return;
    this.list.innerHTML = '';

    // Find elements with ids starting with "section-"
    const nodes = this.body.querySelectorAll('[id^="section-"]');

    nodes.forEach(el => {
      const id = el.id.trim();
      if (!id) return;

      const li = document.createElement('li');
      const a = document.createElement('a');

      a.href = `#${id}`;
      // Use innerHTML if you truly want to keep inline tags; otherwise prefer textContent.
      a.innerHTML = el.innerHTML;

      li.appendChild(a);
      this.list.appendChild(li);
    });

  }

}

document.addEventListener('DOMContentLoaded', () => {
  const containers = document.querySelectorAll('.nds_tob_container')
  containers.forEach(container => new TableOfContents(container));
})