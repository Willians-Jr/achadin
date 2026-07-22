import pandas as pd

# 1. Nosso banco de dados simulado em uma tabela
dados_dos_produtos = {
    'ID': [1, 2, 3, 4],
    'Nome': ['Mouse Gamer Transparente', 'Teclado Mecânico RGB', 'Mouse Pad Extra Grande', 'Cadeira Gamer Ergonômica'],
    'Descricao': ['Mouse para jogos com led e alta precisão', 'Teclado mecânico para jogos switch azul', 'Mousepad grande para teclado e mouse', 'Cadeira confortável para jogar e trabalhar'],
    'Link_Afiliado': ['https://amazon.com.br/mouse', 'https://amazon.com.br/teclado', 'https://amazon.com.br/mousepad', 'https://amazon.com.br/cadeira']
}

df = pd.DataFrame(dados_dos_produtos)

# 2. A função inteligente que varre a tabela buscando semelhanças
def recomendador_por_palavra_chave(produto_escolhido_id, tabela_produtos):
    descricao_busca = tabela_produtos.loc[tabela_produtos['ID'] == produto_escolhido_id, 'Descricao'].values[0]
    palavras_chave = descricao_busca.split()
    
    print(f"=== PRODUTO CLICADO: {tabela_produtos.loc[tabela_produtos['ID'] == produto_escolhido_id, 'Nome'].values[0]} ===\n")
    print("Recomendações da IA baseadas no comportamento de cliques:")
    
    for index, linha in tabela_produtos.iterrows():
        if linha['ID'] != produto_escolhido_id:
            palavras_em_comum = sum(1 for palavra in palavras_chave if palavra.lower() in linha['Descricao'].lower())
            
            if palavras_em_comum > 0:
                print(f"-> {linha['Nome']}")
                print(f"   Comprar aqui: {linha['Link_Afiliado']}\n")

# 3. Execução: Simulando que o usuário clicou no produto de ID 1 (Mouse)
recomendador_por_palavra_chave(1, df)