-- Executar no banco configurado para o SisVet.
CREATE UNIQUE INDEX IF NOT EXISTS usuarios_email_unique ON usuarios (email);

INSERT INTO usuarios (nome, email, senha_hash, perfil)
SELECT 'Kaio', 'k@g.com', '$argon2id$v=19$m=65536,t=4,p=1$T2dIMHo4Ylpxd1FNU25lSQ$kraH2hhPWIslqj0sNTwiozT71gdZsQcFsmviKk2meOU', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email = 'k@g.com');
