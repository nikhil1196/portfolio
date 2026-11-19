/* Shared admin JS for portfolio demo projects */
(function () {
    'use strict';

    /* KDS auto-refresh: elements with data-refresh="seconds" reload the page */
    var el = document.querySelector('[data-refresh]');
    if (el) {
        var secs = parseInt(el.dataset.refresh, 10) || 15;
        setTimeout(function () { window.location.reload(); }, secs * 1000);
    }

    /* Inline status select auto-submit (data-autosubmit on <form> or <select>) */
    document.querySelectorAll('select[data-autosubmit]').forEach(function (sel) {
        sel.addEventListener('change', function () {
            sel.closest('form').submit();
        });
    });

    /* POS: quantity buttons */
    document.querySelectorAll('[data-qty]').forEach(function (btn) {
        btn.addEventListener('click', function (ev) {
            ev.preventDefault();
            var input = document.querySelector(btn.dataset.qty);
            if (!input) return;
            var v = parseInt(input.value || '0', 10) + parseInt(btn.dataset.delta || '0', 10);
            input.value = Math.max(0, v);
        });
    });

    /* Badges: derive b-<slug> class from text content */
    document.querySelectorAll(".badge:not([class*=b-])").forEach(function (b) {
        var s = b.textContent.trim().toLowerCase().replace(/[^a-z]+/g, "-").replace(/^-|-$/g, "");
        if (s) b.classList.add("b-" + s);
    });
})();
