# 🏗️ Architecture / Arquitetura

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

This document describes the architecture and organization of the ReamurCMS project.

---

## 📊 Overview

```
┌─────────────────────────────────────────────────────────────────────┐
│                           REAMURCMS                                 │
├─────────────────────────────────────────────────────────────────────┤
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌─────────────────┐  │
│  │    CMS    │  │ ECOMMERCE │  │   BLOG    │  │  LANDING PAGES  │  │
│  │           │  │           │  │           │  │                 │  │
│  │ • Pages   │  │ • Products│  │ • Posts   │  │ • Visual Builder│  │
│  │ • Media   │  │ • Orders  │  │ • Comments│  │ • A/B Testing   │  │
│  │ • SEO     │  │ • Payments│  │ • Tags    │  │ • CTAs & Forms  │  │
│  └───────────┘  └───────────┘  └───────────┘  └─────────────────┘  │
├─────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │              🎓 COURSES & VIRTUAL CLASSROOMS                │    │
│  │   • Curriculum • Lessons • Enrollments • Live Sessions      │    │
│  │   • Progress Tracking • Certificates • Room Controls        │    │
│  └─────────────────────────────────────────────────────────────┘    │
├─────────────────────────────────────────────────────────────────────┤
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌───────────────┐    │
│  │  USERS &  │  │  THEMES   │  │  REST API │  │   EXTENSIONS  │    │
│  │   ROLES   │  │ & MODULES │  │           │  │               │    │
│  └───────────┘  └───────────┘  └───────────┘  └───────────────┘    │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 🏛️ MVCL Architecture

ReamurCMS is built on the **MVCL** pattern — an extension of MVC that adds a dedicated **Library** layer.

```
┌─────────────────────────────────────────────────────┐
│                  REQUEST / ROUTE                     │
└──────────────────────────┬──────────────────────────┘
                           │
                    ┌──────▼──────┐
                    │  CONTROLLER │  ← Handles request logic
                    └──────┬──────┘
                           │
            ┌──────────────┼──────────────┐
            ▼              ▼              ▼
       ┌─────────┐   ┌─────────┐   ┌──────────┐
       │  MODEL  │   │  VIEW   │   │ LIBRARY  │
       │         │   │         │   │          │
       │Database │   │Template │   │ Shared   │
       │ Queries │   │Rendering│   │ Services │
       └─────────┘   └─────────┘   └──────────┘
