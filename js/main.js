// ===== Mobile nav toggle =====
document.addEventListener('DOMContentLoaded', function () {
  var hamburger = document.querySelector('.hamburger');
  var nav = document.querySelector('.main-nav');
  if (hamburger && nav) {
    hamburger.addEventListener('click', function () {
  nav.classList.toggle('open');
  document.body.classList.toggle('nav-open');
  var expanded = nav.classList.contains('open');
  hamburger.setAttribute('aria-expanded', expanded);
});
nav.querySelectorAll('a').forEach(function (a) {
  a.addEventListener('click', function () {
    nav.classList.remove('open');
    document.body.classList.remove('nav-open');
  });
});
  }

  // ===== Service search filter (home page) =====
  var searchInput = document.getElementById('serviceSearch');
  var clearBtn = document.getElementById('clearSearch');
  var cards = document.querySelectorAll('.service-card');
  var noResults = document.getElementById('noResults');
  var meta = document.getElementById('searchMeta');

  function filterCards () {
    var q = (searchInput.value || '').trim().toLowerCase();
    var visible = 0;
    cards.forEach(function (card) {
      var haystack = card.getAttribute('data-keywords') + ' ' + card.textContent;
      var match = haystack.toLowerCase().indexOf(q) !== -1;
      card.style.display = match ? '' : 'none';
      if (match) visible++;
    });
    if (noResults) noResults.style.display = visible === 0 ? 'block' : 'none';
    if (meta) {
      meta.textContent = q ? (visible + ' service' + (visible === 1 ? '' : 's') + ' matching "' + q + '"') : '';
    }
  }

  if (searchInput) {
    searchInput.addEventListener('input', filterCards);
  }
  if (clearBtn) {
    clearBtn.addEventListener('click', function () {
      searchInput.value = '';
      filterCards();
      searchInput.focus();
    });
  }

  // ===== FAQ accordion =====
  document.querySelectorAll('.faq-item').forEach(function (item) {
    var q = item.querySelector('.faq-q');
    var a = item.querySelector('.faq-a');
    if (!q || !a) return;
    q.addEventListener('click', function () {
      var isOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
        openItem.classList.remove('open');
        openItem.querySelector('.faq-a').style.maxHeight = null;
      });
      if (!isOpen) {
        item.classList.add('open');
        a.style.maxHeight = a.scrollHeight + 'px';
      }
    });
  });

  // ===== Guide page TOC scroll-spy =====
  var tocLinks = document.querySelectorAll('.toc a');
  var guideSections = document.querySelectorAll('.guide-content > section[id]');
  if (tocLinks.length && guideSections.length && 'IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          tocLinks.forEach(function (l) { l.classList.remove('active'); });
          var active = document.querySelector('.toc a[href="#' + entry.target.id + '"]');
          if (active) active.classList.add('active');
        }
      });
    }, { rootMargin: '-40% 0px -50% 0px' });
    guideSections.forEach(function (s) { observer.observe(s); });
  }

  // ===== Contact form (client-side demo submission) =====
  var form = document.getElementById('enquiryForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var checked = form.querySelectorAll('input[name="service"]:checked');
      var checkGrid = form.querySelector('.check-grid');
      if (checked.length === 0) {
        checkGrid.style.outline = '1.5px solid #C9992F';
        checkGrid.style.borderRadius = '4px';
        checkGrid.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
      } else {
        checkGrid.style.outline = 'none';
      }
      form.style.display = 'none';
      var success = document.getElementById('successPanel');
      if (success) success.style.display = 'block';
    });
  }
});
