// Botão de expandir/recolher o chat
const botao = document.querySelector(".AtivarDesativarChat");
const expansao = document.querySelector(".chatExpandido");
botao.addEventListener("click", () => {
  expansao.style.height = expansao.style.height === "31rem" ? "0" : "31rem";
});

// Chat: envio de mensagens
const form = document.getElementById("chat-form");
const input = document.getElementById("messageInput");
const chatbox = document.getElementById("chatbox");

form.addEventListener("submit", async (e) => {
  // Impede o comportamento padrão do formulário (recarregar a página)
  e.preventDefault();
  // Obtém a mensagem do input e remove espaços em branco nas extremidades
  const message = input.value.trim();

  // Se a mensagem estiver vazia, encerra a função
  if (!message) return;
  // Adiciona a mensagem do usuário na interface
  appendMessage("user", message);
  // Limpa o campo de input
  input.value = "";

  try {
    // Envia a mensagem para o servidor via requisição POST
    const res = await fetch("http://localhost:3000/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message }),
    });

    // Converte a resposta para JSON
    const data = await res.json();

    // Se a resposta do servidor for válida, exibe no chat
    if (data.response) {
      appendMessage("bot", data.response);
    } else {
      // Caso a resposta não contenha o campo esperado
      appendMessage("bot", "Erro: resposta inválida do bot.");
    }
  } catch (err) {
    // Em caso de erro na requisição ou conexão com o servidor
    console.error(err);
    appendMessage("bot", "Erro ao conectar com o servidor.");
  }
});


function appendMessage(role, text) {
  // Cria uma nova div que vai conter a mensagem tlg
  const div = document.createElement("div");
  // Adiciona duas classes: 'message' (estilo base) e a role ('user' ou 'bot') para estilos diferentes
  div.classList.add("message", role);
  // Insere o conteúdo da mensagem, formatado (negrito, quebra de linha, etc.)
  div.innerHTML = formatMessage(text);
  // Adiciona a nova mensagem ao final do chatbox
  chatbox.appendChild(div);
  // Faz o chat rolar automaticamente até a última mensagem
  chatbox.scrollTop = chatbox.scrollHeight;
}


function formatMessage(text) { // Em relação a bugs de formatação de texto
  return text
    .replace(/\n/g, "<br>")               // quebra de linha
    .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>"); // negrito com **
}
