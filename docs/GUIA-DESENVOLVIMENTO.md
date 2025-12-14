# 🛠️ Guia de Desenvolvimento - OSLaudos

Este guia mostra como iniciar o projeto em **modo de desenvolvimento** com hot reload e todas as ferramentas necessárias.

---

## 🚀 Iniciar o Projeto em Modo Dev

Para desenvolvimento, você precisa rodar **dois servidores simultaneamente**:

1. **Servidor Laravel** (backend)
2. **Servidor Vite** (frontend - hot reload)

---

## 📋 Pré-requisitos

Certifique-se de ter:
- ✅ XAMPP rodando (Apache e MySQL)
- ✅ Composer instalado
- ✅ Node.js e NPM instalados
- ✅ Dependências instaladas (`composer install` e `npm install`)

---

## 🔧 Configuração Inicial

### 1. Verificar configurações do `.env`

Certifique-se de que seu arquivo `.env` está configurado para desenvolvimento:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Ou se usar XAMPP:
# APP_URL=http://localhost/assina-documentos/public
```

### 2. Instalar dependências (se ainda não fez)

```bash
# Dependências PHP
composer install

# Dependências Node.js
npm install
```

---

## 🎯 Iniciar em Modo Desenvolvimento

### Opção 1: Usando dois terminais (Recomendado)

#### Terminal 1 - Servidor Laravel:
```bash
php artisan serve
```
Isso iniciará o servidor em: `http://localhost:8000`

#### Terminal 2 - Servidor Vite (Hot Reload):
```bash
npm run dev
```
Isso iniciará o Vite em: `http://localhost:5173` (porta padrão do Vite)

**Acesse:** `http://localhost:8000`

---

### Opção 2: Usando XAMPP + Vite

Se preferir usar o Apache do XAMPP:

#### Terminal 1 - Verificar XAMPP:
- Certifique-se de que Apache e MySQL estão rodando

#### Terminal 2 - Servidor Vite:
```bash
npm run dev
```

**Acesse:** `http://localhost/assina-documentos/public`

---

## 🔥 Hot Reload com Vite

O Vite fornece **hot module replacement (HMR)**, ou seja:

- ✅ Mudanças em arquivos CSS/JS são aplicadas **instantaneamente** sem recarregar a página
- ✅ Mudanças em arquivos Blade também são detectadas e a página recarrega automaticamente
- ✅ Não precisa fazer refresh manual no navegador

### Arquivos monitorados pelo Vite:
- `resources/css/app.css`
- `resources/js/app.js`
- `resources/js/bootstrap.js`
- Arquivos Blade (com `refresh: true` configurado)

---

## 📝 Scripts Disponíveis

### NPM Scripts:

```bash
# Iniciar servidor de desenvolvimento (hot reload)
npm run dev

# Compilar assets para produção
npm run build

# Compilar e assistir mudanças
npm run build -- --watch
```

### Artisan Commands:

```bash
# Iniciar servidor de desenvolvimento
php artisan serve

# Limpar todos os caches
php artisan optimize:clear

# Limpar cache específico
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recarregar configurações
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🎨 Estrutura de Assets

```
resources/
├── css/
│   └── app.css          # Estilos principais
├── js/
│   ├── app.js           # JavaScript principal
│   └── bootstrap.js     # Configuração Axios
└── views/               # Templates Blade
```

Os assets são compilados pelo Vite e servidos automaticamente em desenvolvimento.

---

## 🔍 Verificando se está funcionando

### 1. Verificar servidor Laravel:
- Acesse: `http://localhost:8000`
- Deve carregar a página sem erros

### 2. Verificar Vite:
- No terminal onde rodou `npm run dev`, você deve ver:
  ```
  VITE v4.x.x  ready in xxx ms

  ➜  Local:   http://localhost:5173/
  ➜  Network: use --host to expose
  ```

### 3. Verificar Hot Reload:
- Faça uma alteração em `resources/css/app.css`
- A página deve atualizar automaticamente sem refresh manual

---

## 🐛 Solução de Problemas

### Erro: "Vite manifest not found"
**Solução:**
```bash
npm run dev
```
O Vite precisa estar rodando em desenvolvimento.