```

| Layer      | Responsibility                                      |
|------------|-----------------------------------------------------|
| Controller | Receives requests, validates input, calls models    |
| Model      | Database interactions and business logic            |
| View       | Template rendering (Twig/PHP templates)             |
| Library    | Reusable services: cache, mail, session, validation |

---

## 📁 Directory Structure

```
reamurcms/
│
├── 📁 admin/                        # Admin panel
│   ├── 📁 controller/               # Admin controllers
│   │   ├── 📁 catalog/              # CMS & product management
│   │   ├── 📁 sale/                 # Orders & customers
│   │   ├── 📁 extension/            # Module management
│   │   ├── 📁 course/               # Course & classroom management
│   │   └── 📁 landing/              # Landing page builder
│   ├── 📁 model/                    # Admin models
│   ├── 📁 view/                     # Admin templates
│   └── 📁 language/                 # Admin translations
│
├── 📁 catalog/                      # Frontend (storefront)
│   ├── 📁 controller/               # Frontend controllers
│   │   ├── 📁 product/              # Product pages
│   │   ├── 📁 blog/                 # Blog pages
│   │   ├── 📁 checkout/             # Checkout flow
│   │   ├── 📁 course/               # Course & lesson pages
│   │   └── 📁 landing/              # Landing page rendering
│   ├── 📁 model/                    # Frontend models
│   ├── 📁 view/                     # Frontend templates
│   └── 📁 language/                 # Frontend translations
│
├── 📁 system/                       # Core system
│   ├── 📁 engine/                   # MVCL engine (Controller, Model, View, Library)
│   ├── 📁 library/                  # Shared libraries
│   │   ├── 📄 cache.php             # Cache abstraction (file/redis/memcached)
│   │   ├── 📄 db.php                # Database abstraction
│   │   ├── 📄 mail.php              # Mail service
│   │   ├── 📄 session.php           # Session management
│   │   └── 📄 image.php             # Image processing
│   └── 📁 storage/                  # Composer dependencies
│
├── 📁 extension/                    # Third-party & custom modules
│   ├── 📁 payment/                  # Payment gateways
│   ├── 📁 shipping/                 # Shipping methods
│   ├── 📁 analytics/                # Analytics integrations
│   └── 📁 [custom_modules]/         # Your custom modules
│
├── 📁 image/                        # Uploaded media
│   ├── 📁 catalog/                  # Product images
│   ├── 📁 blog/                     # Blog media
│   └── 📁 course/                   # Course thumbnails
│
├── 📁 docs/                         # Documentation
│   ├── 📄 README.md
│   ├── 📄 INSTALLATION.md
│   ├── 📄 CONTRIBUTING.md
│   ├── 📄 CODE-OF-CONDUCT.md
│   ├── 📄 ARCHITECTURE.md
│   ├── 📄 API.md
│   ├── 📄 FAQ.md
│   ├── 📄 SECURITY.md
│   └── 📄 CHANGELOG.md
│
├── 📄 config.php                    # Frontend configuration
├── 📄 config-dist.php               # Frontend config template
├── 📄 index.php                     # Frontend entry point
├── 📄 .htaccess                     # Apache rewrite rules
├── 📄 docker-compose.yml            # Docker setup
└── 📄 composer.json                 # PHP dependencies
```

---

## 🔄 Request Lifecycle

```
Browser / API Client
        │
        ▼
┌───────────────┐
│  index.php    │  ← Entry point
│  (router)     │
└───────┬───────┘
        │
        ▼
┌───────────────┐
│  Controller   │  ← Resolves route, loads dependencies
└───┬───────┬───┘
    │       │
    ▼       ▼
┌───────┐ ┌───────┐
│ Model │ │Library│  ← Model queries DB; Library provides services
└───┬───┘ └───────┘
    │
    ▼
┌───────────────┐
│  Database     │  ← MySQL / MariaDB / PostgreSQL
└───────────────┘
    │
    ▼ (data returned to controller)
┌───────────────┐
│     View      │  ← Renders HTML template
└───────────────┘
    │
    ▼
Browser / API Response
```

---

## 🧩 Module Architecture

Every module in ReamurCMS follows a standardized layout:

```
extension/
└── my_module/
    ├── admin/
    │   ├── controller/my_module.php     # Admin logic
    │   ├── model/my_module.php          # Admin data layer
    │   ├── view/my_module.twig          # Admin template
    │   └── language/
    │       ├── en-gb/my_module.php
    │       └── pt-br/my_module.php
    └── catalog/
        ├── controller/my_module.php     # Frontend logic
        ├── model/my_module.php          # Frontend data layer
        └── view/my_module.twig          # Frontend template
```

---

## 🗄️ Database Design Conventions

| Convention           | Example                              |
|----------------------|--------------------------------------|
| Table prefix         | `rc_` (configurable)                 |
| Primary keys         | `id` (auto-increment integer)        |
| Foreign keys         | `{entity}_id` (e.g., `product_id`)  |
| Timestamps           | `date_added`, `date_modified`        |
| Status fields        | `status` (tinyint: 0/1)             |
| Sort order           | `sort_order` (integer)               |

**Key Tables:**

| Table                    | Module              |
|--------------------------|---------------------|
| `rc_product`             | E-commerce          |
| `rc_order`               | E-commerce          |
| `rc_blog_post`           | Blog                |
| `rc_course`              | Courses             |
| `rc_course_lesson`       | Courses             |
| `rc_course_enrollment`   | Courses             |
| `rc_classroom`           | Virtual Classrooms  |
| `rc_classroom_session`   | Virtual Classrooms  |
| `rc_landing_page`        | Landing Pages       |
| `rc_user`                | Users               |
| `rc_setting`             | System              |

---

## 🔐 Security Architecture

- **Input sanitization** via the database layer (`$this->db->escape()`)
- **CSRF protection** on all admin forms
- **Role-based access control** (RBAC) for all admin routes
- **Password hashing** using `password_hash()` (bcrypt)
- **Session management** with configurable lifetime and regeneration
- **SQL Injection prevention** via parameterized queries
- **XSS prevention** via output escaping in templates

---

## 🚀 Scalability

```
Phase 1 — Current
├── Core platform (CMS, Blog, E-commerce)
├── Landing Pages
├── Courses & Virtual Classrooms
└── REST API

