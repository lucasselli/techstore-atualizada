
USE techstore;

INSERT INTO categoria (id, nome, descricao) VALUES
(1, 'Processadores', 'CPUs para computadores'),
(2, 'Placas de vídeo', 'GPUs para jogos e criação'),
(3, 'Memórias RAM', 'Memórias para computadores'),
(4, 'Armazenamento', 'SSDs e unidades de armazenamento'),
(5, 'Periféricos', 'Acessórios para computadores');

INSERT INTO usuario (id, nome, email, senha_hash, tipo) VALUES
(1, 'Lucas Admin', 'admin@techstore.local', 'HASH_TEMPORARIO', 'admin'),
(2, 'Carlos Silva', 'carlos@techstore.local', 'HASH_TEMPORARIO', 'cliente'),
(3, 'Mariana Souza', 'mariana@techstore.local', 'HASH_TEMPORARIO', 'cliente'),
(4, 'Pedro Lima', 'pedro@techstore.local', 'HASH_TEMPORARIO', 'cliente'),
(5, 'Ana Costa', 'ana@techstore.local', 'HASH_TEMPORARIO', 'cliente'),
(6, 'Rafael Alves', 'rafael@techstore.local', 'HASH_TEMPORARIO', 'cliente');

INSERT INTO cliente (id, usuario_id, telefone) VALUES
(1, 2, '51999990001'),
(2, 3, '51999990002'),
(3, 4, '51999990003'),
(4, 5, '51999990004'),
(5, 6, '51999990005');

INSERT INTO produto
(id, categoria_id, nome, descricao, preco, quantidade, imagem, ativo) VALUES
(1, 1, 'Ryzen 5 5600', 'Processador para jogos e produtividade', 799.90, 10, NULL, TRUE),
(2, 2, 'RTX 4060 8GB', 'Placa de vídeo para jogos em Full HD', 2199.90, 5, NULL, TRUE),
(3, 3, 'Memória RAM 16GB DDR4', 'Módulo de memória para desktop', 229.90, 20, NULL, TRUE),
(4, 4, 'SSD NVMe 1TB', 'Armazenamento de alta velocidade', 399.90, 15, NULL, TRUE),
(5, 5, 'Teclado Mecânico RGB', 'Teclado para jogos e uso diário', 189.90, 12, NULL, TRUE);

INSERT INTO pedido
(id, cliente_id, valor_total, status) VALUES
(1, 1, 799.90, 'concluido'),
(2, 2, 2199.90, 'enviado'),
(3, 3, 229.90, 'confirmado'),
(4, 4, 399.90, 'pendente'),
(5, 5, 189.90, 'pendente');

INSERT INTO item_pedido
(id, pedido_id, produto_id, quantidade, preco_unitario) VALUES
(1, 1, 1, 1, 799.90),
(2, 2, 2, 1, 2199.90),
(3, 3, 3, 1, 229.90),
(4, 4, 4, 1, 399.90),
(5, 5, 5, 1, 189.90);
