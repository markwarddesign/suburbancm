// Mobile menu: full-screen panel that fades and slides in (styles in _design.scss).
document.addEventListener('DOMContentLoaded', () => {
	const menu = document.getElementById('scm-menu');
	const openBtn = document.querySelector('[data-scm-menu-open]');
	const closeBtn = menu && menu.querySelector('[data-scm-menu-close]');
	if (!menu || !openBtn || !closeBtn) {
		return;
	}

	const setOpen = (open) => {
		menu.classList.toggle('is-open', open);
		menu.inert = !open;
		document.body.classList.toggle('scm-menu-open', open);
		openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
		(open ? closeBtn : openBtn).focus();
	};

	openBtn.addEventListener('click', () => setOpen(true));
	closeBtn.addEventListener('click', () => setOpen(false));
	menu.addEventListener('keydown', (e) => {
		if (e.key === 'Escape') {
			setOpen(false);
		}
	});
	// Closing on desktop widths keeps a stale open panel from lingering after a resize.
	window.matchMedia('(min-width: 1181px)').addEventListener('change', (e) => {
		if (e.matches && menu.classList.contains('is-open')) {
			setOpen(false);
		}
	});
});
