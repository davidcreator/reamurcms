# 🤝 Contributing Guide / Guia de Contribuição

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

Thank you for your interest in contributing to ReamurCMS! This document provides guidelines for contributing to the project.

---

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [How Can I Contribute?](#how-can-i-contribute)
- [Environment Setup](#environment-setup)
- [Contribution Process](#contribution-process)
- [Code Standards](#code-standards)
- [Commit Standards](#commit-standards)
- [Pull Requests](#pull-requests)

---

## 📜 Code of Conduct

This project follows a [Code of Conduct](./CODE-OF-CONDUCT.md). By participating, you are expected to uphold this code.

---

## 🎯 How Can I Contribute?

### 🐛 Reporting Bugs

Found a bug? Help us fix it!

1. Check if an [issue](https://github.com/davidcreator/reamurcms/issues) already exists for the problem
2. If not, create a new issue using the bug template
3. Include as many details as possible

**Bug Report Template:**
```markdown
## Bug Description
[Clear and concise description]

## Steps to Reproduce
1. Go to '...'
2. Click on '...'
3. See the error

## Expected Behavior
[What should happen]

## Screenshots
[If applicable]

## Environment
- OS: [e.g. Ubuntu 22.04]
- PHP version: [e.g. 8.2]
- Web server: [e.g. Apache 2.4]
- ReamurCMS version: [e.g. 2.0.0]
- Module affected: [e.g. E-commerce, Courses]
```

### 💡 Suggesting Features

Have an idea? We'd love to hear it!

1. Check if a similar suggestion already exists
2. Create an issue using the feature request template
3. Describe the problem the feature would solve

### 📝 Improving Documentation

Documentation is crucial! You can:

- Fix typos
- Improve explanations
- Add examples
- Translate content

### 💻 Contributing Code

- Fix existing bugs
- Implement new features
- Improve performance
- Add tests
- Create new modules or themes

---

## 🛠️ Environment Setup

**1. Fork the Repository**

Click the "Fork" button in the top right corner of the repository.

**2. Clone your Fork**

```bash
git clone https://github.com/YOUR-USERNAME/reamurcms.git
cd reamurcms
```

**3. Install PHP Dependencies**

```bash
cd system/storage
composer install
```

**4. Configure the Upstream**

```bash
git remote add upstream https://github.com/davidcreator/reamurcms.git
git fetch upstream
```

**5. Set up the Database**

```bash
cp config-dist.php config.php
cp admin/config-dist.php admin/config.php
# Edit config.php with your database credentials
```

**6. Create a Branch**

```bash
git checkout -b feature/my-feature
```

---

## 🔄 Contribution Process

```text
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    Fork     │────▶│   Develop   │────▶│     PR      │
└─────────────┘     └─────────────┘     └─────────────┘
                           │
                    ┌──────┴──────┐
                    ▼             ▼
              ┌─────────┐   ┌─────────┐
              │  Test   │   │ Document│
              └─────────┘   └─────────┘
```

### Step by Step

**1. Sync with upstream**
```bash
git fetch upstream
git checkout main
git merge upstream/main
```

**2. Create a branch**
```bash
git checkout -b type/short-description
```

**3. Make your changes**
- Write clean code
- Add tests if necessary
- Update documentation

**4. Commit your changes**
```bash
git add .
git commit -m "type: description of changes"
```

**5. Push to your fork**
```bash
git push origin type/short-description
```

**6. Open a Pull Request**

---

## 📏 Code Standards

### General
- Use consistent indentation (4 spaces for PHP)
- Use descriptive names for variables and functions
- Comment complex code
- Keep functions small and focused
- Follow PSR-12 for PHP code

### PHP (ReamurCMS Core)

```php
<?php
namespace Reamur\Controller\Catalog;

class Product extends \Reamur\System\Engine\Controller {

    // camelCase for methods
    public function index(): void {
        $this->load->model('catalog/product');

        // Descriptive variable names
        $productData = $this->model_catalog_product->getProducts();

        $this->response->setOutput(
            $this->load->view('catalog/product_list', $productData)
        );
    }

    // Prefix private methods with underscore
    private function _validateForm(): bool {
        // Validation logic
        return true;
    }
}
```

### Module Structure

```text
extension/
└── my_module/
    ├── admin/
    │   ├── controller/
    │   ├── model/
    │   ├── view/
    │   └── language/
    └── catalog/
        ├── controller/
        ├── model/
        └── view/
```

---

## 📝 Commit Standards

We use Conventional Commits:

```text
type(scope): short description

[optional body]

[optional footer]
```

### Allowed Types

| Type       | Description                          |
|------------|--------------------------------------|
| `feat`     | New feature                          |
| `fix`      | Bug fix                              |
| `docs`     | Documentation                        |
| `style`    | Formatting (does not affect logic)   |
| `refactor` | Refactoring                          |
| `test`     | Adding/fixing tests                  |
| `chore`    | General maintenance                  |
| `perf`     | Performance improvement              |

### Examples

```bash
feat(courses): add virtual classroom scheduling system
fix(ecommerce): fix checkout on mobile browsers
docs(api): update REST API reference for courses module
style(admin): reformat dashboard following PSR-12
refactor(cms): simplify content rendering pipeline
test(auth): add unit tests for permission system
chore(deps): update composer dependencies
perf(cache): improve Redis cache hit rate for product pages
```

---

## 🔀 Pull Requests

### Checklist

Before opening a PR, check:

- [ ] Code follows project standards
- [ ] Tests pass (if applicable)
- [ ] Documentation updated
- [ ] Commits follow the standard
- [ ] Branch updated with main

### PR Template

```markdown
## Description
[Describe the changes made]

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation
- [ ] New module

## How to Test
1. [Steps to test]

## Checklist
- [ ] Code reviewed
- [ ] Tests added/updated
- [ ] Documentation updated

## Screenshots (if applicable)
[Add screenshots]

## Related Issues
Closes #[number]
```

### Review Process

1. Maintainer reviews the code
2. Feedback is provided (if necessary)
3. Changes are made
4. PR is approved and merged

---

## 🏷️ Labels

| Label             | Description                    |
|-------------------|--------------------------------|
| `bug`             | Something isn't working        |
| `enhancement`     | New feature or improvement     |
| `documentation`   | Documentation improvements     |
| `good first issue`| Good for newcomers             |
| `help wanted`     | Extra attention needed         |
| `question`        | Further information requested  |
| `wontfix`         | This won't be fixed            |
| `module`          | Related to a specific module   |

---

## 🎉 Recognition

All contributors are recognized:

- In the main README
- In the Contributors section
- In release notes

## ❓ Questions?

- Open an issue
- Check the FAQ

*Thank you for contributing! 🙏*

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

Obrigado pelo interesse em contribuir com o ReamurCMS! Este documento fornece diretrizes para contribuir com o projeto.

---

## 📋 Índice

- [Código de Conduta](#código-de-conduta)
- [Como Posso Contribuir?](#como-posso-contribuir)
- [Configuração do Ambiente](#configuração-do-ambiente)
- [Processo de Contribuição](#processo-de-contribuição)
- [Padrões de Código](#padrões-de-código)
- [Padrões de Commit](#padrões-de-commit)
- [Pull Requests](#pull-requests-1)

---

## 📜 Código de Conduta

Este projeto adota um [Código de Conduta](./CODE-OF-CONDUCT.md). Ao participar, espera-se que você mantenha este código.

---

## 🎯 Como Posso Contribuir?

### 🐛 Reportando Bugs

Encontrou um bug? Ajude-nos a corrigi-lo!

1. Verifique se já existe uma [issue](https://github.com/davidcreator/reamurcms/issues) sobre o problema
2. Se não existir, crie uma nova issue usando o template de bug
3. Inclua o máximo de detalhes possível

**Template de Bug Report:**
```markdown
## Descrição do Bug
[Descrição clara e concisa]

## Passos para Reproduzir
1. Vá para '...'
2. Clique em '...'
3. Veja o erro

## Comportamento Esperado
[O que deveria acontecer]

## Screenshots
[Se aplicável]

## Ambiente
- OS: [ex: Ubuntu 22.04]
- Versão do PHP: [ex: 8.2]
- Servidor web: [ex: Apache 2.4]
- Versão do ReamurCMS: [ex: 2.0.0]
- Módulo afetado: [ex: E-commerce, Cursos]
```

### 💡 Sugerindo Features

Tem uma ideia? Adoraríamos ouvir!

1. Verifique se já não existe uma sugestão similar
2. Crie uma issue usando o template de feature request
3. Descreva o problema que a feature resolveria

### 📝 Melhorando a Documentação

Documentação é crucial! Você pode:

- Corrigir erros de digitação
- Melhorar explicações
- Adicionar exemplos
- Traduzir conteúdo

### 💻 Contribuindo com Código

- Corrigir bugs existentes
- Implementar novas features
- Melhorar performance
- Adicionar testes
- Criar novos módulos ou temas

---

## 🛠️ Configuração do Ambiente

**1. Fork o Repositório**

Clique no botão "Fork" no canto superior direito do repositório.

**2. Clone seu Fork**

```bash
git clone https://github.com/SEU-USERNAME/reamurcms.git
cd reamurcms
```

**3. Instale as Dependências PHP**

```bash
cd system/storage
composer install
```

**4. Configure o Upstream**

```bash
git remote add upstream https://github.com/davidcreator/reamurcms.git
git fetch upstream
```

**5. Configure o Banco de Dados**

```bash
cp config-dist.php config.php
cp admin/config-dist.php admin/config.php
# Edite config.php com suas credenciais do banco de dados
```

**6. Crie uma Branch**

```bash
git checkout -b feature/minha-feature
```

---

## 🔄 Processo de Contribuição

```text
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│    Fork     │────▶│  Desenvolva │────▶│     PR      │
└─────────────┘     └─────────────┘     └─────────────┘
                           │
                    ┌──────┴──────┐
                    ▼             ▼
              ┌─────────┐   ┌─────────┐
              │  Teste  │   │Documente│
              └─────────┘   └─────────┘
```

### Passo a Passo

**1. Sincronize com upstream**
```bash
git fetch upstream
git checkout main
git merge upstream/main
```

**2. Crie uma branch**
```bash
git checkout -b tipo/descricao-curta
```

**3. Faça suas alterações**
- Escreva código limpo
- Adicione testes se necessário
- Atualize a documentação

**4. Commit suas mudanças**
```bash
git add .
git commit -m "tipo: descrição das mudanças"
```

**5. Push para seu fork**
```bash
git push origin tipo/descricao-curta
```

**6. Abra um Pull Request**

---

## 📏 Padrões de Código

### Geral
- Use indentação consistente (4 espaços para PHP)
- Nomes descritivos para variáveis e funções
- Comente código complexo
- Mantenha funções pequenas e focadas
- Siga o PSR-12 para código PHP

### PHP (Core do ReamurCMS)

```php
<?php
namespace Reamur\Controller\Catalog;

class Product extends \Reamur\System\Engine\Controller {

    // camelCase para métodos
    public function index(): void {
        $this->load->model('catalog/product');

        // Nomes de variáveis descritivos
        $productData = $this->model_catalog_product->getProducts();

        $this->response->setOutput(
            $this->load->view('catalog/product_list', $productData)
        );
    }

    // Prefixo underscore para métodos privados
    private function _validateForm(): bool {
        // Lógica de validação
        return true;
    }
}
```

### Estrutura de Módulo

```text
extension/
└── meu_modulo/
    ├── admin/
    │   ├── controller/
    │   ├── model/
    │   ├── view/
    │   └── language/
    └── catalog/
        ├── controller/
        ├── model/
        └── view/
```

---

## 📝 Padrões de Commit

Usamos Conventional Commits:

```text
tipo(escopo): descrição curta

[corpo opcional]

[rodapé opcional]
```

### Tipos Permitidos

| Tipo        | Descrição                              |
|-------------|----------------------------------------|
| `feat`      | Nova feature                           |
| `fix`       | Correção de bug                        |
| `docs`      | Documentação                           |
| `style`     | Formatação (não afeta lógica)          |
| `refactor`  | Refatoração                            |
| `test`      | Adição/correção de testes              |
| `chore`     | Manutenção geral                       |
| `perf`      | Melhoria de performance                |

### Exemplos

```bash
feat(courses): adiciona sistema de agendamento de salas virtuais
fix(ecommerce): corrige checkout em navegadores mobile
docs(api): atualiza referência REST API para módulo de cursos
style(admin): reformata dashboard seguindo PSR-12
refactor(cms): simplifica pipeline de renderização de conteúdo
test(auth): adiciona testes unitários para sistema de permissões
chore(deps): atualiza dependências do composer
perf(cache): melhora taxa de cache hit do Redis para páginas de produto
```

---

## 🔀 Pull Requests

### Checklist

Antes de abrir um PR, verifique:

- [ ] Código segue os padrões do projeto
- [ ] Testes passam (se aplicável)
- [ ] Documentação atualizada
- [ ] Commits seguem o padrão
- [ ] Branch atualizada com main

### Template de PR

```markdown
## Descrição
[Descreva as mudanças feitas]

## Tipo de Mudança
- [ ] Bug fix
- [ ] Nova feature
- [ ] Breaking change
- [ ] Documentação
- [ ] Novo módulo

## Como Testar
1. [Passos para testar]

## Checklist
- [ ] Código revisado
- [ ] Testes adicionados/atualizados
- [ ] Documentação atualizada

## Screenshots (se aplicável)
[Adicione screenshots]

## Issues Relacionadas
Closes #[número]
```

### Processo de Review

1. Mantenedor revisa o código
2. Feedback é fornecido (se necessário)
3. Alterações são feitas
4. PR é aprovado e merged

---

## 🏷️ Labels

| Label              | Descrição                         |
|--------------------|-----------------------------------|
| `bug`              | Algo não está funcionando         |
| `enhancement`      | Nova feature ou melhoria          |
| `documentation`    | Melhorias na documentação         |
| `good first issue` | Bom para iniciantes               |
| `help wanted`      | Precisamos de ajuda               |
| `question`         | Dúvida ou discussão               |
| `wontfix`          | Não será corrigido                |
| `module`           | Relacionado a um módulo específico|

---

## 🎉 Reconhecimento

Todos os contribuidores são reconhecidos:

- No README principal
- Na seção de Contributors
- Nos release notes

## ❓ Dúvidas?

- Abra uma issue
- Consulte a FAQ

*Obrigado por contribuir! 🙏*
