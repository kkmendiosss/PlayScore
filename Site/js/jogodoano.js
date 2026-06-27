function mudarAno(ano) {
    window.location.href = `jogodoano.php?ano=${ano}`;
}

document.addEventListener("DOMContentLoaded", () => {
    const inputPesquisa = document.getElementById('inputPesquisa');
    const dropdown = document.getElementById('dropdownPesquisa');
    const wrapper = document.getElementById('pesquisaWrapper');

    if (!inputPesquisa) return;

    inputPesquisa.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        dropdown.innerHTML = ''; 

        if (query.length > 0) {
            const resultados = jogosDoAno.filter(jogo => 
                jogo.titulo.toLowerCase().includes(query)
            );

            if (resultados.length > 0) {
                dropdown.style.display = 'block';
                resultados.forEach(jogo => {
                    const div = document.createElement('div');
                    div.textContent = juego = jogo.titulo;
                    
                    div.onclick = function() {
                        inputPesquisa.value = jogo.titulo;
                        dropdown.style.display = 'none';
                        
                        const anoSelecionado = document.getElementById('selectAno').value;

                        const dadosVoto = new URLSearchParams();
                        dadosVoto.append('id_jogo', jogo.id_jogo);
                        dadosVoto.append('ano', anoSelecionado);

                        fetch('votar_jogo_ano.php', {
                            method: 'POST',
                            body: dadosVoto
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                alert(data.error || "Ocorreu um erro ao registar o teu voto.");
                            }
                        })
                        .catch(error => {
                            console.error("Erro:", error);
                            alert("Não foi possível conectar ao servidor de votação.");
                        });
                    };
                    dropdown.appendChild(div);
                });
            } else {
                dropdown.style.display = 'none';
            }
        } else {
            dropdown.style.display = 'none';
        }
    });

    window.addEventListener('click', function(e) {
        if (!wrapper.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
});