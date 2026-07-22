import pandas as pd
import sys

# 1. Nosso banco de dados simulado em uma tabela
dados_dos_produtos = {
    'ID': [1, 2, 3, 4],
    'Nome': ['Mouse Gamer Transparente', 'Teclado Mecânico RGB', 'Mouse Pad Extra Grande', 'Cadeira Gamer Ergonômica'],
    'Descricao': ['Mouse para jogos com led e alta precisão', 'Teclado mecânico para jogos switch azul', 'Mousepad grande para teclado e mouse', 'Cadeira confortável para jogar e trabalhar'],
    'Link_Afiliado': ['https://amazon.com.br/mouse', 'https://amazon.com.br/teclado', 'https://amazon.com.br/mousepad', 'https://amazon.com.br/cadeira']
}

df = pd.DataFrame(dados_dos_produtos)

# 2. Função inteligente que varre a tabela baseando-se em múltiplos produtos visitados
def recomendador_por_historico(lista_ids_escolhidos, tabela_produtos):
    palavras_chave_totais = []
    nomes_produtos_visitados = []
    
    # Coleta todas as palavras-chave de todos os produtos do histórico do usuário
    for produto_id in lista_ids_escolhidos:
        filtro = tabela_produtos['ID'] == produto_id
        if filtro.any():
            descricao_busca = tabela_produtos.loc[filtro, 'Descricao'].values[0]
            nome_busca = tabela_produtos.loc[filtro, 'Nome'].values[0]
            
            nomes_produtos_visitados.append(nome_busca)
            palavras_chave_totais.extend(descricao_busca.split())
            
    # Remove palavras duplicadas para otimizar a busca
    palavras_chave_totais = list(set(palavras_chave_totais))
    
    print(f"=== HISTÓRICO RECENTE DO USUÁRIO ===")
    print(f"Produtos vistos: {', '.join(nomes_produtos_visitados)}\n")
    print("Recomendações personalizadas da IA com base no seu perfil:\n")
    
    # Compara com os produtos que o usuário AINDA NÃO visitou no histórico atual
    for index, linha in tabela_produtos.iterrows():
        if linha['ID'] not in lista_ids_escolhidos:
            palavras_em_comum = sum(1 for palavra in palavras_chave_totais if palavra.lower() in linha['Descricao'].lower())
            
            if palavras_em_comum > 0:
                print(f"-> {linha['Nome']}")
                print(f"   Comprar aqui: {linha['Link_Afiliado']}\n")

# 3. Faz o Python ler a lista enviada pelo PHP
if __name__ == "__main__":
    if len(sys.argv) > 1:
        # Transforma o texto "2,1,4" que veio do PHP em uma lista de números reais [2, 1, 4]
        ids_do_php = [int(x) for x in sys.argv[1].split(',')]
    else:
        ids_do_php = [1]
        
    recomendador_por_historico(ids_do_php, df)