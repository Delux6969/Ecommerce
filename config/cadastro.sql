create database cadastro;
use cadastro;


CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nomeProduto` varchar(255) NOT NULL,
  `precoProduto` varchar(255) NOT NULL,
  `tamanhoProduto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nomeProduto`, `precoProduto`, `tamanhoProduto`) VALUES
(32, 'lucca', '34', '200');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `cep` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `funcao` varchar(255) NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `nome`, `email`, `senha`, `cep`, `endereco`, `funcao`) VALUES
(3, 'bibi gomes', 'bibi@gmail.com', '$2y$10$iAgPT0Y16yvtux4SBzAIpO.c/ajLqs/FgxGUwCmDiHOlvxr071TIy', '72210-104', '34', 'cliente'),
(26, 'Rafael ', 'rafael.gonalo@gmail.com', '$2y$10$iJPv9ZzQsHsaND8JuX0VReHQ1ZRoQfgPkpFhbRaYga/mbu7xDgn3G', '72210-104', '34', 'admin');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

create table pedido(
  id              integer not null AUTO_INCREMENT primary key,  
  id_user         integer not null,
  tipo_pagamento  varchar(200),
  payment_id      integer,
  preference_id   varchar(200),
  status          varchar(100),
  dt_created      timestamp not null default CURRENT_TIMESTAMP,
  foreign key (id_user) references users(id)
);

create table itens_pedido(
  id        integer not null AUTO_INCREMENT primary key ,
  id_pedido integer not null,
  id_prod   integer not null,
  qntd      integer,
  dt_created      timestamp not null default CURRENT_TIMESTAMP,
  foreign key (id_pedido) references pedido(id),
  foreign key (id_prod) references produtos(id)
);

drop table itens_pedido;
drop table pedido;

select * from produtos;
select * from users;