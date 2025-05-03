// /js/navbar.js
const loadNavbar = async () => {
  try {
    // 1. Carrega a navbar
    const response = await fetch('/projetopi/components/navbar.html');
    
    // Verifica se a requisição foi bem-sucedida
    if (!response.ok) {
      throw new Error(`Erro HTTP: ${response.status}`);
    }

    // 2. Insere no HTML
    const html = await response.text();
    document.body.insertAdjacentHTML('afterbegin', html);

    // 3. Debug (opcional)
    console.log("✅ Navbar carregada com sucesso!");

  } catch (err) {
    console.error("❌ Falha ao carregar navbar:", err);
    
    // Fallback visual (opcional)
    document.body.insertAdjacentHTML('afterbegin', `
      <div style="
        background: #ffebee;
        color: #d32f2f;
        padding: 15px;
        border: 1px solid #ef9a9a;
        font-family: sans-serif;
      ">
        ⚠️ Erro ao carregar a navbar. 
        <button onclick="location.reload()" style="margin-left: 10px;">
          Recarregar Página
        </button>
      </div>
    `);
  }
};

// Inicia o carregamento
loadNavbar();