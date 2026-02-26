# 🔒 Security Policy / Política de Segurança

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

## Supported Versions

| Version | Supported |
|---------|-----------|
| 2.0.x   | ✅ Yes    |
| 1.0.x   | ✅ Yes    |
| < 1.0   | ❌ No     |

---

## Reporting a Vulnerability

If you discover a security vulnerability in ReamurCMS, please follow responsible disclosure:

1. **DO NOT** open a public issue
2. Send an email to `security@reamurcms.com` with the subject: `[SECURITY] Brief description`
3. Include all relevant details about the vulnerability
4. Wait for confirmation before any public disclosure

### What to Include in Your Report

- **Type of vulnerability** (e.g., SQL Injection, XSS, CSRF, RCE)
- **Affected module** (e.g., E-commerce, Courses, Admin Panel)
- **Affected file path(s)**
- **Steps to reproduce** the vulnerability
- **Potential impact** assessment
- **Suggested fix** (if you have one)
- **Proof of concept** code (if applicable)

---

## Response Timeline

| Stage              | Timeframe   |
|--------------------|-------------|
| Acknowledgment     | 48 hours    |
| Initial assessment | 7 days      |
| Status update      | 14 days     |
| Fix deployment     | Depends on severity |

### Severity Levels

| Level    | Description                                    | Target Fix Time |
|----------|------------------------------------------------|-----------------|
| Critical | Remote code execution, full system compromise  | 24–72 hours     |
| High     | Authentication bypass, data breach             | 7 days          |
| Medium   | Privilege escalation, sensitive data exposure  | 30 days         |
| Low      | Minor information disclosure, low-impact bugs  | 90 days         |

---

## Security Best Practices for Deployments

### After Installation
- Change default admin credentials immediately
- Remove the `install/` directory
- Set proper file permissions (see `INSTALLATION.md`)
- Enable HTTPS/SSL for all traffic

### Ongoing
- Keep ReamurCMS updated to the latest stable release
- Monitor your server logs regularly
- Use strong passwords and consider 2FA for admin accounts
- Restrict admin panel access by IP if possible
- Keep PHP and server software updated

### Configuration Hardening

```php
// config.php — recommended settings for production
$_['error_display'] = 0;        // Disable error display
$_['error_log']     = 1;        // Keep logging enabled
$_['error_filename'] = 'error.log';
```

---

## Recognition

Contributors who responsibly report valid vulnerabilities will be:

- Credited in the `CHANGELOG.md` under the relevant release
- Added to the Security Hall of Fame (if desired)

We are grateful to all security researchers who help keep ReamurCMS safe.

---

## Contact

- **Security email:** `security@reamurcms.com`
- **GitHub Security Advisories:** [Report here](https://github.com/davidcreator/reamurcms/security/advisories/new)

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

## Versões Suportadas

| Versão  | Suportada |
|---------|-----------|
| 2.0.x   | ✅ Sim    |
| 1.0.x   | ✅ Sim    |
| < 1.0   | ❌ Não    |

---

## Reportando uma Vulnerabilidade

Se você descobrir uma vulnerabilidade de segurança no ReamurCMS, siga o processo de divulgação responsável:

1. **NÃO** abra uma issue pública
2. Envie um e-mail para `security@reamurcms.com` com o assunto: `[SECURITY] Breve descrição`
3. Inclua todos os detalhes relevantes sobre a vulnerabilidade
4. Aguarde confirmação antes de qualquer divulgação pública

### O que Incluir no Relatório

- **Tipo de vulnerabilidade** (ex: SQL Injection, XSS, CSRF, RCE)
- **Módulo afetado** (ex: E-commerce, Cursos, Painel Admin)
- **Caminho(s) do(s) arquivo(s) afetado(s)**
- **Passos para reproduzir** a vulnerabilidade
- **Avaliação do impacto potencial**
- **Sugestão de correção** (se houver)
- **Código de prova de conceito** (se aplicável)

---

## Prazo de Resposta

| Etapa              | Prazo       |
|--------------------|-------------|
| Confirmação        | 48 horas    |
| Avaliação inicial  | 7 dias      |
| Atualização de status | 14 dias  |
| Implantação da correção | Depende da severidade |

### Níveis de Severidade

| Nível    | Descrição                                         | Prazo para Correção |
|----------|---------------------------------------------------|---------------------|
| Crítico  | Execução remota de código, comprometimento total  | 24–72 horas         |
| Alto     | Bypass de autenticação, vazamento de dados        | 7 dias              |
| Médio    | Escalação de privilégios, exposição de dados      | 30 dias             |
| Baixo    | Divulgação de informação menor, baixo impacto     | 90 dias             |

---

## Boas Práticas de Segurança em Implantações

### Após a Instalação
- Altere as credenciais de admin padrão imediatamente
- Remova o diretório `install/`
- Configure permissões de arquivo corretamente (veja `INSTALLATION.md`)
- Habilite HTTPS/SSL para todo o tráfego

### Rotinas
- Mantenha o ReamurCMS atualizado para a versão estável mais recente
- Monitore os logs do servidor regularmente
- Use senhas fortes e considere 2FA para contas admin
- Restrinja o acesso ao painel admin por IP, se possível
- Mantenha o PHP e o software do servidor atualizados

### Hardening de Configuração

```php
// config.php — configurações recomendadas para produção
$_['error_display'] = 0;        // Desabilitar exibição de erros
$_['error_log']     = 1;        // Manter log habilitado
$_['error_filename'] = 'error.log';
```

---

## Reconhecimento

Contribuidores que reportarem responsavelmente vulnerabilidades válidas serão:

- Creditados no `CHANGELOG.md` na release correspondente
- Adicionados ao Hall da Fama de Segurança (se desejarem)

Somos gratos a todos os pesquisadores de segurança que ajudam a manter o ReamurCMS seguro.

---

## Contato

- **E-mail de segurança:** `security@reamurcms.com`
- **GitHub Security Advisories:** [Reporte aqui](https://github.com/davidcreator/reamurcms/security/advisories/new)
