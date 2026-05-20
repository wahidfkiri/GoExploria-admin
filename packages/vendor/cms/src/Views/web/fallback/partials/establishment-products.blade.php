@php
    $cmsLandingProducts = collect();
    $cmsProductsLimit = (int) ($cmsProductsLimit ?? 8);
    $cmsProductsTitle = $cmsProductsTitle ?? "Produits à vendre";
    $cmsProductsSubtitle = $cmsProductsSubtitle ?? "Découvrez les produits, services et offres disponibles directement auprès de cet établissement.";
    $cmsProductsDevisLink = $devisLink ?? ($devisUrl ?? url('/devis'));

    $cmsProductMediaUrl = static function ($path) {
        if (empty($path)) {
            return null;
        }

        if (is_array($path)) {
            $path = data_get($path, 'url') ?: data_get($path, 'thumbnail') ?: data_get($path, 0);
        }

        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/storage/'])) {
            return asset(ltrim($path, '/'));
        }

        if (\Illuminate\Support\Str::startsWith($path, ['storage/'])) {
            return asset($path);
        }

        if (\Illuminate\Support\Str::startsWith($path, ['/'])) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . ltrim($path, '/'));
    };

    $cmsProductPrice = static function ($product) {
        $value = $product->price_ttc ?? $product->price_ht ?? null;

        if ($value === null || $value === '') {
            return 'Sur demande';
        }

        return number_format((float) $value, 2, ',', ' ') . ' $';
    };

    try {
        if (
            isset($etablissement)
            && !empty($etablissement->id)
            && class_exists(\App\Models\Product::class)
            && \Illuminate\Support\Facades\Schema::hasTable('products')
        ) {
            $cmsLandingProducts = \App\Models\Product::query()
                ->with(['category:id,name', 'family:id,name'])
                ->where('etablissement_id', $etablissement->id)
                ->where('is_public', true)
                ->where('is_available_for_sale', true)
                ->latest('updated_at')
                ->limit(max(1, $cmsProductsLimit))
                ->get();
        }
    } catch (\Throwable $e) {
        $cmsLandingProducts = collect();
    }
@endphp

