@php
    $cmsRawOpeningHours = $hours ?? null;

    if ($cmsRawOpeningHours === null && isset($etablissement)) {
        $cmsRawOpeningHours = $etablissement->getSetting('opening_hours', null, 'company');
    }

    $cmsHasExplicitOpeningHours = false;
    if (is_array($cmsRawOpeningHours)) {
        $cmsHasExplicitOpeningHours = count(array_filter($cmsRawOpeningHours, function ($row) {
            if (is_array($row)) {
                return trim((string) ($row['day'] ?? $row['label'] ?? $row['hours'] ?? $row['value'] ?? '')) !== '';
            }

            return trim((string) $row) !== '';
        })) > 0;
    } else {
        $cmsRawOpeningHoursText = trim((string) $cmsRawOpeningHours);
        $cmsHasExplicitOpeningHours = $cmsRawOpeningHoursText !== ''
            && !in_array(mb_strtolower($cmsRawOpeningHoursText, 'UTF-8'), ['[]', '{}', 'null'], true);
    }

    $cmsLandingWorkingHours = $cmsHasExplicitOpeningHours
        ? normalize_cms_opening_hours($cmsRawOpeningHours, [])
        : collect();
    $cmsLandingWorkingHours = collect($cmsLandingWorkingHours)
        ->filter(fn ($row) => trim((string) ($row['day'] ?? $row['hours'] ?? '')) !== '')
        ->values();

    $cmsHoursSiteName = trim((string) ($siteName ?? get_site_name($etablissement->id) ?: ($etablissement->name ?? '')));
    $cmsHoursAddress = trim((string) ($address ?? $etablissement->adresse ?? $etablissement->address ?? $etablissement->ville ?? ''));
    $cmsHoursPhone = trim((string) ($phone ?? $etablissement->telephone ?? $etablissement->phone ?? ''));
    $cmsHoursPhoneHref = preg_replace('/\s+/', '', $cmsHoursPhone);
    $cmsHoursEmail = trim((string) ($email ?? $etablissement->email ?? $etablissement->contact_email ?? ''));
    $cmsClosedNeedles = ['ferme', 'fermee', 'closed', 'off', 'indisponible'];
@endphp

