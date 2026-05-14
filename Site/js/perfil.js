document.addEventListener('DOMContentLoaded', () => {
    const listsContainer = document.getElementById('lists-container');
    const addListBtn = document.getElementById('add-list-btn');

    // Dados de exemplo iniciais para as listas
    let customLists = [
        { title: 'Jogos para Platinar', count: 12 },
        { title: 'RPG Clássicos', count: 8 },
        { title: 'Favoritos de 2026', count: 3 }
    ];

    // Função para desenhar as listas no ecrã
    function renderLists() {
        listsContainer.innerHTML = ''; // Limpa o container

        if (customLists.length === 0) {
            listsContainer.innerHTML = '<p style="color: #64748b; font-size: 0.95rem; font-style: italic;">Ainda não criaste nenhuma lista. Clica em "+ Nova Lista"!</p>';
            return;
        }

        customLists.forEach(list => {
            const card = document.createElement('div');
            card.classList.add('list-card');
            
            card.innerHTML = `
                <h3>${list.title}</h3>
                <p>${list.count} jogos adicionados</p>
            `;
            
            listsContainer.appendChild(card);
        });
    }
const toggleBioEdit = document.getElementById("toggleBioEdit");
    const bioForm = document.getElementById("bioForm");

    toggleBioEdit.addEventListener("click", function () {
        if (bioForm.style.display === "none" || bioForm.style.display === "") {
            bioForm.style.display = "block";
            toggleBioEdit.innerHTML = "Cancelar";
        } else {
            bioForm.style.display = "none";
            toggleBioEdit.innerHTML = "Editar Bio";
        }
    });
    // Função para adicionar nova lista ao clicar no botão
    addListBtn.addEventListener('click', () => {
        const listName = prompt('Introduz o nome da nova lista:');
        
        if (listName && listName.trim() !== '') {
            customLists.push({
                title: listName,
                count: 0 // Começa com 0 jogos
            });
            renderLists();
        }
    });
    const avatarInput = document.getElementById("avatarInput");
    const guardarAvatarBtn = document.getElementById("guardarAvatarBtn");

    avatarInput.addEventListener("change", function () {
        guardarAvatarBtn.click();
    });
    // Renderiza as listas iniciais
    renderLists();
});