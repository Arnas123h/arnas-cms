<?php
require_once __DIR__ . '/includes/functions.php';
$darbai = get_darbai();
?>
<!doctype html>
<html lang="lt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= h(setting('svetaines_pavadinimas', 'Arnas Video – Portfolio')) ?></title>
  <meta name="description" content="Arnas Video — tamsus, estetiškas video editing portfolio." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
  <div class="bg-noise" aria-hidden="true"></div>
  <div class="bg-glow" aria-hidden="true"></div>

  <header class="topbar">
    <div class="container topbar__inner">
      <a class="brand" href="#top" aria-label="Į pradžią">
        <img src="<?= h(setting('logotipas', 'assets/logo.svg')) ?>" alt="<?= h(setting('imones_pavadinimas', 'Arnas Video')) ?>" class="brand__logo" />
      </a>
      <nav class="nav" aria-label="Navigacija">
        <a href="#darbai">Darbai</a>
        <a href="#paslaugos">Paslaugos</a>
        <a href="#kainos">Kainos</a>
        <a href="#apie">Apie</a>
        <a href="#atsiliepimai">Atsiliepimai</a>
        <a href="#kontaktai" class="pill">Susisiekti</a>
      </nav>
      <button class="burger" id="burger" aria-label="Meniu" aria-expanded="false"><span></span><span></span><span></span></button>
    </div>
    <div class="drawer" id="drawer" aria-hidden="true">
      <div class="drawer__panel">
        <div class="drawer__head">
          <span class="drawer__title">Meniu</span>
          <button class="drawer__close" id="drawerClose" aria-label="Uždaryti">✕</button>
        </div>
        <div class="drawer__links">
          <a href="#darbai">Darbai</a><a href="#paslaugos">Paslaugos</a><a href="#kainos">Kainos</a>
          <a href="#apie">Apie</a><a href="#atsiliepimai">Atsiliepimai</a><a href="#kontaktai">Susisiekti</a>
        </div>
      </div>
    </div>
  </header>

  <main id="top">
    <!-- DARBAI (iš DB) -->
    <section class="section section--first" id="darbai">
      <div class="container">
        <div class="section__head">
          <div>
            <p class="kicker">portfolio</p>
            <h1 class="h1">Mano darbai:</h1>
          </div>
          <div class="filters" role="tablist" aria-label="Darbų filtrai">
            <button class="chip is-active" data-filter="all">Visi</button>
            <button class="chip" data-filter="16x9">16:9</button>
            <button class="chip" data-filter="9x16">9:16</button>
            <button class="chip" data-filter="ads">Reklama</button>
            <button class="chip" data-filter="showreel">Showreel</button>
          </div>
        </div>

        <div class="grid" id="worksGrid" aria-live="polite">
          <?php foreach ($darbai as $d):
            
            $img = $d['nuotrauka'] ? $d['nuotrauka'] : yt_thumb($d['nuoroda']);
            $style = $img
              ? "style=\"background-image: linear-gradient(180deg, rgba(0,0,0,.20), rgba(0,0,0,.62)), url('" . h($img) . "'); background-size:cover; background-position:center; background-repeat:no-repeat;\""
              : '';
          ?>
          <article class="work" data-tag="<?= h($d['kategorija']) ?>" data-ratio="<?= h($d['formatas']) ?>">
            <div class="work__thumb" <?= $style ?>>
              <span class="badge"><?= h($d['formatas']) ?> • <?= h($d['trumpas']) ?></span>
            </div>
            <div class="work__body">
              <h3 class="work__title"><?= h($d['pavadinimas']) ?></h3>
              <div class="work__meta">
                <span class="mono"><?= h($d['trukme']) ?></span>
                <?php if ($d['trumpas']): ?><span>•</span><span><?= h($d['trumpas']) ?></span><?php endif; ?>
              </div>
            </div>
            <?php if ($d['nuoroda']): ?>
              <a class="stretch" href="<?= h($d['nuoroda']) ?>" target="_blank" rel="noopener">Atidaryti</a>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>

          <?php if (!$darbai): ?>
            <p class="lead">Darbų dar nėra. Pridėk juos admin skiltyje.</p>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Paslaugos -->
    <section class="section" id="paslaugos">
      <div class="container">
        <div class="section__head"><div><p class="kicker">Daugiau apie paslaugas</p><h2 class="h2">Video editing</h2></div></div>
        <div class="cards">
          <article class="card"><h3>YouTube vaizdo įrašai</h3><p>Karpymas, transitions, garsas, efektai ir storytelling.</p><div class="meta">Long-form</div></article>
          <article class="card"><h3>Reels / Shorts / TikTok</h3><p>Greiti cut's, transitions, subtitrai ir hook'ai.</p><div class="meta">9:16</div></article>
          <article class="card"><h3>Podcast edit</h3><p>Švarus dialogas, iškarpos, highlight'ai, vizualiniai callout'ai.</p><div class="meta">Multicam</div></article>
          <article class="card"><h3>Subtitrai / titrai</h3><p>Subtitrai, lower-thirds, callouts. Minimalu, estetiška, pagal brand'ą.</p><div class="meta">Captions</div></article>
        </div>
      </div>
    </section>

    <!-- Kainos  -->
    <section class="section" id="kainos">
      <div class="container">
        <div class="section__head">
          <div><p class="kicker">pigu-kokybiška</p><h2 class="h2">Kainoraštis:</h2><p class="lead">Kainos priklauso individualiai nuo jūsų norų.</p></div>
          <div class="note"><span class="dot"></span><span>Kainos skiriasi pagal jūsų projektą.</span></div>
        </div>
        <div class="pricing">
          <div class="tableWrap">
            <table class="table" aria-label="Kainų lentelė">
              <thead><tr><th>Paslauga</th><th>Kas įeina</th><th>Kaina</th></tr></thead>
              <tbody id="pricingBody"></tbody>
            </table>
          </div>
          <div class="pricingCard">
            <h3>Daugiau informacijos:</h3>
            <p>Parašyk formatą, trukmę, kiek epizodų ir deadline – atsakysiu su tikslesne kaina.</p>
            <div class="mini">
              <div class="mini__row"><span>Formatas</span><span class="mono">16:9 / 9:16</span></div>
              <div class="mini__row"><span>Terminas</span><span class="mono">1–5 d.</span></div>
              <div class="mini__row"><span>Komunikacija</span><span class="mono">Jums tinkanti platforma.</span></div>
            </div>
            <a class="btn" href="#kontaktai">Susisiekti</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Apie -->
    <section class="section" id="apie">
      <div class="container">
        <div class="section__head"><div><p class="kicker">susipažinkime</p><h2 class="h2">Apie mane:</h2></div></div>
        <div class="about">
          <div class="about__left">
            <div class="portrait">
              <div class="portrait__shine" aria-hidden="true"></div>
              <div class="portrait__inner">
                <p class="big">Montažas, kuris atrodo brangiai.</p>
                <p class="muted"><?= nl2br(h(setting('apie'))) ?></p>
              </div>
            </div>
          </div>
          <div class="about__right">
            <div class="stats">
              <div class="stat"><div class="stat__num">400+</div><div class="stat__label">Sumontuoti video</div></div>
              <div class="stat"><div class="stat__num">10+</div><div class="stat__label">Klientai</div></div>
              <div class="stat"><div class="stat__num">2+</div><div class="stat__label">Metų patirtis</div></div>
            </div>
            <div class="ctaRow">
              <a class="btn btn--ghost" href="#darbai">Peržiūrėti darbus</a>
              <a class="btn" href="#kontaktai">Užklausa</a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Atsiliepimai  -->
    <section class="section" id="atsiliepimai">
      <div class="container">
        <div class="section__head">
          <div><p class="kicker">atsiliepimai</p><h2 class="h2">Klientų žodis:</h2><p class="lead">Kelios žinutės iš žmonių, kuriems montuoju.</p></div>
          <div class="note"><span class="dot"></span><span>Realūs atsiliepimai</span></div>
        </div>
        <div class="testimonials" id="testimonialsGrid" aria-live="polite"></div>
      </div>
    </section>

    <!-- Kontaktai  -->
    <section class="section" id="kontaktai">
      <div class="container">
        <div class="contact">
          <div>
            <p class="kicker">susisiekime</p>
            <h2 class="h2">Įveskite kokios paslaugos reikia, kopijuokite užklausą mygtuku ir siųskite paštu.</h2>
            <div class="contact__grid">
              <div class="contactCard"><div class="label">Telefonas</div><a class="mono link" href="tel:<?= h(str_replace(' ','',setting('telefonas'))) ?>"><?= h(setting('telefonas')) ?></a></div>
              <div class="contactCard"><div class="label">El. paštas</div><a class="mono link" href="mailto:<?= h(setting('el_pastas')) ?>"><?= h(setting('el_pastas')) ?></a></div>
              <div class="contactCard"><div class="label">Adresas</div><span class="mono link"><?= h(setting('adresas')) ?></span></div>
            </div>
          </div>
          <form class="form" onsubmit="return false;">
            <div class="form__row"><label>Vardas</label><input id="name" placeholder="Jūsų vardas" /></div>
            <div class="form__row"><label>Projektas</label><input id="project" placeholder="Pvz. 8 epizodai / reklama / YouTube video" /></div>
            <div class="form__row"><label>Detalės</label><textarea id="details" rows="5" placeholder="Formatas, trukmės, deadline, nuorodos..."></textarea></div>
            <button class="btn" type="button" id="copyDraft">Kopijuoti užklausą</button>
            <p class="hint">Mygtukas nukopijuoja užklausą – patogu siųsti į email/DM.</p>
          </form>
        </div>
        <footer class="footer">
          <span>© <span id="year"></span> <?= h(setting('imones_pavadinimas', 'Arnas.VIDEO')) ?></span>
          <span class="sep">•</span>
          <a class="link muted" href="admin/login.php">Admin</a>
          <span class="sep">•</span>
          <a class="link muted" href="#top">Į viršų</a>
        </footer>
      </div>
    </section>
  </main>

  <script src="app.js"></script>
</body>
</html>
