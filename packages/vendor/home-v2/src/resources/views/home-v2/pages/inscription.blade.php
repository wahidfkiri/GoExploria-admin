<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription &mdash; GoExploria</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-v2/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/navigation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-mega-menu-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/vertical-destinations-mega.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/destinations-search.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/search-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home-v2/footer.css') }}">
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Montserrat',sans-serif;background:#f4f6f9;color:#0a1628;overflow-x:hidden;min-height:100vh;display:flex;flex-direction:column}

        /* ── Form centré (ex-split) ────────────── */
        .split{display:flex;justify-content:center;align-items:flex-start;margin-top:150px;padding:48px 20px 60px;min-height:70vh}

        /* ── Right Panel (Form) ──────────── */
        .split-right{background:#fff;padding:48px 56px;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);width:100%;max-width:560px;display:flex;flex-direction:column;justify-content:center;overflow-y:auto}
        .form-header{margin-bottom:28px}
        .form-header h2{font-size:1.6rem;font-weight:900;color:#0a1628;margin-bottom:6px}
        .form-header p{font-size:13px;color:#9ba3af}
        .form-header p a{color:#4361ee;font-weight:700;text-decoration:none}
        .form-header p a:hover{text-decoration:underline}

        /* Social buttons */
        .social-auth{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px}
        .social-auth-btn{display:flex;align-items:center;justify-content:center;gap:10px;padding:11px;border:1.5px solid #e5e7eb;border-radius:9px;font-size:13px;font-weight:600;color:#374151;text-decoration:none;transition:all .2s;cursor:pointer;background:#fff}
        .social-auth-btn:hover{border-color:#0a1628;background:#f9fafb}
        .social-auth-btn img{width:20px;height:20px}
        .divider{display:flex;align-items:center;gap:14px;margin-bottom:22px}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:#e9ecef}
        .divider span{font-size:11px;font-weight:700;color:#9ba3af;letter-spacing:.5px;text-transform:uppercase}

        /* Form */
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .form-group{margin-bottom:14px;display:flex;flex-direction:column;gap:5px}
        .form-group label{font-size:11px;font-weight:700;color:#374151;letter-spacing:.5px;text-transform:uppercase}
        .form-group input,.form-group select{width:100%;padding:11px 14px;border:1.5px solid #e5e7eb;border-radius:8px;font-family:'Montserrat',sans-serif;font-size:13px;color:#0a1628;outline:none;transition:all .2s}
        .form-group input:focus,.form-group select:focus{border-color:#d4af37;box-shadow:0 0 0 3px rgba(212,175,55,.1)}
        .input-wrap{position:relative}
        .input-wrap input{padding-right:40px}
        .input-icon{position:absolute;right:13px;top:50%;transform:translateY(-50%);color:#9ba3af;font-size:14px;cursor:pointer}
        .input-icon:hover{color:#0a1628}

        /* Password strength */
        .pwd-strength{display:flex;gap:4px;margin-top:6px}
        .pwd-bar{flex:1;height:3px;border-radius:2px;background:#e9ecef;transition:background .3s}

        /* Terms */
        .terms-check{display:flex;align-items:flex-start;gap:10px;margin-bottom:18px}
        .terms-check input[type="checkbox"]{width:16px;height:16px;margin-top:2px;accent-color:#d4af37;cursor:pointer;flex-shrink:0}
        .terms-check label{font-size:12px;color:#6b7280;line-height:1.5;cursor:pointer}
        .terms-check label a{color:#4361ee;font-weight:700;text-decoration:none}

        /* Submit */
        .btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,#0a1628,#1a2942);color:#fff;border:none;border-radius:10px;font-family:'Montserrat',sans-serif;font-size:13px;font-weight:700;letter-spacing:1px;text-transform:uppercase;cursor:pointer;transition:all .25s;display:flex;align-items:center;justify-content:center;gap:10px}
        .btn-submit:hover{background:linear-gradient(135deg,#1a2942,#2a3a52);transform:translateY(-1px);box-shadow:0 8px 24px rgba(10,22,40,.25)}
        .btn-submit i{color:#d4af37}
        .login-link{text-align:center;margin-top:16px;font-size:12px;color:#9ba3af}
        .login-link a{color:#4361ee;font-weight:700;text-decoration:none}

        @media(max-width:900px){.split-right{padding:40px 28px}}
        @media(max-width:480px){.split-right{padding:32px 20px}.form-row{grid-template-columns:1fr}.social-auth{grid-template-columns:1fr}}
        footer,.footer-v2{margin-top:0!important}
    </style>
</head>
<body>

@include('home-v2.components.VerticalMenu')
@include('home-v2.components.Header')

<div class="split">
    {{-- ── Formulaire d’inscription ──────────── --}}
    <div class="split-right">
        <div class="form-header">
            <h2>Cr&eacute;er mon compte</h2>
            <p>D&eacute;j&agrave; membre ? <a href="{{ url('/login') }}">Connectez-vous ici</a></p>
        </div>

        <div class="social-auth">
            <button class="social-auth-btn">
                <svg width="20" height="20" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.4 1.2 8.7 3.2l6.4-6.4C35.1 2.8 29.9.5 24 .5 14.6.5 6.6 6 2.7 13.9l7.5 5.8C12.2 13.4 17.6 9.5 24 9.5z"/><path fill="#4A90D9" d="M46.1 24.5c0-1.6-.1-3.1-.4-4.5H24v8.5h12.5c-.5 2.7-2.1 5-4.4 6.6l7 5.4c4.1-3.8 6.5-9.4 6.5-16z"/><path fill="#34A853" d="M10.2 28.3A14.7 14.7 0 0 1 9.5 24c0-1.5.3-2.9.7-4.3L2.7 13.9A23.5 23.5 0 0 0 .5 24c0 3.8.9 7.3 2.2 10.5l7.5-6.2z"/><path fill="#FBBC05" d="M24 47.5c5.9 0 10.9-2 14.5-5.3l-7-5.4c-2 1.4-4.5 2.2-7.5 2.2-6.4 0-11.8-4-13.8-9.6l-7.5 6.2C6.6 42 14.6 47.5 24 47.5z"/></svg>
                Google
            </button>
            <button class="social-auth-btn">
                <svg width="20" height="20" viewBox="0 0 48 48"><path fill="#1877F2" d="M48 24C48 10.7 37.3 0 24 0S0 10.7 0 24c0 12 8.8 21.9 20.3 23.7V30.9h-6.1V24h6.1v-5.3c0-6 3.6-9.3 9-9.3 2.6 0 5.3.5 5.3.5v5.9h-3c-2.9 0-3.8 1.8-3.8 3.7V24h6.5l-1 6.9h-5.5v16.8C39.2 45.9 48 36 48 24z"/></svg>
                Facebook
            </button>
        </div>

        <div class="divider"><span>ou avec votre courriel</span></div>

        <form>
            <div class="form-row">
                <div class="form-group">
                    <label>Pr&eacute;nom *</label>
                    <input type="text" placeholder="Jean">
                </div>
                <div class="form-group">
                    <label>Nom *</label>
                    <input type="text" placeholder="Tremblay">
                </div>
            </div>
            <div class="form-group">
                <label>Adresse courriel *</label>
                <input type="email" placeholder="jean.tremblay@exemple.com">
            </div>
            <div class="form-group">
                <label>T&eacute;l&eacute;phone</label>
                <input type="tel" placeholder="+1 (514) 000-0000">
            </div>
            <div class="form-group">
                <label>Pays de r&eacute;sidence</label>
                <select>
                    <option value="CA" selected>Canada</option>
                    <option value="FR">France</option>
                    <option value="BE">Belgique</option>
                    <option value="CH">Suisse</option>
                    <option value="MA">Maroc</option>
                    <option value="SN">S&eacute;n&eacute;gal</option>
                    <option value="DZ">Alg&eacute;rie</option>
                    <option value="TN">Tunisie</option>
                    <option value="US">États-Unis</option>
                    <option value="AU">Australie</option>
                </select>
            </div>
            <div class="form-group">
                <label>Mot de passe *</label>
                <div class="input-wrap">
                    <input type="password" id="pwd" placeholder="Minimum 8 caract&egrave;res">
                    <i class="fas fa-eye input-icon" onclick="togglePwd('pwd',this)"></i>
                </div>
                <div class="pwd-strength">
                    <div class="pwd-bar" id="bar1"></div>
                    <div class="pwd-bar" id="bar2"></div>
                    <div class="pwd-bar" id="bar3"></div>
                    <div class="pwd-bar" id="bar4"></div>
                </div>
            </div>
            <div class="form-group">
                <label>Confirmer le mot de passe *</label>
                <div class="input-wrap">
                    <input type="password" id="pwd2" placeholder="R&eacute;p&eacute;ter le mot de passe">
                    <i class="fas fa-eye input-icon" onclick="togglePwd('pwd2',this)"></i>
                </div>
            </div>
            <div class="terms-check">
                <input type="checkbox" id="terms">
                <label for="terms">J&apos;accepte les <a href="#">Conditions g&eacute;n&eacute;rales d&apos;utilisation</a> et la <a href="#">Politique de confidentialit&eacute;</a> de GoExploria.</label>
            </div>
            <button type="submit" class="btn-submit">
                <i class="fas fa-user-plus"></i> Cr&eacute;er mon compte
            </button>
            <p class="login-link">D&eacute;j&agrave; inscrit ? <a href="{{ url('/login') }}">Connectez-vous</a></p>
        </form>
    </div>
</div>

@include('home-v2.components.Footer')

<script src="{{ asset('js/home-v2/navigation.js') }}"></script>
<script src="{{ asset('js/home-v2/menu-api-service.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu-service.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu-dynamic.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/vertical-destinations-mega.js') }}"></script>
<script src="{{ asset('js/home-v2/mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/destinations-mega-menu.js') }}"></script>
<script src="{{ asset('js/home-v2/search-bar.js') }}"></script>
<script>
function togglePwd(id,icon){
    const f=document.getElementById(id);
    if(f.type==='password'){f.type='text';icon.classList.replace('fa-eye','fa-eye-slash');}
    else{f.type='password';icon.classList.replace('fa-eye-slash','fa-eye');}
}
</script>
</body>
</html>