Phase 2 — Planned
├── Microservices for heavy modules (e.g., live classrooms)
├── Message queue support (Redis/RabbitMQ)
├── CDN integration for media delivery
└── Multi-store / multi-tenant support

Phase 3 — Long Term
├── Marketplace for community modules
├── Managed hosting option
└── Mobile app API expansion
```

---

## 🏷️ Naming Conventions

| Type              | Convention    | Example                          |
|-------------------|---------------|----------------------------------|
| PHP Classes       | PascalCase    | `ProductController`              |
| PHP Methods       | camelCase     | `getProductById()`               |
| PHP Variables     | camelCase     | `$productData`                   |
| Database tables   | snake_case    | `rc_course_enrollment`           |
| Database columns  | snake_case    | `date_added`, `instructor_id`    |
| Files             | snake_case    | `product_controller.php`         |
| Routes            | kebab-case    | `/catalog/product/view`          |
| Template files    | snake_case    | `product_list.twig`              |

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

Este documento descreve a arquitetura e organização do projeto ReamurCMS.

---

## 📊 Visão Geral

```
┌─────────────────────────────────────────────────────────────────────┐
│                           REAMURCMS                                 │
├─────────────────────────────────────────────────────────────────────┤
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌─────────────────┐  │
│  │    CMS    │  │ ECOMMERCE │  │   BLOG    │  │  LANDING PAGES  │  │
│  │           │  │           │  │           │  │                 │  │
│  │ • Páginas │  │ • Produtos│  │ • Posts   │  │ • Construtor    │  │
│  │ • Mídia   │  │ • Pedidos │  │ • Coment. │  │ • Testes A/B   │  │
│  │ • SEO     │  │ • Pag.    │  │ • Tags    │  │ • CTAs & Forms  │  │
│  └───────────┘  └───────────┘  └───────────┘  └─────────────────┘  │
├─────────────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │           🎓 CURSOS & SALAS VIRTUAIS                        │    │
│  │   • Currículo • Aulas • Matrículas • Sessões ao Vivo        │    │
│  │   • Progresso • Certificados • Controle de Salas            │    │
│  └─────────────────────────────────────────────────────────────┘    │
├─────────────────────────────────────────────────────────────────────┤
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌───────────────┐    │
│  │ USUÁRIOS  │  │  TEMAS    │  │  REST API │  │   EXTENSÕES   │    │
│  │  & PAPÉIS │  │ & MÓDULOS │  │           │  │               │    │
│  └───────────┘  └───────────┘  └───────────┘  └───────────────┘    │
└─────────────────────────────────────────────────────────────────────┘
```

---

## 🏛️ Arquitetura MVCL

O ReamurCMS é construído sobre o padrão **MVCL** — uma extensão do MVC que adiciona uma camada dedicada de **Library** (Biblioteca).

```
┌─────────────────────────────────────────────────────┐
│                  REQUISIÇÃO / ROTA                   │
└──────────────────────────┬──────────────────────────┘
                           │
                    ┌──────▼──────┐
                    │ CONTROLLER  │  ← Gerencia a lógica da requisição
                    └──────┬──────┘
                           │
            ┌──────────────┼──────────────┐
            ▼              ▼              ▼
       ┌─────────┐   ┌─────────┐   ┌──────────┐
       │  MODEL  │   │  VIEW   │   │ LIBRARY  │
       │         │   │         │   │          │
       │ Banco   │   │Template │   │ Serviços │
       │ de Dados│   │   HTML  │   │Reutiliz. │
       └─────────┘   └─────────┘   └──────────┘
