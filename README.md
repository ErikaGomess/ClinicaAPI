# ClínicaMed API

ClínicaMed API é um sistema desenvolvido em PHP para gerenciar clínicas médicas, permitindo o cadastro e gerenciamento de pacientes, médicos, especialidades e consultas. O projeto foi criado para oferecer um backend robusto e seguro para aplicações médicas.

## Tecnologias Utilizadas
- PHP com padrão MVC
- MySQL para banco de dados relacional
- Composer para gerenciamento de dependências
- NetBeans como IDE principal

## Funcionalidades
- Cadastro, edição e exclusão de pacientes
- Cadastro, edição e exclusão de médicos e especialidades
- Agendamento e gerenciamento de consultas
- Controle de acesso seguro
- Relatórios e histórico de atendimentos

## Como Executar o Projeto
1. Clone o repositório:
   ```bash
   git clone https://github.com/seu-usuario/clinica-med-api.git
   ```
2. Configure o banco de dados (importando o schema do MySQL).
3. Instale as dependências com Composer:
   ```bash
   composer install
   ```
4. Configure as variáveis de ambiente (`.env`).
5. Inicie o servidor local:
   ```bash
   php -S localhost:8000 -t public
   ```

## Contribuição
Contribuições são bem-vindas! Para contribuir:
- Faça um fork do projeto
- Crie uma branch com suas alterações: `git checkout -b minha-feature`
- Faça commit das mudanças: `git commit -m 'Adiciona nova funcionalidade'`
- Faça push para a branch: `git push origin minha-feature`
- Abra um Pull Request

## Licença
Este projeto está sob a licença MIT.
