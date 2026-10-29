
#!/bin/bash

URL="http://localhost/techstore/api/produtos.php"
TOKEN="TechStoreTeste2026TokenSeguro"
NOME="Produto Teste Automatizado"
APROVADOS=0
FALHAS=0
ID=""

testar() {
    DESCRICAO="$1"
    ESPERADO="$2"
    OBTIDO="$3"

    if [ "$ESPERADO" = "$OBTIDO" ]; then
        echo "[OK] $DESCRICAO - HTTP $OBTIDO"
        APROVADOS=$((APROVADOS + 1))
    else
        echo "[FALHA] $DESCRICAO - Esperado: $ESPERADO | Obtido: $OBTIDO"
        FALHAS=$((FALHAS + 1))
    fi
}

echo "===== TESTES DA API TECHSTORE ====="

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Authorization: Bearer $TOKEN" "$URL")
testar "Listar produtos" 200 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Authorization: Bearer $TOKEN" "$URL?id=1")
testar "Buscar produto existente" 200 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" "$URL")
testar "Acesso sem token" 401 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Authorization: Bearer tokenErrado" "$URL")
testar "Token invalido" 401 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Authorization: Bearer $TOKEN" "$URL?id=9999")
testar "Produto inexistente" 404 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" \
    -H "Authorization: Bearer $TOKEN" "$URL?id=abc")
testar "ID invalido" 400 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
    -H "Authorization: Bearer $TOKEN" \
    -H "Content-Type: application/json" \
    -d '{"categoria_id":1,"nome":"Produto JSON Invalido","preco":10,"quantidade":2' \
    "$URL")
testar "JSON invalido" 400 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" -X PATCH \
    -H "Authorization: Bearer $TOKEN" "$URL")
testar "Metodo nao permitido" 405 "$CODIGO"

CODIGO=$(curl -s -o /dev/null -w "%{http_code}" -X POST \
    -H "Authorization: Bearer $TOKEN" \
    -H "Content-Type: application/json" \
    -d '{"categoria_id":1,"descricao":"Produto sem nome","preco":10,"quantidade":2,"ativo":1}' \
    "$URL")
testar "Cadastro com dados invalidos" 400 "$CODIGO"

RESPOSTA=$(curl -s -w "\n%{http_code}" -X POST \
    -H "Authorization: Bearer $TOKEN" \
    -H "Content-Type: application/json" \
    -d "{\"categoria_id\":1,\"nome\":\"$NOME\",\"descricao\":\"Produto temporario para testes\",\"preco\":10,\"quantidade\":2,\"ativo\":1}" \
    "$URL")

CODIGO=$(echo "$RESPOSTA" | tail -n 1)
testar "Cadastrar produto" 201 "$CODIGO"

ID=$(curl -s -H "Authorization: Bearer $TOKEN" "$URL" |
    grep -o "\"id\":[0-9]*,\"categoria_id\":[0-9]*,\"nome\":\"$NOME\"" |
    head -1 |
    grep -o '"id":[0-9]*' |
    cut -d ':' -f2)

if [ -n "$ID" ]; then
    echo "Produto de teste encontrado: ID $ID"

    CODIGO=$(curl -s -o /dev/null -w "%{http_code}" -X PUT \
        -H "Authorization: Bearer $TOKEN" \
        -H "Content-Type: application/json" \
        -d '{"categoria_id":1,"nome":"Produto Teste Atualizado","descricao":"Teste de atualizacao","preco":15,"quantidade":3,"ativo":1}' \
        "$URL?id=$ID")
    testar "Atualizar produto" 200 "$CODIGO"

    CODIGO=$(curl -s -o /dev/null -w "%{http_code}" -X DELETE \
        -H "Authorization: Bearer $TOKEN" "$URL?id=$ID")
    testar "Excluir produto" 200 "$CODIGO"
else
    echo "[FALHA] Nao foi possivel localizar o produto cadastrado."
    FALHAS=$((FALHAS + 1))
fi

echo
echo "===== RESUMO ====="
echo "Aprovados: $APROVADOS"
echo "Falhas: $FALHAS"

if [ "$FALHAS" -gt 0 ]; then
    exit 1
fi

echo "Todos os testes passaram!"
exit 0
