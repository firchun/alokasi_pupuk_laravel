<footer id="footer" class="footer dark-background">

    <div class="copyright text-center">
        <div
            class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

            <div class="d-flex flex-column align-items-center align-items-lg-start">
                <div>
                    {{ date('Y') }} © Copyright <strong><span>{{ env('APP_NAME') }}</span></strong>. All Rights
                    Reserved
                </div>
                <div class="credits">
                    Designed by <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
                </div>
            </div>

            <div class="social-links order-first order-lg-last mb-3 mb-lg-0">
                <a href=""><i class="bi bi-twitter-x"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
            </div>

        </div>
    </div>

</footer>
