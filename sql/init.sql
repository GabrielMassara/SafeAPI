CREATE TABLE IF NOT EXISTS users (
  id SERIAL PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password TEXT NOT NULL
);

-- Usuário exemplo: email: admin@example.com senha: 123456
INSERT INTO users (name, email, password) VALUES (
  'Admin',
  'admin@example.com',
  '$2y$10$D9jxk86BdVWzSD9DWErq2eJD7NdtU4pRh/C2sN9ZJ/s38ZGnIExdK'
) ON CONFLICT DO NOTHING;
