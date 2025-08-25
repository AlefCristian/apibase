# API Base

Este projeto é uma **API base** desenvolvida em **CodeIgniter 4**, estruturada para servir como ponto inicial para criação de sistemas modulares.  
O objetivo é fornecer uma arquitetura limpa, organizada e pronta para expandir com novos módulos de acordo com a necessidade.

---

## 🚀 Tecnologias Utilizadas
- **PHP 8+**
- **CodeIgniter 4**
- **MySQL/MariaDB** (ou outro banco relacional compatível)
- **Composer** para gerenciamento de dependências
- **Docker** (opcional, para ambiente de desenvolvimento)
- **AdminLTE** (para o front-end administrativo, quando aplicável)

---

## 📂 Estrutura do Projeto
```
app/
 ├── Config/        # Configurações principais
 ├── Controllers/   # Controladores da API
 ├── Models/        # Modelos (camada de acesso ao banco)
 ├── Views/         # Views (quando necessário)
 ├── Modules/       # Módulos independentes do sistema
public/             # Pasta pública (index.php)
writable/           # Arquivos de cache, logs, etc.
```

---

## ⚙️ Configuração do Ambiente

1. Clone o repositório:
   ```bash
   git clone git@github.com:AlefCristian/apibase.git
   cd apibase
   ```

2. Instale as dependências do Composer:
   ```bash
   composer install
   ```

3. Copie o arquivo de configuração `.env.example` para `.env`:
   ```bash
   cp env.example .env
   ```

4. Configure o banco de dados no arquivo `.env`:
   ```
   database.default.hostname = localhost
   database.default.database = apibase
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```

5. Rode as migrations (se houver):
   ```bash
   php spark migrate
   ```

6. Inicie o servidor local:
   ```bash
   php spark serve
   ```

---

## 📌 Funcionalidades Principais
- Estrutura modular para expansão.
- Controle de autenticação via filtro.
- Suporte a APIs RESTful.
- Fácil integração com frontend.

---

## 🔑 Autenticação
A API pode utilizar **JWT** ou autenticação por sessão.  
O fluxo de login retorna um **token** que deve ser enviado em todas as requisições subsequentes:

```
Authorization: Bearer {token}
```

---

## 🤝 Contribuindo
Sinta-se à vontade para abrir **issues** e enviar **pull requests** com melhorias.

---

## 📄 Licença
Este projeto está sob a licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.
