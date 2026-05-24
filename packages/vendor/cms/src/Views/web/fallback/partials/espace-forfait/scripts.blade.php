<script>
const tlConfig = {!! \Illuminate\Support\Js::from($tlConfig) !!};
const tlSlideCaptions = tlConfig.slideCaptions || [];
const tlForfaitsData = tlConfig.forfaitsData || [];
const tlDevisLink = tlConfig.devisLink || '';
let currentSlide = 0;
let slideshowTimer = null;
let bookingState = { forfait: '', dateArrive: null, dateDepart: null, salle: '', adults: 1, children: 0 };
let calState = { year: new Date().getFullYear(), month: new Date().getMonth(), selecting: 'arrive' };
const SLIDE_DURATION = 5000;

function initSlideshow() {
  startProgress();
  slideshowTimer = setInterval(() => goToSlide((currentSlide + 1) % Math.max(1, document.querySelectorAll('.hero-slide').length)), SLIDE_DURATION);
}
function goToSlide(n) {
  const slides = document.querySelectorAll('.hero-slide');
  const dots = document.querySelectorAll('.hero-dot');
  if (!slides.length) return;
  slides[currentSlide]?.classList.remove('active');
  dots[currentSlide]?.classList.remove('active');
  currentSlide = (n + slides.length) % slides.length;
  slides[currentSlide]?.classList.add('active');
  dots[currentSlide]?.classList.add('active');
  const caption = document.getElementById('slideCaption');
  if (caption) caption.textContent = tlSlideCaptions[currentSlide] || 'Expérience forfait';
  resetProgress();
}
function slideshowNav(dir) {
  clearInterval(slideshowTimer);
  goToSlide(currentSlide + dir);
  slideshowTimer = setInterval(() => goToSlide(currentSlide + 1), SLIDE_DURATION);
}
function startProgress() {
  const bar = document.getElementById('heroProgressBar');
  if (!bar) return;
  bar.style.transition = 'none';
  bar.style.width = '0%';
  setTimeout(() => { bar.style.transition = 'width '+SLIDE_DURATION+'ms linear'; bar.style.width = '100%'; }, 50);
}
function resetProgress() { startProgress(); }
function toggleMenu(){ document.getElementById('mobileMenu')?.classList.toggle('open'); }

