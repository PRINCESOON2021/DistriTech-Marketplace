const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.main-nav');
if (toggle && nav) {
  toggle.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    toggle.setAttribute('aria-expanded', String(open));
  });
}

document.documentElement.classList.add('js');
const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      revealObserver.unobserve(entry.target);
    }
  });
}, { threshold: 0.01, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));

document.querySelectorAll('.product-card').forEach((card) => {
  card.addEventListener('pointermove', (event) => {
    const box = card.getBoundingClientRect();
    card.style.setProperty('--mx', `${event.clientX - box.left}px`);
    card.style.setProperty('--my', `${event.clientY - box.top}px`);
  });
});

const catalogPage = document.querySelector('.catalog-page');
const viewToggles = document.querySelectorAll('.view-toggle');
if (catalogPage && viewToggles.length) {
  const setCatalogView = (view) => {
    const listView = view === 'list';
    catalogPage.classList.toggle('view-list', listView);
    viewToggles.forEach((button) => {
      const active = button.dataset.view === view;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });
    try { localStorage.setItem('distritech-catalog-view', view); } catch (error) {}
  };

  let savedView = 'grid';
  try { savedView = localStorage.getItem('distritech-catalog-view') || 'grid'; } catch (error) {}
  setCatalogView(savedView === 'list' ? 'list' : 'grid');
  viewToggles.forEach((button) => button.addEventListener('click', () => setCatalogView(button.dataset.view)));
}
