<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ __('home-v2.legal.privacy.meta_description') }}">
    <title>{{ __('home-v2.legal.privacy.meta_title') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/services-mega-menu-v2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome/footer.css') }}">

    <style>
        .legal-page-v2 {
            min-height: 100vh;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 30%);
            padding: 150px 0 70px;
        }

        .legal-page-v2-container {
            width: min(980px, calc(100% - 40px));
            margin: 0 auto;
        }

        .legal-page-v2-card {
            background: #fff;
            border: 1px solid #dce8fb;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(12, 38, 82, 0.08);
            padding: 26px;
        }

        .legal-page-v2 h1 {
            margin: 0 0 8px;
            color: #0f2d61;
            font-size: clamp(28px, 3vw, 38px);
        }

        .legal-page-v2-updated {
            margin: 0 0 20px;
            color: #5a7196;
            font-size: 14px;
        }

        .legal-page-v2 h2 {
            margin: 24px 0 10px;
            color: #123f8d;
            font-size: 21px;
        }

        .legal-page-v2 p,
        .legal-page-v2 li {
            color: #2a436d;
            line-height: 1.75;
            font-size: 15px;
        }

        .legal-page-v2 ul {
            margin: 0 0 14px;
            padding-left: 20px;
        }
    </style>
</head>
<body>
    @include('welcome-home.components.VerticalMenu')
    @include('welcome-home.components.Header')

    <main class="legal-page-v2">
        <div class="legal-page-v2-container">
            <article class="legal-page-v2-card">
                <h1>{{ __('home-v2.legal.privacy.title') }}</h1>
                <p class="legal-page-v2-updated">{{ __('home-v2.legal.updated', ['date' => now()->format('d/m/Y')]) }}</p>

                <p>{{ __('home-v2.legal.privacy.intro') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_1_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_1_intro') }}</p>
                <ul>
                    @foreach (trans('home-v2.legal.privacy.section_1_list') as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>

                <h2>{{ __('home-v2.legal.privacy.section_2_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_2_intro') }}</p>
                <ul>
                    @foreach (trans('home-v2.legal.privacy.section_2_list') as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>

                <h2>{{ __('home-v2.legal.privacy.section_3_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_3_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_4_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_4_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_5_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_5_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_6_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_6_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_7_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_7_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_8_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_8_body') }}</p>

                <h2>{{ __('home-v2.legal.privacy.section_9_heading') }}</h2>
                <p>{{ __('home-v2.legal.privacy.section_9_body') }} <a href="mailto:{{ __('home-v2.common.email') }}">{{ __('home-v2.common.email') }}</a></p>
            </article>
        </div>
    </main>

    @include('welcome-home.components.Footer')
    <script src="{{ asset('js/welcome/menu-api-service.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu-dynamic.js') }}"></script>
    <script src="{{ asset('js/welcome/vertical-menu.js') }}"></script>
    <script src="{{ asset('js/welcome/navigation.js') }}"></script>
</body>
</html>