```

| Camada     | Responsabilidade                                       |
|------------|--------------------------------------------------------|
| Controller | Recebe requisições, valida entrada, chama models       |
| Model      | Interações com banco de dados e lógica de negócio      |
| View       | Renderização de templates (Twig/PHP)                   |
| Library    | Serviços reutilizáveis: cache, e-mail, sessão, validação |

---

## 📁 Estrutura de Diretórios

```
reamurcms/
│
├── 📁 admin/                        # Painel administrativo
│   ├── 📁 controller/               # Controllers do admin
│   │   ├── 📁 catalog/              # Gestão de CMS e produtos
│   │   ├── 📁 sale/                 # Pedidos e clientes
│   │   ├── 📁 extension/            # Gerenciamento de módulos
│   │   ├── 📁 course/               # Gestão de cursos e salas
│   │   └── 📁 landing/              # Construtor de landing pages
│   ├── 📁 model/                    # Models do admin
│   ├── 📁 view/                     # Templates do admin
│   └── 📁 language/                 # Traduções do admin
│
├── 📁 catalog/                      # Frontend (loja/site)
│   ├── 📁 controller/               # Controllers do frontend
│   │   ├── 📁 product/              # Páginas de produto
│   │   ├── 📁 blog/                 # Páginas do blog
│   │   ├── 📁 checkout/             # Fluxo de checkout
│   │   ├── 📁 course/               # Páginas de curso e aula
│   │   └── 📁 landing/              # Renderização de landing pages
│   ├── 📁 model/                    # Models do frontend
│   ├── 📁 view/                     # Templates do frontend
│   └── 📁 language/                 # Traduções do frontend
│
├── 📁 system/                       # Sistema core
│   ├── 📁 engine/                   # Engine MVCL
│   ├── 📁 library/                  # Bibliotecas compartilhadas
│   │   ├── 📄 cache.php             # Abstração de cache
│   │   ├── 📄 db.php                # Abstração de banco de dados
│   │   ├── 📄 mail.php              # Serviço de e-mail
│   │   ├── 📄 session.php           # Gerenciamento de sessão
│   │   └── 📄 image.php             # Processamento de imagens
│   └── 📁 storage/                  # Dependências do Composer
│
├── 📁 extension/                    # Módulos de terceiros e customizados
│   ├── 📁 payment/                  # Gateways de pagamento
│   ├── 📁 shipping/                 # Métodos de envio
│   ├── 📁 analytics/                # Integrações de analytics
│   └── 📁 [modulos_customizados]/   # Seus módulos customizados
│
├── 📁 image/                        # Mídia enviada
│
├── 📁 docs/                         # Documentação
│
├── 📄 config.php                    # Configuração do frontend
├── 📄 config-dist.php               # Template de configuração
├── 📄 index.php                     # Ponto de entrada
├── 📄 .htaccess                     # Regras Apache rewrite
├── 📄 docker-compose.yml            # Configuração Docker
└── 📄 composer.json                 # Dependências PHP
```

---

## 🔄 Ciclo de Vida da Requisição

```
Navegador / Cliente API
        │
        ▼
┌───────────────┐
│  index.php    │  ← Ponto de entrada
│  (router)     │
└───────┬───────┘
        │
        ▼
┌───────────────┐
│  Controller   │  ← Resolve rota, carrega dependências
└───┬───────┬───┘
    │       │
    ▼       ▼
┌───────┐ ┌───────┐
│ Model │ │Library│  ← Model consulta DB; Library provê serviços
└───┬───┘ └───────┘
    │
    ▼
