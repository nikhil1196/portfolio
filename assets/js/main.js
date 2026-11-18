/* ============================================================
   Nikhil Agrawal — Portfolio interactions
   ============================================================ */
(function () {
    'use strict';

    /* ---------- Page loader ---------- */
    window.addEventListener('load', function () {
        var loader = document.getElementById('pageLoader');
        if (loader) setTimeout(function () { loader.classList.add('hidden'); }, 350);
    });

    /* ---------- Sticky header ---------- */
    var header = document.getElementById('siteHeader');
    function onScrollHeader() {
        header.classList.toggle('scrolled', window.scrollY > 24);
    }
    onScrollHeader();
    window.addEventListener('scroll', onScrollHeader, { passive: true });

    /* ---------- Theme toggle ---------- */
    var themeBtn = document.getElementById('themeToggle');
    if (themeBtn) {
        themeBtn.addEventListener('click', function () {
            var next = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
            document.documentElement.dataset.theme = next;
            try { localStorage.setItem('site-theme', next); } catch (e) {}
        });
    }

    /* ---------- Language switcher ---------- */
    var langSel = document.getElementById('langSelect');
    if (langSel) {
        langSel.addEventListener('change', function () {
            var url = new URL(window.location.href);
            url.searchParams.set('lang', this.value);
            window.location.href = url.toString();
        });
    }

    /* ---------- Mobile nav ---------- */
    var navToggle = document.getElementById('navToggle');
    var mainNav = document.getElementById('mainNav');
    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function () {
            var open = mainNav.classList.toggle('open');
            navToggle.classList.toggle('open', open);
            navToggle.setAttribute('aria-expanded', open);
        });
        mainNav.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mainNav.classList.remove('open');
                navToggle.classList.remove('open');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ---------- Typing effect ---------- */
    var typedEl = document.querySelector('.hero-role .typed');
    if (typedEl && window.HERO_ROLES && window.HERO_ROLES.length) {
        var roles = window.HERO_ROLES, ri = 0, ci = 0, deleting = false;
        (function tick() {
            var word = roles[ri];
            ci += deleting ? -1 : 1;
            typedEl.textContent = word.substring(0, ci);
            var delay = deleting ? 45 : 85;
            if (!deleting && ci === word.length) { delay = 1800; deleting = true; }
            else if (deleting && ci === 0) { deleting = false; ri = (ri + 1) % roles.length; delay = 400; }
            setTimeout(tick, delay);
        })();
    }

    /* ---------- Scroll reveal ---------- */
    var revealEls = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && revealEls.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        revealEls.forEach(function (el) { io.observe(el); });
    } else {
        revealEls.forEach(function (el) { el.classList.add('visible'); });
    }

    /* ---------- Animated counters ---------- */
    var counters = document.querySelectorAll('[data-count]');
    if ('IntersectionObserver' in window && counters.length) {
        var cio = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target, target = parseInt(el.dataset.count, 10),
                    suffix = el.dataset.suffix || '', start = null, dur = 1600;
                function step(ts) {
                    if (!start) start = ts;
                    var p = Math.min((ts - start) / dur, 1);
                    // ease-out cubic
                    el.textContent = Math.floor(target * (1 - Math.pow(1 - p, 3))) + suffix;
                    if (p < 1) requestAnimationFrame(step);
                }
                requestAnimationFrame(step);
                cio.unobserve(el);
            });
        }, { threshold: 0.5 });
        counters.forEach(function (el) { cio.observe(el); });
    }

    /* ---------- Skill bars ---------- */
    var bars = document.querySelectorAll('.skill-bar-fill');
    if ('IntersectionObserver' in window && bars.length) {
        var bio = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.style.width = entry.target.dataset.level + '%';
                    bio.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        bars.forEach(function (b) { bio.observe(b); });
    }

    /* ---------- Portfolio filter ---------- */
    var filterBtns = document.querySelectorAll('.filter-btn');
    if (filterBtns.length) {
        filterBtns.forEach(function (btn) {
            btn.addEventListener('click', function () {
                filterBtns.forEach(function (b) { b.classList.remove('active'); });
                btn.classList.add('active');
                var filter = btn.dataset.filter;
                document.querySelectorAll('.project-item').forEach(function (item) {
                    var show = filter === 'all' || item.dataset.category === filter;
                    item.classList.toggle('project-hidden', !show);
                });
            });
        });
    }

    /* ---------- FAQ accordion ---------- */
    document.querySelectorAll('.faq-q').forEach(function (q) {
        q.addEventListener('click', function () {
            var item = q.closest('.faq-item');
            var answer = item.querySelector('.faq-a');
            var isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(function (o) {
                o.classList.remove('open');
                o.querySelector('.faq-a').style.maxHeight = null;
            });
            if (!isOpen) {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        });
    });

    /* ---------- Contact form ---------- */
    var form = document.getElementById('contactForm');
    if (form) {
        form.addEventListener('submit', function (ev) {
            ev.preventDefault();
            var valid = true;
            form.querySelectorAll('[required]').forEach(function (field) {
                var group = field.closest('.form-group');
                var bad = !field.value.trim() ||
                    (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value));
                group.classList.toggle('has-error', bad);
                field.classList.toggle('error', bad);
                if (bad) valid = false;
            });
            if (!valid) return;

            var card = form.closest('.form-card');
            var success = card.querySelector('.form-success');
            var errAlert = card.querySelector('.form-error-alert');
            var btn = document.getElementById('cfSubmit');
            success.classList.remove('show');
            errAlert.classList.remove('show');
            var origLabel = btn.innerHTML;
            btn.disabled = true;
            btn.textContent = form.dataset.sending || 'Sending...';

            fetch(form.action, { method: 'POST', body: new FormData(form) })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.ok) {
                        success.textContent = data.message;
                        success.classList.add('show');
                        form.reset();
                        success.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        errAlert.textContent = data.message;
                        errAlert.classList.add('show');
                        errAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                })
                .catch(function () {
                    errAlert.textContent = form.dataset.netError || 'Network error.';
                    errAlert.classList.add('show');
                })
                .finally(function () {
                    btn.disabled = false;
                    btn.innerHTML = origLabel;
                });
        });
    }

    /* ---------- Content protection (deterrent) ----------
       Blocks right-click, copy, text selection, drag, and
       devtools/source shortcuts. Form fields stay usable. */
    var exemptSel = 'input, textarea, select, [contenteditable="true"]';
    function isExempt(e) { return e.target.closest && e.target.closest(exemptSel); }

    document.addEventListener('contextmenu', function (e) { if (!isExempt(e)) e.preventDefault(); });
    document.addEventListener('copy', function (e) { if (!isExempt(e)) e.preventDefault(); });
    document.addEventListener('cut', function (e) { if (!isExempt(e)) e.preventDefault(); });
    document.addEventListener('selectstart', function (e) { if (!isExempt(e)) e.preventDefault(); });
    document.addEventListener('dragstart', function (e) { e.preventDefault(); });

    document.addEventListener('keydown', function (e) {
        var k = (e.key || '').toLowerCase();
        if (e.key === 'F12') { e.preventDefault(); return; }
        if (!(e.ctrlKey || e.metaKey)) return;
        if (e.shiftKey && (k === 'i' || k === 'j' || k === 'c')) { e.preventDefault(); return; }
        if (k === 'u' || k === 's' || k === 'p') { e.preventDefault(); return; }
        if ((k === 'c' || k === 'x') && !isExempt(e)) e.preventDefault();
    });

    console.log('%cSTOP!', 'color:#ff6b81;font-size:42px;font-weight:bold;');
    console.log('%cThis area is for developers. Content on this site is protected — please respect the owner\'s work.', 'font-size:14px;color:#9aa4bd;');

    /* ---------- Back to top ---------- */
    var toTop = document.getElementById('backToTop');
    if (toTop) {
        window.addEventListener('scroll', function () {
            toTop.classList.toggle('show', window.scrollY > 600);
        }, { passive: true });
        toTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
})();
