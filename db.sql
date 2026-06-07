

CREATE DATABASE IF NOT EXISTS arnas_cms
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE arnas_cms;

-- ---------- Admino prisijungimas  ----------
CREATE TABLE IF NOT EXISTS vartotojai (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  vartotojas  VARCHAR(100) NOT NULL UNIQUE,
  slaptazodis VARCHAR(255) NOT NULL          -- bcrypt hash (password_hash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Prisijungimas:  admin  /  admin123
INSERT INTO vartotojai (vartotojas, slaptazodis) VALUES
('admin', '$2b$12$Y7eVb2TkbYkezN1/99UsZuLkMDoKIoMbMVkLzdxAf/XQsfG043gQy')
ON DUPLICATE KEY UPDATE vartotojas = vartotojas;

-- ---------- Darbai ----------

CREATE TABLE IF NOT EXISTS darbai (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  pavadinimas VARCHAR(255) NOT NULL,
  trumpas     VARCHAR(500) DEFAULT '',       
  pilnas      TEXT,                           
  nuotrauka   VARCHAR(255) DEFAULT '',       
  formatas    VARCHAR(20)  DEFAULT '16x9',    
  kategorija  VARCHAR(20)  DEFAULT '16x9',    
  trukme      VARCHAR(20)  DEFAULT '',        
  nuoroda     VARCHAR(500) DEFAULT '',        
  sukurta     TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO darbai (pavadinimas, trumpas, pilnas, formatas, kategorija, trukme, nuoroda) VALUES
('Apsauginio veiksmai šokiravo – FARAI RELOADED', 'YouTube vaizdo įrašas', 'Pilnametražis montažas su karpymu, transitions ir storytelling.', '16x9', 'showreel', '31:15', 'https://www.youtube.com/watch?v=KkatwQJIV5c'),
('YouTube edit — Episode #12', 'YouTube', 'Long-form montažas su garsu ir efektais.', '16x9', '16x9', '12:40', 'https://www.youtube.com/'),
('Ad edit — 30s', 'Reklama', 'Dinamiška 30 sekundžių reklama.', '16x9', 'ads', '0:30', 'https://www.youtube.com/'),
('Shorts edit — Hook + captions', 'Shorts', 'Vertikalus formatas su hook ir titrais.', '9x16', '9x16', '0:45', 'https://www.youtube.com/'),
('Podcast highlight — 9:16', 'Podcast', 'Highlight iškarpa vertikaliu formatu.', '9x16', '9x16', '0:58', 'https://www.youtube.com/'),
('Talking-head edit — clean cuts', 'Talking Head', 'Švarūs cut''ai, tvarkingas garsas.', '16x9', '16x9', '8:05', 'https://www.youtube.com/');

-- ---------- Nustatymai ----------

CREATE TABLE IF NOT EXISTS settings (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  raktas  VARCHAR(100) NOT NULL UNIQUE,
  reiksme TEXT,
  etikete VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO settings (raktas, reiksme, etikete) VALUES
('svetaines_pavadinimas', 'Arnas Video – Portfolio', 'Svetainės pavadinimas (title)'),
('imones_pavadinimas',    'Arnas.VIDEO',             'Įmonės pavadinimas'),
('logotipas',             'assets/logo.svg',         'Įmonės logotipas (kelias)'),
('telefonas',             '+370 686 68813',          'Telefono numeris'),
('el_pastas',             'arnasliuk@gmail.com',     'El. paštas'),
('adresas',               'Šiauliai, Lietuva',       'Adresas'),
('apie',                  'Sveiki! Esu Arnas. Šiuo menu domiuosi jau 2 metus. Studijuoju multimedijos technologijas, šiuo metu užsiimu video montavimu, taip pat AI technologijomis. Esu draugiškas ir komunikabilus. Susirašom ir sukuriam kažką gero!', 'Apie puslapis (tekstas)')
ON DUPLICATE KEY UPDATE raktas = raktas;
