<?php include("header-login.php"); ?>
		
		<?php
			if(isset($_GET["view"])){
				$pcode = $_GET["code"];

				$result = mysqli_query($connect, "SELECT * FROM product WHERE product_code='$pcode'");
				$row = mysqli_fetch_assoc($result);
				
				$spec_result = mysqli_query($connect, "SELECT * FROM product_specification WHERE product_code='$pcode'");
				$spec_row = mysqli_fetch_assoc($spec_result);
											
				$color_result = mysqli_query($connect, "SELECT * FROM product_image WHERE product_code='$pcode'");
				$color_row = mysqli_fetch_assoc($color_result);
			}
		?>
		<br>
		
		<main class="main">
            <div class="page-content">
                <div class="container">
                    <div class="product-details-top">
					<form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery product-gallery-vertical">
                                    <div class="row">
                                        <figure class="product-main-image">
                                            <img id="testimg" src="admin/product/<?=$color_row['product_img1']?>" alt="product image">
                                        </figure><!-- End .product-main-image -->

										<div class="product-image-gallery">
                                           <a class="product-gallery-item" onclick="view1()">
												<img src="admin/product/<?=$color_row['product_img1']?>">
                                            </a>
											<?php
												if (empty($color_row['product_img2'])){}
												else{
											?>
                                            <a class="product-gallery-item" onclick="view2()">
                                                <img src="admin/product/<?=$color_row['product_img2']?>">
                                            </a>
											<?php
												}
											?>
											<?php
												if (empty($color_row['product_img3'])){}
												else{
											?>
                                            <a class="product-gallery-item" onclick="view3()">
                                                <img src="admin/product/<?=$color_row['product_img3']?>">
                                            </a>
											<?php
												}
											?>
											<?php
												if (empty($color_row['product_img4'])){}
												else{
											?>
                                            <a class="product-gallery-item" onclick="view4()">
                                                <img src="admin/product/<?=$color_row['product_img4']?>">
                                            </a>
											<?php
												}
											?>
											<?php
												if (empty($color_row['product_img5'])){}
												else{
											?>
											<a class="product-gallery-item" onclick="view5()">
                                                <img src="admin/product/<?=$color_row['product_img5']?>">
                                            </a>
											<?php
												}
												if (empty($color_row['product_img6'])){}
												else{
											?>
											<a class="product-gallery-item" onclick="view6()">
                                                <img src="admin/product/<?=$color_row['product_img6']?>">
                                            </a>
											<?php
												}
											?>
                                        </div><!-- End .product-image-gallery -->
                                    </div><!-- End .row -->
                                </div><!-- End .product-gallery -->
                            </div><!-- End .col-md-6 -->

                            <div class="col-md-6">
							
                                <div class="product-details">
                                    <h1 class="product-title"><?php echo $row['product_name']; ?></h1><!-- End .product-title -->
									<?php
									$price = array();
									$sum_stock = array();
									$cap = array();
									$detail_res = mysqli_query($connect,"SELECT * FROM product_detail WHERE product_code='$pcode'");
									while($detail_row = mysqli_fetch_assoc($detail_res)){
										$price[] = $detail_row['product_price'];
										$sum_stock[] = $detail_row['product_stock1']+$detail_row['product_stock2']+$detail_row['product_stock3']+$detail_row['product_stock4']+$detail_row['product_stock5']+$detail_row['product_stock6'];
										$cap[] = $detail_row['product_capacity'];
									}
									$max = $price[0];
									$min = $price[0];
									foreach($price as $key => $val){
										if($max < $val){
											$max = $val;
										}
									}
									foreach($price as $key => $val){
										if($min > $val){
											$min = $val;
										}
									}
									$total_stock = array_sum($sum_stock);
									?>
                                    <div style="font-size:20pt; color:black; font-weight:bold;">
                                        <b>RM 
											<span name="prod_price" id="priceChange"><?php  
												if(count($price) > 1){
													echo $min." - RM ".$max;
												}
												else{
													echo $min;
												}
											?></span>
										</b>
                                    </div>

                                    <div class="product-content">
                                        <p>Choose your model.</p>
                                    </div><!-- End .product-content -->
									
									<?php
									if($row['cat_name'] == 'Audio' || $row['cat_name'] == 'Accessories'){
									?>
										<div class="details-filter-row details-row-size">
											<label>Color:</label>&nbsp;

											<div class="product-nav product-nav-thumbs">
												<select class="form-control" id="color" name="color" onchange="colorDisplay(<?php echo $pcode; ?>),changePrice2(<?php echo $pcode; ?>)" required>
													<option selected disabled value="">Choose a color</option>
													<option><?php echo $color_row['product_color1']; ?></option>
													<?php
													if(empty($color_row['product_color2'])){}
													else{
													?>
													<option><?php echo $color_row['product_color2']; ?></option>
													<?php
													}
													if(empty($color_row['product_color3'])){}
													else{
													?>
													<option><?php echo $color_row['product_color3']; ?></option>
													<?php
													}
													if(empty($color_row['product_color4'])){}
													else{
													?>
													<option><?php echo $color_row['product_color4']; ?></option>
													<?php
													}
													if(empty($color_row['product_color5'])){}
													else{
													?>
													<option><?php echo $color_row['product_color5']; ?></option>
													<?php
													}
													if(empty($color_row['product_color6'])){}
													else{
													?>
													<option><?php echo $color_row['product_color6']; ?></option>
													<?php
													}
													?>
												</select>
											</div><!-- End .product-nav -->
										</div><!-- End .details-filter-row -->
									<?php
									}
									else{
									?>
										<div class="details-filter-row details-row-size">
											<?php
												if($row['cat_name'] == 'Watch'){
											?>
												<label>Size:</label>&nbsp;
											<?php
												}
												else{
											?>
												<label>Capacity:</label>&nbsp;
											<?php
												}
											?>
											<div class="product-nav product-nav-thumbs">
												<select class="form-control" id="capacity" name="capacity" onchange="display(),changePrice()" required>
												<?php
													if($row['cat_name'] == 'Watch'){
												?>
													<option selected disabled value="">Choose a size</option>
												<?php
													}
													else{
												?>
													<option selected disabled value="">Choose a capacity</option>
												<?php
													}
													$cap_res = mysqli_query($connect,"SELECT * FROM product_detail WHERE product_code='$pcode'");
													while($cap_row = mysqli_fetch_assoc($cap_res)){
													?>
														<option value="<?php echo $cap_row['product_detail_code'];?>"><?php echo $cap_row['product_capacity'];?></option>
													<?php
													}
													?>
												</select>
											</div><!-- End .product-nav -->
										</div><!-- End .details-filter-row -->

										<div class="details-filter-row details-row-size">
											<label>Color:</label>&nbsp;

											<div class="product-nav product-nav-thumbs">
												<select class="form-control" id="color" name="color" onchange="display()" required>
													<option selected disabled value="">Choose a color</option>
													<option><?php echo $color_row['product_color1']; ?></option>
													<?php
													if(empty($color_row['product_color2'])){}
													else{
													?>
													<option><?php echo $color_row['product_color2']; ?></option>
													<?php
													}
													if(empty($color_row['product_color3'])){}
													else{
													?>
													<option><?php echo $color_row['product_color3']; ?></option>
													<?php
													}
													if(empty($color_row['product_color4'])){}
													else{
													?>
													<option><?php echo $color_row['product_color4']; ?></option>
													<?php
													}
													if(empty($color_row['product_color5'])){}
													else{
													?>
													<option><?php echo $color_row['product_color5']; ?></option>
													<?php
													}
													if(empty($color_row['product_color6'])){}
													else{
													?>
													<option><?php echo $color_row['product_color6']; ?></option>
													<?php
													}
													?>
												</select>
											</div><!-- End .product-nav -->
										</div><!-- End .details-filter-row -->
									<?php
									}
									?>
									<div class="details-filter-row details-row-size">
                                        <label for="qty">Qty:</label>&nbsp;
                                        <div class="product-details-quantity">
                                            <input type="number" name="prod_qty" class="form-control" id="qty" value="" min="1" step="1"  data-decimals="0" disabled>
                                        </div><!-- End .product-details-quantity -->
                                    </div><!-- End .details-filter-row -->
									<br>
									<style> button{background-color:white;} #cart:hover{background-color:#3f;}</style>
                                    <div class="product-details-action">
										<button type="submit" id="cart" name="addcart" class="btn-product btn-cart" title="Add to cart" disabled>ADD TO CART</button> 
										&emsp;
										<?php
											$clearance_res = mysqli_query($connect,"SELECT * FROM clearance WHERE clearance_product_code='$pcode'");
											$clearance_count = mysqli_num_rows($clearance_res);

											if($clearance_count != 0){}
											else{
										?>
												<button type="submit" name="addwish" id="wish" class="btn-product-icon btn-wishlist" title="Add to wishlist"></button>
										<?php
											}
										?>
									</div><!-- End .product-details-action -->
									<span id="stock"></span>
									
									<input type="hidden" id="btnClickedValue" name="btnClickedValue" value="">
                                    <div class="product-details-footer">
                                        <div class="product-cat">
                                            <span>Category:</span>
											<a href="category-products-login.php?view&cat=<?php echo $row['cat_name'];?>" style="display: inline-block;">
												<?php echo $row['cat_name'];?>
											</a>
											<br><br>
											<span>Brand:</span>
                                            <a href="brand-products-login.php?view&brand=<?php echo $row['brand_name'];?>" style="display: inline-block;">
												<?php echo $row['brand_name'];?>
											</a>
                                        </div><!-- End .product-cat -->
                                    </div><!-- End .product-details-footer -->
                                </div><!-- End .product-details -->
                            </div><!-- End .col-md-6 -->
                        </div><!-- End .row -->
					</form>
                    </div><!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Specification</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    <h3>Features</h3>
									<p><?php echo $row['product_descrip']; ?></p>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                                <div class="product-desc-content">
									<?php
										if (empty($spec_row['product_display'])){}
											else{
									?>
                                    <h3>Display</h3>
                                    <p><?php echo $spec_row['product_display']; ?></p><br>
									<?php
											}
									?>
									<?php
										if (empty($spec_row['product_chip'])){}
											else{
									?>
                                    <h3>Chip</h3>
                                    <p><?php echo $spec_row['product_chip']; ?></p><br>
									<?php
											}
									?>
									<?php
										if (empty($spec_row['product_back_cam'])){}
											else{
									?>
                                    <h3>Back Camera</h3>
									<p><?php echo $spec_row['product_back_cam']; ?></p><br>
									<?php
											}
									?>
									<?php
										if (empty($spec_row['product_front_cam'])){}
											else{
									?>
                                    <h3>Front Camera</h3>
									<p><?php echo $spec_row['product_front_cam']; ?></p><br>
									<?php
											}
									?>
									<?php
										if (empty($spec_row['product_battery'])){}
											else{
									?>
                                    <h3>Power and Battery</h3>
									<p><?php echo $spec_row['product_battery']; ?></p><br>
									<?php
											}
									?>
									<?php
										if (empty($spec_row['others'])){}
											else{
									?>
                                    <h3>Others</h3>
									<p><?php echo $spec_row['others']; ?></p><br>
									<?php
											}
									?>
                                </div><!-- End .product-desc-content -->
                            </div><!-- .End .tab-pane -->
                        </div><!-- End .tab-content -->
                    </div><!-- End .product-details-tab -->
				</div><!-- container -->
			</div><!-- End .page-content -->
		</main><!-- End .main -->
		