### Erro: "Port 5173 already in use"
**Solução:** O Vite está tentando usar uma porta que já está em uso.
- Feche outros processos usando a porta 5173
- Ou configure outra porta no `vite.config.js`:
  ```js
  export default defineConfig({
      server: {
          port: 5174
      },
      // ... resto da config
  });
  ```

### Erro: "Port 8000 already in use"
**Solução:** Outro processo está usando a porta 8000.
```bash
# Use outra porta
php artisan serve --port=8001
```

### Hot reload não funciona
**Solução:**
1. Verifique se o Vite está rodando (`npm run dev`)
2. Limpe o cache do navegador
3. Verifique se o `vite.config.js` tem `refresh: true`:
   ```js
   laravel({
       input: ['resources/css/app.css', 'resources/js/app.js'],
       refresh: true,  // ← Isso deve estar true
   })
   ```

### Assets não carregam
**Solução:**
1. Certifique-se de que o Vite está rodando
2. Verifique se as views estão usando `@vite()` (se aplicável)
3. Limpe o cache:
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

---

## 🚀 Workflow de Desenvolvimento Recomendado

### Início do dia:
```bash
# 1. Iniciar XAMPP (Apache e MySQL)
# 2. Abrir dois terminais no diretório do projeto

# Terminal 1:
php artisan serve

# Terminal 2:
npm run dev
```

### Durante o desenvolvimento:
- Edite arquivos normalmente
- O Vite detecta mudanças automaticamente
- A página atualiza sozinha (hot reload)

### Fim do dia:
- Pressione `Ctrl+C` nos terminais para parar os servidores
- Não precisa fazer nada mais

---

## 📦 Build para Produção

Quando estiver pronto para produção:

```bash
# Compilar assets otimizados
npm run build

# Isso criará os arquivos em public/build/
```

**Importante:** Em produção, o Vite não precisa estar rodando. Os assets compilados são servidos diretamente.

---

## 🎯 Dicas de Desenvolvimento

1. **Mantenha ambos os servidores rodando** durante o desenvolvimento
2. **Use o DevTools do navegador** para debug
3. **Verifique o console** do terminal do Vite para ver erros de compilação
4. **Limpe o cache** se algo estiver estranho: `php artisan optimize:clear`
5. **Use `php artisan tinker`** para testar código rapidamente

---

## 🧪 Testes e Documentação

### ⚠️ ATUALIZAÇÃO OBRIGATÓRIA DE TESTES

**Sempre que implementar ou alterar funcionalidades, você DEVE atualizar o documento de testes!**

### Documentos de Testes (pasta `docs/`):

- **[TESTES-REGRESSAO-COMPLETO.md](./TESTES-REGRESSAO-COMPLETO.md)**  
  Documento principal com 80+ casos de teste organizados por módulo

- **[GUIA-MANUTENCAO-TESTES.md](./GUIA-MANUTENCAO-TESTES.md)**  
  Guia completo de como manter o documento atualizado

- **[PROCESSO-ATUALIZACAO-TESTES.md](./PROCESSO-ATUALIZACAO-TESTES.md)**  
  Checklist rápido e processo de atualização

- **[CHANGELOG-TESTES.md](./CHANGELOG-TESTES.md)**  
  Histórico de todas as atualizações do documento

- **[README-TESTES.md](./README-TESTES.md)**  
  Índice e visão geral dos documentos de teste

### Processo Rápido:

1. **Implementou algo?** → Adicionar/atualizar casos de teste
2. **Corrigiu bug?** → Adicionar teste que valida correção
3. **Alterou comportamento?** → Atualizar casos existentes
4. **Sempre:** → Atualizar CHANGELOG-TESTES.md

📖 **Consulte `PROCESSO-ATUALIZACAO-TESTES.md` para o checklist completo!**

---

## 📚 Recursos Adicionais

- [Documentação do Laravel](https://laravel.com/docs)
- [Documentação do Vite](https://vitejs.dev/)
- [Laravel Vite Plugin](https://laravel.com/docs/vite)

---

**Bom desenvolvimento! 🚀**

