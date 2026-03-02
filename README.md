# ReamurCMS

![Build](https://github.com/davidcreator/reamurcms/actions/workflows/build.yml/badge.svg)
[![Translation](https://img.shields.io/badge/translation-65%25-yellow?style=for-the-badge)](#)
[![Discord](https://img.shields.io/badge/discord-join-7289DA?style=for-the-badge&logo=discord&logoColor=white)](https://discord.gg/seu-link-aqui)
[![License](https://img.shields.io/badge/license-GPL--3.0-blue?style=for-the-badge)](https://github.com/davidcreator/reamurcms/blob/main/LICENSE)

---

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

**ReamurCMS** is an open-source project developed in PHP with **MVCL (Model–View–Controller–Library)** architecture.  
Its goal is to provide an all-in-one platform that combines **digital content management (CMS)**, **e-commerce**, **landing pages**, **blog publishing**, and **online learning management** — designed especially for developers, designers, and content creators who want autonomy and flexibility in their projects.

---

### 🚀 Key Features

#### 📦 E-commerce
- Complete catalog for digital and physical products.
- Shopping cart, checkout flow, and order management.
- Payment gateway integrations.
- Inventory and product variant control.

#### 🏠 Landing Pages
- Visual builder for high-converting landing pages.
- Customizable sections, CTAs, and forms.
- A/B testing support and conversion tracking.
- Seamless integration with CMS content and e-commerce products.

#### 📝 CMS & Blog
- Full content management system for articles, categories, and tags.
- Rich text editor with media library support.
- Comment moderation system.
- Content scheduling and draft management.

#### 🎓 Online Courses & Virtual Classrooms *(New!)*
- Course creation and curriculum management.
- Lesson editor with support for video, text, and quizzes.
- Student enrollment and progress tracking.
- Virtual classroom management with room controls.
- Live session scheduling and recording integration.
- Certificate generation upon course completion.

#### ⚙️ Core Platform
- **MVCL Architecture** – Clear separation between logic, data, and interface.
- **Modularity** – Add or remove modules as needed.
- **Open Source** – Licensed under GPL, allowing customization and community contributions.
- **Responsive Design** – Interface that adapts to all screen sizes.
- **SEO Tools** – Built-in features to optimize content visibility.
- **Multi-language Support** – Create content in multiple languages.
- **User Management** – Role and permission control system.
- **Extensible** – Support for custom modules and themes.
- **Cache System** – File, Redis, and Memcached support.

---

### 📋 Requirements

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Web server (Apache, Nginx, etc.)
- Composer
- Node.js and NPM (for frontend development)

---

### 📥 Installation

#### Manual Installation

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

1. Install PHP dependencies:
   ```bash
   cd system/storage
   composer install
   ```

2. Create a database for ReamurCMS.

3. Copy the configuration files:
   ```bash
   cp config-dist.php config.php
   cp admin/config-dist.php admin/config.php
   ```

4. Edit the configuration files with your database credentials and preferences.

5. Access the installer via your browser and follow the instructions.

#### Using Docker

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
```

Access at: `http://localhost:8080`

#### Using NPM

```bash
npm install -g reamur-cms
reamur-cms create my-project
cd my-project
npm run dev
```

---

### 🛠️ Environment Configuration

#### Database
```php
$_['db_engine']    = 'mysqli'; // mysqli, pdo or pgsql
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'username';
$_['db_password']  = 'password';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

#### Email
```php
$_['mail_engine']        = 'smtp';
$_['mail_from']          = 'your@email';
$_['mail_smtp_hostname'] = 'smtp.yourserver.com';
$_['mail_smtp_port']     = 587;
```

#### Cache
```php
$_['cache_engine'] = 'file'; // file, redis, memcached
$_['cache_expire'] = 3600;
```

---

### 🧩 Module Development

ReamurCMS follows a modular architecture. To create a new module:

1. Create a folder under `admin/controller/`, `catalog/controller/` or `extension/`.
2. Add the necessary files (Controller, Model, View).
3. Register the module in the system.

More details can be found in the [Developer Guide](https://docs.reamurcms.com/developer-guide).

---

### 🤝 Contributing

Contributions are welcome!

1. Fork the repository.
2. Create your feature branch:
   ```bash
   git checkout -b my-feature
   ```
3. Commit your changes:
   ```bash
   git commit -am "Add my feature"
   ```
4. Push the branch:
   ```bash
   git push origin my-feature
   ```
5. Open a Pull Request.

---

### 📜 License

ReamurCMS is licensed under the **GPL**, allowing free use, modification, and contributions.

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

**ReamurCMS** é um projeto open-source desenvolvido em PHP com arquitetura **MVCL (Model–View–Controller–Library)**.  
Seu objetivo é oferecer uma plataforma completa que combina **gestão de conteúdo digital (CMS)**, **e-commerce**, **landing pages**, **publicação de blog** e **gestão de aprendizado online** — desenvolvida especialmente para desenvolvedores, designers e criadores de conteúdo que buscam autonomia e flexibilidade em seus projetos.

---

### 🚀 Principais Recursos

#### 📦 E-commerce
- Loja completa para produtos digitais e físicos.
- Carrinho de compras, fluxo de checkout e gestão de pedidos.
- Integração com gateways de pagamento.
- Controle de estoque e variantes de produtos.

#### 🏠 Landing Pages
- Construtor visual para landing pages de alta conversão.
- Seções, CTAs e formulários totalmente personalizáveis.
- Suporte a testes A/B e rastreamento de conversões.
- Integração nativa com conteúdo CMS e produtos do e-commerce.

#### 📝 CMS & Blog
- Sistema completo de gestão de conteúdo para artigos, categorias e tags.
- Editor rich text com suporte à biblioteca de mídia.
- Sistema de moderação de comentários.
- Agendamento de publicações e gerenciamento de rascunhos.

#### 🎓 Cursos Online & Salas Virtuais *(Novidade!)*
- Criação de cursos e gerenciamento de grade curricular.
- Editor de aulas com suporte a vídeo, texto e questionários.
- Matrícula de alunos e acompanhamento de progresso.
- Gerenciamento de salas virtuais com controles de acesso.
- Agendamento de sessões ao vivo e integração com gravação.
- Emissão de certificados ao concluir o curso.

#### ⚙️ Plataforma Principal
- **Arquitetura MVCL** – Separação clara entre lógica, dados e interface.
- **Modularidade** – Adicione ou remova módulos conforme necessário.
- **Open Source** – Código aberto sob a licença GPL, permitindo customizações e contribuições.
- **Design Responsivo** – Interface adaptada para diferentes tamanhos de tela.
- **Ferramentas de SEO** – Recursos integrados para otimização de visibilidade do conteúdo.
- **Suporte a Múltiplos Idiomas** – Crie conteúdo em vários idiomas.
- **Gestão de Usuários** – Sistema de controle de papéis e permissões.
- **Extensível** – Suporte a módulos e temas personalizados.
- **Sistema de Cache** – Suporte a File, Redis e Memcached.

---

### 📋 Requisitos

- PHP 8.0 ou superior
- MySQL 5.7+ ou MariaDB 10.3+
- Servidor web (Apache, Nginx, etc.)
- Composer
- Node.js e NPM (para desenvolvimento frontend)

---

### 📥 Instalação

#### Instalação Manual

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

1. Instale as dependências PHP:
   ```bash
   cd system/storage
   composer install
   ```

2. Crie um banco de dados para o ReamurCMS.

3. Copie os arquivos de configuração:
   ```bash
   cp config-dist.php config.php
   cp admin/config-dist.php admin/config.php
   ```

4. Edite os arquivos de configuração com suas credenciais de banco de dados e preferências.

5. Acesse o instalador pelo navegador e siga as instruções.

#### Usando Docker

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
```

Acesse em: `http://localhost:8080`

#### Usando NPM

```bash
npm install -g reamur-cms
reamur-cms create meu-projeto
cd meu-projeto
npm run dev
```

---

### 🛠️ Configuração do Ambiente

#### Banco de Dados
```php
$_['db_engine']    = 'mysqli'; // mysqli, pdo ou pgsql
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'usuario';
$_['db_password']  = 'senha';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

#### E-mail
```php
$_['mail_engine']        = 'smtp';
$_['mail_from']          = 'seu@email.com';
$_['mail_smtp_hostname'] = 'smtp.seuservidor.com';
$_['mail_smtp_port']     = 587;
```

#### Cache
```php
$_['cache_engine'] = 'file'; // file, redis, memcached
$_['cache_expire'] = 3600;
```

---

### 🧩 Desenvolvimento de Módulos

O ReamurCMS segue uma arquitetura modular. Para criar um novo módulo:

1. Crie uma pasta em `admin/controller/`, `catalog/controller/` ou `extension/`.
2. Adicione os arquivos necessários (Controller, Model, View).
3. Registre o módulo no sistema.

Mais detalhes no [Guia do Desenvolvedor](https://docs.reamurcms.com/developer-guide).

---

### 🤝 Contribuição

Contribuições são bem-vindas!

1. Faça um fork do repositório.
2. Crie sua branch de feature:
   ```bash
   git checkout -b minha-feature
   ```
3. Faça o commit das suas alterações:
   ```bash
   git commit -am "Adiciona minha feature"
   ```
4. Envie a branch:
   ```bash
   git push origin minha-feature
   ```
5. Abra um Pull Request.

---

### 📜 Licença

O ReamurCMS é licenciado sob a **GPL**, permitindo uso, modificação e contribuições livres.