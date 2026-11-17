/**
 * Aliados comerciales por estado.
 * Enlaza los <path> del mapa de Venezuela con los grupos de aliados.
 * Solo por clic (o Enter/Espacio con el teclado): pasar el cursor no cambia
 * nada, solo tinta el estado como pista de que es pulsable.
 */
(function () {
    const section = document.querySelector('.partner-section');
    if (!section) return;

    const codes = new Set(window.partnerStateCodes || []);
    const paths = section.querySelectorAll('.pn-state');
    const chips = section.querySelectorAll('.pn-chip');
    const groups = section.querySelectorAll('.partner-group');

    let selected = null;

    function select(code) {
        // Repintar lo ya pintado relanza transiciones sin motivo
        if (code === selected) return;
        selected = code;

        groups.forEach((group) => {
            const match = group.dataset.state === code;
            group.classList.toggle('hide', !match);
            group.hidden = !match;
        });

        chips.forEach((chip) => {
            const match = chip.dataset.state === code;
            chip.classList.toggle('active', match);
            chip.setAttribute('aria-selected', match ? 'true' : 'false');
        });

        paths.forEach((path) => {
            path.classList.toggle('active', path.dataset.code === code);
        });
    }

    paths.forEach((path) => {
        const code = path.dataset.code;

        // Un estado sin aliados no es pulsable: se queda apagado
        if (!codes.has(code)) {
            path.classList.add('is-empty');
            return;
        }

        path.classList.add('is-available');
        path.setAttribute('tabindex', '0');
        path.setAttribute('role', 'button');
        path.setAttribute('aria-label', 'Aliados en ' + path.dataset.name);

        path.addEventListener('click', () => select(code));

        path.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                select(code);
            }
        });
    });

    chips.forEach((chip) => {
        chip.addEventListener('click', () => select(chip.dataset.state));
    });

    select(window.partnerInitialState || null);
})();
