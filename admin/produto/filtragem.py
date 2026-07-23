import pandas as pd
import sys
import pymysql
import re

def buscar_produtos_do_banco():
    conexao = pymysql.connect(
        host="localhost",
        user="root",
        password="",
        database="achadin",
        charset="utf8mb4"
    )
    query = "SELECT idProduto AS ID, nomeProduto AS Nome, descricaoProduto AS Descricao, linkAfiliado AS Link_Afiliado FROM produto"
    df = pd.read_sql(query, conexao)
    conexao.close()
    return df

def limpar_texto(texto):
    if not texto:
        return []
    # Converte para minúsculas e remove pontuações comuns (, . ! ? ...)
    texto_limpo = re.sub(r'[^\w\s]', '', str(texto).lower())
    
    # Lista de "stopwords" (palavras que devem ser ignoradas na comparação da IA)
    stopwords = {'para', 'de', 'o', 'a', 'os', 'as', 'com', 'em', 'um', 'uma', 'ao', 'leite', 'do', 'da', 'seguindo', 'normas', 'impostas', 'pelo'}
    
    # Filtra mantendo apenas palavras reais com mais de 2 letras
    palavras = [p for p in texto_limpo.split() if p not in stopwords and len(p) > 2]
    return palavras

def recomendador_por_historico(lista_ids_escolhidos, tabela_produtos):
    lista_ids_escolhidos = [int(x) for x in lista_ids_escolhidos]
    palavras_chave_totais = []
    
    # 1. Coleta palavras importantes do histórico do usuário
    for produto_id in lista_ids_escolhidos:
        filtro = tabela_produtos['ID'].astype(int) == produto_id
        if filtro.any():
            descricao_busca = tabela_produtos.loc[filtro, 'Descricao'].values[0]
            palavras_chave_totais.extend(limpar_texto(descricao_busca))
            
    # Remove palavras duplicadas obtidas do histórico
    palavras_chave_totais = list(set(palavras_chave_totais))
    ids_recomendados = []
    
    # 2. Compara com os outros produtos cadastrados
    for index, linha in tabela_produtos.iterrows():
        id_atual_tabela = int(linha['ID'])
        
        # Só sugere se NÃO for um produto que o usuário já clicou
        if id_atual_tabela not in lista_ids_escolhidos:
            palavras_produto = limpar_texto(linha['Descricao'])
            
            # Conta quantas palavras importantes batem
            palavras_em_comum = sum(1 for palavra in palavras_chave_totais if palavra in palavras_produto)
            
            if palavras_em_comum > 0:
                ids_recomendados.append(str(id_atual_tabela))
                
    # Retorna os IDs separados por vírgula para o PHP
    print(",".join(ids_recomendados))

if __name__ == "__main__":
    try:
        df = buscar_produtos_do_banco()
        
        if len(sys.argv) > 1 and sys.argv[1].strip():
            arg_limpo = sys.argv[1].replace('\r', '').replace('\n', '').strip()
            ids_do_php = [int(x) for x in arg_limpo.split(',') if x.strip()]
        else:
            ids_do_php = [3] # Fallback de teste para o ID 3 (Shampoo CR7)
            
        recomendador_por_historico(ids_do_php, df)
        
    except Exception as e:
        print(f"Erro no Python: {str(e)}")