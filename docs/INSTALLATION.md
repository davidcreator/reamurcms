# 🔧 Installation Guide / Guia de Instalação

> 🌐 **Language / Idioma:** [English](#english) | [Português Brasil](#português-brasil)

---

<a name="english"></a>

## 🇺🇸 English

This guide will help you set up ReamurCMS on your local machine or production server.

---

## 📋 Prerequisites

Before you begin, make sure you have the following installed:

### Required

| Tool          | Minimum Version | Download |
|---------------|-----------------|----------|
| PHP           | 8.0+            | [php.net](https://www.php.net/downloads) |
| MySQL/MariaDB | 5.7+ / 10.3+    | [mysql.com](https://dev.mysql.com/downloads/) |
| Composer      | 2.0+            | [getcomposer.org](https://getcomposer.org/) |
| Git           | 2.30+           | [git-scm.com](https://git-scm.com/downloads) |

### Required PHP Extensions

- `mysqli` or `pdo_mysql`
- `mbstring`
- `gd`
- `curl`
- `zip`
- `openssl`

### Optional (for frontend development)

| Tool    | Minimum Version | Download |
|---------|-----------------|----------|
| Node.js | 16+             | [nodejs.org](https://nodejs.org/) |
| NPM     | 8+              | Included with Node.js |

---

## 🚀 Step-by-Step Installation

### Method 1 — Manual Installation

**1. Clone the Repository**

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

**2. Install PHP Dependencies**

```bash
cd system/storage
composer install
cd ../..
```

**3. Create the Database**

```sql
CREATE DATABASE reamurcms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**4. Copy Configuration Files**

```bash
cp config-dist.php config.php
cp admin/config-dist.php admin/config.php
```

**5. Edit the Configuration Files**

Open `config.php` and `admin/config.php` and set your database credentials:

```php
$_['db_engine']    = 'mysqli';
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'your_user';
$_['db_password']  = 'your_password';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

**6. Set File Permissions**

```bash
# Linux/macOS
chmod 755 -R .
chmod 644 config.php admin/config.php
chmod 777 -R system/storage/cache
chmod 777 -R system/storage/logs
chmod 777 -R image/
```

**7. Run the Installer**

Open your browser and navigate to:

```
http://your-domain.com/install
```

Follow the on-screen instructions to complete the setup.

**8. Remove the Install Directory**

```bash
rm -rf install/
```

---

### Method 2 — Using Docker

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
```

Access at: `http://localhost:8080`

The Docker setup automatically configures the database, web server, and PHP environment.

---

### Method 3 — Using NPM

```bash
npm install -g reamur-cms
reamur-cms create my-project
cd my-project
npm run dev
```

---

## 🌐 Web Server Configuration

### Apache

Enable `mod_rewrite` and use the included `.htaccess` file:

```bash
a2enmod rewrite
service apache2 restart
```

Make sure `AllowOverride All` is set for your project directory in your Apache virtual host.

### Nginx

Use the following configuration block:

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/reamurcms;
    index index.php;

    location / {
        try_files $uri $uri/ @rewrite;
    }

    location @rewrite {
        rewrite ^(.*)$ /index.php?_route_=$1 last;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires max;
        log_not_found off;
    }
}
```

---

## ⚙️ Environment Configuration

### Database
```php
$_['db_engine']    = 'mysqli'; // mysqli, pdo or pgsql
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'username';
$_['db_password']  = 'password';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

### Email
```php
$_['mail_engine']        = 'smtp';
$_['mail_from']          = 'your@email.com';
$_['mail_smtp_hostname'] = 'smtp.yourserver.com';
$_['mail_smtp_username'] = 'your@email.com';
$_['mail_smtp_password'] = 'your_password';
$_['mail_smtp_port']     = 587;
```

### Cache
```php
$_['cache_engine'] = 'file'; // file, redis, memcached
$_['cache_expire'] = 3600;
```

---

## ✅ Post-Installation Checklist

- [ ] Admin panel accessible at `/admin`
- [ ] Default admin credentials changed
- [ ] `install/` directory removed
- [ ] File permissions reviewed
- [ ] Email configuration tested
- [ ] SSL/HTTPS configured (recommended for production)
- [ ] Cache engine configured
- [ ] Desired modules enabled

---

## 🔄 Updates

Keep your installation up to date:

```bash
git fetch origin
git pull origin main
cd system/storage
composer install
```

After updating, clear the cache from the admin panel under **System > Tools > Cache**.

---

## ❓ Common Issues

**Permission denied errors (Linux/macOS)**
```bash
sudo chmod 777 -R system/storage/cache
sudo chmod 777 -R system/storage/logs
sudo chmod 777 -R image/
```

**Blank page after installation**

Check PHP error logs and ensure all required PHP extensions are enabled.

**Database connection error**

Double-check credentials in `config.php`. Ensure the MySQL user has full privileges on the database.

**Admin panel returns 404**

Ensure `mod_rewrite` is enabled (Apache) or Nginx rewrite rules are applied.

---

## 📞 Need Help?

- 📖 Check the [FAQ](./FAQ.md)
- 🐛 Open an [Issue](https://github.com/davidcreator/reamurcms/issues)
- 💬 Join the [Discord](https://discord.gg/seu-link-aqui)

---
---

<a name="português-brasil"></a>

## 🇧🇷 Português Brasil

Este guia ajudará você a configurar o ReamurCMS em sua máquina local ou servidor de produção.

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados:

### Obrigatórios

| Ferramenta    | Versão Mínima | Download |
|---------------|---------------|----------|
| PHP           | 8.0+          | [php.net](https://www.php.net/downloads) |
| MySQL/MariaDB | 5.7+ / 10.3+  | [mysql.com](https://dev.mysql.com/downloads/) |
| Composer      | 2.0+          | [getcomposer.org](https://getcomposer.org/) |
| Git           | 2.30+         | [git-scm.com](https://git-scm.com/downloads) |

### Extensões PHP Obrigatórias

- `mysqli` ou `pdo_mysql`
- `mbstring`
- `gd`
- `curl`
- `zip`
- `openssl`

### Opcionais (para desenvolvimento frontend)

| Ferramenta | Versão Mínima | Download |
|------------|---------------|----------|
| Node.js    | 16+           | [nodejs.org](https://nodejs.org/) |
| NPM        | 8+            | Incluso com Node.js |

---

## 🚀 Instalação Passo a Passo

### Método 1 — Instalação Manual

**1. Clone o Repositório**

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
```

**2. Instale as Dependências PHP**

```bash
cd system/storage
composer install
cd ../..
```

**3. Crie o Banco de Dados**

```sql
CREATE DATABASE reamurcms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**4. Copie os Arquivos de Configuração**

```bash
cp config-dist.php config.php
cp admin/config-dist.php admin/config.php
```

**5. Edite os Arquivos de Configuração**

Abra `config.php` e `admin/config.php` e configure suas credenciais de banco de dados:

```php
$_['db_engine']    = 'mysqli';
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'seu_usuario';
$_['db_password']  = 'sua_senha';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

**6. Configure as Permissões de Arquivo**

```bash
# Linux/macOS
chmod 755 -R .
chmod 644 config.php admin/config.php
chmod 777 -R system/storage/cache
chmod 777 -R system/storage/logs
chmod 777 -R image/
```

**7. Execute o Instalador**

Abra seu navegador e acesse:

```
http://seu-dominio.com/install
```

Siga as instruções na tela para concluir a configuração.

**8. Remova o Diretório de Instalação**

```bash
rm -rf install/
```

---

### Método 2 — Usando Docker

```bash
git clone https://github.com/davidcreator/reamurcms.git
cd reamur
docker-compose up -d
```

Acesse em: `http://localhost:8080`

A configuração Docker define automaticamente o banco de dados, servidor web e ambiente PHP.

---

### Método 3 — Usando NPM

```bash
npm install -g reamur-cms
reamur-cms create meu-projeto
cd meu-projeto
npm run dev
```

---

## 🌐 Configuração do Servidor Web

### Apache

Ative o `mod_rewrite` e use o arquivo `.htaccess` incluído:

```bash
a2enmod rewrite
service apache2 restart
```

Certifique-se de que `AllowOverride All` esteja definido para o diretório do projeto no virtual host Apache.

### Nginx

Use o seguinte bloco de configuração:

```nginx
server {
    listen 80;
    server_name seu-dominio.com;
    root /var/www/reamurcms;
    index index.php;

    location / {
        try_files $uri $uri/ @rewrite;
    }

    location @rewrite {
        rewrite ^(.*)$ /index.php?_route_=$1 last;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
        expires max;
        log_not_found off;
    }
}
```

---

## ⚙️ Configuração do Ambiente

### Banco de Dados
```php
$_['db_engine']    = 'mysqli'; // mysqli, pdo ou pgsql
$_['db_hostname']  = 'localhost';
$_['db_username']  = 'usuario';
$_['db_password']  = 'senha';
$_['db_database']  = 'reamurcms';
$_['db_port']      = 3306;
```

### E-mail
```php
$_['mail_engine']        = 'smtp';
$_['mail_from']          = 'seu@email.com';
$_['mail_smtp_hostname'] = 'smtp.seuservidor.com';
$_['mail_smtp_username'] = 'seu@email.com';
$_['mail_smtp_password'] = 'sua_senha';
$_['mail_smtp_port']     = 587;
```

### Cache
```php
$_['cache_engine'] = 'file'; // file, redis, memcached
$_['cache_expire'] = 3600;
```

---

## ✅ Checklist Pós-Instalação

- [ ] Painel admin acessível em `/admin`
- [ ] Credenciais de admin padrão alteradas
- [ ] Diretório `install/` removido
- [ ] Permissões de arquivo revisadas
- [ ] Configuração de e-mail testada
- [ ] SSL/HTTPS configurado (recomendado para produção)
- [ ] Engine de cache configurada
- [ ] Módulos desejados ativados

---

## 🔄 Atualizações

Mantenha sua instalação atualizada:

```bash
git fetch origin
git pull origin main
cd system/storage
composer install
```

Após atualizar, limpe o cache pelo painel admin em **Sistema > Ferramentas > Cache**.

---

## ❓ Problemas Comuns

**Erro de permissão (Linux/macOS)**
```bash
sudo chmod 777 -R system/storage/cache
sudo chmod 777 -R system/storage/logs
sudo chmod 777 -R image/
```

**Página em branco após instalação**

Verifique os logs de erro do PHP e certifique-se de que todas as extensões PHP necessárias estejam habilitadas.

**Erro de conexão com banco de dados**

Verifique as credenciais no `config.php`. Certifique-se de que o usuário MySQL tenha privilégios completos no banco de dados.

**Painel admin retorna 404**

Certifique-se de que `mod_rewrite` está ativo (Apache) ou que as regras de rewrite do Nginx estão aplicadas.

---

## 📞 Precisa de Ajuda?

- 📖 Consulte o [FAQ](./FAQ.md)
- 🐛 Abra uma [Issue](https://github.com/davidcreator/reamurcms/issues)
- 💬 Entre no [Discord](https://discord.gg/seu-link-aqui)
