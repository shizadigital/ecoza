      
                    </div>
                    <!-- END air__utils__content -->

                </div>
                <!-- END air__layout__content" -->
                <!-- END content here -->

                <div class="air__layout__footer">
                    <div class="air__footer">
                        <div class="air__footer__inner">
                        <div class="row">
                            <div class="col-md-8">
                            
                            <p>
                                &copy; <?php echo date('Y'); ?>. <a href="<?php echo URL::to('/'); ?>"><?php echo env('APP_NAME') ?></a>. Powered by <a href="https://shiza.id/" target="_blank">Shiza</a>. Version <?php echo env('APP_VERSION'); ?>
                            </p>
                            </div>
                            <div class="col-md-4">
                                <div class="air__footer__logo">
                                    <img src="{{ asset('admin/components/core/img/shiza-logo.png') }}" alt="<?php echo env('APP_NAME') ?>" />
                                    <div class="air__footer__logo__name">Shiza.Id</div>
                                    <div class="air__footer__logo__descr">Administrator</div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- END air__layout -->

    </div>
    <!-- END air__layout air__layout--hasSider -->

    @yield('custom-script')
</body>
</html>