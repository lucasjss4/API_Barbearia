💈 Sistema de Gestão de Barbearia - API REST
Este projeto é uma API RESTful completa desenvolvida para o desafio técnico de Desenvolvedor Back-end Júnior. O sistema gerencia o fluxo de uma barbearia, permitindo o cadastro de clientes, agendamentos com validação de horário e notificações automáticas para administradores.

🛠️ Tecnologias e Requisitos
PHP: 8.3

Framework: Laravel 12

Banco de Dados: MySQL

Autenticação: Laravel Sanctum (Tokens)

Documentação: Scribe & Apidog (OpenAPI 3.0)

Serviço de E-mail: SMTP (Mailtrap)

🚀 Instruções de Instalação e Execução
Siga os passos abaixo para rodar o projeto localmente:

Clonar o repositório:

Bash
git clone <url-do-repositorio>
cd <nome-da-pasta>
Instalar dependências do Composer:

Bash
composer install
Configurar o Ambiente (.env):

Copie o arquivo de exemplo: cp .env.example .env

Gere a chave da aplicação: php artisan key:generate

Configure as credenciais do seu banco de dados MySQL em DB_DATABASE, DB_USERNAME e DB_PASSWORD.

Importante: Configure as chaves do Mailtrap no bloco MAIL_ para validar o envio de e-mails via SMTP.

Migrações e Dados Iniciais:
Execute o comando abaixo para criar as tabelas e o administrador padrão:

Bash
php artisan migrate --seed
Gerar Documentação Estática:

Bash
php artisan scribe:generate
Iniciar o Servidor:

Bash
php artisan serve
🔑 Credenciais de Teste (Admin via Seeder)
Para testar a criação de novos administradores (conforme requisito do desafio), utilize o login abaixo:

E-mail: admin@gmail.com

Senha: 123456

📑 Documentação e Testes da API
Visualização no Apidog (Requisito)
Certifique-se de ter rodado o comando php artisan scribe:generate.

O arquivo de especificação será gerado em: storage/app/scribe/openapi.yaml.

Importe este arquivo no Apidog para visualizar os endpoints, parâmetros e esquemas de resposta.

Testes Manuais
Você pode testar a API utilizando ferramentas como Postman, Insomnia ou CURL.

Cadastro de Cliente: POST /api/client (Aberto)

Login: POST /api/login -> Retorna o access_token.

Agendamento: POST /api/agendamento (Requer Token).

✅ Requisitos Implementados
[x] Autenticação: Uso do Laravel Sanctum para proteção de rotas.

[x] CRUDs: Administradores, Clientes e Agendamentos.

[x] Segurança: Apenas administradores logados podem cadastrar outros administradores.

[x] Notificação: Envio de e-mail via SMTP para todos os admins ao realizar um novo agendamento.

[x] Validação: Verificação de conflito de horários (bloqueio de sobreposição de 30 minutos).

[x] Documentação: API documentada seguindo padrões OpenAPI via Scribe/Apidog.

📧 Configuração de E-mail
O sistema utiliza o protocolo SMTP. Para testes, foi validado utilizando o Mailtrap, garantindo que as notificações contenham o nome do cliente, a data e o horário.