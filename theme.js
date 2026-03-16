// Theme toggle script
document.addEventListener('DOMContentLoaded', function() {
    // Detect system theme and set initial class
    const theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark-theme' : 'light-theme';
    document.body.classList.add(theme);
    console.log('Initial theme set to:', theme);

    // Toggle function for manual switch
    window.toggleTheme = function() {
        document.body.classList.toggle('dark-theme');
        document.body.classList.toggle('light-theme');
        console.log('Theme toggled. Current classes:', document.body.className);
    };
});