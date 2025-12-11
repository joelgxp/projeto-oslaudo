# OSLaudo

Sistema de gestão de laudos desenvolvido com Laravel 10.

## Requisitos

- PHP >= 8.1
- Composer
- MySQL >= 5.7 ou MariaDB >= 10.3
- Extensões PHP: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## Instalação

1. Clone o repositório:
```bash
git clone <url-do-repositorio>
cd assina-documentos
```

2. Instale as dependências:
```bash
composer install
```

3. Configure o ambiente:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure o banco de dados no arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oslaudo
DB_USERNAME=root
DB_PASSWORD=
```

5. Crie o banco de dados MySQL:
```sql
CREATE DATABASE oslaudo;
```

6. Execute as migrações:
```bash
php artisan migrate
```

## Configuração do Servidor

### XAMPP

O projeto está configurado para rodar no XAMPP. Acesse:
```
http://localhost/assina-documentos/public
```

Certifique-se de que o Apache está configurado para permitir o mod_rewrite.

## Comandos Úteis

- Iniciar servidor de desenvolvimento:
```bash
php artisan serve
```

- Executar migrações:
```bash
php artisan migrate
```

- Criar uma nova migration:
```bash
php artisan make:migration nome_da_migration
```

- Criar um novo controller:
```bash
php artisan make:controller NomeController
```

- Criar um novo model:
```bash
php artisan make:model NomeModel
```

## Estrutura do Projeto

```
assina-documentos/
├── app/                # Código da aplicação
├── bootstrap/          # Arquivos de inicialização
├── config/             # Arquivos de configuração
├── database/           # Migrações e seeds
├── public/             # Ponto de entrada público
├── resources/          # Views, assets, etc.
├── routes/             # Rotas da aplicação
├── storage/            # Arquivos de armazenamento
├── tests/              # Testes automatizados
└── vendor/             # Dependências do Composer
```

## Tecnologias

- **Laravel 10** - Framework PHP
- **MySQL** - Banco de dados
- **Composer** - Gerenciador de dependências

## Licença

Este projeto é open-source e está disponível sob a [licença MIT](https://opensource.org/licenses/MIT).
