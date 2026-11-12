# Resolção do Desafio SAEP: Sistema de Gestão para Clínica Veterinária

**Avaliação prática do desempenho dos estudantes - SAEP**

**Tecnologias**: PHP 8.5, PostgreSQL, PDO (Prepared statements)

**Arquitetura**: MVC Artesanal, Autload PRS-4 via composer 

## Como executar localmente

Na pasta raiz do projeto, gere o autoloader e inicie o servidor PHP usando o front controller como roteador:

```powershell
cd sistema
composer dump-autoload
php -S localhost:8000 -t public public/index.php
```

Depois acesse `http://localhost:8000/`. O servidor precisa usar `sistema/public` como raiz para que as rotas da aplicação sejam encaminhadas corretamente.

---

- Segurança LGPD
- Sessão com Tempo de Expiração
- Código Limpo e Princípio SOLID
- Uso de Credenciais 
- Prevenção Anti Vulnerabiilidade (XSS, SQL Injection, CRSF)

## Entregas

### Identificação do Projeto
- **Nome do Sistema**: SisVet - Sistema de Gestão de Clinica Veterinária
- **Público-Alvo**: Veterinários, Recepcionista e gestores da clínica
- **Problema**: Eliminação dos controles manuais, duplicidade de registros, perda de agendamentos, risco e vazamentos de dados(LGPD)

### Requisitos Funcionais do sistema (RF)

- **RF-01**: Autenticação do Usuário com Sessão e Expiração => O sistema deve autenticar o usuário com email e senha(hash de criptografia). Exibir Alerta em CAso de Erro. Sessão deve expirar automaticamento após 15 minutos de intividde
- **RF-02**: Logout => encerramento da sessão , destruindo os dados do usuário (cookies)
- **RF-03**: Painel Principal (DASHBOARD) => tela inicial após o login, deve exibir o nome do usuário logado
- **RF-04**: Cadastro de Tutores (LGPD) => Cadastrar infrmações dos tutores criptografando dados sensíveis (CPF)
- **RF-05**: Busca e Listagem de Tutores => Campo de pesquisa por termo e listagem dos resultados
- **RF-06**: Edição dos Tutores: Permitir a alteração dos dados dos Tutores
- **RF-07**: Cadastro dos Pets com Vínculo em Tutor => Cadastro de novo pet associado a um tutor
- **RF-08** Listagem de pets => Exibir a lista de pets cadastrados
- **RF-09**: Agendamento e Listagem de Agendamento =>  O sistema deve permitir cadastrar um agendamento e listar ordenadas por data de todos os agendamentos
- **RF-10**: Atualização de Agendamento => permitir alterar informações do agendamento

### Requisitos Não Funcionais (RNF)

- RNF-01: Arquitetura MVC
- RNF-02: Mapeamento via PSR-04
- RNF-03: Proteção e Criptografia
- RNF-04: Armazenamento em Banco de Dados Relacional

### Diagrama de Entidades Relacionais (DER)

```mermaid

erDiagram
    title "DER - Sistema de Gestão de Clínica Veterinária"

    usuarios {
        int id PK
        varchar nome
        varchar email UNIQUE
        varchar senha_hash
        varchar perfil
        timestamp criado_em
    }

    tutores {
        int id PK
        varchar nome
        varchar cpf_criptografado
        varchar telefone
        varchar email
        timestamp criado_em
    }

    pets {
        int id PK
        int tutor_id FK
        varchar nome
        varchar especie
        varchar raca
        date data_nascimento
        timestamp cadastrado_em
    }

    agendamentos {
        int id PK
        int tutor_id FK
        int pet_id FK
        int usuario_id FK
        date data_agendamento
        time hora_agendamento
        varchar servico
        varchar status
        text observacao
        timestamp criado_em
    }

    usuarios ||--o{ agendamentos : "agenda/gerencia"
    tutores ||--o{ pets : "possui (1:N)"
    tutores ||--o{ agendamentos : "responsavel (1:N)"
    pets ||--o{ agendamentos : "paciente (1:N)"
```

## Banco de Dados - Script de Criação e População