<?php include("footer-login.php"); ?>

<script>
	function view1(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img1']?>";
	}
	function view2(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img2']?>";
	}
	function view3(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img3']?>";
	}
	function view4(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img4']?>";
	}
	function view5(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img5']?>";
	}
	function view6(){
		document.getElementById("testimg").src="admin/product/<?=$color_row['product_img6']?>";
	}

	var allStock = <?php echo $total_stock; ?>;
	if(allStock > 0){
		document.getElementById("stock").innerHTML="<b>Product is in stock</b>";
		document.getElementById("stock").style.color = "green";
	}
	else{
		document.getElementById("stock").innerHTML="<b>Product is out of stock</b>";
		document.getElementById("stock").style.color = "red";
	}
	function colorDisplay(prod_code){
		var code = prod_code;
		var color = document.getElementById("color");
		var color_selected = color.options[color.selectedIndex].value;
		$.ajax({
			type:'post',
			url:'product-detail-cat-onchange.php',
			data: {
				prod_code:code,
				color_selected
			},
			success:function(data){
				if(color_selected != ""){
					console.log(data);
					if(color_selected == "<?php echo $color_row['product_color1'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img1']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color2'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img2']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color3'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img3']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color4'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img4']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color5'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img5']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color6'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img6']?>";
					}
					document.getElementById("qty").disabled=false;
					document.getElementById("qty").value="1";
					document.getElementById("qty").max=data;
					if(data >= 5){
						document.getElementById("cart").disabled=false;
						document.getElementById("stock").innerHTML="<b>This color is in stock</b>";
						document.getElementById("stock").style.color = "green";
					}
					else if(data < 5 && data > 0){
						document.getElementById("cart").disabled=false;
						document.getElementById("stock").innerHTML="<b>This color left a few stock only</b>";
						document.getElementById("stock").style.color = "#ffcc00";
					}
					else{
						document.getElementById("cart").disabled=true;
						document.getElementById("stock").innerHTML="<b>This color is out of stock</b>";
						document.getElementById("stock").style.color = "red";
						document.getElementById("qty").value="0";
						document.getElementById("qty").disabled=true;
					}
				}
				else{
					document.getElementById("qty").disabled=true;
					document.getElementById("qty").value="";
				}
			}
		})
	}
	function changePrice2(prod_code){
		var code = prod_code;
		$.ajax({
			type:'post',
			url:'product-price-onchange2.php',
			data: {
				prod_code:code
			},
			success:function(data){
				document.getElementById("btnClickedValue").value=data;
			}
		})
	}
	function changePrice(){
		var cap = document.getElementById("capacity");
		var cap_selected = cap.options[cap.selectedIndex].value;
		$.ajax({
			type:'post',
			url:'product-price-onchange.php',
			data: {
				cap_selected
			},
			success:function(data){
				document.getElementById("priceChange").innerHTML=data;
				document.getElementById("btnClickedValue").value=data;
			}
		})
	}
	function display(){
		var cap = document.getElementById("capacity");
		var color = document.getElementById("color");
		var cap_selected = cap.options[cap.selectedIndex].value;
		var color_selected = color.options[color.selectedIndex].value;
		$.ajax({
			type:'post',
			url:'product-detail-onchange.php',
			data: {
				cap_selected,
				color_selected
			},
			success:function(data){
				console.log(data);
				if(color_selected != ""){
					if(color_selected == "<?php echo $color_row['product_color1'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img1']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color2'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img2']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color3'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img3']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color4'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img4']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color5'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img5']?>";
					}
					else if(color_selected == "<?php echo $color_row['product_color6'];?>"){
						document.getElementById("testimg").src="admin/product/<?=$color_row['product_img6']?>";
					}
					document.getElementById("qty").disabled=false;
					document.getElementById("qty").value="1";
					document.getElementById("qty").max=data;
					if(data >= 5){
						document.getElementById("cart").disabled=false;
						document.getElementById("stock").innerHTML="<b>This color is in stock</b>";
						document.getElementById("stock").style.color = "green";
					}
					else if(data < 5 && data > 0){
						document.getElementById("cart").disabled=false;
						document.getElementById("stock").innerHTML="<b>This color left a few stock only</b>";
						document.getElementById("stock").style.color = "#ffcc00";
					}
					else{
						document.getElementById("cart").disabled=true;
						document.getElementById("stock").innerHTML="<b>This color is out of stock</b>";
						document.getElementById("stock").style.color = "red";
						document.getElementById("qty").value="0";
						document.getElementById("qty").disabled=true;
					}
				}
				else{
					document.getElementById("qty").disabled=true;
					document.getElementById("qty").value="";
				}
			}
		})
	}