┌───────────────┐
│  Banco Dados  │  ← MySQL / MariaDB / PostgreSQL
└───────────────┘
    │
    ▼ (dados retornam ao controller)
┌───────────────┐
│     View      │  ← Renderiza template HTML
└───────────────┘
    │
    ▼
Resposta ao Navegador / API
```

---

## 🧩 Arquitetura de Módulos

Todo módulo no ReamurCMS segue um layout padronizado:

```
extension/
└── meu_modulo/
    ├── admin/
    │   ├── controller/meu_modulo.php     # Lógica do admin
    │   ├── model/meu_modulo.php          # Camada de dados do admin
    │   ├── view/meu_modulo.twig          # Template do admin
    │   └── language/
    │       ├── en-gb/meu_modulo.php
    │       └── pt-br/meu_modulo.php
    └── catalog/
        ├── controller/meu_modulo.php     # Lógica do frontend
        ├── model/meu_modulo.php          # Camada de dados do frontend
        └── view/meu_modulo.twig          # Template do frontend
```

---

## 🗄️ Convenções do Banco de Dados

| Convenção           | Exemplo                              |
|---------------------|--------------------------------------|
| Prefixo de tabelas  | `rc_` (configurável)                 |
| Chaves primárias    | `id` (integer auto-increment)        |
| Chaves estrangeiras | `{entidade}_id` (ex: `product_id`)  |
| Timestamps          | `date_added`, `date_modified`        |
| Campos de status    | `status` (tinyint: 0/1)             |
| Ordenação           | `sort_order` (integer)               |

**Tabelas Principais:**

| Tabela                   | Módulo              |
|--------------------------|---------------------|
| `rc_product`             | E-commerce          |
| `rc_order`               | E-commerce          |
| `rc_blog_post`           | Blog                |
| `rc_course`              | Cursos              |
| `rc_course_lesson`       | Cursos              |
| `rc_course_enrollment`   | Cursos              |
| `rc_classroom`           | Salas Virtuais      |
| `rc_classroom_session`   | Salas Virtuais      |
| `rc_landing_page`        | Landing Pages       |
| `rc_user`                | Usuários            |
| `rc_setting`             | Sistema             |

---

## 🔐 Arquitetura de Segurança

- **Sanitização de entrada** via camada de banco de dados (`$this->db->escape()`)
- **Proteção CSRF** em todos os formulários do admin
- **Controle de acesso baseado em papéis** (RBAC) para todas as rotas do admin
- **Hash de senhas** usando `password_hash()` (bcrypt)
- **Gerenciamento de sessão** com tempo de vida configurável e regeneração
- **Prevenção de SQL Injection** via queries parametrizadas
- **Prevenção de XSS** via escape de saída nos templates

---

## 🚀 Escalabilidade

```
Fase 1 — Atual
├── Plataforma core (CMS, Blog, E-commerce)
├── Landing Pages
├── Cursos & Salas Virtuais
└── REST API

Fase 2 — Planejado
├── Microsserviços para módulos pesados (ex: salas ao vivo)
├── Suporte a filas de mensagens (Redis/RabbitMQ)
├── Integração com CDN para entrega de mídia
└── Suporte multi-loja / multi-tenant

Fase 3 — Longo Prazo
├── Marketplace de módulos da comunidade
├── Opção de hosting gerenciado
└── Expansão da API para apps mobile
```

---

## 🏷️ Convenções de Nomenclatura

| Tipo              | Convenção     | Exemplo                          |
|-------------------|---------------|----------------------------------|
| Classes PHP       | PascalCase    | `ProductController`              |
| Métodos PHP       | camelCase     | `getProductById()`               |
| Variáveis PHP     | camelCase     | `$productData`                   |
| Tabelas do banco  | snake_case    | `rc_course_enrollment`           |
| Colunas do banco  | snake_case    | `date_added`, `instructor_id`    |
| Arquivos          | snake_case    | `product_controller.php`         |
| Rotas             | kebab-case    | `/catalog/product/view`          |
| Templates         | snake_case    | `product_list.twig`              |
