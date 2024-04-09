<?php 

?>
   
  <!-- About Start -->
        
  <div class="container">
            <div class="breadandfilter">
                <ol class="breadcrumb" itemscope="" itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a href="./" title="Trang chủ" itemprop="item"><span itemprop="name">Trang chủ</span></a><meta itemprop="position" content="1"><span class="rowbr">›</span></li>
                    <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem"><a href="ke-sach-go-cong-nghiep" title="Giới thiệu" itemprop="item"><h2><span itemprop="name">Giới thiệu</span></h2></a><meta itemprop="position" content="4"></li>
                </ol>
            </div>
                <div class="about">
                <div class="section-header text-center">
                    <p>Giới thiệu</p>
                    <h2>Về chúng tôi</h2>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-12">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
      the_content();
      endwhile; else: ?>
      <p>!Sorry no posts here</p>
<?php endif; ?>

                    </div> 
                </div>
            </div>
        </div>
        <!-- About End -->