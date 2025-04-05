// Importação dos módulos necessários
import express from "express"; // Framework web para lidar com rotas e requisições
import cors from "cors"; // Middleware para permitir requisições de outras origens (Cross-Origin Resource Sharing)
import bodyParser from "body-parser"; // Middleware para interpretar dados JSON no corpo das requisições
import { OpenAI } from "openai/index.mjs"; // SDK da OpenAI para comunicação com a API
import dotenv from "dotenv"; // Carrega variáveis de ambiente a partir de um arquivo .env
import path from "path"; // Utilitário do Node.js para manipulação de caminhos de arquivos
import { fileURLToPath } from "url"; // Necessário para trabalhar com __dirname em ES Modules

// Converte o caminho do arquivo atual para uma string e obtém o diretório onde ele está localizado
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Carrega o arquivo .env a partir do diretório atual do arquivo
dotenv.config({ path: path.join(__dirname, ".env") });

// É um debug para termos certeza que a chave ta carregada, isso deu uma dor de cabeça que você não faz ideia cara
console.log("🔑 OPENAI KEY:", process.env.OPENAI_API_KEY);

// Inicialização do servidor Express
const app = express();
const port = 3000; // Nossa porta :)

// Middlewares que permitem o funcionamento do servidor:
app.use(cors()); // Permite que o front-end (em outro domínio ou porta) acesse o servidor
app.use(bodyParser.json()); // Permite que o servidor entenda requisições com JSON no corpo

// Verifica se a variável OPENAI_API_KEY foi carregada corretamente, meio que outro DEBUG pra chave
if (!process.env.OPENAI_API_KEY) {
    console.error("❌ ERRO: A variável OPENAI_API_KEY não está definida no .env");
    process.exit(1); // Encerra o servidor, já que sem a chave a API não pode funcionar
}

// Inicializa a instância da OpenAI com a chave de API
const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

// Rota POST que recebe mensagens do front-end e retorna a resposta da IA
app.post("/chat", async (req, res) => {
    const { message } = req.body; // Extrai a mensagem do corpo da requisição

    if (!message) {
        return res.status(400).json({ error: "A mensagem não pode estar vazia" }); // Validação fácil fácil
    }

    console.log("🔹 Pergunta recebida:", message);

    try {
        // Envia a mensagem para a OpenAI usando o modelo gpt-4o
        const response = await openai.chat.completions.create({
            model: "gpt-4o", // Escolhe o modelo
            messages: [
                { 
                    role: "system", // Em "Content" fica o prompt do bot, basicamente a forma que ele vai agir é essa ↓↓↓↓↓
                    content: "Você é um assistente financeiro que responde em português. Dê dicas sobre finanças pessoais, investimentos e controle de gastos. Apenas responda dúvidas sobre finanças, não fale nada fora disso. E fale como um humano" 
                },
                { role: "user", content: message }
            ],
        });

        // Verifica se houve retorno válido
        if (!response.choices || response.choices.length === 0) {
            throw new Error("Resposta vazia da API");
        }

        const respostaBot = response.choices[0].message.content;
        console.log("✅ Resposta da API:", respostaBot);

        res.json({ response: respostaBot }); // Retorna a resposta ao front-end
    } catch (error) {
        console.error("❌ Erro na API:", error);
        res.status(500).json({ error: "Erro ao obter resposta da API" }); // Erro genérico
    }
});

// Inicia o servidor na porta 3000
app.listen(port, () => {
    console.log(`🚀 Assistente Financeiro rodando em http://localhost:${port}`);
});
