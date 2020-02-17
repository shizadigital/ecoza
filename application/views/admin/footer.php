<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
?>          
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
                                &copy; <?php echo date('Y'); ?>. <a href="<?php echo base_url(); ?>"><?php echo web_info(); ?></a>. Powered by <a href="https://shiza.id/" target="_blank">Shiza</a>. Version <?php echo SHIZA_VERSION; ?>
                            </p>
                            </div>
                            <div class="col-md-4">
                                <div class="air__footer__logo">
                                    <img src="<?php echo admin_assets('components/core/img/shiza-logo.png'); ?>" alt="<?php echo web_info(); ?>" />
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
    <!-- END air__layout air__layout-\-hasSider -->

<?php echo $this->assetsloc->get_footer_element(); ?>

<!-- custom app -->    
<script src="<?php echo admin_assets('vendors/jquery-mousewheel/jquery.mousewheel.min.js'); ?>"></script>
<script src="<?php echo admin_assets('vendors/perfect-scrollbar/js/perfect-scrollbar.jquery.js'); ?>"></script>

<?php 
// LOAD JAVASCRIPT LIB
echo $this->assetsloc->get_admin_script('library');
?>

<script src="<?php echo admin_assets('components/core/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/menu-left/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/sidebar/index.js'); ?>"></script>
<script src="<?php echo admin_assets('components/topbar/index.js'); ?>"></script>
<script src="<?php echo admin_assets('custom.js'); ?>"></script>

<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<?php 
// LOAD JAVASCRIPT
echo $this->assetsloc->get_admin_script('manually');
?>

<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
</body>

</html>