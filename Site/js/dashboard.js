function validarFormulario() {
        var inputNome = document.getElementById('nome').value;
        
        if (inputNome.trim() === "") {
            alert("Por favor, introduza um nome válido. O campo não pode conter apenas espaços!");
            return false;
        }
        return true;
}