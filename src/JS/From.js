// Inicia o EmailJS com a chave pública
(function(){
    emailjs.init("YIjEOLhSsCBRiLKj3"); // public key
})();

// Adiciona o ouvinte de evento para o envio do formulário ao clicar no botão
document.getElementById("enviar").addEventListener("click", function(e) {
    e.preventDefault(); // Impede o comportamento padrão, caso o botão esteja em um formulário

    var form = document.getElementById("formEmail");

    // Envia o formulário usando o EmailJS
    emailjs.sendForm("service_gvw5cpn", "template_yls7rno", form)
        .then(function(response) {
            alert("Email enviado com sucesso!");
            form.reset();
        }, function(error) {
            alert("Erro ao enviar: " + error.text);
        });
});
