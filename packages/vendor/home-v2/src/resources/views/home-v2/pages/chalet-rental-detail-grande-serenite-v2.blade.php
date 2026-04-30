<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grande Serenite - Experience premium bord de lac | GoExploria</title>
    <meta name="description" content="Grande Serenite a St-Tite, Mauricie: geo carte, slider photos/video, activites 4 saisons, calendrier de reservation et commodites completes.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Montserrat', sans-serif; background: #f3f6fb; color: #101828; font-size: 17px; }
        .page-header {
            background: linear-gradient(120deg, #0a1628, #1a2942);
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .page-header-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .brand { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; color: #fff; }
        .brand img { height: 64px; width: auto; }
        .brand small { display: block; opacity: .84; font-size: 12px; }
        .brand strong { font-size: 15px; }
        .top-nav { display: flex; gap: 8px; flex-wrap: wrap; }
        .top-nav a {
            color: rgba(255,255,255,.9);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 999px;
            padding: 9px 12px;
        }
        .top-nav a.active { border-color: rgba(212,175,55,.6); background: rgba(212,175,55,.15); color: #f5d675; }

        .wrap { max-width: 1280px; margin: 0 auto; padding: 28px 20px 80px; }
        .crumbs { color: #667085; font-size: 13px; margin-bottom: 16px; }
        .crumbs a { color: #344054; text-decoration: none; }

        .hero {
            border-radius: 24px;
            overflow: hidden;
            background: linear-gradient(120deg, #0b1a34, #1d335e);
            color: #fff;
            box-shadow: 0 20px 55px rgba(16,24,40,.25);
            margin-bottom: 24px;
        }
        .hero-grid { display: grid; grid-template-columns: 1.18fr .82fr; }
        .hero-main { position: relative; min-height: 460px; }
        .hero-main img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(6,13,27,.86), rgba(6,13,27,.15));
            display: flex; align-items: end; padding: 28px;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 12px; font-weight: 800; letter-spacing: .8px; text-transform: uppercase;
            color: #f4d36c;
            border: 1px solid rgba(212,175,55,.48);
            background: rgba(212,175,55,.16);
        }
        .hero-title { font-size: clamp(2rem, 2.3vw, 2.6rem); line-height: 1.18; font-weight: 900; margin: 12px 0 8px; }
        .hero-property-name { font-size: clamp(1.05rem, 1.35vw, 1.3rem); color: #f8e39f; font-weight: 800; margin-bottom: 10px; }
        .hero-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 8px 0 12px; }
        .hero-tag {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 6px 11px;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(255,255,255,.1);
            font-size: 11px;
            letter-spacing: .5px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .hero-sub { font-size: 16px; line-height: 1.72; color: rgba(255,255,255,.9); max-width: 650px; }

        .hero-side { padding: 24px; display: flex; flex-direction: column; gap: 14px; }
        .region-box {
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(255,255,255,.07);
            border-radius: 12px;
            padding: 12px 14px;
            text-align: right;
        }
        .region-title { font-size: 11px; letter-spacing: .8px; text-transform: uppercase; color: rgba(255,255,255,.8); }
        .region-value { margin-top: 4px; font-size: 15px; font-weight: 800; color: #f4d36c; }

        .price-box {
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.08);
            border-radius: 14px;
            padding: 16px;
        }
        .price-main { font-size: 2rem; font-weight: 900; line-height: 1; color: #f4d36c; }
        .price-note { margin-top: 8px; font-size: 13px; color: rgba(255,255,255,.86); line-height: 1.55; }

        .meta-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .meta-card {
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.06);
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 13px;
        }
        .meta-card b { display: block; margin-top: 4px; font-size: 14px; color: #fff; }

        .geo-context {
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.06);
            border-radius: 12px;
            padding: 12px;
        }
        .geo-context h3 { font-size: 13px; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 8px; }
        .geo-icons { display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .geo-item {
            display: inline-flex; align-items: center; gap: 8px;
            font-size: 12px; color: rgba(255,255,255,.92);
            padding: 7px 8px;
            border-radius: 9px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.14);
        }
        .geo-item i { color: #f4d36c; width: 16px; text-align: center; }

        .stay-box {
            border: 1px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.06);
            border-radius: 12px;
            padding: 12px;
        }
        .stay-box h3 { font-size: 13px; text-transform: uppercase; margin-bottom: 8px; letter-spacing: .6px; }
        .stay-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
        .stay-chip { padding: 6px 10px; border-radius: 999px; border: 1px solid rgba(255,255,255,.22); font-size: 12px; font-weight: 700; }
        .stay-hours { font-size: 13px; color: rgba(255,255,255,.92); line-height: 1.5; }

        .hero-actions { display: flex; gap: 10px; flex-wrap: wrap; }
        .hero-actions .btn,
        .media-caption .btn,
        .contact-form .btn {
            border: 0;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }
        .hero-actions .btn-primary,
        .contact-form .btn-primary,
        .media-caption .btn-primary { background: linear-gradient(135deg, #d4af37, #f4d978); color: #1f2937; }
        .hero-actions .btn-dark,
        .media-caption .btn-dark { background: rgba(255,255,255,.14); color: #fff; border: 1px solid rgba(255,255,255,.2); }

        .section-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 9px 26px rgba(16,24,40,.08);
            margin-bottom: 18px;
        }
        .section-card h2 { font-size: 1.35rem; margin-bottom: 12px; }
        .section-card p { font-size: 16px; line-height: 1.85; color: #475467; }

        .geo-map-embed {
            border: 1px solid #e6ebf3;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .media-slider {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e6ebf3;
        }
        .media-track { display: flex; transition: transform .45s ease; }
        .media-slide { min-width: 100%; position: relative; }
        .media-slide img { width: 100%; height: 420px; object-fit: cover; display: block; }
        .media-caption {
            position: absolute; left: 14px; right: 14px; bottom: 14px;
            background: rgba(10,22,40,.68);
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 10px;
            padding: 10px 12px;
            color: #fff;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            gap: 8px;
            align-items: center;
        }
        .media-nav {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }
        .media-dot { width: 10px; height: 10px; border-radius: 50%; border: 0; background: #d0d5dd; cursor: pointer; }
        .media-dot.active { background: #1e88e5; }
        .media-strip {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
        }
        .media-thumb {
            border: 1px solid #d8e0ec;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
            cursor: pointer;
            position: relative;
            min-height: 94px;
        }
        .media-thumb img { width: 100%; height: 94px; object-fit: cover; display: block; }
        .media-thumb.active { box-shadow: 0 0 0 2px #1e88e5 inset; }
        .media-thumb-label {
            position: absolute;
            left: 7px;
            right: 7px;
            bottom: 7px;
            background: rgba(10,22,40,.66);
            color: #fff;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 7px;
            line-height: 1.2;
        }
        .media-thumb-video {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
            height: 100%;
            background: linear-gradient(135deg, #0a1628, #1d335e);
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border: 0;
            width: 100%;
        }
        .media-thumb-video i { font-size: 1.4rem; color: #f4d36c; }
        .media-thumb-video b { font-size: 12px; text-align: center; line-height: 1.35; }
        .chalet-video-modal {
            position: fixed;
            inset: 0;
            z-index: 3000;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(3, 10, 22, .78);
            padding: 24px;
        }
        .chalet-video-modal.active { display: flex; }
        .chalet-video-modal-panel {
            width: min(980px, 100%);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.25);
            background: #0f172a;
            box-shadow: 0 24px 60px rgba(2, 6, 23, .5);
        }
        .chalet-video-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 14px;
            background: linear-gradient(90deg, #0f2a4f, #1a3a68);
            color: #fff;
        }
        .chalet-video-modal-head h3 {
            margin: 0;
            font-size: 1.02rem;
            letter-spacing: .3px;
            font-weight: 800;
        }
        .chalet-video-close {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,.3);
            background: rgba(255,255,255,.12);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
        }
        .chalet-video-frame-wrap {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%;
            background: #000;
        }
        .chalet-video-frame-wrap iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .two-col { display: grid; grid-template-columns: 1.45fr .95fr; gap: 18px; align-items: start; }

        .experience-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 12px; }
        .experience-card {
            border: 1px solid #e6ebf3;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 6px 18px rgba(16,24,40,.06);
        }
        .experience-card img { width: 100%; height: 180px; object-fit: cover; display: block; }
        .experience-body { padding: 13px 14px 14px; }
        .experience-type {
            display: inline-flex;
            border-radius: 999px;
            padding: 4px 8px;
            background: #e9f2ff;
            color: #155eef;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .4px;
            text-transform: uppercase;
            margin-bottom: 7px;
        }
        .experience-title { font-size: 16px; line-height: 1.4; font-weight: 800; color: #0f172a; }
        .experience-text { margin-top: 6px; font-size: 14px; line-height: 1.65; color: #475467; }
        .experience-title--hero {
            font-size: 20px;
            line-height: 1.28;
            background: linear-gradient(90deg, #0f2a4f, #2a5bd7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-transform: uppercase;
            letter-spacing: .35px;
        }

        .booking-redesign {
            border: 1px solid #dbe5f4;
            background: linear-gradient(180deg, #f9fbff 0%, #ffffff 55%);
        }
        .booking-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #d4ddec;
        }
        .booking-top p {
            margin-top: 6px;
            font-size: 15px;
            color: #475467;
            line-height: 1.6;
        }
        .booking-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            border: 1px solid #d4af37;
            background: #fff8e1;
            color: #8a6213;
            font-weight: 800;
            font-size: 11px;
            letter-spacing: .35px;
            text-transform: uppercase;
            padding: 8px 12px;
            white-space: nowrap;
        }
        .booking-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.75fr) minmax(0, .9fr);
            gap: 16px;
            align-items: start;
        }
        .month-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .month-card {
            border: 1px solid #dbe5f4;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 22px rgba(16,24,40,.05);
        }
        .month-head {
            background: linear-gradient(90deg, #0f2a4f, #1a3a68);
            border-bottom: 1px solid #dbe5f4;
            padding: 11px 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .month-head b { font-size: 16px; color: #fff; letter-spacing: .25px; }
        .month-head span { font-size: 12px; color: #dbe9ff; font-weight: 700; }
        .month-weekdays, .month-days {
            display: grid;
            grid-template-columns: repeat(7, minmax(0, 1fr));
        }
        .month-weekdays div {
            padding: 9px 0;
            text-align: center;
            font-size: 11px;
            font-weight: 800;
            color: #667085;
            border-bottom: 1px solid #edf2fa;
            text-transform: uppercase;
        }
        .month-days div {
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            border-right: 1px solid #f2f4f7;
            border-bottom: 1px solid #f2f4f7;
            color: #344054;
        }
        .month-days div:nth-child(7n) { border-right: 0; }
        .day-off { color: #98a2b3; background: #fcfcfd; }
        .day-ok { background: #ecfdf3; color: #027a48; font-weight: 800; }
        .day-busy { background: #fff1f3; color: #b42318; font-weight: 800; }
        .day-alert { background: #fffaeb; color: #b54708; font-weight: 800; }
        .month-legend { margin-top: 12px; display: flex; gap: 10px; flex-wrap: wrap; }
        .legend-item { display: inline-flex; align-items: center; gap: 7px; font-size: 13px; color: #475467; font-weight: 700; }
        .legend-dot { width: 10px; height: 10px; border-radius: 50%; }
        .legend-ok { background: #12b76a; }
        .legend-busy { background: #f04438; }
        .legend-alert { background: #f79009; }
        .booking-side {
            display: grid;
            gap: 12px;
        }
        .booking-side-card {
            border: 1px solid #dbe5f4;
            border-radius: 14px;
            background: #fff;
            padding: 13px 14px;
            box-shadow: 0 8px 20px rgba(16,24,40,.04);
        }
        .booking-side-card h3 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: .45px;
            color: #0f2a4f;
            margin-bottom: 9px;
        }
        .booking-side-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 14px;
            color: #344054;
            padding: 8px 0;
            border-bottom: 1px dashed #e4eaf4;
        }
        .booking-side-line:last-child { border-bottom: 0; }
        .booking-side-line b { color: #101828; }

        .amenities-redesign {
            margin-top: 2px;
        }
        .amenities-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(0, .95fr);
            gap: 16px;
            align-items: start;
        }
        .amenities-main {
            border: 1px solid #dbe5f4;
            background: #fff;
        }
        .amenities-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 14px;
        }
        .amenities-head h2 { margin-bottom: 0; }
        .amenities-head p {
            margin-top: 6px;
            font-size: 15px;
            color: #475467;
            line-height: 1.6;
        }
        .amenities-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            border: 1px solid #cad8ef;
            background: #f5f9ff;
            color: #1a3a68;
            padding: 7px 11px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .icon-list-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .icon-list-block {
            border: 1px solid #e3eaf6;
            border-radius: 14px;
            padding: 12px;
            background: linear-gradient(180deg, #fbfdff 0%, #f6f9ff 100%);
        }
        .icon-list-block h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #0f2a4f;
            text-transform: uppercase;
            letter-spacing: .35px;
        }
        .amenity-list { display: grid; gap: 7px; }
        .amenity-row {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 14px;
            color: #344054;
            line-height: 1.45;
            padding: 6px 8px;
            border-radius: 9px;
            background: rgba(255,255,255,.65);
        }
        .amenity-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #fff;
            flex: 0 0 32px;
        }
        .c-ext { background: #1e88e5; }
        .c-sport { background: #12b76a; }
        .c-int { background: #f79009; }
        .c-kitchen { background: #7a5af8; }
        .c-family { background: #ef5da8; }
        .c-access { background: #344054; }
        .c-service { background: #0ea5e9; }
        .c-excl { background: #f04438; }
        .contact-pro-card {
            border: 1px solid #dbe5f4;
            background: #fff;
            position: sticky;
            top: 16px;
        }
        .contact-pro-card h2 { margin-bottom: 6px; }
        .contact-subline {
            margin-bottom: 12px;
            font-size: 14px;
            color: #475467;
            line-height: 1.6;
        }
        .contact-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .contact-form .f { margin-bottom: 10px; }
        .contact-form .f-full { grid-column: 1 / -1; }
        .contact-form label {
            display: block;
            margin-bottom: 5px;
            font-size: 12px;
            font-weight: 800;
            color: #344054;
            letter-spacing: .35px;
            text-transform: uppercase;
        }
        .contact-form input, .contact-form textarea, .contact-form select {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 12px 13px;
            font-size: 14px;
            font-family: inherit;
            background: #fdfefe;
        }
        .contact-form textarea { min-height: 124px; resize: vertical; }
        .contact-help {
            margin-top: 8px;
            font-size: 13px;
            color: #667085;
            line-height: 1.55;
        }

        .footer {
            background: #0f172a;
            color: rgba(255,255,255,.86);
            margin-top: 20px;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 26px 20px;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 18px;
        }
        .footer h4 { color: #f4d36c; font-size: 12px; letter-spacing: .8px; text-transform: uppercase; margin-bottom: 10px; }
        .footer p, .footer a { font-size: 13px; line-height: 1.75; color: rgba(255,255,255,.84); text-decoration: none; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.14); text-align: center; padding: 12px 20px 16px; font-size: 11px; color: rgba(255,255,255,.72); }

        @media (max-width: 1100px) {
            .hero-grid, .two-col, .booking-layout, .amenities-layout { grid-template-columns: 1fr; }
            .experience-grid { grid-template-columns: repeat(2, 1fr); }
            .month-grid { grid-template-columns: 1fr; }
            .icon-list-grid { grid-template-columns: 1fr; }
            .media-slide img { height: 340px; }
            .media-strip { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .footer-inner { grid-template-columns: 1fr; }
            .contact-pro-card { position: static; }
        }
        @media (max-width: 720px) {
            .hero-main { min-height: 320px; }
            .hero-title { font-size: 1.6rem; }
            .hero-sub { font-size: 14px; }
            .experience-grid { grid-template-columns: 1fr; }
            .page-header-inner { flex-direction: column; align-items: flex-start; }
            .media-slide img { height: 260px; }
            .media-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .geo-icons { grid-template-columns: 1fr; }
            .contact-form-grid { grid-template-columns: 1fr; }
            .booking-top { flex-direction: column; align-items: flex-start; }
            .experience-title--hero { font-size: 17px; }
        }
    </style>
</head>
<body>
@php
    $amenities = [
        'Attraits exterieurs' => [
            ['icon' => 'fa-tree', 'text' => 'Cour arriere', 'class' => 'c-ext'],
            ['icon' => 'fa-fire', 'text' => 'Foyer exterieur', 'class' => 'c-ext'],
            ['icon' => 'fa-gas-pump', 'text' => 'Propane inclus', 'class' => 'c-ext'],
            ['icon' => 'fa-hot-tub-person', 'text' => 'Spa', 'class' => 'c-ext'],
            ['icon' => 'fa-binoculars', 'text' => 'Vue', 'class' => 'c-ext'],
            ['icon' => 'fa-burger', 'text' => 'BBQ/Grill', 'class' => 'c-ext'],
            ['icon' => 'fa-person-booth', 'text' => 'Balcon/terrasse', 'class' => 'c-ext'],
        ],
        'Sports et activites a proximite' => [
            ['icon' => 'fa-person-skiing', 'text' => 'Ski alpin', 'class' => 'c-sport'],
            ['icon' => 'fa-motorcycle', 'text' => 'Sentiers de VTT', 'class' => 'c-sport'],
            ['icon' => 'fa-ship', 'text' => 'Navigation de plaisance', 'class' => 'c-sport'],
            ['icon' => 'fa-water', 'text' => 'Canot / Kayak / Planche a pagaie', 'class' => 'c-sport'],
            ['icon' => 'fa-fish', 'text' => 'Peche', 'class' => 'c-sport'],
            ['icon' => 'fa-golf-ball-tee', 'text' => 'Golf', 'class' => 'c-sport'],
            ['icon' => 'fa-person-hiking', 'text' => 'Randonnee pedestre', 'class' => 'c-sport'],
            ['icon' => 'fa-person-snowboarding', 'text' => 'Planche a neige / Raquette', 'class' => 'c-sport'],
            ['icon' => 'fa-road', 'text' => 'Velo de route / montagne', 'class' => 'c-sport'],
            ['icon' => 'fa-wind', 'text' => 'Voile / Planche a voile', 'class' => 'c-sport'],
        ],
        'Attraits interieurs' => [
            ['icon' => 'fa-snowflake', 'text' => 'Climatisation', 'class' => 'c-int'],
            ['icon' => 'fa-bed', 'text' => 'Literie + literie supplementaire', 'class' => 'c-int'],
            ['icon' => 'fa-faucet-drip', 'text' => 'Eau chaude / Eau potable', 'class' => 'c-int'],
            ['icon' => 'fa-fireplace', 'text' => 'Foyer interieur', 'class' => 'c-int'],
            ['icon' => 'fa-tv', 'text' => 'Television', 'class' => 'c-int'],
            ['icon' => 'fa-wifi', 'text' => 'Wifi', 'class' => 'c-int'],
            ['icon' => 'fa-shirt', 'text' => 'Laveuse / Secheuse / Serviettes', 'class' => 'c-int'],
            ['icon' => 'fa-temperature-full', 'text' => 'Plancher chauffant / Chauffage', 'class' => 'c-int'],
        ],
        'Cuisine & Cafe' => [
            ['icon' => 'fa-kitchen-set', 'text' => 'Cuisine complete', 'class' => 'c-kitchen'],
            ['icon' => 'fa-utensils', 'text' => 'Vaisselle et ustensiles', 'class' => 'c-kitchen'],
            ['icon' => 'fa-blender', 'text' => 'Lave-vaisselle / Four / Micro-ondes', 'class' => 'c-kitchen'],
            ['icon' => 'fa-pan-frying', 'text' => 'Marmites, casseroles, poele', 'class' => 'c-kitchen'],
            ['icon' => 'fa-icicles', 'text' => 'Refrigerateur', 'class' => 'c-kitchen'],
            ['icon' => 'fa-cheese', 'text' => 'Poele a raclette electrique', 'class' => 'c-kitchen'],
            ['icon' => 'fa-mug-hot', 'text' => 'Cafetiere filtre + presse francaise', 'class' => 'c-kitchen'],
            ['icon' => 'fa-bowl-food', 'text' => 'Poele a fondue electrique', 'class' => 'c-kitchen'],
        ],
        'Famille, accessibilite, services' => [
            ['icon' => 'fa-baby', 'text' => 'Baignoire / Chaise haute', 'class' => 'c-family'],
            ['icon' => 'fa-door-open', 'text' => 'Entree privee', 'class' => 'c-access'],
            ['icon' => 'fa-car-battery', 'text' => 'Chargeur de VE', 'class' => 'c-service'],
            ['icon' => 'fa-paw', 'text' => 'Adapte aux animaux', 'class' => 'c-service'],
            ['icon' => 'fa-square-parking', 'text' => 'Stationnement gratuit', 'class' => 'c-service'],
            ['icon' => 'fa-ban', 'text' => 'Bois exclus', 'class' => 'c-excl'],
        ],
    ];
@endphp

<header class="page-header">
    <div class="page-header-inner">
        <a href="{{ route('home-v2') }}" class="brand">
            <img src="{{ asset('logo.png') }}" alt="GoExploria">
            <div>
                <small>Collection premium</small>
                <strong>CHALET A LOUER</strong>
            </div>
        </a>
        <nav class="top-nav" aria-label="Navigation page chalet">
            <a href="#geo-map-section">Carte</a>
            <a href="#calendar" class="active">Calendrier</a>
            <a href="#amenities">Commodites</a>
            <a href="#contact-proprio">Contacter</a>
        </nav>
    </div>
</header>

<main class="wrap">
    <div class="crumbs">
        <a href="{{ route('home-v2') }}">Accueil</a> / <a href="#">Chalets a louer</a> / <span>Grande Serenite</span>
    </div>

    <section class="hero">
        <div class="hero-grid">
            <div class="hero-main">
                <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1600&auto=format&fit=crop&q=80" alt="Grande Serenite bord de lac">
                <div class="hero-overlay">
                    <div>
                        <span class="hero-badge"><i class="fas fa-house-chimney-window"></i> Grande Serenite - Experience premium bord de lac</span>
                        <h1 class="hero-title">CHALET A LOUER</h1>
                        <div class="hero-property-name">Grande Serenite - Experience premium bord de lac</div>
                        <div class="hero-tags" aria-label="Regions">
                            <span class="hero-tag">CANADA</span>
                            <span class="hero-tag">MOURICIE</span>
                            <span class="hero-tag">ST-TITE</span>
                        </div>
                        <p class="hero-sub">Location haut de gamme a St-Tite avec geo carte, galerie immersive, activites 4 saisons et reservation avec disponibilites.</p>
                    </div>
                </div>
            </div>
            <aside class="hero-side">
                <div class="region-box">
                <div class="region-title">Region</div>
                    <div class="region-value">CANADA, MOURICIE, ST-TITE</div>
                </div>

                <div class="price-box">
                    <div class="price-main">595$ - 650$ / nuit</div>
                    <div class="price-note">Voir details des prix en bas. Long terme: 2, 3 ou 4 semaines.</div>
                </div>

                <div class="meta-grid">
                    <div class="meta-card"><i class="fas fa-users"></i> Capacite<b>16 personnes</b></div>
                    <div class="meta-card"><i class="fas fa-bed"></i> Chambres<b>7 chambres</b></div>
                    <div class="meta-card"><i class="fas fa-bath"></i> Salles de bain<b>3 + 1 salle d eau</b></div>
                    <div class="meta-card"><i class="fas fa-location-dot"></i> Emplacement<b>Bord de lac prive</b></div>
                </div>

                <div class="geo-context">
                    <h3>Contexte geographique</h3>
                    <div class="geo-icons">
                        <span class="geo-item"><i class="fas fa-anchor"></i> Quai</span>
                        <span class="geo-item"><i class="fas fa-water"></i> Lac</span>
                        <span class="geo-item"><i class="fas fa-water-ladder"></i> Riviere</span>
                        <span class="geo-item"><i class="fas fa-hot-tub-person"></i> Bain tourbillon</span>
                        <span class="geo-item"><i class="fas fa-bicycle"></i> Velos electriques</span>
                        <span class="geo-item"><i class="fas fa-paw"></i> Animaux admis</span>
                    </div>
                </div>

                <div class="stay-box">
                    <h3>Location long terme</h3>
                    <div class="stay-chips">
                        <span class="stay-chip">2 semaines</span>
                        <span class="stay-chip">3 semaines</span>
                        <span class="stay-chip">4 semaines</span>
                    </div>
                    <div class="stay-hours">Arrivee: 17:00<br>Depart: 11:00</div>
                </div>

                <div class="hero-actions">
                    <a href="#contact-proprio" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Contacter le proprietaire</a>
                    <button type="button" class="btn btn-dark js-open-chalet-video" data-youtube="_1KUM8QweOc"><i class="fab fa-youtube"></i> Video</button>
                </div>
            </aside>
        </div>
    </section>

    <section class="section-card">
        <h2>Galerie photos, video et slider multi-vues</h2>
        <div class="media-slider" id="mediaSlider">
            <div class="media-track" id="mediaTrack">
                <div class="media-slide">
                    <img src="https://images.unsplash.com/photo-1470246973918-29a93221c455?w=1600&auto=format&fit=crop&q=80" alt="Facade chalet">
                    <div class="media-caption"><span>Facade et terrain boise</span><button type="button" class="btn btn-dark js-open-chalet-video" data-youtube="_1KUM8QweOc" style="padding:7px 10px;font-size:12px;">Voir video</button></div>
                </div>
                <div class="media-slide">
                    <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=1600&auto=format&fit=crop&q=80" alt="Chambre premium">
                    <div class="media-caption"><span>Chambres confortables</span><span><i class="fas fa-bed"></i> 7 chambres</span></div>
                </div>
                <div class="media-slide">
                    <img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1600&auto=format&fit=crop&q=80" alt="Cuisine equipee">
                    <div class="media-caption"><span>Cuisine complete</span><span><i class="fas fa-kitchen-set"></i> Equipements complets</span></div>
                </div>
                <div class="media-slide">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=1600&auto=format&fit=crop&q=80" alt="Activites eau">
                    <div class="media-caption"><span>Activites a proximite</span><span><i class="fas fa-water"></i> Lac / riviere</span></div>
                </div>
            </div>
        </div>
        <div class="media-nav" id="mediaDots"></div>
        <div class="media-strip" id="mediaStrip">
            <button type="button" class="media-thumb active" data-slide="0">
                <img src="https://images.unsplash.com/photo-1470246973918-29a93221c455?w=700&h=420&fit=crop&auto=format&q=80" alt="Facade">
                <span class="media-thumb-label">Facade</span>
            </button>
            <button type="button" class="media-thumb" data-slide="1">
                <img src="https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=700&h=420&fit=crop&auto=format&q=80" alt="Chambres">
                <span class="media-thumb-label">Chambres</span>
            </button>
            <button type="button" class="media-thumb" data-slide="2">
                <img src="https://images.unsplash.com/photo-1484154218962-a197022b5858?w=700&h=420&fit=crop&auto=format&q=80" alt="Cuisine">
                <span class="media-thumb-label">Cuisine</span>
            </button>
            <button type="button" class="media-thumb" data-slide="3">
                <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?w=700&h=420&fit=crop&auto=format&q=80" alt="Activites">
                <span class="media-thumb-label">Activites</span>
            </button>
            <button type="button" class="media-thumb media-thumb-video js-open-chalet-video" data-youtube="_1KUM8QweOc" aria-label="Video Grande Serenite">
                <i class="fab fa-youtube"></i>
                <b>Voir la video du chalet</b>
            </button>
        </div>
    </section>

    <section class="section-card" id="geo-map-section">
        <h2>Geo carte interactive</h2>
        <div class="geo-map-embed">
            @include('geo-map::index-grande-serenite')
        </div>
    </section>

    <section class="section-card">
        <h2>Activites a proximite et forfaits activite 4 saisons</h2>
        <div class="experience-grid">
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=900&h=600&fit=crop&auto=format&q=80" alt="Randonnee et sentiers">
                <div class="experience-body">
                    <span class="experience-type">Activites</span>
                    <div class="experience-title">Sentiers nature et randonnee</div>
                    <div class="experience-text">Parcours pedestres et velo de montagne a quelques minutes du chalet.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?w=900&h=600&fit=crop&auto=format&q=80" alt="Kayak lac">
                <div class="experience-body">
                    <span class="experience-type">Activites</span>
                    <div class="experience-title">Lac, kayak et canot</div>
                    <div class="experience-text">Navigation douce, paddleboard et baignade selon la saison.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1489515217757-5fd1be406fef?w=900&h=600&fit=crop&auto=format&q=80" alt="Spa et detente">
                <div class="experience-body">
                    <span class="experience-type">Activites</span>
                    <div class="experience-title">Spa et detente premium</div>
                    <div class="experience-text">Vue panoramique, bain tourbillon et ambiance calme en soiree.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.pexels.com/photos/1024324/pexels-photo-1024324.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Forfait hiver">
                <div class="experience-body">
                    <span class="experience-type">Forfait Hiver</span>
                    <div class="experience-title experience-title--hero">Neige, ski et motoneige</div>
                    <div class="experience-text">Ski alpin, raquette, sentiers motoneige et retour spa apres-ski.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.pexels.com/photos/1761279/pexels-photo-1761279.jpeg?auto=compress&cs=tinysrgb&w=1200" alt="Forfait printemps">
                <div class="experience-body">
                    <span class="experience-type">Forfait Printemps</span>
                    <div class="experience-title experience-title--hero">Nature et escapades vertes</div>
                    <div class="experience-text">Peche, randonnees et decouvertes locales dans la region de Mauricie.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=900&h=600&fit=crop&auto=format&q=80" alt="Forfait ete">
                <div class="experience-body">
                    <span class="experience-type">Forfait Ete</span>
                    <div class="experience-title">Eau, soleil et plein air</div>
                    <div class="experience-text">Kayak, canot, paddleboard, baignade et BBQ sur terrasse.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1477414348463-c0eb7f1359b6?w=900&h=600&fit=crop&auto=format&q=80" alt="Forfait automne">
                <div class="experience-body">
                    <span class="experience-type">Forfait Automne</span>
                    <div class="experience-title">Couleurs et panoramas</div>
                    <div class="experience-text">Velo, sentiers forestiers et observation des couleurs automnales.</div>
                </div>
            </article>
            <article class="experience-card">
                <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=900&h=600&fit=crop&auto=format&q=80" alt="Sejour long terme">
                <div class="experience-body">
                    <span class="experience-type">Long terme</span>
                    <div class="experience-title">Sejours 2, 3 ou 4 semaines</div>
                    <div class="experience-text">Formule flexible pour famille, teletravail et experience immersive.</div>
                </div>
            </article>
        </div>
    </section>

    <section class="section-card booking-redesign" id="calendar">
        <div class="booking-top">
            <div>
                <h2>Calendrier de reservation avec disponibilites</h2>
                <p>Visualisation mensuelle rapide pour verifier les periodes ouvertes, les semaines en forte demande et les dates indisponibles.</p>
            </div>
            <span class="booking-badge"><i class="fas fa-calendar-check"></i> Mise a jour temps reel</span>
        </div>

        <div class="booking-layout">
            <div>
                <div class="month-grid">
                    <article class="month-card">
                        <div class="month-head">
                            <b>Mai 2026</b>
                            <span>Duree min: 2 nuits</span>
                        </div>
                        <div class="month-weekdays">
                            <div>Lu</div><div>Ma</div><div>Me</div><div>Je</div><div>Ve</div><div>Sa</div><div>Di</div>
                        </div>
                        <div class="month-days">
                            <div class="day-off"></div><div class="day-off"></div><div class="day-off"></div><div class="day-off"></div>
                            <div class="day-ok">1</div><div class="day-ok">2</div><div class="day-ok">3</div>
                            <div class="day-ok">4</div><div class="day-ok">5</div><div class="day-ok">6</div><div class="day-ok">7</div><div class="day-ok">8</div><div class="day-ok">9</div><div class="day-ok">10</div>
                            <div class="day-ok">11</div><div class="day-ok">12</div><div class="day-ok">13</div><div class="day-alert">14</div><div class="day-alert">15</div><div class="day-alert">16</div><div class="day-alert">17</div>
                            <div class="day-alert">18</div><div class="day-alert">19</div><div class="day-alert">20</div><div class="day-alert">21</div><div class="day-alert">22</div><div class="day-alert">23</div><div class="day-alert">24</div>
                            <div class="day-busy">25</div><div class="day-busy">26</div><div class="day-busy">27</div><div class="day-busy">28</div><div class="day-busy">29</div><div class="day-busy">30</div><div class="day-busy">31</div>
                        </div>
                    </article>
                    <article class="month-card">
                        <div class="month-head">
                            <b>Juin 2026</b>
                            <span>Duree min: 3 nuits</span>
                        </div>
                        <div class="month-weekdays">
                            <div>Lu</div><div>Ma</div><div>Me</div><div>Je</div><div>Ve</div><div>Sa</div><div>Di</div>
                        </div>
                        <div class="month-days">
                            <div class="day-busy">1</div><div class="day-busy">2</div><div class="day-busy">3</div><div class="day-busy">4</div><div class="day-busy">5</div><div class="day-busy">6</div><div class="day-busy">7</div>
                            <div class="day-busy">8</div><div class="day-busy">9</div><div class="day-busy">10</div><div class="day-busy">11</div><div class="day-busy">12</div><div class="day-busy">13</div><div class="day-busy">14</div>
                            <div class="day-alert">15</div><div class="day-alert">16</div><div class="day-alert">17</div><div class="day-alert">18</div><div class="day-alert">19</div><div class="day-alert">20</div><div class="day-alert">21</div>
                            <div class="day-ok">22</div><div class="day-ok">23</div><div class="day-ok">24</div><div class="day-ok">25</div><div class="day-ok">26</div><div class="day-ok">27</div><div class="day-ok">28</div>
                            <div class="day-ok">29</div><div class="day-ok">30</div><div class="day-off"></div><div class="day-off"></div><div class="day-off"></div><div class="day-off"></div><div class="day-off"></div>
                        </div>
                    </article>
                </div>
                <div class="month-legend" aria-label="Legende disponibilites">
                    <span class="legend-item"><i class="legend-dot legend-ok"></i> Disponible</span>
                    <span class="legend-item"><i class="legend-dot legend-alert"></i> Forte demande</span>
                    <span class="legend-item"><i class="legend-dot legend-busy"></i> Reserve / indisponible</span>
                </div>
            </div>

            <aside class="booking-side">
                <article class="booking-side-card">
                    <h3>Regles de sejour</h3>
                    <div class="booking-side-line"><span>Arrivee</span><b>17:00</b></div>
                    <div class="booking-side-line"><span>Depart</span><b>11:00</b></div>
                    <div class="booking-side-line"><span>Sejour minimum</span><b>2 a 3 nuits</b></div>
                    <div class="booking-side-line"><span>Long terme</span><b>2, 3 ou 4 semaines</b></div>
                </article>
                <article class="booking-side-card">
                    <h3>Infos reservation</h3>
                    <div class="booking-side-line"><span>Capacite max</span><b>16 personnes</b></div>
                    <div class="booking-side-line"><span>Type de sejour</span><b>Famille, premium, affaires</b></div>
                    <div class="booking-side-line"><span>Support client</span><b>Reponse rapide</b></div>
                </article>
            </aside>
        </div>
    </section>

    <section class="amenities-redesign" id="amenities">
        <div class="amenities-layout">
            <article class="section-card amenities-main">
                <div class="amenities-head">
                    <div>
                        <h2>Commodites, activites et services</h2>
                        <p>Toutes les commodites majeures sont structurees par univers pour faciliter la lecture et la preparation du sejour.</p>
                    </div>
                    <span class="amenities-chip"><i class="fas fa-shield"></i> Chalet equipe complet</span>
                </div>
                <div class="icon-list-grid">
                    @foreach($amenities as $group => $items)
                    <div class="icon-list-block">
                        <h3>{{ $group }}</h3>
                        <div class="amenity-list">
                            @foreach($items as $it)
                            <div class="amenity-row"><span class="amenity-icon {{ $it['class'] }}"><i class="fas {{ $it['icon'] }}"></i></span> {{ $it['text'] }}</div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </article>

            <aside class="section-card contact-pro-card" id="contact-proprio">
                <h2>Contact proprietaire</h2>
                <p class="contact-subline">Demande rapide pour sejour court ou location long terme. Nous revenons vers vous avec une proposition adaptee.</p>
                <form class="contact-form">
                    <div class="contact-form-grid">
                        <div class="f">
                            <label>Prenom</label>
                            <input type="text" placeholder="Votre prenom">
                        </div>
                        <div class="f">
                            <label>Nom</label>
                            <input type="text" placeholder="Votre nom">
                        </div>
                        <div class="f">
                            <label>Courriel</label>
                            <input type="email" placeholder="exemple@courriel.com">
                        </div>
                        <div class="f">
                            <label>Telephone</label>
                            <input type="tel" placeholder="+1 ...">
                        </div>
                        <div class="f f-full">
                            <label>Nombre d'adultes</label>
                            <select><option>Selectionner</option><option>2</option><option>4</option><option>8</option><option>12+</option></select>
                        </div>
                        <div class="f f-full">
                            <label>Message</label>
                            <textarea placeholder="Dates souhaitees, type de sejour, besoins particuliers..."></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary" style="width:100%;"><i class="fas fa-paper-plane"></i> Envoyer la demande</button>
                    <p class="contact-help">Envoi securise. Un conseiller vous contacte pour confirmer disponibilites et tarifs.</p>
                </form>
            </aside>
        </div>
    </section>
</main>

<div class="chalet-video-modal" id="chaletVideoModal" aria-hidden="true">
    <div class="chalet-video-modal-panel" role="dialog" aria-modal="true" aria-labelledby="chaletVideoTitle">
        <div class="chalet-video-modal-head">
            <h3 id="chaletVideoTitle">Video chalet - Grande Serenite</h3>
            <button type="button" class="chalet-video-close" id="chaletVideoClose" aria-label="Fermer">×</button>
        </div>
        <div class="chalet-video-frame-wrap" id="chaletVideoFrameWrap"></div>
    </div>
</div>

<footer class="footer">
    <div class="footer-inner">
        <div>
            <h4>A propos du chalet</h4>
            <p>Grande Serenite propose une experience premium en Mauricie avec nature, confort et activites 4 saisons.</p>
        </div>
        <div>
            <h4>Infos location</h4>
            <p>Capacite: 16 personnes</p>
            <p>Location long terme: 2, 3, 4 semaines</p>
            <p>Arrivee: 17:00 - Depart: 11:00</p>
        </div>
        <div>
            <h4>Liens utiles</h4>
            <p><a href="#calendar">Voir disponibilites</a></p>
            <p><a href="#amenities">Voir commodites</a></p>
            <p><a href="{{ route('home-v2') }}">Retour accueil</a></p>
        </div>
    </div>
    <div class="footer-bottom">GoExploria - Grande Serenite (version client v2)</div>
</footer>

<script>
(function () {
    var track = document.getElementById('mediaTrack');
    var dotsWrap = document.getElementById('mediaDots');
    var strip = document.getElementById('mediaStrip');
    if (!track || !dotsWrap || !strip) return;

    var slides = Array.from(track.children);
    var thumbs = Array.from(strip.querySelectorAll('.media-thumb[data-slide]'));
    var idx = 0;
    var timer = null;

    slides.forEach(function (_, i) {
        var b = document.createElement('button');
        b.className = 'media-dot' + (i === 0 ? ' active' : '');
        b.setAttribute('aria-label', 'Slide ' + (i + 1));
        b.addEventListener('click', function () {
            idx = i;
            render();
            restart();
        });
        dotsWrap.appendChild(b);
    });

    function render() {
        track.style.transform = 'translateX(-' + (idx * 100) + '%)';
        Array.from(dotsWrap.children).forEach(function (d, i) {
            d.classList.toggle('active', i === idx);
        });
        thumbs.forEach(function (t, i) {
            t.classList.toggle('active', i === idx);
        });
    }

    function next() {
        idx = (idx + 1) % slides.length;
        render();
    }

    function restart() {
        clearInterval(timer);
        timer = setInterval(next, 5500);
    }

    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            var nextIdx = parseInt(thumb.getAttribute('data-slide'), 10);
            if (isNaN(nextIdx)) return;
            idx = nextIdx;
            render();
            restart();
        });
    });

    restart();
})();
</script>
<script>
(function () {
    var modal = document.getElementById('chaletVideoModal');
    var closeBtn = document.getElementById('chaletVideoClose');
    var wrap = document.getElementById('chaletVideoFrameWrap');
    if (!modal || !closeBtn || !wrap) return;

    function extractYoutubeId(value) {
        if (!value) return '';
        var v = String(value).trim();
        if (/^[a-zA-Z0-9_-]{11}$/.test(v)) return v;
        var patterns = [
            /(?:youtube\.com\/watch\?v=)([a-zA-Z0-9_-]{11})/i,
            /(?:youtu\.be\/)([a-zA-Z0-9_-]{11})/i,
            /(?:youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/i,
            /(?:youtube\.com\/shorts\/)([a-zA-Z0-9_-]{11})/i
        ];
        for (var i = 0; i < patterns.length; i += 1) {
            var m = v.match(patterns[i]);
            if (m && m[1]) return m[1];
        }
        var qp = v.match(/[?&]v=([a-zA-Z0-9_-]{11})/);
        return qp && qp[1] ? qp[1] : '';
    }

    function openVideo(value) {
        var id = extractYoutubeId(value) || '_1KUM8QweOc';
        wrap.innerHTML = '<iframe src="https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0&modestbranding=1" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>';
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeVideo() {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        wrap.innerHTML = '';
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.js-open-chalet-video').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openVideo(btn.getAttribute('data-youtube'));
        });
    });

    closeBtn.addEventListener('click', closeVideo);
    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeVideo();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) closeVideo();
    });
})();
</script>
</body>
</html>
