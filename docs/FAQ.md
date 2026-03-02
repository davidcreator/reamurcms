# ❓ Frequently Asked Questions (FAQ) / Perguntas Frequentes

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

Find answers to the most common questions about ReamurCMS.

---

## 📚 Table of Contents

- [General](#general)
- [Installation](#installation)
- [Modules](#modules)
- [E-commerce](#e-commerce)
- [Courses & Virtual Classrooms](#courses--virtual-classrooms)
- [CMS & Blog](#cms--blog)
- [Landing Pages](#landing-pages)
- [Contributing](#contributing)
- [Technical](#technical)

---

## 🌐 General

### What is ReamurCMS?

ReamurCMS is an open-source platform developed in PHP with MVCL architecture. It combines content management (CMS), e-commerce, blog publishing, landing page creation, and online learning — all in one flexible, extensible system.

### Is the content free?

Yes! ReamurCMS is 100% free and open-source, licensed under the GPL.

### What can I build with ReamurCMS?

You can build: content websites, blogs, online stores, landing pages, course platforms, and virtual classrooms — or any combination of these.

### What languages is the interface available in?

The admin panel supports multiple languages. Currently English and Portuguese (BR) are officially maintained. Community translations are welcome!

### Can I use ReamurCMS for commercial projects?

Yes! The GPL license allows commercial use. You may need to share modifications under the same license.

---

## 🔧 Installation

### How do I clone the repository?

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

### What software do I need?

- PHP 8.0 or higher
- MySQL 5.7+ or MariaDB 10.3+
- Web server: Apache or Nginx
- Composer
- Node.js and NPM (for frontend development)

### How do I install using Docker?

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
# Access at http://localhost:8080
```

### How do I keep my local copy up to date?

```bash
git pull origin main
```

### Can I install via NPM?

```bash
npm install -g reamur-cms
reamur-cms create my-project
cd my-project
npm run dev
```

---

## 🧩 Modules

### How do I enable or disable a module?

Log in to the admin panel, navigate to **Extensions > Modules**, and toggle any module on or off.

### Can I create my own module?

Yes! ReamurCMS is fully modular. See the [Developer Guide](https://docs.reamurcms.com/developer-guide) and `ARCHITECTURE.md` for details.

### Where do I place custom modules?

Custom modules go in `admin/controller/`, `catalog/controller/`, or `extension/`, depending on their scope.

---

## 📦 E-commerce

### What payment gateways are supported?

ReamurCMS supports integrations with major payment gateways. Check the extensions directory for available connectors.

### Can I sell digital products?

Yes! The e-commerce module supports both digital and physical products.

### How does inventory control work?

You can define stock levels per product, enable stock tracking, and set low-stock alerts from the admin panel.

### Can I set up product variants?

Yes — you can define multiple variants (e.g., size, color) per product with individual pricing and stock.

---

## 🎓 Courses & Virtual Classrooms

### How do I create a course?

1. Go to **Extensions > Courses** in the admin panel
2. Click "New Course"
3. Add a title, description, and curriculum
4. Add lessons (video, text, or quiz)
5. Publish the course

### Can students enroll for free?

Yes — you can set a course as free or paid. Paid courses integrate with the e-commerce module for checkout.

### How does the virtual classroom work?

Each course can have virtual classrooms assigned. Instructors can schedule live sessions, control access, and enable recording integration.

### Are certificates automatically issued?

Yes — once a student completes all lessons and quizzes in a course, a certificate is automatically generated.

### Can I track student progress?

Yes — the instructor dashboard shows enrollment numbers, lesson completion rates, quiz scores, and overall progress per student.

---

## 📝 CMS & Blog

### How do I create a blog post?

Go to **Content > Blog > Posts**, click "New Post", add your content, set a category and tags, and publish or schedule it.

### Does ReamurCMS support SEO for blog content?

Yes — each post has dedicated fields for meta title, meta description, URL slug, and Open Graph data.

### Can I moderate comments?

Yes — comments can be set to require manual approval before appearing publicly.

---

## 🏠 Landing Pages

### How do I create a landing page?

Go to **Content > Landing Pages**, click "New Page", and use the visual builder to assemble sections, CTAs, and forms.

### Can landing pages be linked to products or courses?

Yes — you can embed product cards, enrollment buttons, and lead capture forms directly on landing pages.

### Is A/B testing supported?

Yes — you can create two variants of a landing page and track conversion rates for each.

---

## 🤝 Contributing

### How can I contribute?

- Report bugs
- Suggest features
- Improve documentation
- Add translations
- Submit modules or themes

Read the full [Contributing Guide](./CONTRIBUTING.md).

### Do I need to be an expert to contribute?

No! Contributions at all levels are valued, from fixing typos to building new modules.

### Will my contribution be credited?

Yes! All contributors are recognized in the project.

### How long does it take for a PR to be reviewed?

Generally 1–7 days, depending on complexity.

---

## 🔧 Technical

### What are the minimum system requirements?

- **Server:** 1 GB RAM (2 GB recommended), 10 GB disk space
- **PHP:** 8.0+ with extensions: mysqli/pdo, mbstring, gd, curl, zip
- **Database:** MySQL 5.7+ or MariaDB 10.3+

### Which database engines are supported?

ReamurCMS supports `mysqli`, `pdo`, and `pgsql` (PostgreSQL).

### Which cache engines are supported?

File-based cache, Redis, and Memcached.

### How do I report a bug?

1. Check if a similar issue already exists
2. Use the bug report template
3. Include: OS, PHP version, web server, ReamurCMS version, and steps to reproduce

### The admin panel is not loading after installation — what should I do?

1. Verify your `config.php` and `admin/config.php` settings
2. Ensure file permissions are correct (`755` for folders, `644` for files)
3. Check your web server error logs
4. Open an issue if the problem persists

---

## 🆘 Still Have Questions?

If your question wasn't answered here:

- 🔍 Search the [Issues](https://github.com/davidcreator/reamurcms/issues)
- 📝 Open a new issue with the label `question`
- 💬 Join the community on [Discord](https://discord.gg/seu-link-aqui)

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

Encontre respostas para as dúvidas mais comuns sobre o ReamurCMS.

---

## 📚 Índice

- [Geral](#geral)
- [Instalação](#instalação)
- [Módulos](#módulos)
- [E-commerce](#e-commerce-1)
- [Cursos & Salas Virtuais](#cursos--salas-virtuais)
- [CMS & Blog](#cms--blog-1)
- [Landing Pages](#landing-pages-1)
- [Contribuição](#contribuição)
- [Técnico](#técnico)

---

## 🌐 Geral

### O que é o ReamurCMS?

O ReamurCMS é uma plataforma open-source desenvolvida em PHP com arquitetura MVCL. Ele combina gestão de conteúdo (CMS), e-commerce, publicação de blog, criação de landing pages e aprendizado online — tudo em um sistema flexível e extensível.

### O projeto é gratuito?

Sim! O ReamurCMS é 100% gratuito e open-source, licenciado sob a GPL.

### O que posso construir com o ReamurCMS?

Você pode construir: sites de conteúdo, blogs, lojas virtuais, landing pages, plataformas de cursos, salas virtuais — ou qualquer combinação dessas soluções.

### Em que idiomas a interface está disponível?

O painel administrativo suporta múltiplos idiomas. Atualmente inglês e português (BR) são mantidos oficialmente. Traduções da comunidade são bem-vindas!

### Posso usar o ReamurCMS em projetos comerciais?

Sim! A licença GPL permite uso comercial. Pode ser necessário compartilhar modificações sob a mesma licença.

---

## 🔧 Instalação

### Como faço para clonar o repositório?

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

### Quais softwares preciso?

- PHP 8.0 ou superior
- MySQL 5.7+ ou MariaDB 10.3+
- Servidor web: Apache ou Nginx
- Composer
- Node.js e NPM (para desenvolvimento frontend)

### Como instalar usando Docker?

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
# Acesse em http://localhost:8080
```

### Como atualizo minha cópia local?

```bash
git pull origin main
```

### Posso instalar via NPM?

```bash
npm install -g reamur-cms
reamur-cms create meu-projeto
cd meu-projeto
npm run dev
```

---

## 🧩 Módulos

### Como ativo ou desativo um módulo?

Acesse o painel administrativo, vá em **Extensões > Módulos** e ative ou desative o módulo desejado.

### Posso criar meu próprio módulo?

Sim! O ReamurCMS é totalmente modular. Consulte o [Guia do Desenvolvedor](https://docs.reamurcms.com/developer-guide) e o `ARCHITECTURE.md` para detalhes.

### Onde coloco módulos customizados?

Módulos customizados ficam em `admin/controller/`, `catalog/controller/` ou `extension/`, dependendo do escopo.

---

## 📦 E-commerce

### Quais gateways de pagamento são suportados?

O ReamurCMS suporta integração com os principais gateways de pagamento. Verifique o diretório de extensões para conectores disponíveis.

### Posso vender produtos digitais?

Sim! O módulo de e-commerce suporta produtos digitais e físicos.

### Como funciona o controle de estoque?

Você pode definir níveis de estoque por produto, ativar rastreamento de inventário e configurar alertas de estoque baixo pelo painel admin.

### Posso criar variantes de produto?

Sim — você pode definir múltiplas variantes (ex: tamanho, cor) por produto com preços e estoques individuais.

---

## 🎓 Cursos & Salas Virtuais

### Como crio um curso?

1. Acesse **Extensões > Cursos** no painel admin
2. Clique em "Novo Curso"
3. Adicione título, descrição e grade curricular
4. Adicione aulas (vídeo, texto ou quiz)
5. Publique o curso

### Os alunos podem se matricular gratuitamente?

Sim — você pode definir um curso como gratuito ou pago. Cursos pagos se integram ao módulo de e-commerce para o checkout.

### Como funciona a sala virtual?

Cada curso pode ter salas virtuais atribuídas. Os instrutores podem agendar sessões ao vivo, controlar o acesso e ativar integração com gravação.

### Os certificados são emitidos automaticamente?

Sim — ao concluir todas as aulas e questionários de um curso, o certificado é gerado automaticamente para o aluno.

### Posso acompanhar o progresso dos alunos?

Sim — o dashboard do instrutor exibe número de matrículas, taxa de conclusão de aulas, notas dos quizzes e progresso geral por aluno.

---

## 📝 CMS & Blog

### Como crio uma postagem no blog?

Acesse **Conteúdo > Blog > Posts**, clique em "Novo Post", adicione seu conteúdo, defina categoria e tags, e publique ou agende.

### O ReamurCMS suporta SEO para conteúdo do blog?

Sim — cada post possui campos dedicados para meta título, meta descrição, URL amigável e dados Open Graph.

### Posso moderar comentários?

Sim — comentários podem ser configurados para exigir aprovação manual antes de aparecerem publicamente.

---

## 🏠 Landing Pages

### Como crio uma landing page?

Acesse **Conteúdo > Landing Pages**, clique em "Nova Página" e use o construtor visual para montar seções, CTAs e formulários.

### Landing pages podem ser vinculadas a produtos ou cursos?

Sim — você pode incorporar cards de produto, botões de matrícula e formulários de captura de leads diretamente nas landing pages.

### Testes A/B são suportados?

Sim — você pode criar duas variantes de uma landing page e acompanhar a taxa de conversão de cada uma.

---

## 🤝 Contribuição

### Como posso contribuir?

- Reportar bugs
- Sugerir features
- Melhorar documentação
- Adicionar traduções
- Submeter módulos ou temas

Leia o [Guia de Contribuição](./CONTRIBUTING.md) completo.

### Preciso ser expert para contribuir?

Não! Contribuições de todos os níveis são valorizadas, desde correção de typos até criação de novos módulos.

### Minha contribuição será creditada?

Sim! Todos os contribuidores são reconhecidos no projeto.

### Quanto tempo leva para um PR ser revisado?

Geralmente 1–7 dias, dependendo da complexidade.

---

## 🔧 Técnico

### Quais são os requisitos mínimos do servidor?

- **Servidor:** 1 GB RAM (2 GB recomendado), 10 GB de espaço em disco
- **PHP:** 8.0+ com extensões: mysqli/pdo, mbstring, gd, curl, zip
- **Banco de dados:** MySQL 5.7+ ou MariaDB 10.3+

### Quais engines de banco de dados são suportadas?

O ReamurCMS suporta `mysqli`, `pdo` e `pgsql` (PostgreSQL).

### Quais engines de cache são suportadas?

Cache baseado em arquivo, Redis e Memcached.

### Como reporto um bug?

1. Verifique se já existe issue similar
2. Use o template de bug report
3. Inclua: OS, versão do PHP, servidor web, versão do ReamurCMS e passos para reproduzir

### O painel admin não carrega após a instalação — o que fazer?

1. Verifique as configurações do `config.php` e `admin/config.php`
2. Certifique-se de que as permissões de arquivo estão corretas (`755` para pastas, `644` para arquivos)
3. Verifique os logs de erro do servidor web
4. Abra uma issue se o problema persistir

---

## 🆘 Ainda com Dúvidas?

Se sua pergunta não foi respondida:

- 🔍 Pesquise nas [Issues](https://github.com/davidcreator/reamurcms/issues)
- 📝 Abra uma nova issue com a label `question`
- 💬 Entre no [Discord](https://discord.gg/seu-link-aqui) da comunidade
