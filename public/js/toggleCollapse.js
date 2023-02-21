function toggleCollapse() {
    const ariaExpanded = document.getElementById('ariaExpanded');
    const navbarNavAltMarkup = document.getElementById('navbarNavAltMarkup');

    if (ariaExpanded.getAttribute('aria-expanded') == 'false') {
        ariaExpanded.setAttribute('aria-expanded', 'true');
        navbarNavAltMarkup.classList.add('show');                 
    } else {
        ariaExpanded.setAttribute('aria-expanded', 'false');        
        navbarNavAltMarkup.classList.remove('show');
    }
}