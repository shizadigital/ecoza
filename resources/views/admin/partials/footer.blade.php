      
            </div>
            <!-- /content area -->
            
            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>

                <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; <?php echo date('Y'); ?>. <a href="<?php echo URL::to('/'); ?>"><?php echo env('APP_NAME') ?></a>. Powered by <a href="https://shiza.id/" target="_blank">Shiza</a>
					</span>

                    <ul class="navbar-nav ml-lg-auto">
                        <?php /*
                        <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                        <li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
                        <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                        */ ?>
                        <li class="nav-item">Version <?php echo env('APP_VERSION'); ?></li>
                    </ul>
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>

    <!-- Core JS files -->
    <script src="{{ asset('admin/global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->
    <script src="{{ asset('admin/js/app.js') }}"></script>
    @yield('custom-script')

    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
</body>

</html>