# 🧪 PLANO DE TESTES DE REGRESSÃO - OSLaudos

**Versão do Sistema:** 1.0  
**Data de Criação:** 15/12/2024  
**Última Atualização:** 15/12/2024

> 📝 **IMPORTANTE:** Este documento deve ser atualizado sempre que houver mudanças ou novas implementações no sistema.  
> 
> 📖 **Consulte:**
> - `GUIA-MANUTENCAO-TESTES.md` - Instruções completas de atualização
> - `PROCESSO-ATUALIZACAO-TESTES.md` - Checklist rápido e processo
> - `CHANGELOG-TESTES.md` - Histórico de atualizações

---

## 📋 ÍNDICE

1. [Testes de Autenticação](#1-testes-de-autenticação)
2. [Testes de Gestão de Clientes](#2-testes-de-gestão-de-clientes)
3. [Testes de Gestão de Serviços](#3-testes-de-gestão-de-serviços)
4. [Testes de Execução de Serviços](#4-testes-de-execução-de-serviços)
5. [Testes de Geração de Laudos](#5-testes-de-geração-de-laudos)
6. [Testes de Assinatura Digital](#6-testes-de-assinatura-digital)
7. [Testes de Gestão de Usuários/Técnicos](#7-testes-de-gestão-de-usuáriostécnicos)
8. [Testes de Perfil do Usuário](#8-testes-de-perfil-do-usuário)
9. [Testes de Dashboard](#9-testes-de-dashboard)
10. [Testes de Permissões RBAC](#10-testes-de-permissões-rbac)
11. [Testes de Responsividade Mobile](#11-testes-de-responsividade-mobile)
12. [Testes de Validações e Segurança](#12-testes-de-validações-e-segurança)
13. [Testes de Integração](#13-testes-de-integração)

---

## 1. TESTES DE AUTENTICAÇÃO

### TC-AUTH-001: Login com Credenciais Válidas
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Usuário cadastrado no sistema

**Passos:**
1. Acessar `/login`
2. Preencher email válido
3. Preencher senha correta
4. Clicar em "Entrar"

**Resultado Esperado:**
- ✅ Redirecionamento para `/dashboard`
- ✅ Mensagem de boas-vindas visível
- ✅ Sidebar e topbar aparecem
- ✅ Sessão criada corretamente

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-AUTH-002: Login com Credenciais Inválidas
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar `/login`
2. Preencher email inválido ou não cadastrado
3. Preencher senha incorreta
4. Clicar em "Entrar"

**Resultado Esperado:**
- ✅ Mensagem de erro: "Credenciais inválidas"
- ✅ Permanece na página de login
- ✅ Campos não são limpos (exceto senha)

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-AUTH-003: Logout
**Prioridade:** 🔴 Crítica

**Passos:**
1. Estar logado no sistema
2. Clicar em "Sair" no menu do usuário
3. Confirmar logout

**Resultado Esperado:**
- ✅ Redirecionamento para `/login`
- ✅ Sessão encerrada
- ✅ Não é possível acessar rotas protegidas

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-AUTH-004: Proteção de Rotas (Usuário Não Autenticado)
**Prioridade:** 🟡 Alta

**Passos:**
1. Fazer logout (ou não estar logado)
2. Tentar acessar diretamente `/dashboard`
3. Tentar acessar `/clientes`
4. Tentar acessar `/servicos`

**Resultado Esperado:**
- ✅ Redirecionamento para `/login`
- ✅ Mensagem solicitando autenticação

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-AUTH-005: Sessão Expirada (Erro 419)
**Prioridade:** 🟡 Alta

**Passos:**
1. Fazer login
2. Aguardar expiração da sessão (ou limpar cookies)
3. Tentar submeter um formulário

**Resultado Esperado:**
- ✅ Mensagem: "Sua sessão expirou. Por favor, tente novamente."
- ✅ Redirecionamento apropriado
- ✅ Dados do formulário preservados (exceto senha)

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 2. TESTES DE GESTÃO DE CLIENTES

### TC-CLIENTE-001: Criar Novo Cliente
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Usuário admin ou técnico logado

**Passos:**
1. Acessar `/clientes`
2. Clicar em "Novo Cliente"
3. Preencher todos os campos obrigatórios:
   - Nome: "João Silva"
   - Email: "joao@teste.com"
   - Telefone: "(11) 98765-4321"
   - Tipo Documento: CPF
   - Número Documento: "123.456.789-00"
   - CEP: "01310-100"
   - Endereço: "Av. Paulista, 1000"
   - Número: "1000"
   - Cidade: "São Paulo"
   - Estado: "SP"
4. Clicar em "Salvar Cliente"

**Resultado Esperado:**
- ✅ Cliente criado com sucesso
- ✅ Mensagem: "Cliente criado com sucesso!"
- ✅ Redirecionamento para lista de clientes
- ✅ Cliente aparece na listagem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-002: Validação de Campos Obrigatórios
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar `/clientes/create`
2. Tentar salvar sem preencher campos obrigatórios
3. Verificar mensagens de erro

**Resultado Esperado:**
- ✅ Mensagens de erro para cada campo obrigatório
- ✅ Formulário não é submetido
- ✅ Campos com erro destacados visualmente

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-003: Editar Cliente Existente
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar `/clientes`
2. Clicar em "Editar" em um cliente existente
3. Alterar nome e telefone
4. Salvar alterações

**Resultado Esperado:**
- ✅ Alterações salvas com sucesso
- ✅ Mensagem: "Cliente atualizado com sucesso!"
- ✅ Dados atualizados aparecem na listagem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-004: Visualizar Detalhes do Cliente
**Prioridade:** 🟢 Média

**Passos:**
1. Acessar `/clientes`
2. Clicar em "Ver" em um cliente
3. Verificar informações exibidas

**Resultado Esperado:**
- ✅ Todos os dados do cliente exibidos
- ✅ Histórico de serviços vinculados visível
- ✅ Botões de ação (Editar) presentes

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-005: Excluir Cliente (Sem Serviços Vinculados)
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar um cliente sem serviços
2. Acessar `/clientes`
3. Clicar em "Excluir"
4. Confirmar exclusão

**Resultado Esperado:**
- ✅ Mensagem de confirmação aparece
- ✅ Cliente excluído com sucesso
- ✅ Mensagem: "Cliente excluído com sucesso!"
- ✅ Cliente não aparece mais na listagem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-006: Tentar Excluir Cliente com Serviços Vinculados
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar um cliente
2. Criar um serviço vinculado a esse cliente
3. Tentar excluir o cliente

**Resultado Esperado:**
- ✅ Mensagem de erro: "Não é possível excluir cliente com serviços vinculados. Exclua os serviços primeiro."
- ✅ Cliente não é excluído
- ✅ Permanece na listagem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-007: Buscar Cliente
**Prioridade:** 🟢 Média

**Passos:**
1. Acessar `/clientes`
2. Usar campo de busca
3. Digitar nome de cliente existente

**Resultado Esperado:**
- ✅ Lista filtrada mostra apenas clientes que correspondem
- ✅ Busca funciona em tempo real ou após submit

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-CLIENTE-008: Paginação de Clientes
**Prioridade:** 🟢 Média

**Passos:**
1. Ter mais de 15 clientes cadastrados
2. Acessar `/clientes`
3. Navegar para próxima página

**Resultado Esperado:**
- ✅ Paginação funciona corretamente
- ✅ Links de página aparecem
- ✅ Dados carregam corretamente em cada página

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 3. TESTES DE GESTÃO DE SERVIÇOS

### TC-SERVICO-001: Criar Nova Ordem de Serviço
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Cliente e técnico cadastrados

**Passos:**
1. Acessar `/servicos`
2. Clicar em "Nova Ordem de Serviço"
3. Preencher campos:
   - Cliente: Selecionar cliente existente
   - Técnico: Selecionar técnico existente
   - Tipo de Serviço: "Dedetização"
   - Data Agendada: Data futura
   - Hora Início: "09:00"
   - Endereço: "Av. Paulista, 1000"
   - Descrição: "Serviço de dedetização residencial"
4. Clicar em "Salvar"

**Resultado Esperado:**
- ✅ Serviço criado com sucesso
- ✅ Status inicial: "Agendado"
- ✅ Aparece na listagem de serviços
- ✅ Técnico recebe o serviço atribuído

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-002: Criar OS sem Técnico Cadastrado
**Prioridade:** 🟡 Alta

**Passos:**
1. Garantir que não há técnicos cadastrados
2. Acessar `/servicos/create`
3. Verificar seletor de técnico

**Resultado Esperado:**
- ✅ Mensagem: "⚠️ Nenhum técnico cadastrado"
- ✅ Link para cadastrar técnico visível
- ✅ Seletor mostra "Nenhum técnico cadastrado"

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-003: Editar Ordem de Serviço
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar `/servicos`
2. Clicar em "Editar" em um serviço
3. Alterar tipo de serviço e data
4. Salvar

**Resultado Esperado:**
- ✅ Alterações salvas
- ✅ Dados atualizados na visualização

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-004: Visualizar Detalhes do Serviço
**Prioridade:** 🟢 Média

**Passos:**
1. Acessar `/servicos`
2. Clicar em "Ver" em um serviço
3. Verificar informações exibidas

**Resultado Esperado:**
- ✅ Dados do serviço completos
- ✅ Informações do cliente
- ✅ Informações do técnico
- ✅ Botões de ação apropriados (Editar, Executar)

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-005: Excluir Serviço (Sem Laudos)
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar um serviço sem laudos
2. Acessar `/servicos`
3. Clicar em "Excluir"
4. Confirmar exclusão

**Resultado Esperado:**
- ✅ Confirmação solicitada
- ✅ Serviço excluído com sucesso
- ✅ Não aparece mais na listagem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-006: Tentar Excluir Serviço com Laudos
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar serviço
2. Gerar laudo para o serviço
3. Tentar excluir o serviço

**Resultado Esperado:**
- ✅ Mensagem: "Não é possível excluir serviço com laudos vinculados. Exclua os laudos primeiro."
- ✅ Serviço não é excluído

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-007: Filtrar Serviços por Técnico (Admin)
**Prioridade:** 🟢 Média

**Passos:**
1. Login como admin
2. Acessar `/servicos`
3. Usar filtro por técnico
4. Selecionar um técnico

**Resultado Esperado:**
- ✅ Lista mostra apenas serviços do técnico selecionado
- ✅ Filtro funciona corretamente

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SERVICO-008: Técnico Vê Apenas Seus Serviços
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico
2. Acessar `/servicos`
3. Verificar listagem

**Resultado Esperado:**
- ✅ Apenas serviços atribuídos ao técnico aparecem
- ✅ Não aparecem serviços de outros técnicos
- ✅ Filtro por técnico não aparece (não é necessário)

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 4. TESTES DE EXECUÇÃO DE SERVIÇOS

### TC-EXECUCAO-001: Acessar Página de Execução
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Serviço agendado atribuído ao técnico

**Passos:**
1. Login como técnico
2. Acessar serviço atribuído
3. Clicar em "Executar"

**Resultado Esperado:**
- ✅ Página de execução carrega
- ✅ Formulário de checklist visível
- ✅ Campos de fotos, problemas, recomendações presentes
- ✅ Canvas de assinatura funcional

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-002: Preencher Checklist
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar página de execução
2. Marcar 3 itens do checklist
3. Verificar estado dos checkboxes

**Resultado Esperado:**
- ✅ Checkboxes respondem ao toque/clique
- ✅ Estado visual claro (marcado/não marcado)
- ✅ Valores são preservados ao recarregar

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-003: Upload de Fotos
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar página de execução
2. Clicar em "Fotos"
3. Selecionar 2-3 imagens
4. Verificar upload

**Resultado Esperado:**
- ✅ Campo aceita múltiplas imagens
- ✅ Fotos são enviadas com sucesso
- ✅ Preview das fotos aparece (se implementado)
- ✅ Fotos são salvas no storage

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-004: Assinatura Digital no Canvas
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar página de execução
2. Desenhar assinatura no canvas (mouse ou touch)
3. Verificar desenho

**Resultado Esperado:**
- ✅ Canvas responde a mouse/touch
- ✅ Linha aparece ao desenhar
- ✅ Linha tem espessura adequada (3px)
- ✅ Assinatura é preservada ao redimensionar janela

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-005: Limpar Assinatura
**Prioridade:** 🟢 Média

**Passos:**
1. Desenhar assinatura no canvas
2. Clicar em "Limpar Assinatura"

**Resultado Esperado:**
- ✅ Canvas é limpo completamente
- ✅ Campo hidden é resetado
- ✅ Pode desenhar nova assinatura

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-006: Salvar Execução Completa
**Prioridade:** 🔴 Crítica

**Passos:**
1. Preencher checklist (3 itens)
2. Adicionar texto em "Problemas Encontrados"
3. Adicionar texto em "Recomendações"
4. Fazer upload de 2 fotos
5. Desenhar assinatura
6. Clicar em "Salvar Execução"

**Resultado Esperado:**
- ✅ Execução salva com sucesso
- ✅ Status do serviço muda para "Concluído"
- ✅ Todos os dados são preservados
- ✅ Assinatura é salva como imagem
- ✅ Fotos são salvas no storage
- ✅ Redirecionamento para visualização do serviço

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-007: Editar Execução Existente
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar serviço com execução já salva
2. Clicar em "Editar Execução"
3. Modificar checklist
4. Adicionar mais fotos
5. Salvar

**Resultado Esperado:**
- ✅ Dados existentes são carregados
- ✅ Assinatura existente é exibida no canvas
- ✅ Alterações são salvas
- ✅ Dados antigos não são perdidos

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-008: Preservar Assinatura ao Redimensionar
**Prioridade:** 🟡 Alta

**Passos:**
1. Desenhar assinatura no canvas
2. Redimensionar janela do navegador (ou rotacionar mobile)
3. Verificar se assinatura permanece

**Resultado Esperado:**
- ✅ Assinatura é preservada após redimensionamento
- ✅ Não é apagada ao mudar orientação (mobile)
- ✅ Canvas mantém proporções corretas

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-009: Técnico Não Pode Executar Serviço de Outro Técnico
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico A
2. Tentar acessar `/servicos/{id}/executar` de serviço atribuído a técnico B

**Resultado Esperado:**
- ✅ Erro 403 (Forbidden)
- ✅ Mensagem: "Você só pode executar serviços atribuídos a você."

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-EXECUCAO-010: Admin Pode Executar Qualquer Serviço
**Prioridade:** 🟡 Alta

**Passos:**
1. Login como admin
2. Acessar serviço atribuído a qualquer técnico
3. Verificar se pode executar

**Resultado Esperado:**
- ✅ Admin pode acessar página de execução
- ✅ Pode salvar execução
- ✅ Não recebe erro 403

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 5. TESTES DE GERAÇÃO DE LAUDOS

### TC-LAUDO-001: Gerar Laudo PDF
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Serviço concluído com execução registrada

**Passos:**
1. Login como admin
2. Acessar serviço concluído
3. Clicar em "Gerar Laudo PDF"
4. Aguardar geração

**Resultado Esperado:**
- ✅ Laudo é gerado com sucesso
- ✅ PDF é criado no storage
- ✅ Mensagem: "Laudo gerado com sucesso!"
- ✅ Link para visualizar/download aparece

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-002: Gerar Laudo com Template Personalizado
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar template de laudo
2. Acessar serviço concluído
3. Selecionar template no dropdown
4. Gerar laudo

**Resultado Esperado:**
- ✅ Template é aplicado ao laudo
- ✅ Variáveis são substituídas corretamente
- ✅ Formatação do template é preservada

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-003: Gerar Laudo sem Template (Padrão)
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar serviço concluído
2. Não selecionar template
3. Gerar laudo

**Resultado Esperado:**
- ✅ Laudo é gerado com template padrão
- ✅ Todas as informações do serviço aparecem
- ✅ PDF é válido e legível

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-004: Visualizar Laudo Gerado
**Prioridade:** 🟢 Média

**Passos:**
1. Gerar laudo
2. Clicar em "Ver" no laudo
3. Verificar visualização

**Resultado Esperado:**
- ✅ Laudo é exibido corretamente
- ✅ Todas as informações estão presentes
- ✅ Formatação está correta

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-005: Download de Laudo PDF
**Prioridade:** 🟡 Alta

**Passos:**
1. Gerar laudo
2. Clicar em "Baixar"
3. Verificar download

**Resultado Esperado:**
- ✅ Download inicia automaticamente
- ✅ Arquivo PDF é válido
- ✅ Pode ser aberto em leitor de PDF
- ✅ Nome do arquivo é apropriado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-006: Tentar Gerar Laudo sem Execução
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar serviço marcado como "Concluído" mas sem execução
2. Tentar gerar laudo

**Resultado Esperado:**
- ✅ Mensagem: "É necessário registrar a execução antes de gerar o laudo."
- ✅ Botão de gerar não aparece ou está desabilitado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-LAUDO-007: Enviar Laudo para Assinatura
**Prioridade:** 🔴 Crítica

**Passos:**
1. Gerar laudo
2. Clicar em "Enviar para Assinatura"
3. Verificar link gerado

**Resultado Esperado:**
- ✅ Link único é gerado
- ✅ Status do laudo muda para "Enviado"
- ✅ Link tem data de expiração (30 dias)
- ✅ Link é copiável ou exibido

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 6. TESTES DE ASSINATURA DIGITAL

### TC-ASSINATURA-001: Acessar Link de Assinatura
**Prioridade:** 🔴 Crítica

**Passos:**
1. Obter link único de assinatura
2. Acessar link em navegador (sem login)
3. Verificar página

**Resultado Esperado:**
- ✅ Página de assinatura carrega
- ✅ Dados do laudo são exibidos
- ✅ Canvas de assinatura está presente
- ✅ Não requer autenticação

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-ASSINATURA-002: Assinar Laudo com Canvas
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar link de assinatura
2. Desenhar assinatura no canvas
3. Clicar em "Assinar"

**Resultado Esperado:**
- ✅ Assinatura é salva
- ✅ Laudo é marcado como "Assinado"
- ✅ Mensagem de sucesso
- ✅ Histórico de assinatura é registrado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-ASSINATURA-003: Tentar Assinar Laudo Já Assinado
**Prioridade:** 🟡 Alta

**Passos:**
1. Assinar laudo
2. Tentar acessar link novamente
3. Tentar assinar novamente

**Resultado Esperado:**
- ✅ Mensagem: "Este laudo já foi assinado"
- ✅ Canvas desabilitado ou não aparece
- ✅ Data/hora da assinatura exibida

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-ASSINATURA-004: Link de Assinatura Expirado
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar laudo com link expirado (simular)
2. Tentar acessar link expirado

**Resultado Esperado:**
- ✅ Mensagem: "Link de assinatura expirado"
- ✅ Não permite assinar
- ✅ Sugestão de contatar administrador

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-ASSINATURA-005: Assinatura em Dispositivo Mobile
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar link de assinatura em mobile
2. Desenhar assinatura com dedo
3. Verificar funcionalidade

**Resultado Esperado:**
- ✅ Canvas responde a touch
- ✅ Linha aparece ao desenhar
- ✅ Assinatura é salva corretamente

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 7. TESTES DE GESTÃO DE USUÁRIOS/TÉCNICOS

### TC-USUARIO-001: Criar Novo Técnico
**Prioridade:** 🔴 Crítica  
**Pré-condições:** Login como admin

**Passos:**
1. Acessar Configurações > Usuários
2. Clicar em "Novo Usuário"
3. Preencher:
   - Nome: "José Técnico"
   - Email: "jose@teste.com"
   - Telefone: "(11) 98765-4321"
   - Papel: Técnico
   - Senha: "senha123"
   - Confirmar Senha: "senha123"
4. Salvar

**Resultado Esperado:**
- ✅ Técnico criado com sucesso
- ✅ Aparece na listagem
- ✅ Status: "Ativo"
- ✅ Aparece no seletor ao criar OS

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-USUARIO-002: Criar Novo Administrador
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar Configurações > Usuários
2. Criar usuário com papel "Administrador"
3. Salvar

**Resultado Esperado:**
- ✅ Admin criado com sucesso
- ✅ Pode fazer login
- ✅ Tem acesso a todas as funcionalidades

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-USUARIO-003: Validação de Email Único
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar usuário com email "teste@teste.com"
2. Tentar criar outro usuário com mesmo email

**Resultado Esperado:**
- ✅ Mensagem: "Este email já está em uso"
- ✅ Usuário não é criado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-USUARIO-004: Ativar/Desativar Usuário
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar Configurações > Usuários
2. Clicar em "Desativar" em um usuário ativo
3. Verificar status

**Resultado Esperado:**
- ✅ Status muda para "Inativo"
- ✅ Usuário não pode mais fazer login
- ✅ Botão muda para "Ativar"

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-USUARIO-005: Técnico Não Pode Acessar Gestão de Usuários
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico
2. Tentar acessar `/configuracoes/usuarios`

**Resultado Esperado:**
- ✅ Erro 403 (Forbidden)
- ✅ Ou link não aparece no menu

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 8. TESTES DE PERFIL DO USUÁRIO

### TC-PERFIL-001: Acessar Página de Perfil
**Prioridade:** 🟡 Alta

**Passos:**
1. Fazer login
2. Clicar em "Meu Perfil" no menu do usuário
3. Verificar página

**Resultado Esperado:**
- ✅ Página de perfil carrega
- ✅ Dados atuais são exibidos
- ✅ Formulário preenchido com dados do usuário

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-PERFIL-002: Atualizar Dados Pessoais
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar `/perfil`
2. Alterar nome e telefone
3. Salvar

**Resultado Esperado:**
- ✅ Dados atualizados com sucesso
- ✅ Mensagem: "Perfil atualizado com sucesso!"
- ✅ Alterações refletem no sistema

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-PERFIL-003: Alterar Senha
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar `/perfil`
2. Preencher senha atual
3. Preencher nova senha
4. Confirmar nova senha
5. Salvar

**Resultado Esperado:**
- ✅ Senha alterada com sucesso
- ✅ Pode fazer login com nova senha
- ✅ Não pode fazer login com senha antiga

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-PERFIL-004: Tentar Alterar Senha com Senha Atual Incorreta
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar `/perfil`
2. Preencher senha atual incorreta
3. Preencher nova senha
4. Tentar salvar

**Resultado Esperado:**
- ✅ Mensagem: "A senha atual está incorreta."
- ✅ Senha não é alterada

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-PERFIL-005: Validação de Email Único ao Editar
**Prioridade:** 🟡 Alta

**Passos:**
1. Ter dois usuários: A e B
2. Login como usuário A
3. Tentar alterar email para email do usuário B

**Resultado Esperado:**
- ✅ Mensagem: "Este email já está em uso"
- ✅ Email não é alterado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 9. TESTES DE DASHBOARD

### TC-DASHBOARD-001: Dashboard Admin
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como admin
2. Acessar `/dashboard`
3. Verificar informações exibidas

**Resultado Esperado:**
- ✅ Cards de estatísticas aparecem
- ✅ Total de clientes correto
- ✅ Total de serviços correto
- ✅ Serviços por status corretos
- ✅ Laudos gerados/assinados corretos
- ✅ Ações rápidas funcionais

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-DASHBOARD-002: Dashboard Técnico
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico
2. Acessar `/dashboard`
3. Verificar informações

**Resultado Esperado:**
- ✅ Mostra apenas serviços do técnico
- ✅ Cards: Hoje, Em Progresso, Concluídos
- ✅ Serviços de hoje listados
- ✅ Serviço atual destacado (se houver)
- ✅ Próximos serviços (7 dias)

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-DASHBOARD-003: Dashboard Técnico - Serviço em Andamento
**Prioridade:** 🟡 Alta

**Passos:**
1. Login como técnico
2. Iniciar execução de um serviço (status: em_progresso)
3. Acessar dashboard

**Resultado Esperado:**
- ✅ Card destacado "Serviço em Andamento" aparece
- ✅ Informações do serviço exibidas
- ✅ Botão "Continuar" funcional

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-DASHBOARD-004: Dashboard Técnico - Sem Serviços
**Prioridade:** 🟢 Média

**Passos:**
1. Login como técnico sem serviços atribuídos
2. Acessar dashboard

**Resultado Esperado:**
- ✅ Mensagem apropriada: "Nenhum serviço agendado"
- ✅ Interface não quebra
- ✅ Cards mostram zeros

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 10. TESTES DE PERMISSÕES RBAC

### TC-RBAC-001: Admin Acessa Todas as Funcionalidades
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como admin
2. Verificar acesso a:
   - Clientes (criar, editar, excluir)
   - Serviços (criar, editar, excluir)
   - Templates de Laudos
   - Relatórios
   - Configurações
   - Gestão de Usuários

**Resultado Esperado:**
- ✅ Todas as rotas acessíveis
- ✅ Todos os botões aparecem
- ✅ Nenhum erro 403

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-RBAC-002: Técnico Não Acessa Funcionalidades Admin
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico
2. Tentar acessar:
   - `/clientes/create`
   - `/laudo-templates`
   - `/relatorios`
   - `/configuracoes/usuarios`

**Resultado Esperado:**
- ✅ Erro 403 ou links não aparecem
- ✅ Sidebar não mostra opções admin

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-RBAC-003: Técnico Acessa Apenas Seus Serviços
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como técnico A
2. Criar serviço atribuído a técnico B (como admin)
3. Login como técnico A
4. Verificar listagem de serviços

**Resultado Esperado:**
- ✅ Técnico A não vê serviço do técnico B
- ✅ Apenas seus serviços aparecem

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-RBAC-004: Técnico Não Pode Criar/Editar/Excluir Clientes
**Prioridade:** 🟡 Alta

**Passos:**
1. Login como técnico
2. Tentar criar cliente
3. Tentar editar cliente
4. Tentar excluir cliente

**Resultado Esperado:**
- ✅ Erro 403 em todas as ações
- ✅ Botões não aparecem na interface

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-RBAC-005: Técnico Não Pode Criar/Editar/Excluir Serviços
**Prioridade:** 🟡 Alta

**Passos:**
1. Login como técnico
2. Tentar criar serviço
3. Tentar editar serviço
4. Tentar excluir serviço

**Resultado Esperado:**
- ✅ Erro 403 ou botões não aparecem
- ✅ Apenas pode visualizar e executar

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 11. TESTES DE RESPONSIVIDADE MOBILE

### TC-MOBILE-001: Layout Responsivo em Mobile (768px)
**Prioridade:** 🟡 Alta

**Passos:**
1. Abrir sistema em dispositivo mobile ou DevTools (375px-768px)
2. Navegar por todas as páginas principais
3. Verificar layout

**Resultado Esperado:**
- ✅ Layout se adapta corretamente
- ✅ Sidebar colapsável
- ✅ Botão hambúrguer aparece
- ✅ Cards em coluna única
- ✅ Tabelas com scroll horizontal

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-002: Checklist Touch-Friendly
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar execução de serviço em mobile
2. Marcar itens do checklist com dedo

**Resultado Esperado:**
- ✅ Checkboxes são fáceis de tocar (24px+)
- ✅ Área de toque adequada
- ✅ Feedback visual claro

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-003: Canvas de Assinatura em Mobile
**Prioridade:** 🔴 Crítica

**Passos:**
1. Acessar execução em mobile
2. Desenhar assinatura com dedo
3. Verificar funcionalidade

**Resultado Esperado:**
- ✅ Canvas responde a touch
- ✅ Linha aparece ao desenhar
- ✅ Não há scroll durante desenho
- ✅ Assinatura é preservada ao rotacionar

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-004: Upload de Fotos em Mobile
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar execução em mobile
2. Clicar em upload de fotos
3. Selecionar fotos da galeria

**Resultado Esperado:**
- ✅ Seletor de arquivo abre
- ✅ Pode selecionar múltiplas fotos
- ✅ Upload funciona
- ✅ Fotos são salvas

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-005: Formulários sem Zoom Automático (iOS)
**Prioridade:** 🟡 Alta

**Passos:**
1. Acessar formulário em iOS
2. Focar em input
3. Verificar zoom

**Resultado Esperado:**
- ✅ Inputs têm font-size 16px
- ✅ Não há zoom automático ao focar
- ✅ Teclado aparece normalmente

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-006: Botões Touch-Friendly
**Prioridade:** 🟡 Alta

**Passos:**
1. Navegar pelo sistema em mobile
2. Verificar tamanho dos botões

**Resultado Esperado:**
- ✅ Botões têm altura mínima de 44px
- ✅ Fáceis de tocar com dedo
- ✅ Espaçamento adequado entre botões

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-MOBILE-007: PWA - Instalação
**Prioridade:** 🟢 Média

**Passos:**
1. Acessar sistema em Chrome/Edge mobile
2. Verificar opção "Instalar aplicativo"
3. Instalar PWA

**Resultado Esperado:**
- ✅ Opção de instalação aparece
- ✅ PWA instala com sucesso
- ✅ Ícone aparece na home screen
- ✅ Abre em modo standalone

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 12. TESTES DE VALIDAÇÕES E SEGURANÇA

### TC-SEG-001: Validação de CSRF Token
**Prioridade:** 🔴 Crítica

**Passos:**
1. Fazer login
2. Tentar submeter formulário sem token CSRF
3. Verificar resposta

**Resultado Esperado:**
- ✅ Erro 419 (Page Expired)
- ✅ Mensagem apropriada
- ✅ Formulário não é processado

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SEG-002: Validação de Dados de Entrada
**Prioridade:** 🟡 Alta

**Passos:**
1. Tentar criar cliente com dados inválidos:
   - Email inválido
   - CPF/CNPJ inválido
   - Campos vazios obrigatórios
2. Verificar validações

**Resultado Esperado:**
- ✅ Mensagens de erro específicas
- ✅ Dados não são salvos
- ✅ Formulário não é submetido

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SEG-003: SQL Injection - Tentativa de Injeção
**Prioridade:** 🔴 Crítica

**Passos:**
1. Tentar inserir SQL malicioso em campos de busca:
   - `'; DROP TABLE users; --`
   - `' OR '1'='1`
2. Verificar comportamento

**Resultado Esperado:**
- ✅ Sistema não quebra
- ✅ Dados não são expostos
- ✅ Query é sanitizada

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SEG-004: XSS - Tentativa de Script Injection
**Prioridade:** 🔴 Crítica

**Passos:**
1. Tentar inserir script em campos de texto:
   - `<script>alert('XSS')</script>`
   - `<img src=x onerror=alert('XSS')>`
2. Verificar se script é executado

**Resultado Esperado:**
- ✅ Scripts não são executados
- ✅ Tags são escapadas
- ✅ Dados são sanitizados

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-SEG-005: Acesso Direto a Rotas Protegidas
**Prioridade:** 🟡 Alta

**Passos:**
1. Sem estar logado, tentar acessar:
   - `/servicos/create`
   - `/clientes/create`
   - `/configuracoes/usuarios`
2. Verificar redirecionamento

**Resultado Esperado:**
- ✅ Redirecionamento para `/login`
- ✅ Não acessa rotas protegidas

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 13. TESTES DE INTEGRAÇÃO

### TC-INT-001: Fluxo Completo - Criar Cliente → Criar OS → Executar → Gerar Laudo → Assinar
**Prioridade:** 🔴 Crítica

**Passos:**
1. Login como admin
2. Criar cliente
3. Criar técnico
4. Criar OS atribuindo ao técnico
5. Login como técnico
6. Executar serviço (checklist + fotos + assinatura)
7. Login como admin
8. Gerar laudo PDF
9. Enviar para assinatura
10. Acessar link público e assinar

**Resultado Esperado:**
- ✅ Todos os passos funcionam
- ✅ Dados são preservados entre etapas
- ✅ Laudo final está completo
- ✅ Assinatura é registrada

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-INT-002: Relacionamento Cliente-Serviço-Laudo
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar cliente
2. Criar 2 serviços para o cliente
3. Gerar laudos para ambos
4. Verificar histórico do cliente

**Resultado Esperado:**
- ✅ Cliente mostra ambos os serviços
- ✅ Laudos aparecem vinculados corretamente
- ✅ Relacionamentos funcionam

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

### TC-INT-003: Exclusão em Cascata
**Prioridade:** 🟡 Alta

**Passos:**
1. Criar cliente com serviço
2. Criar execução para o serviço
3. Gerar laudo
4. Tentar excluir cliente

**Resultado Esperado:**
- ✅ Não permite excluir cliente
- ✅ Mensagem apropriada
- ✅ Sugere excluir serviços/laudos primeiro

**Resultado Obtido:** ☐ Passou ☐ Falhou  
**Observações:** _________________________

---

## 📊 RESUMO DE TESTES

### Por Prioridade

| Prioridade | Total | Passou | Falhou | Não Testado |
|------------|-------|--------|--------|-------------|
| 🔴 Crítica | ___ | ___ | ___ | ___ |
| 🟡 Alta | ___ | ___ | ___ | ___ |
| 🟢 Média | ___ | ___ | ___ | ___ |
| **TOTAL** | ___ | ___ | ___ | ___ |

### Por Módulo

| Módulo | Total | Passou | Falhou | Taxa de Sucesso |
|--------|-------|--------|--------|-----------------|
| Autenticação | ___ | ___ | ___ | ___% |
| Clientes | ___ | ___ | ___ | ___% |
| Serviços | ___ | ___ | ___ | ___% |
| Execução | ___ | ___ | ___ | ___% |
| Laudos | ___ | ___ | ___ | ___% |
| Assinatura | ___ | ___ | ___ | ___% |
| Usuários | ___ | ___ | ___ | ___% |
| Perfil | ___ | ___ | ___ | ___% |
| Dashboard | ___ | ___ | ___ | ___% |
| RBAC | ___ | ___ | ___ | ___% |
| Mobile | ___ | ___ | ___ | ___% |
| Segurança | ___ | ___ | ___ | ___% |
| Integração | ___ | ___ | ___ | ___% |

---

## 🐛 BUGS ENCONTRADOS

### Bug #1
**Descrição:**  
**Módulo:**  
**Prioridade:**  
**Passos para Reproduzir:**  
**Resultado Esperado:**  
**Resultado Obtido:**  
**Status:** ☐ Aberto ☐ Em Correção ☐ Corrigido

---

### Bug #2
**Descrição:**  
**Módulo:**  
**Prioridade:**  
**Passos para Reproduzir:**  
**Resultado Esperado:**  
**Resultado Obtido:**  
**Status:** ☐ Aberto ☐ Em Correção ☐ Corrigido

---

## ✅ CONCLUSÃO

**Data do Teste:** ___/___/___  
**Testado por:** _________________________  
**Versão Testada:** _________________________  

**Status Geral:** ☐ Aprovado ☐ Aprovado com Ressalvas ☐ Reprovado

**Observações Finais:**

_____________________________________________________________________________
_____________________________________________________________________________
_____________________________________________________________________________

---

## 📝 NOTAS ADICIONAIS

- **Ambiente de Teste:** ☐ Desenvolvimento ☐ Homologação ☐ Produção
- **Navegadores Testados:** ☐ Chrome ☐ Firefox ☐ Edge ☐ Safari ☐ Mobile
- **Dispositivos Testados:** ☐ Desktop ☐ Tablet ☐ Mobile

---

**Documento gerado em:** 15/12/2024  
**Próxima atualização:** Sempre que houver mudanças no sistema

> 🔄 **Lembre-se:** Atualize este documento sempre que implementar ou alterar funcionalidades!

