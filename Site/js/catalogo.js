function toggleDropdown(event) {
    event.stopPropagation();
    const dropdown = document.getElementById('dropdown-generos');
    if (dropdown) {
        dropdown.classList.toggle('ativo');
    }
}

window.addEventListener('click', function(e) {
    const container = document.getElementById('filtro-genero-container');
    const dropdown = document.getElementById('dropdown-generos');
    if (container && !container.contains(e.target)) {
        if (dropdown && dropdown.classList.contains('ativo')) {
            dropdown.classList.remove('ativo');
        }
    }
});