@if($cmsLandingProducts->isNotEmpty())
    <section class="cms-live-products" id="produits-a-vendre">
        <style>
            .cms-live-products {
                margin: 18px 0;
                padding: clamp(22px, 3vw, 38px);
                border-radius: 28px;
                background:
                    radial-gradient(circle at top left, rgba(230, 82, 22, .16), transparent 34%),
                    linear-gradient(135deg, rgba(255,255,255,.96), rgba(248,250,252,.92));
                border: 1px solid rgba(15, 23, 42, .08);
                box-shadow: 0 22px 55px rgba(15, 23, 42, .10);
                overflow: hidden;
            }

            .cms-live-products-head {
                display: flex;
                align-items: flex-end;
                justify-content: space-between;
                gap: 18px;
                margin-bottom: 22px;
            }

            .cms-live-products-kicker {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 8px;
                color: #e65216;
                font-size: .78rem;
                font-weight: 900;
                letter-spacing: .12em;
                text-transform: uppercase;
            }

            .cms-live-products-title {
                margin: 0;
                color: #101827;
                font-size: clamp(1.75rem, 3vw, 2.7rem);
                line-height: 1.05;
                font-weight: 950;
            }

            .cms-live-products-subtitle {
                max-width: 640px;
                margin: 8px 0 0;
                color: #64748b;
                font-size: .98rem;
                line-height: 1.65;
            }

            .cms-live-products-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .cms-live-product-card {
                display: flex;
                min-width: 0;
                flex-direction: column;
                color: inherit;
                text-decoration: none;
                background: #fff;
                border: 1px solid rgba(15, 23, 42, .08);
                border-radius: 22px;
                overflow: hidden;
                box-shadow: 0 14px 35px rgba(15, 23, 42, .08);
                transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
            }

            .cms-live-product-card:hover {
                transform: translateY(-5px);
                border-color: rgba(230, 82, 22, .35);
                box-shadow: 0 24px 55px rgba(15, 23, 42, .14);
            }

            .cms-live-product-media {
                position: relative;
                height: 190px;
                overflow: hidden;
                background: linear-gradient(135deg, #f1f5f9, #fff7ed);
            }

            .cms-live-product-media img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
                transition: transform .45s ease;
            }

            .cms-live-product-card:hover .cms-live-product-media img {
                transform: scale(1.06);
            }

            .cms-live-product-price {
                position: absolute;
                left: 14px;
                bottom: 14px;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 9px 13px;
                border-radius: 999px;
                color: #fff;
                background: #101827;
                box-shadow: 0 12px 28px rgba(15, 23, 42, .24);
                font-size: .88rem;
                font-weight: 900;
            }

            .cms-live-product-body {
                display: flex;
                flex: 1;
                flex-direction: column;
                padding: 18px;
            }

            .cms-live-product-chip {
                width: fit-content;
                max-width: 100%;
                margin-bottom: 10px;
                padding: 5px 10px;
                border-radius: 999px;
                color: #e65216;
                background: rgba(230, 82, 22, .10);
                font-size: .72rem;
                font-weight: 900;
                letter-spacing: .04em;
                text-transform: uppercase;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .cms-live-product-name {
                margin: 0 0 8px;
                color: #0f172a;
                font-size: 1.12rem;
                line-height: 1.24;
                font-weight: 900;
            }

            .cms-live-product-desc {
                margin: 0 0 16px;
                color: #64748b;
                font-size: .91rem;
                line-height: 1.58;
            }

            .cms-live-product-foot {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                margin-top: auto;
                padding-top: 14px;
                border-top: 1px solid rgba(15, 23, 42, .07);
                color: #0f172a;
                font-size: .84rem;
                font-weight: 800;
            }

            .cms-live-product-foot span:last-child {
                color: #e65216;
            }

            @media (max-width: 1180px) {
                .cms-live-products-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            }

            @media (max-width: 640px) {
                .cms-live-products { padding: 18px; border-radius: 20px; }
                .cms-live-products-head { display: block; }
                .cms-live-products-grid { grid-template-columns: 1fr; }
                .cms-live-product-media { height: 220px; }
            }
        </style>

        <div class="cms-live-products-head">
            <div>
                <span class="cms-live-products-kicker"><i class="fas fa-store"></i> Catalogue établissement</span>
                <h2 class="cms-live-products-title">{{ $cmsProductsTitle }}</h2>
                <p class="cms-live-products-subtitle">{{ $cmsProductsSubtitle }}</p>
            </div>
        </div>

        <div class="cms-live-products-grid">
            @foreach($cmsLandingProducts as $product)
                @php
                    $galleryImage = is_array($product->gallery_images ?? null) ? data_get($product->gallery_images, 0) : null;
                    $image = $cmsProductMediaUrl($product->main_image ?: $galleryImage)
                        ?: 'https://images.pexels.com/photos/3184465/pexels-photo-3184465.jpeg?auto=compress&cs=tinysrgb&w=900&h=700&fit=crop';
                    $label = optional($product->category)->name
                        ?: optional($product->family)->name
                        ?: str_replace('_', ' ', (string) $product->main_type);
                    $description = $product->short_description
                        ?: \Illuminate\Support\Str::limit(strip_tags((string) $product->long_description), 120)
                        ?: 'Produit disponible à la vente auprès de cet établissement.';
                    $productLink = $cmsProductsDevisLink . (str_contains($cmsProductsDevisLink, '?') ? '&' : '?') . http_build_query([
                        'etablissement_id' => $etablissement->id ?? null,
                        'product_id' => $product->id,
                    ]);
                @endphp

                <a class="cms-live-product-card" href="{{ $productLink }}" target="_blank" rel="noopener noreferrer">
                    <div class="cms-live-product-media">
                        <img src="{{ $image }}" alt="{{ $product->name }}" loading="lazy">
                        <span class="cms-live-product-price">{{ $cmsProductPrice($product) }}</span>
                    </div>
                    <div class="cms-live-product-body">
                        <span class="cms-live-product-chip">{{ $label }}</span>
                        <h3 class="cms-live-product-name">{{ $product->name }}</h3>
                        <p class="cms-live-product-desc">{{ \Illuminate\Support\Str::limit(strip_tags($description), 135) }}</p>
                        <div class="cms-live-product-foot">
                            <span>{{ $product->stock_management === 'sur_commande' ? 'Sur commande' : 'Disponible' }}</span>
                            <span>Demander <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif
