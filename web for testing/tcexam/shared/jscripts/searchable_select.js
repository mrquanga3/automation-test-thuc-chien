/*!
 * TCExam — Searchable / autocomplete <select> enhancer
 *
 * Replaces any <select class="searchable"> with a combobox UI:
 *   - text input shows the currently selected label
 *   - dropdown panel of options opens on focus/click
 *   - typing filters the panel in real time
 *   - selecting an option writes the value back into the original
 *     <select> and fires its `change` event, so the existing TCExam
 *     onchange auto-submit pattern keeps working.
 *
 * Usage:  <select class="searchable" name="...">...</select>
 */
(function () {
    'use strict';

    function ensureStyles() {
        if (document.getElementById('tce-searchable-style')) return;
        var css =
            '.tce-ss{position:relative;display:block;width:100%}' +
            '.tce-ss__input{display:block;width:100%;box-sizing:border-box;' +
            'padding:6px 28px 6px 10px;font-size:1em;line-height:1.4;' +
            'border:1px solid var(--input-border,#c8d1d8);border-radius:var(--block-round,4px);' +
            'background-color:#fff;color:#222;cursor:text;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}' +
            '.tce-ss__input:focus{outline:none;border-color:var(--primary,#1095c1);' +
            'box-shadow:0 0 0 2px var(--primary-focus,rgba(16,149,193,0.18))}' +
            '.tce-ss__caret{position:absolute;right:8px;top:50%;transform:translateY(-50%);' +
            'pointer-events:none;color:#666;font-size:0.7em}' +
            '.tce-ss__panel{position:absolute;left:0;top:100%;z-index:9999;' +
            'max-height:260px;overflow-y:auto;margin-top:2px;min-width:100%;' +
            'width:max-content;max-width:800px;' +
            'background:#fff;border:1px solid var(--input-border,#c8d1d8);' +
            'border-radius:var(--block-round,4px);' +
            'box-shadow:0 4px 12px rgba(0,0,0,0.12);display:none}' +
            '.tce-ss__panel--open{display:block}' +
            '.tce-ss__opt{padding:6px 10px;cursor:pointer;color:#222;' +
            'border-bottom:1px solid #f0f0f0;font-size:0.95em;line-height:1.3;' +
            'white-space:nowrap;overflow:hidden;text-overflow:ellipsis}' +
            '.tce-ss__opt:last-child{border-bottom:0}' +
            '.tce-ss__opt:hover,.tce-ss__opt--active{background:var(--primary,#1095c1);color:#fff}' +
            '.tce-ss__opt--selected{font-weight:bold}' +
            '.tce-ss__opt mark{background:#fff59d;color:#222;padding:0;border-radius:2px}' +
            '.tce-ss__opt:hover mark,.tce-ss__opt--active mark{background:#fff59d;color:#222}' +
            '.tce-ss__empty{padding:8px 10px;color:#888;font-style:italic;font-size:0.9em}' +
            '.tce-msf{display:block;width:100%}' +
            '.tce-msf__filter{display:block;width:100%;box-sizing:border-box;' +
            'margin:0 0 4px 0;padding:5px 10px;font-size:0.95em;line-height:1.4;' +
            'border:1px solid var(--input-border,#c8d1d8);border-radius:var(--block-round,4px);' +
            'background-color:#fff;color:#222}' +
            '.tce-msf__filter:focus{outline:none;border-color:var(--primary,#1095c1);' +
            'box-shadow:0 0 0 2px var(--primary-focus,rgba(16,149,193,0.18))}' +
            '.tce-msf__count{font-size:0.8em;color:var(--muted-text,#888);' +
            'margin:-2px 0 4px 2px;display:none}';
        var style = document.createElement('style');
        style.id = 'tce-searchable-style';
        style.appendChild(document.createTextNode(css));
        document.head.appendChild(style);
    }

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function highlight(text, term) {
        if (!term) return escapeHtml(text);
        var i = text.toLowerCase().indexOf(term.toLowerCase());
        if (i < 0) return escapeHtml(text);
        return escapeHtml(text.slice(0, i)) +
            '<mark>' + escapeHtml(text.slice(i, i + term.length)) + '</mark>' +
            escapeHtml(text.slice(i + term.length));
    }

    function enhance(select) {
        if (select.dataset.tceSearchable === '1') return;
        select.dataset.tceSearchable = '1';

        var options = [];
        for (var i = 0; i < select.options.length; i++) {
            options.push({
                value: select.options[i].value,
                text: select.options[i].textContent,
                style: select.options[i].getAttribute('style') || ''
            });
        }
        if (options.length < 2) return;

        // Hide native select but keep it in DOM for form submission
        select.style.display = 'none';
        select.setAttribute('aria-hidden', 'true');
        select.setAttribute('tabindex', '-1');

        var wrap = document.createElement('span');
        wrap.className = 'tce-ss';

        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'tce-ss__input';
        input.setAttribute('autocomplete', 'off');
        input.setAttribute('role', 'combobox');
        input.setAttribute('aria-expanded', 'false');
        input.setAttribute('aria-autocomplete', 'list');
        input.placeholder = select.dataset.searchPlaceholder || 'Type to search…';

        var caret = document.createElement('span');
        caret.className = 'tce-ss__caret';
        caret.textContent = '▼';

        var panel = document.createElement('div');
        panel.className = 'tce-ss__panel';
        panel.setAttribute('role', 'listbox');

        select.parentNode.insertBefore(wrap, select);
        wrap.appendChild(input);
        wrap.appendChild(caret);
        wrap.appendChild(panel);
        wrap.appendChild(select);

        var activeIdx = -1;
        var visibleItems = [];

        function selectedLabel() {
            for (var i = 0; i < options.length; i++) {
                if (options[i].value === select.value) return options[i].text;
            }
            return '';
        }

        function syncInputFromSelect() {
            var label = selectedLabel();
            input.value = label.length > 100 ? label.substring(0, 100) + '...' : label;
            input.title = label;
        }

        function renderPanel(term) {
            var lower = term.toLowerCase();
            visibleItems = options.filter(function (o) {
                return !lower || o.text.toLowerCase().indexOf(lower) !== -1;
            });
            panel.innerHTML = '';
            if (visibleItems.length === 0) {
                var empty = document.createElement('div');
                empty.className = 'tce-ss__empty';
                empty.textContent = 'No matches';
                panel.appendChild(empty);
                activeIdx = -1;
                return;
            }
            visibleItems.forEach(function (o, idx) {
                var item = document.createElement('div');
                item.className = 'tce-ss__opt';
                if (o.value === select.value) item.className += ' tce-ss__opt--selected';
                item.setAttribute('role', 'option');
                item.dataset.value = o.value;
                item.dataset.idx = idx;
                item.title = o.text;
                var displayText = o.text;
                if (displayText.length > 100) {
                    displayText = displayText.substring(0, 100) + '...';
                }
                item.innerHTML = highlight(displayText, term);
                if (o.style) {
                    // Carry over inline style (e.g. the green "+" marker)
                    item.setAttribute('style', o.style);
                }
                item.addEventListener('mousedown', function (e) {
                    e.preventDefault();
                    pick(o);
                });
                panel.appendChild(item);
            });
            activeIdx = -1;
            // Auto-highlight currently selected option
            for (var i = 0; i < visibleItems.length; i++) {
                if (visibleItems[i].value === select.value) {
                    setActive(i);
                    break;
                }
            }
        }

        function setActive(idx) {
            var prev = panel.querySelector('.tce-ss__opt--active');
            if (prev) prev.classList.remove('tce-ss__opt--active');
            activeIdx = idx;
            if (idx >= 0) {
                var nodes = panel.querySelectorAll('.tce-ss__opt');
                if (nodes[idx]) {
                    nodes[idx].classList.add('tce-ss__opt--active');
                    nodes[idx].scrollIntoView({ block: 'nearest' });
                }
            }
        }

        function openPanel() {
            panel.classList.add('tce-ss__panel--open');
            input.setAttribute('aria-expanded', 'true');
        }

        function closePanel() {
            panel.classList.remove('tce-ss__panel--open');
            input.setAttribute('aria-expanded', 'false');
        }

        function pick(o) {
            if (select.value !== o.value) {
                select.value = o.value;
                select.dispatchEvent(new Event('change', { bubbles: true }));
            }
            input.value = o.text.length > 100 ? o.text.substring(0, 100) + '...' : o.text;
            input.title = o.text;
            closePanel();
        }

        input.addEventListener('focus', function () {
            input.select();
            renderPanel('');
            openPanel();
        });

        input.addEventListener('click', function () {
            if (!panel.classList.contains('tce-ss__panel--open')) {
                renderPanel(input.value === selectedLabel() ? '' : input.value);
                openPanel();
            }
        });

        input.addEventListener('input', function () {
            renderPanel(input.value);
            openPanel();
        });

        input.addEventListener('keydown', function (e) {
            var nodes = panel.querySelectorAll('.tce-ss__opt');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (!panel.classList.contains('tce-ss__panel--open')) {
                    renderPanel(input.value);
                    openPanel();
                }
                if (visibleItems.length) setActive((activeIdx + 1) % visibleItems.length);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (visibleItems.length) {
                    setActive(activeIdx <= 0 ? visibleItems.length - 1 : activeIdx - 1);
                }
            } else if (e.key === 'Enter') {
                if (panel.classList.contains('tce-ss__panel--open')) {
                    e.preventDefault();
                    if (activeIdx >= 0 && visibleItems[activeIdx]) {
                        pick(visibleItems[activeIdx]);
                    } else if (visibleItems.length === 1) {
                        pick(visibleItems[0]);
                    }
                }
            } else if (e.key === 'Escape') {
                if (panel.classList.contains('tce-ss__panel--open')) {
                    e.preventDefault();
                    closePanel();
                    syncInputFromSelect();
                }
            } else if (e.key === 'Tab') {
                closePanel();
            }
        });

        input.addEventListener('blur', function () {
            // Delay so click on options can fire first
            setTimeout(function () {
                if (!panel.contains(document.activeElement)) {
                    closePanel();
                    syncInputFromSelect();
                }
            }, 150);
        });

        // Initial label
        syncInputFromSelect();

        // External code may change select.value programmatically
        select.addEventListener('change', function () {
            syncInputFromSelect();
        });
    }

    function enhanceMulti(select) {
        if (select.dataset.tceSearchable === '1') return;
        select.dataset.tceSearchable = '1';

        var originals = [];
        for (var i = 0; i < select.options.length; i++) {
            var o = select.options[i];
            originals.push({
                value: o.value,
                text: o.textContent,
                style: o.getAttribute('style') || '',
                disabled: o.disabled,
                defaultSelected: o.defaultSelected
            });
        }
        if (originals.length < 2) return;

        var wrap = document.createElement('span');
        wrap.className = 'tce-msf';

        var filter = document.createElement('input');
        filter.type = 'search';
        filter.className = 'tce-msf__filter';
        filter.placeholder = select.dataset.searchPlaceholder || 'Filter…';
        filter.setAttribute('autocomplete', 'off');
        filter.setAttribute('aria-label', 'Filter ' + (select.name || 'options'));

        var count = document.createElement('span');
        count.className = 'tce-msf__count';

        select.parentNode.insertBefore(wrap, select);
        wrap.appendChild(filter);
        wrap.appendChild(count);
        wrap.appendChild(select);

        function rebuild(term) {
            // Capture currently-selected values from live select before clearing
            var picked = {};
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].selected) picked[select.options[i].value] = true;
            }
            var lower = term.toLowerCase();
            while (select.options.length > 0) select.remove(0);
            var visible = 0;
            for (var j = 0; j < originals.length; j++) {
                var o = originals[j];
                var match = !lower || o.text.toLowerCase().indexOf(lower) !== -1;
                // Always keep selected options so the form value stays valid
                if (match || picked[o.value]) {
                    var opt = document.createElement('option');
                    opt.value = o.value;
                    opt.textContent = o.text;
                    if (o.style) opt.setAttribute('style', o.style);
                    if (o.disabled) opt.disabled = true;
                    if (picked[o.value]) opt.selected = true;
                    select.appendChild(opt);
                    if (match) visible++;
                }
            }
            if (lower) {
                count.textContent = visible + ' / ' + originals.length;
                count.style.display = 'block';
            } else {
                count.style.display = 'none';
            }
        }

        filter.addEventListener('input', function () { rebuild(filter.value.trim()); });
        filter.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                e.preventDefault();
                filter.value = '';
                rebuild('');
            }
        });
    }

    function init() {
        ensureStyles();
        var nodes = document.querySelectorAll('select.searchable');
        for (var i = 0; i < nodes.length; i++) {
            if (nodes[i].multiple) {
                enhanceMulti(nodes[i]);
            } else {
                enhance(nodes[i]);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    /**
     * Global Delete Confirmation logic
     * Requires a checkbox with id="confirm_delete_check" to be ticked before any button named "delete" can be clicked.
     */
    document.addEventListener('click', function (e) {
        if (e.target && (e.target.name === 'delete' || e.target.id === 'delete')) {
            var cb = document.getElementById('confirm_delete_check');
            if (cb && !cb.checked) {
                alert('Please check the confirmation box next to the Delete button!');
                e.preventDefault();
                return false;
            }
        }
    }, true);

    /**
     * Auto-hide system messages after 10 seconds
     */
    function hideMessages() {
        var msgs = document.querySelectorAll('.message, .warning, .error');
        msgs.forEach(function(msg) {
            setTimeout(function() {
                msg.style.opacity = '0';
                msg.style.transform = 'translateY(-20px)';
                msg.style.marginTop = '0';
                msg.style.marginBottom = '0';
                msg.style.paddingTop = '0';
                msg.style.paddingBottom = '0';
                msg.style.height = '0';
                setTimeout(function() {
                    msg.style.setProperty('display', 'none', 'important');
                }, 1000);
            }, 10000);
        });
    }
    hideMessages();

})();
