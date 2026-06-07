

const pricing = [
  { service: "YouTube montažas",        includes: "Karpymas, SFX, subtitrai ir daugiau", price: "nuo €70 / video" },
  { service: "Shorts / Reels / TikTok", includes: "Hook'ai, titrai, dinamiški cut'ai",   price: "nuo €15 / vnt" },
  { service: "Podcast edit",            includes: "Multicam, cut'ai, highlight'ai",       price: "nuo €50" },
  { service: "Subtitrai / titrai",      includes: "Subtitrai, callouts, lower-thirds",     price: "nuo €10" },
  { service: "Batch / paketas",         includes: "Keli video per savaitę / mėnesį",       price: "nuo €? / mėn" },
];

const testimonials = [
  { name: "Svarbeuse Dariti", role: "YouTube kūrėjas", rating: "5.0", photo: "assets/people/svarbeuse.jpg",
    quote: "Superinis bendradarbiavimas: viskas atlikta pagal gaires, bet su labai skoningais jo paties papildymais. Jaučiasi, kad žmogus turi viziją ir skill'ą pajausti, koks sprendimas video padarys dar stipresnį." },
  { name: "Loco", role: "Streamer'is", rating: "5.0", photo: "assets/people/loco.png",
    quote: "Labai gerai pagauna brand'o estetiką. Cut'ai tikslūs, titrai tvarkingi, o rezultatas – super žiūrimas." },
  { name: "potencialas_", role: "Influencerė", rating: "5.0", photo: "assets/people/potencialas.jpg",
    quote: "Dirbam kartu jau antrus metus ir galiu pasakyti paprastai: su juo ramu. Kai duodu viziją – įgyvendina tiksliai. Kokybiškas darbas ir pagarbus bendravimas – retas derinys." },
];

const els = {
  pricingBody: document.getElementById("pricingBody"),
  testimonialsGrid: document.getElementById("testimonialsGrid"),
  year: document.getElementById("year"),
  copyDraft: document.getElementById("copyDraft"),
  burger: document.getElementById("burger"),
  drawer: document.getElementById("drawer"),
  drawerClose: document.getElementById("drawerClose"),
  name: document.getElementById("name"),
  project: document.getElementById("project"),
  details: document.getElementById("details"),
};

function escapeHtml(str){
  return String(str).replaceAll("&","&amp;").replaceAll("<","&lt;").replaceAll(">","&gt;").replaceAll('"',"&quot;").replaceAll("'","&#039;");
}

function initials(name){
  const p = String(name||"").trim().split(/\s+/).filter(Boolean);
  return ((p[0]?.[0]||"A") + (p[1]?.[0]||"V")).toUpperCase();
}


function bindFilters(){
  const chips = document.querySelectorAll(".chip");
  const cards = document.querySelectorAll("#worksGrid .work");
  chips.forEach(btn => {
    btn.addEventListener("click", () => {
      chips.forEach(b => b.classList.remove("is-active"));
      btn.classList.add("is-active");
      const f = btn.dataset.filter;
      cards.forEach(c => {
        const show = (f === "all") || c.dataset.tag === f || c.dataset.ratio === f;
        c.style.display = show ? "" : "none";
      });
    });
  });
}

function renderPricing(){
  if (!els.pricingBody) return;
  els.pricingBody.innerHTML = pricing.map(r => `
    <tr><td><strong>${escapeHtml(r.service)}</strong></td><td>${escapeHtml(r.includes)}</td><td>${escapeHtml(r.price)}</td></tr>
  `).join("");
}

function renderTestimonials(){
  if (!els.testimonialsGrid) return;
  els.testimonialsGrid.innerHTML = testimonials.map(t => {
    const fb = escapeHtml(initials(t.name));
    const avatar = t.photo
      ? `<img src="${t.photo}" alt="${escapeHtml(t.name)}" loading="lazy" onerror="this.closest('.avatar').innerHTML='<span class=&quot;avatar__fallback&quot;>${fb}</span>';">`
      : `<span class="avatar__fallback">${fb}</span>`;
    return `
      <article class="tcard"><div class="tcard__inner">
        <p class="tquote">${escapeHtml(t.quote)}</p>
        <div class="tperson">
          <div class="avatar">${avatar}</div>
          <div class="tmeta">
            <div class="tnameRow"><div class="tname">${escapeHtml(t.name)}</div><div class="trating">★ ${escapeHtml(t.rating)}</div></div>
            <div class="trole">${escapeHtml(t.role)}</div>
          </div>
        </div>
      </div></article>`;
  }).join("");
}

async function copyRequestDraft(){
  const n=(els.name?.value||"").trim(), p=(els.project?.value||"").trim(), d=(els.details?.value||"").trim();
  const draft =
`Sveiki! Noriu užsisakyti video montažą.

Vardas: ${n||"-"}
Projektas: ${p||"-"}
Detalės: ${d||"-"}

• Formatas (16:9 / 9:16):
• Galutinė trukmė:
• "Žalios" medžiagos trukmė:
• Video kiekis:
• Deadline:
• Nuorodos / pavyzdžiai:

Ačiū! — Arnas Video`;
  try{
    await navigator.clipboard.writeText(draft);
    els.copyDraft.textContent = "Nukopijuota ✓";
    setTimeout(()=> els.copyDraft.textContent = "Kopijuoti užklausą", 1400);
  }catch(e){ alert("Nepavyko nukopijuoti. Pažymėk tekstą ranka."); }
}

function bindMobileMenu(){
  const open = () => { els.drawer.classList.add("is-open"); els.drawer.setAttribute("aria-hidden","false"); els.burger.setAttribute("aria-expanded","true"); };
  const close = () => { els.drawer.classList.remove("is-open"); els.drawer.setAttribute("aria-hidden","true"); els.burger.setAttribute("aria-expanded","false"); };
  els.burger?.addEventListener("click", open);
  els.drawerClose?.addEventListener("click", close);
  els.drawer?.addEventListener("click", e => { if (e.target === els.drawer) close(); });
  document.querySelectorAll(".drawer__links a").forEach(a => a.addEventListener("click", close));
}

function init(){
  if (els.year) els.year.textContent = new Date().getFullYear();
  renderPricing();
  renderTestimonials();
  bindFilters();
  bindMobileMenu();
  els.copyDraft?.addEventListener("click", copyRequestDraft);
}
init();
