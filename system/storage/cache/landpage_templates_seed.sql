INSERT INTO rms_landpage_template (name, code, description, html, css, status, date_added, date_modified) VALUES
('Hero CTA','hero-cta','Hero com título, copy e botão.','<section class="hero"><h1>Hero CTA</h1><p>Subcopy para conversão</p><a class="btn btn-primary">Call to action</a></section>','',1,NOW(),NOW()),
('Split Lead','split-lead','Layout dividido com captura de lead.','<section class="split" style="display:flex;gap:24px;"><div><h1>Landing ágil</h1><p>Bloco de texto e lista.</p></div><div><form><input placeholder="Email"/><button>Enviar</button></form></div></section>','',1,NOW(),NOW())
ON DUPLICATE KEY UPDATE description=VALUES(description), html=VALUES(html), css=VALUES(css), status=VALUES(status), date_modified=VALUES(date_modified);