@if($cmsHasExplicitOpeningHours && $cmsLandingWorkingHours->isNotEmpty())
    @once
        <style>
            .horaires-wrap{--hours-bg:var(--bg,var(--boids-bg,#FAFAF8));--hours-card:var(--card,var(--card-bg,var(--boids-card,#fff)));--hours-border:var(--border,var(--boids-border,rgba(45,106,79,.12)));--hours-border2:var(--border2,var(--border,rgba(45,106,79,.2)));--hours-text:var(--text,var(--boids-ink,#1A2E1E));--hours-text2:var(--text2,var(--text-muted,var(--boids-muted,#4A6355)));--hours-text3:var(--text3,var(--muted,#8FA898));--hours-sage:var(--sage,var(--gold,var(--y,#2D6A4F)));--hours-sage2:var(--sage2,var(--gold,var(--y,#40916C)));--hours-sage3:var(--sage3,var(--gold,var(--y,#52B788)));--hours-pale:rgba(45,106,79,.08);--hours-shadow:var(--sh2,var(--sh,0 18px 48px rgba(45,106,79,.10)));background:var(--hours-bg);padding:96px 40px;margin-bottom:2rem;color:var(--hours-text)}
            .horaires-wrap .container{width:min(1180px,calc(100% - 40px));margin:auto}
            .horaires-layout{display:grid;grid-template-columns:1.1fr 1fr;gap:56px;align-items:start}
            .horaires-head{display:flex;align-items:flex-end;justify-content:space-between;gap:30px;margin-bottom:42px}
            .horaires-pill{display:inline-flex;align-items:center;gap:10px;font-size:10px;font-weight:800;letter-spacing:3px;text-transform:uppercase;color:var(--hours-sage);margin-bottom:14px}
            .horaires-pill:before{content:"";width:22px;height:2px;background:var(--hours-sage);border-radius:2px}
            .horaires-title{font-family:Fraunces,Playfair Display,serif;font-size:clamp(34px,4.6vw,62px);font-weight:700;line-height:1.05;color:var(--hours-text);margin:0}
            .horaires-title em{font-style:italic;color:var(--hours-sage)}
            .horaires-sub{font-size:14px;color:var(--hours-text2);line-height:1.8;max-width:520px;margin:0;text-align:right}
            .horaires-card{background:var(--hours-card);border:1px solid var(--hours-border);border-radius:24px;overflow:hidden;box-shadow:var(--hours-shadow)}
            .h-card-header{background:var(--hours-sage);padding:28px 32px}
            .h-card-title{font-family:Fraunces,Playfair Display,serif;font-size:22px;font-weight:700;color:#fff}
            .h-card-sub{font-size:12px;color:rgba(255,255,255,.72);margin-top:4px;line-height:1.5}
            .h-card-body{padding:8px 0}
            .h-row{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:16px 32px;border-bottom:1px solid var(--hours-border);transition:all .35s ease}
            .h-row:last-child{border-bottom:none}
            .h-row:hover{background:var(--hours-pale)}
            .h-day{font-size:13px;font-weight:700;color:var(--hours-text);display:flex;align-items:center;gap:8px}
            .h-dot{width:7px;height:7px;border-radius:50%;background:var(--hours-sage3);flex:0 0 auto}
            .h-dot.closed{background:var(--hours-text3)}
            .h-time{font-family:Fraunces,Playfair Display,serif;font-size:15px;font-weight:700;color:var(--hours-sage);text-align:right}
            .h-time.closed{color:var(--hours-text3);font-style:italic;font-family:Plus Jakarta Sans,DM Sans,Arial,sans-serif;font-size:12px}
            .h-urgences{margin-top:24px;background:var(--hours-pale);border:1px solid var(--hours-border2);border-radius:18px;padding:22px 24px;display:flex;align-items:flex-start;gap:14px}
            .h-urg-icon{width:42px;height:42px;border-radius:14px;background:var(--hours-sage);color:#fff;display:grid;place-items:center;flex:0 0 auto}
            .h-urg-title{font-size:14px;font-weight:800;color:var(--hours-text);margin-bottom:4px}
            .h-urg-desc{font-size:12px;color:var(--hours-text2);line-height:1.7}
            .h-urg-tel{display:inline-flex;color:var(--hours-sage);font-weight:800;font-size:15px;margin-top:8px;letter-spacing:.4px}
            .appointment-widget{background:var(--hours-card);border:1px solid var(--hours-border);border-radius:24px;padding:34px;box-shadow:var(--hours-shadow)}
            .aw-title{font-family:Fraunces,Playfair Display,serif;font-size:26px;font-weight:700;color:var(--hours-text);margin-bottom:6px}
            .aw-sub{font-size:13px;color:var(--hours-text3);margin-bottom:24px;line-height:1.7}
            .aw-info-list{display:grid;gap:12px;margin-bottom:24px}
            .aw-info{display:grid;grid-template-columns:42px 1fr;gap:12px;align-items:center;border:1px solid var(--hours-border);border-radius:14px;padding:12px;background:rgba(255,255,255,.03)}
            .aw-info i{width:42px;height:42px;border-radius:12px;background:var(--hours-pale);color:var(--hours-sage);display:grid;place-items:center}
            .aw-info strong{display:block;font-size:10px;letter-spacing:1.7px;text-transform:uppercase;color:var(--hours-text3);margin-bottom:2px}
            .aw-info span,.aw-info a{color:var(--hours-text2);font-size:13px;line-height:1.55}
            .aw-submit{width:100%;background:var(--hours-sage);color:#fff;border:none;padding:15px 18px;border-radius:50px;font:inherit;font-size:13px;font-weight:800;letter-spacing:1px;cursor:pointer;transition:all .35s ease;display:flex;align-items:center;justify-content:center;gap:10px;text-decoration:none}
            .aw-submit:hover{background:var(--hours-sage2);transform:translateY(-2px);box-shadow:0 10px 36px rgba(45,106,79,.25);color:#fff}
            @media(max-width:1200px){.horaires-wrap{padding:80px 24px}.horaires-layout{grid-template-columns:1fr;gap:34px}.horaires-sub{text-align:left}}
            @media(max-width:768px){.horaires-wrap{padding:64px 0}.horaires-wrap .container{width:min(100% - 28px,1180px)}.horaires-head{display:block}.h-row{padding:15px 20px;align-items:flex-start}.appointment-widget,.h-card-header{padding:24px 22px}}
        </style>
    @endonce

    <section class="horaires-wrap" id="horaires">
        <div class="container">
            <div class="horaires-head">
                <div>
                    <div class="horaires-pill">Disponibilites</div>
                    <h2 class="horaires-title">Horaires &<br><em>prise de contact</em></h2>
                </div>
                <p class="horaires-sub">Consultez les horaires publies par l'etablissement et envoyez une demande depuis le formulaire de contact.</p>
            </div>
            <div class="horaires-layout">
                <div>
                    <div class="horaires-card">
                        <div class="h-card-header">
                            <div class="h-card-title">Horaires d'ouverture</div>
                            @if($cmsHoursSiteName || $cmsHoursAddress)
                                <div class="h-card-sub">
                                    {{ $cmsHoursSiteName }}@if($cmsHoursSiteName && $cmsHoursAddress) - @endif{{ $cmsHoursAddress }}
                                </div>
                            @endif
                        </div>
                        <div class="h-card-body">
                            @foreach($cmsLandingWorkingHours as $row)
                                @php
                                    $rowHours = trim((string) ($row['hours'] ?? ''));
                                    $rowHoursAscii = mb_strtolower(\Illuminate\Support\Str::ascii($rowHours), 'UTF-8');
                                    $isClosed = $rowHours === '' || collect($cmsClosedNeedles)->contains(fn ($needle) => str_contains($rowHoursAscii, $needle));
                                @endphp
                                <div class="h-row">
                                    <div class="h-day"><div class="h-dot{{ $isClosed ? ' closed' : '' }}"></div>{{ $row['day'] ?? '' }}</div>
                                    <div class="h-time{{ $isClosed ? ' closed' : '' }}">{{ $rowHours ?: 'Ferme' }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if($cmsHoursPhone)
                        <div class="h-urgences">
                            <div class="h-urg-icon"><i class="fa-solid fa-phone"></i></div>
                            <div>
                                <div class="h-urg-title">Contact direct</div>
                                <div class="h-urg-desc">Pour une demande rapide, contactez directement l'etablissement par telephone.</div>
                                <a href="tel:{{ $cmsHoursPhoneHref }}" class="h-urg-tel">{{ $cmsHoursPhone }}</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="appointment-widget">
                    <div class="aw-title">Prendre contact</div>
                    <div class="aw-sub">Les informations ci-dessous proviennent des donnees de l'etablissement.</div>
                    <div class="aw-info-list">
                        @if($cmsHoursPhone)
                            <div class="aw-info"><i class="fa-solid fa-phone"></i><div><strong>Telephone</strong><a href="tel:{{ $cmsHoursPhoneHref }}">{{ $cmsHoursPhone }}</a></div></div>
                        @endif
                        @if($cmsHoursEmail)
                            <div class="aw-info"><i class="fa-solid fa-envelope"></i><div><strong>Courriel</strong><a href="mailto:{{ $cmsHoursEmail }}">{{ $cmsHoursEmail }}</a></div></div>
                        @endif
                        @if($cmsHoursAddress)
                            <div class="aw-info"><i class="fa-solid fa-location-dot"></i><div><strong>Adresse</strong><span>{{ $cmsHoursAddress }}</span></div></div>
                        @endif
                    </div>
                    <a href="#contact" class="aw-submit">Envoyer une demande <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
@endif
