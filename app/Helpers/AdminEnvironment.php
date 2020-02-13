<?php 
if(!function_exists('adminPageHeader')){
    /**
     * field validation when page receiving response
     *
     * @param  bool $page_header_on
     * @param  string array $optvar
     * @return string
     */

    function adminPageHeader( $page_header_on = false, $optvar ='' ){
        if( $page_header_on == true ){
            // $title_page =  empty($optvar['title_page']) ? '':$optvar['title_page'];
            // $title_page_icon = empty($optvar['title_page_icon']) ? '':$optvar['title_page_icon'];
            // $title_page_secondary = empty($optvar['title_page_secondary']) ? '':$optvar['title_page_secondary'];
            // $header_button_action = (count($optvar['header_button_action'])>0) ? $optvar['header_button_action']:array();

            // // get segment
            // $querymodule = $this->CI->uri->segment(2);
            // $countmod = strlen($querymodule);
            // $data = 'a:1:{s:10:"admin_link";s:'.$countmod.':"'.$querymodule.'";}';
            // $getmenu = getval("menuId,menuParentId,menuName,menuAccess,menuSort,menuActive,menuIcon","users_menu","menuAccess = '{$data}'");
        ?>
            <div class="air__subbar">
                <ul class="air__subbar__breadcrumbs mr-4">
                    <li class="air__subbar__breadcrumb">
                        <a href="#" class="air__subbar__breadcrumbLink">Main</a>
                    </li>
                    <li class="air__subbar__breadcrumb">
                        <a href="#" class="air__subbar__breadcrumbLink air__subbar__breadcrumbLink--current"
                        >Dashboard</a>
                    </li>
                </ul>
                <div class="air__subbar__divider mr-4 d-none d-xl-block"></div>
                <p class="color-gray-4 text-uppercase font-size-18 mb-0 mr-4 d-none d-xl-block">INV-00125</p>
                
                <div class="air__subbar__amount mr-3 ml-auto d-none d-sm-flex">
                    <button class="btn btn-primary btn-with-addon mr-auto text-nowrap d-none d-md-block">
                        <span class="btn-addon">
                            <i class="btn-addon-icon fe fe-plus-circle"></i>
                        </span>
                        Tambah
                    </button>
                </div>                
            </div>


        
        <?php }
    }
}