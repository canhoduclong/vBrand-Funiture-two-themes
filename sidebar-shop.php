<aside class="col-lg-3 order-lg-first">
    <div class="sidebar sidebar-shop">
        <div class="widget widget-clean">
            <label>Filters:</label>
            <a href="javascript:;" class="sidebar-filter-clear">Clean All</a>
        </div><!-- End .widget widget-clean -->

        

        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
                    Size
                </a>
            </h3><!-- End .widget-title -->

            <div class="collapse show" id="widget-2">
                <div class="widget-body">
                    <div class="filter-items">
                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="size-1">
                                <label class="custom-control-label" for="size-1">XS</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="size-2">
                                <label class="custom-control-label" for="size-2">S</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="size-3">
                                <label class="custom-control-label" for="size-3">M</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" checked id="size-4">
                                <label class="custom-control-label" for="size-4">L</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="size-5">
                                <label class="custom-control-label" for="size-5">XL</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->

                        <div class="filter-item">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="size-6">
                                <label class="custom-control-label" for="size-6">XXL</label>
                            </div><!-- End .custom-checkbox -->
                        </div><!-- End .filter-item -->
                    </div><!-- End .filter-items -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget -->

        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
                    Colour
                </a>
            </h3><!-- End .widget-title -->

            <div class="collapse show" id="widget-3">
                <div class="widget-body">
                    <div class="filter-colors">
                        <a href="javascript:;" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #333333;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #669933;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
                        <a href="javascript:;" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
                    </div><!-- End .filter-colors -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget --> 

        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
                    Price
                </a>
            </h3><!-- End .widget-title -->

            <div class="collapse show" id="widget-5">
                <div class="widget-body">
                    <div class="filter-price">
                        <div class="filter-price-text">
                            Price Range:
                            <span id="filter-price-range"></span>
                        </div><!-- End .filter-price-text -->

                        <div id="price-slider"></div><!-- End #price-slider -->
                    </div><!-- End .filter-price -->
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget -->


        <div class="widget widget-collapsible">
            <h3 class="widget-title">
                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                    Category
                </a>
            </h3><!-- End .widget-title -->
            <div class="collapse show" id="widget-1">
                <div class="widget-body">
                   <?php  echo do_shortcode('[product_category_filter]') ?>
                </div><!-- End .widget-body -->
            </div><!-- End .collapse -->
        </div><!-- End .widget -->
        
    </div><!-- End .sidebar sidebar-shop -->
</aside>

 
