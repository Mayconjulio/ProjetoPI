// Importação dos módulos necessários
import express from "express";
import cors from "cors";
import bodyParser from "body-parser";
import { OpenAI } from "openai/index.mjs";
import dotenv from "dotenv";
import path from "path";
import { fileURLToPath } from "url";
import fs from "fs";

// Para usar __dirname com ESModules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Carrega variáveis de ambiente do .env
dotenv.config({ path: path.join(__dirname, ".env") });

// Inicializa o servidor
const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

// Verifica se a chave da OpenAI está presente
if (!process.env.OPENAI_API_KEY) {
    console.error("❌ ERRO: A variável OPENAI_API_KEY não está definida no .env");
    process.exit(1);
}

// Inicializa a instância da OpenAI
const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

// Lê o prompt do arquivo
const systemPrompt = fs.readFileSync("./backend/prompt.txt", "utf-8");

// Objeto para armazenar o histórico das sessões
const chatHistory = {};

// Rota principal do chat
app.post("/chat", async (req, res) => {
    const { message, sessionId = "default" } = req.body;

    if (!message) {
        return res.status(400).json({ error: "A mensagem não pode estar vazia" });
    }

    // Se ainda não tiver histórico dessa sessão, inicia um array
    if (!chatHistory[sessionId]) {
        chatHistory[sessionId] = [];
    }

    // Adiciona a mensagem do usuário ao histórico
    chatHistory[sessionId].push({ role: "user", content: message });

    console.log("🔹 Pergunta recebida:", message);

    try {
        const response = await openai.chat.completions.create({
            model: "gpt-4o",
            messages: [
                { role: "system", content: systemPrompt },
                ...chatHistory[sessionId] // Envia o histórico completo (sem repetir o systemPrompt)
            ],
        });

        if (!response.choices || response.choices.length === 0) {
            throw new Error("Resposta vazia da API");
        }

        const respostaBot = response.choices[0].message.content;
        console.log("✅ Resposta da API:", respostaBot);

        // Adiciona a resposta do bot ao histórico
        chatHistory[sessionId].push({ role: "assistant", content: respostaBot });

        res.json({ response: respostaBot });
    } catch (error) {
        console.error("❌ Erro na API:", error);
        res.status(500).json({ error: "Erro ao obter resposta da API" });
    }
});

// Inicia o servidor
app.listen(port, () => {
    console.log(`🚀 Assistente Financeiro rodando em http://localhost:${port}`);
});
