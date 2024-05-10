<?php 
/**
* Template Name: vBrand Template One Conact
*/?>

<?php include 'header.php'; ?>
         
<div class="product-section">
    <div class="container"> 
        <div class="about"> 
            <div class="row">
                <div class="col-lg-6">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
                            the_content();
                            endwhile; else: ?>
                        <p>!Sorry no posts here</p>
                    <?php endif; ?>
                </div> 
                <div class="col-lg-6">
                    <div class="mb-4">
                        <h2>GỬI LIÊN HỆ</h2>
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black" for="fname">Tên quý khách</label>
                                <input type="text" class="form-control" id="fname">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                <label class="text-black" for="lname">Số điện thoại</label>
                                <input type="text" class="form-control" id="lname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-black" for="email">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-black" for="message">Nội dung liên hệ</label>
                            <textarea name="" class="form-control" id="message" cols="30" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-hover-outline">Gửi liên hệ</button>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>