</script>
<?php
if(isset($_POST['addwish'])){
	$code = $row['product_code'];

	if($row['cat_name'] == 'Audio' || $row['cat_name'] == 'Accessories'){
		$product_res = mysqli_query($connect,"SELECT * FROM product_detail WHERE product_code='$code'");
		$product_row = mysqli_fetch_assoc($product_res);
		$capacity = $product_row['product_detail_code'];;
	}
	else{
		$capacity = $_POST['capacity'];
	}
	$color = $_POST['color'];
	$price = $_POST['btnClickedValue'];


	$checkWish = mysqli_query($connect,"SELECT * FROM wishlist WHERE cus_email='$cus_email' AND product_code='$code' AND product_color='$color' AND product_detail_code='$capacity'");
	$countWish = mysqli_num_rows($checkWish);

	if($countWish == 0){
		mysqli_query($connect,"INSERT INTO wishlist (product_code,product_detail_code,product_color,product_price,cus_email) VALUES ('$code','$capacity','$color','$price','$cus_email')");
?>
		<script>
			function productDetail(){window.location.href = 'product-details-login.php?view&code=<?php echo $pcode; ?>';}
			function wishPage(){window.location.href = 'wishlist.php';}
			swal({
			title: "Product already added in your wishlist.",
			icon: "success",
			buttons: {
				wish: {
					text: "View Wishlist",
					value: "wish",
				},
				product: {
					text: "Continue Shop",
					value: "product",
				}
			},
			}).then((value) => {
				switch(value){
					case "product": productDetail();
					break;
					case "wish": wishPage();
					break;
					default: productDetail();
				}
			});
		</script>
<?php
	}
	else{
?>
		<script>
			function productDetail(){window.location.href = 'product-details-login.php?view&code=<?php echo $code; ?>';}
			function wishPage(){window.location.href = 'wishlist.php';}
			swal({
			title: "This product is existing in your wishlist.",
			icon: "error",
			buttons: {
				wish: {
					text: "View Wishlist",
					value: "wish",
				},
				product: {
					text: "Continue Shop",
					value: "product",
				}
			},
			}).then((value) => {
				switch(value){
					case "product": productDetail();
					break;
					case "wish": wishPage();
					break;
					default: productDetail();
				}
			});
		</script>
<?php
	}
}
?>

