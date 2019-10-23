# Teste para Engenheiro de Software

O teste consiste em construir uma simples aplicação que exibe o valor de ações através de chamadas de API. Crie uma tela apenas com um input de texto que receberá um símbolo de ação (ex: aapl para Apple, fb para Facebook, twtr para Twitter) e retornará o último valor de ação da empresa, assim como outras informações relevantes. Sinta-se livre para utilizar quaisquer dependências que você desejar e auxiliar no desenvolvimento da aplicação.

* Você pode utilizar a API gratuita do [IEX](https://iexcloud.io/docs/api/) para obter os dados necessários
* A documentação da API sugerida pode ser acessada [aqui](https://iexcloud.io/docs/api/#stocks)
* As informações de ações para cada símbolo são encontradas [aqui](https://iexcloud.io/docs/api/#quote) (Estamos interessados apenas no `latestPrice`)
* A mesma API também retorna [as informações mais relevantes da empresa](https://iexcloud.io/docs/api/#company)
* Plotar um gráfico ou uma tabela com [a evolução do valor das ações](https://iexcloud.io/docs/api/#historical-prices) (PS: utilizamos o pacote [Recharts](http://recharts.org))
* Salvar todas as consultas e seus dados em um banco de dados, evitando que faça outra requisição repetida

## Desafios extras

Se você gostar de fazer um pouco mais, sugerimos os seguintes desafios:

* Atualizações: a API é atualizada quase em tempo real e poderia atualizar as informações de acordo (conforme faz o [Yahoo! Finance](https://finance.yahoo.com/quote/AAPL?p=AAPL&.tsrc=fin-srch))
* Testes unitários e de integração em todos os principais módulos