function toggleDropdown(id) {
  document.querySelectorAll('.filter-dropdown').forEach(d => { if(d.id !== id) d.classList.remove('open'); });
  const d = document.getElementById(id);
  if (!d) return;
  d.classList.toggle('open');
  if(id === 'dropDateArrive' && !d.querySelector('.cal-grid')) renderCalendars();
}
document.addEventListener('click', e => { if(!e.target.closest('.filter-group')) document.querySelectorAll('.filter-dropdown').forEach(d => d.classList.remove('open')); });
function selectForfait(name, e) {
  e.stopPropagation();
  bookingState.forfait = name;
  const val = document.getElementById('valForfait');
  if (val) { val.innerHTML = '<span class="filter-icon">🏔️</span> '+name; val.classList.remove('placeholder'); }
  document.querySelectorAll('.forfait-option').forEach(o => o.classList.remove('selected'));
  e.currentTarget.classList.add('selected');
  document.getElementById('dropForfait')?.classList.remove('open');
}
function selectSalle(name, el) {
  bookingState.salle = name;
  const val = document.getElementById('valSalle');
  if (val) { val.innerHTML = '<span class="filter-icon">🏠</span> '+name; val.classList.remove('placeholder'); }
  document.querySelectorAll('.salle-option').forEach(o => o.classList.remove('selected'));
  el.classList.add('selected');
}
function changeCount(type, delta) {
  if(type === 'adults') { bookingState.adults = Math.max(1, bookingState.adults + delta); document.getElementById('countAdults').textContent = bookingState.adults; }
  else { bookingState.children = Math.max(0, bookingState.children + delta); document.getElementById('countChildren').textContent = bookingState.children; }
}
function confirmPersonnes() {
  const total = bookingState.adults + bookingState.children;
  const val = document.getElementById('valPersonnes');
  if (val) { val.innerHTML = '<span class="filter-icon">👥</span> ' + total + ' personne' + (total>1?'s':''); val.classList.remove('placeholder'); }
  document.getElementById('dropPersonnes')?.classList.remove('open');
}
function renderCalendars() { renderCal('calArrive', calState.year, calState.month); renderCal('calDepart', calState.month + 1 <= 11 ? calState.year : calState.year + 1, calState.month + 1 <= 11 ? calState.month + 1 : 0); }
function renderCal(containerId, year, month) {
  const el = document.getElementById(containerId); if (!el) return;
  const months = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
  const days = ['Di','Lu','Ma','Me','Je','Ve','Sa'];
  const firstDay = new Date(year, month, 1).getDay();
  const daysInMonth = new Date(year, month + 1, 0).getDate();
  const today = new Date(); today.setHours(0,0,0,0);
  let html = `<div class="mini-calendar"><div class="cal-header">${containerId==='calArrive'?`<button type="button" class="cal-nav" onclick="shiftCal(-1)">‹</button>`:'<div></div>'}<div class="cal-title">${months[month]} ${year}</div>${containerId==='calDepart'?`<button type="button" class="cal-nav" onclick="shiftCal(1)">›</button>`:'<div></div>'}</div><div class="cal-grid">${days.map(d=>`<div class="cal-day-name">${d}</div>`).join('')}${Array(firstDay).fill('<div></div>').join('')}`;
  for(let d=1; d<=daysInMonth; d++){
    const date = new Date(year, month, d);
    const isPast = date < today;
    const isToday = date.getTime() === today.getTime();
    const isStart = bookingState.dateArrive && date.getTime() === bookingState.dateArrive.getTime();
    const isEnd = bookingState.dateDepart && date.getTime() === bookingState.dateDepart.getTime();
    const inRange = bookingState.dateArrive && bookingState.dateDepart && date > bookingState.dateArrive && date < bookingState.dateDepart;
    let cls = 'cal-day'; if(isPast) cls += ' disabled'; if(isToday) cls += ' today'; if(isStart) cls += ' range-start selected'; else if(isEnd) cls += ' range-end selected'; else if(inRange) cls += ' in-range';
    html += `<div class="${cls}" ${!isPast?`onclick="pickDate(new Date(${year},${month},${d}))"`:''}>${d}</div>`;
  }
  el.innerHTML = html + '</div></div>';
}
function shiftCal(delta) { calState.month += delta; if(calState.month > 11) { calState.month = 0; calState.year++; } if(calState.month < 0) { calState.month = 11; calState.year--; } renderCalendars(); }
function pickDate(date) {
  if(!bookingState.dateArrive || (bookingState.dateArrive && bookingState.dateDepart) || date <= bookingState.dateArrive) { bookingState.dateArrive = date; bookingState.dateDepart = null; document.getElementById('calRangeLabel').textContent = 'Maintenant sélectionnez votre date de départ'; }
  else { bookingState.dateDepart = date; const fmt = d => d.toLocaleDateString('fr-CA',{day:'numeric',month:'short'}); document.getElementById('valDateArrive').innerHTML = '<span class="filter-icon">📅</span> '+fmt(bookingState.dateArrive); document.getElementById('valDateArrive').classList.remove('placeholder'); document.getElementById('valDateDepart').innerHTML = '<span class="filter-icon">📅</span> '+fmt(bookingState.dateDepart); document.getElementById('valDateDepart').classList.remove('placeholder'); document.getElementById('calRangeLabel').textContent = fmt(bookingState.dateArrive) + ' → ' + fmt(bookingState.dateDepart); document.getElementById('dropDateArrive').classList.remove('open'); }
  renderCalendars();
}
function searchForfaits() {
  const results = document.getElementById('bookingResults'); const def = document.getElementById('bookingDefault'); const cards = document.getElementById('resultCards'); const label = document.getElementById('resultsLabel');
  let filtered = tlForfaitsData;
  if(bookingState.forfait) filtered = filtered.filter(f => f.type === bookingState.forfait || bookingState.forfait === 'Tout terrain' || f.name.toLowerCase().includes(bookingState.forfait.toLowerCase()));
  if(!filtered.length) { def.style.display = 'none'; results.style.display = 'block'; cards.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:32px;color:var(--mid-gray)">Aucun forfait trouvé. Essayez d’autres critères ou contactez-nous.</div>'; return; }
  label.textContent = filtered.length + ' forfait' + (filtered.length>1?'s':'') + ' disponible' + (filtered.length>1?'s':'');
  cards.innerHTML = filtered.map(f => `<div class="result-card${f.best?' best-match':''}"><div class="result-card-top"><div class="result-card-name">${f.icon} ${f.name}</div><div class="result-card-badge">${f.tag}</div></div><div class="result-card-meta"><div class="result-meta-item">📍 ${f.km}</div><div class="result-meta-item">⛷️ ${f.level}</div>${f.rooms?`<div class="result-meta-item">🏨 ${f.rooms}</div>`:''}${bookingState.salle?`<div class="result-meta-item">🏠 ${bookingState.salle}</div>`:''}</div><div class="result-card-price"><span style="font-size:11px;color:var(--mid-gray)">À partir de </span><span class="result-price-num">${f.price}</span><span class="result-price-unit"> ${f.unit||''}</span></div><button type="button" class="result-book-btn" onclick="bookForfait('${String(f.name).replace(/'/g, "\\'")}')">Réserver →</button></div>`).join('');
  def.style.display = 'none'; results.style.display = 'block'; results.scrollIntoView({ behavior:'smooth', block:'nearest' });
}
function bookForfait(name) { showToast('Demande de réservation pour « '+name+' »', 'success'); setTimeout(() => document.getElementById('contact')?.scrollIntoView({behavior:'smooth'}), 650); }
function toggleFaq(el){ const wasOpen=el.classList.contains('open'); document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open')); if(!wasOpen) el.classList.add('open'); }
function showTab(id, event){ document.querySelectorAll('.itinerary-panel').forEach(p=>p.classList.remove('active')); document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active')); document.getElementById('tab-'+id)?.classList.add('active'); event?.target?.classList.add('active'); }
function switchGallery(type, event){ document.querySelectorAll('.gallery-tab').forEach(t=>t.classList.remove('active')); event?.target?.classList.add('active'); const grid=document.getElementById('galleryGrid'); if(grid) grid.style.filter = type === 'instagram' ? 'sepia(.25) saturate(1.35)' : 'none'; }
function showToast(msg,type=''){ const t=document.getElementById('toast'); if(!t) return; t.textContent=msg; t.className='toast'+(type?' '+type:''); setTimeout(()=>t.classList.add('show'),50); setTimeout(()=>t.classList.remove('show'),3500); }

window.addEventListener('scroll',()=>{ document.getElementById('navbar')?.classList.toggle('scrolled',window.scrollY>50); });
document.getElementById('tlContactForm')?.addEventListener('submit', function(e){ e.preventDefault(); const params = new URLSearchParams(new FormData(this)); params.set('etablissement_id', tlConfig.etablissementId || ''); window.open(tlDevisLink + (tlDevisLink.includes('?') ? '&' : '?') + params.toString(), '_blank'); });

const snow = document.getElementById('snowContainer');
if (snow) { for(let i=0;i<28;i++){ const s=document.createElement('div'); s.className='snowflake'; const size=Math.random()*5+2; s.style.cssText=`left:${Math.random()*100}%;width:${size}px;height:${size}px;opacity:${Math.random()*.6+.2};animation-duration:${Math.random()*8+6}s;animation-delay:${Math.random()*10}s`; snow.appendChild(s); } }

const mapNode=document.getElementById('tlMap');
if(mapNode && window.L){
  const lat=Number(mapNode.dataset.lat||47.6577); const lng=Number(mapNode.dataset.lng||-70.1526); const title=mapNode.dataset.title||tlConfig.siteName||''; const address=mapNode.dataset.address||tlConfig.address||''; const videoUrl=tlConfig.mapVideoUrl||'';
  const map=L.map(mapNode,{zoomControl:true,scrollWheelZoom:false}).setView([lat,lng],6);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap contributors'}).addTo(map);
  const icon=L.divIcon({className:'lf-marker',html:'<div class="lf-marker-wrap"><i class="fas fa-seedling"></i></div>',iconSize:[42,42],iconAnchor:[21,40],popupAnchor:[0,-36]});
  const popupHtml='<div style="width:320px;max-width:100%;"><div style="font-weight:800;margin-bottom:8px;color:#0d2137;">'+title+'</div><div style="font-size:12px;color:#666;margin-bottom:10px;line-height:1.45;">'+address+'</div><iframe width="320" height="180" src="'+videoUrl+'" title="Vidéo sur la carte" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="display:block;width:100%;border-radius:8px;"></iframe></div>';
  const marker=L.marker([lat,lng],{icon}).addTo(map).bindPopup(popupHtml,{maxWidth:360,minWidth:260});
  document.getElementById('tlMapVideoBtn')?.addEventListener('click',function(){map.setView(marker.getLatLng(),6,{animate:true});marker.openPopup();});
  setTimeout(()=>map.invalidateSize(),250);
}

initSlideshow();
</script>

