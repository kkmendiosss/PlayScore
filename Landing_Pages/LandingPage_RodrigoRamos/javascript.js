document.getElementById('voteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btn = document.querySelector('.final-submit');
    const originalBtnText = btn.innerText; 
    
    
    btn.disabled = true;
    btn.style.opacity = "0.7";

    setTimeout(() => {
       
        alert("Sucesso! O teu voto foi registado e o cupão Eneba será enviado para o teu e-mail em instantes.");
        
      
        this.reset(); 
        btn.disabled = false;
        btn.innerText = originalBtnText; 
        btn.style.opacity = "1";
        
        console.log("Formulário enviado com sucesso!");
    }, 1500);
});