<?php
if(isset($_POST['addcart'])){
	$code = $row['product_code'];
	if($row['cat_name'] == 'Audio' || $row['cat_name'] == 'Accessories'){
		$product_res = mysqli_query($connect,"SELECT * FROM product_detail WHERE product_code='$code'");
		$product_row = mysqli_fetch_assoc($product_res);
		$capacity = $product_row['product_detail_code'];;
	}
	else{
		$capacity = $_POST['capacity'];
	}
	$color = $_POST['color'];
	$qty = $_POST['prod_qty'];
	$price = $_POST['btnClickedValue'];

	$subtotal = $price * $qty;
	
	$checkCart = mysqli_query($connect,"SELECT * FROM cart WHERE cus_email='$cus_email' AND product_code='$code' AND product_color='$color' AND product_detail_code='$capacity' AND cart_status=1");
	$countCart = mysqli_num_rows($checkCart);

	if($countCart == 0){
		mysqli_query($connect,"INSERT INTO cart (product_code,product_detail_code,product_color,quantity,product_price,cart_subtotal,cus_email) VALUES ('$code','$capacity','$color','$qty','$price','$subtotal','$cus_email')");
?>
		<script>
			function productDetail(){window.location.href = 'product-details-login.php?view&code=<?php echo $code; ?>';}
			function cartPage(){window.location.href = 'cart.php';}
			swal({
			title: "Product is added in your cart.",
			icon: "success",
			buttons: {
				cart: {
					text: "View Cart",
					value: "cart",
				},
				product: {
					text: "Continue Shop",
					value: "product",
				}
			},
			}).then((value) => {
				switch(value){
					case "product": productDetail();
					break;
					case "cart": cartPage();
					break;
					default: productDetail();
				}
			});
		</script>
<?php
	}
	else{
		$checkCart_row = mysqli_fetch_assoc($checkCart);
		$currentQty = $checkCart_row['quantity'];
		$addQty = $currentQty + $qty;
		$subtotal = $price * $addQty;
		mysqli_query($connect,"UPDATE cart SET quantity='$addQty', cart_subtotal='$subtotal' WHERE cus_email='$cus_email' AND product_code='$code' AND product_color='$color' AND product_detail_code='$capacity' AND cart_status=1");
?>
		<script>
			function productDetail(){window.location.href = 'product-details-login.php?view&code=<?php echo $code; ?>';}
			function cartPage(){window.location.href = 'cart.php';}
			swal({
			title: "Updated your cart.",
			icon: "success",
			buttons: {
				cart: {
					text: "View Cart",
					value: "cart",
				},
				product: {
					text: "Continue Shop",
					value: "product",
				}
			},
			}).then((value) => {
				switch(value){
					case "product": productDetail();
					break;
					case "cart": cartPage();
					break;
					default: productDetail();
				}
			});
		</script>
<?php
	}
}
mysqli_close($connect);
?>