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
  const productCards = [...catalogPage.querySelectorAll('.product-card')];
  const sliderControls = catalogPage.querySelector('.product-slider-controls');
  const sliderCurrent = catalogPage.querySelector('.slider-current');
  const sliderPrev = catalogPage.querySelector('.slider-prev');
  const sliderNext = catalogPage.querySelector('.slider-next');
  let slideIndex = 0;

  const showSlide = (nextIndex) => {
    if (!productCards.length) return;
    slideIndex = (nextIndex + productCards.length) % productCards.length;
    productCards.forEach((card, index) => {
      const active = index === slideIndex;
      card.classList.toggle('slide-active', active);
      card.setAttribute('aria-hidden', String(!active));
    });
    if (sliderCurrent) sliderCurrent.textContent = String(slideIndex + 1);
  };

  const setCatalogView = (view) => {
    const listView = view === 'list';
    const slideView = view === 'slide';
    catalogPage.classList.toggle('view-list', listView);
    catalogPage.classList.toggle('view-slide', slideView);
    viewToggles.forEach((button) => {
      const active = button.dataset.view === view;
      button.classList.toggle('active', active);
      button.setAttribute('aria-pressed', String(active));
    });
    productCards.forEach((card) => card.removeAttribute('aria-hidden'));
    if (sliderControls) sliderControls.hidden = !slideView;
    if (slideView) showSlide(slideIndex);
    try { localStorage.setItem('distritech-catalog-view', view); } catch (error) {}
  };

  let savedView = 'grid';
  try { savedView = localStorage.getItem('distritech-catalog-view') || 'grid'; } catch (error) {}
  setCatalogView(['grid', 'list', 'slide'].includes(savedView) ? savedView : 'grid');
  viewToggles.forEach((button) => button.addEventListener('click', () => setCatalogView(button.dataset.view)));
  if (sliderPrev) sliderPrev.addEventListener('click', () => showSlide(slideIndex - 1));
  if (sliderNext) sliderNext.addEventListener('click', () => showSlide(slideIndex + 1));
  catalogPage.addEventListener('keydown', (event) => {
    if (!catalogPage.classList.contains('view-slide')) return;
    if (event.key === 'ArrowLeft') showSlide(slideIndex - 1);
    if (event.key === 'ArrowRight') showSlide(slideIndex + 1);
  });
}
