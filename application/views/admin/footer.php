<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>          
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
                        &copy; <?php echo date('Y'); ?>. <a href="<?php echo base_url(); ?>"><?php echo web_info(); ?></a>. Powered by <a href="https://www.memoindomedia.com/" target="_blank">Memo Indo Media</a>
                    </span>

                    <ul class="navbar-nav ml-lg-auto">
                        <?php /*
                        <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                        <li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
                        <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                        */ ?>
                        <li class="nav-item">Version <?php echo FRAMEWORK_VERSION; ?></li>
                    </ul>
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <?php echo $this->assetsloc->get_footer_element(); ?>

    <!-- custom app -->
    <?php 
    // LOAD JAVASCRIPT LIB
    echo $this->assetsloc->get_admin_script('library');
    ?>

    <script src="<?php echo admin_assets(); ?>/js/app.js"></script>

    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <?php 
    // LOAD JAVASCRIPT
    echo $this->assetsloc->get_admin_script('manually');
    ?>

    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
</body>

</html>