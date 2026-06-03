@php
    $cmsHeaderHtml = isset($etablissement) && function_exists('get_cms_header_html')
        ? trim((string) get_cms_header_html($etablissement->id))
        : '';
@endphp

@if($cmsHeaderHtml !== '')
    @once
        <style>
            :root {
                --cms-global-header-offset: 0px;
            }

            .cms-establishment-header-shell {
                --cms-establishment-header-height: 0px;
                position: relative;
                z-index: 9990;
            }

            .cms-establishment-header-fixed {
                position: fixed;
                top: var(--cms-global-header-offset, 0px);
                left: 0;
                right: 0;
                width: 100%;
                z-index: 9990;
            }

            .cms-establishment-header-spacer {
                height: var(--cms-establishment-header-height, 0px);
                min-height: var(--cms-establishment-header-height, 0px);
                pointer-events: none;
            }
        </style>

        <script>
            (function () {
                let ticking = false;

                function updateCmsEstablishmentHeader() {
                    const globalHeader = document.querySelector('.header-v2');
                    const globalHeight = globalHeader ? Math.ceil(globalHeader.getBoundingClientRect().height) : 0;
                    document.documentElement.style.setProperty('--cms-global-header-offset', globalHeight + 'px');

                    document.querySelectorAll('.cms-establishment-header-shell').forEach(function (shell) {
                        const fixedHeader = shell.querySelector('.cms-establishment-header-fixed');
                        const headerHeight = fixedHeader ? Math.ceil(fixedHeader.getBoundingClientRect().height) : 0;
                        shell.style.setProperty('--cms-establishment-header-height', headerHeight + 'px');
                    });

                    ticking = false;
                }

                function requestHeaderUpdate() {
                    if (ticking) {
                        return;
                    }

                    ticking = true;
                    window.requestAnimationFrame(updateCmsEstablishmentHeader);
                }

                document.addEventListener('DOMContentLoaded', function () {
                    requestHeaderUpdate();

                    if ('ResizeObserver' in window) {
                        const observer = new ResizeObserver(requestHeaderUpdate);
                        const globalHeader = document.querySelector('.header-v2');
                        if (globalHeader) {
                            observer.observe(globalHeader);
                        }

                        document.querySelectorAll('.cms-establishment-header-fixed').forEach(function (header) {
                            observer.observe(header);
                        });
                    }
                });

                window.addEventListener('load', requestHeaderUpdate);
                window.addEventListener('resize', requestHeaderUpdate);
                window.addEventListener('scroll', requestHeaderUpdate, { passive: true });
            })();
        </script>
    @endonce

    <div class="cms-establishment-header-shell">
        <div class="cms-establishment-header-fixed">
            {!! $cmsHeaderHtml !!}
        </div>
        <div class="cms-establishment-header-spacer" aria-hidden="true"></div>
    </div>
@endif
