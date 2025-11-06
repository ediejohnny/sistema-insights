# Quadro de Insights Rápidos

Sistema de gerenciamento de insights pessoais desenvolvido com Laravel 12, Livewire 3, Volt e Alpine.js.

---

# Como instalar

### Windows 10

#### Pré-requisitos:

1. **PHP 8.2 ou superior**

   - Baixe em: https://windows.php.net/download
   - Extraia em C:\php
   - Adicione C:\php ao PATH do sistema
   - Habilite extensões no php.ini:
     - extension=pdo_sqlite
     - extension=mbstring
     - extension=openssl
     - extension=curl
2. **Composer**

   - Baixe em: https://getcomposer.org/download/
   - Execute o instalador
3. **Node.js 18 ou superior**

   - Baixe em: https://nodejs.org/
   - Execute o instalador

#### Instalação:

```powershell
# 1. Instalar dependências PHP
composer install

# 2. Instalar dependências Node.js
npm install

# 3. Configurar ambiente
copy .env.example .env
php artisan key:generate

# 4. Compilar assets
npm run build

# 5. Iniciar servidor
php artisan serve
```

Acesse: **http://localhost:8000**

---

### Ubuntu 24.04

#### Pré-requisitos:

```bash
# 1. Atualizar sistema
sudo apt update && sudo apt upgrade -y

# 2. Instalar PHP 8.2 e extensões
sudo apt install -y php8.2 php8.2-cli php8.2-common php8.2-curl php8.2-mbstring php8.2-xml php8.2-zip php8.2-sqlite3

# 3. Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# 4. Instalar Node.js 18
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs
```

#### Instalação:

```bash
# 1. Instalar dependências PHP
composer install

# 2. Instalar dependências Node.js
npm install

# 3. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 4. Compilar assets
npm run build

# 5. Iniciar servidor
php artisan serve
```

Acesse: **http://localhost:8000**
