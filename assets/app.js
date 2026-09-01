// Gestion de la bascule de thème (clair/sombre)
const themeCheckbox = document.querySelector('.theme-controller');
if (themeCheckbox) {
    const currentTheme = document.documentElement.getAttribute('data-theme') || 'corporate';
    themeCheckbox.checked = currentTheme === themeCheckbox.value;

    themeCheckbox.addEventListener('change', () => {
        const theme = themeCheckbox.checked ? themeCheckbox.value : 'corporate';
        document.documentElement.setAttribute('data-theme', theme);
        try {
            localStorage.setItem('theme', theme);
        } catch (e) {}
    });
}
