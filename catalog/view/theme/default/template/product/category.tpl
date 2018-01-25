<?php echo $header; ?>
<input type="hidden" name="products_json_id" value="<?php echo $products_json_id ?>" />
<input type="hidden" name="category_id"  value="<?php echo $category_id ?>" />
<div class="container visible-lg" id="category">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
		<?php if(!next($breadcrumbs)) { ?>
		<li class="breadcrumb_last"><span class="red"><?php echo $breadcrumb['text']; ?></span></li>
		<?php continue; ?>
		<?php } ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
		<?php } ?>
	</ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> catalog"><?php echo $content_top; ?>
      <h1 class="line-dark-before cat-bef-h4"><?php echo $heading_title; ?></h1>
      <div class="row" style="margin-top: 25px;">
		  <div class="col-lg-12">
			  <div id="reference_characteristic">
				  <a class="gray" href="<?php echo $categories[67]['href'] ?>">Стандартные шкафы-купе</a>
         		 <a class="gray" href="<?php echo $categories[60]['href'] ?>">Встроенные шкафы-купе</a>
				  <a class="gray" href="<?php echo $categories[66]['href'] ?>">Угловые шкафы-купе</a>
				  <!-- <a class="gray" href="<?php echo $categories[59]['href'] ?>">Шкафы-Купе</a></li> -->
				  <a class="gray" href="<?php echo $categories[64]['href'] ?>">Радиусные шкафы-купе</a>
			  </div>
		  </div>

        <?php if ($description) { ?>
        <div class="col-lg-12 font-size-16" id="description-p" style="text-align:justify; padding-top: 15px;"><?php echo $description; ?></div>
        <?php } ?>
		  <div class="col-lg-12" style="left: 18px;">
			  <div class="picture-characteristic line-dark-before row">
				  <p class="text pull-right" style="    margin-left: 126px; position: static;">Быстрая доставка</p>
				  <p class="text pull-right" style="    position: static;margin-left: 94px;">Бесплатная сборка</p>
				  <p class="text pull-right" style="position: static;margin-left: 84px;">Качество и надежность</p>
				  <p class="text pull-right" style="padding-left: 4px;position: static;margin-left: 82px;width: 120px;">Рассчрочка 0% без переплат</p>
			  </div>
		  </div>
      </div>
      <?php if ($products) { ?>
		<div class="row select-product-box" style="    margin-top: 36px;">
			<div class="col-lg-6">
				<div class="input-select" style="display: table;">
					<label class=""
						   style="display: table-cell; vertical-align: middle; font-size: 14px; width: 124px;"
						   for="input-sort"><?php echo $text_sort; ?></label>
					<select id="input-sort" class="" style="width: 223px; height: 33px;" onchange="location = this.value;">
						<?php foreach ($sorts as $sortsar) { ?>
						<?php if ($sortsar['value'] == $sort . '-' . $order) { ?>
						<option value="<?php echo $sortsar['href']; ?>"
								selected="selected"><?php echo $sortsar['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sortsar['href']; ?>"><?php echo $sortsar['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div id="check-left">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="input-select" style="display: table; float: right;">
					<label class=""
						   style="display: table-cell; vertical-align: middle; font-size: 14px; width: 124px;"
						   for="input-limit"><?php echo $text_limit; ?></label>
					<select id="input-limit" class="" style="width: 66px; height: 33px;" onchange="location = this.value;">
						<?php foreach ($limits as $limits) { ?>
						<?php if ($limits['value'] == $limit) { ?>
						<option value="<?php echo $limits['href']; ?>"
								selected="selected"><?php echo $limits['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
				</div>
				<div class="check-right"></div>
        	</div>
      </div>
      <div class="row product-box" style="padding-top: 27px;">
        <?php foreach ($products as $product) { ?>
		  <?php echo $product['html_product']; ?>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>


	</div>
	  <?php echo $content_bottom; ?>
		  <?php if ($description_down) { ?>
		  <div class="col-sm-12 description-down "><?php echo $description_down; ?></div>
		  <?php } ?>


    <?php echo $column_right; ?></div>
</div>


<!-- FOR MOBILE -->
<div class="container hidden-lg" id="category">
	<div class="row">
		<div class="col-xs-12 text-left back">
			<a href="<?php echo $referer_mobile; ?>" class="border-gray">Назад</a>
			<div id="name-box">
				<img class="text-right" id="logo-category" src="<?php echo $category_image; ?>" alt="<?php echo $heading_title; ?>">
				<p class="cat-bef-h4 text-right"><?php echo $heading_title; ?></p>
			</div>
		</div>
		<?php if ($products) { ?>

		<div class="col-xs-12 margin-bottom-mobile">
			<div class="select-product-box input-select-mobile">
				<label class=""
					   for="input-sort-mobile"><?php echo $text_sort; ?></label>
				<div style="position: relative;flex:1">
					<select  class="input-sort-mobile" onchange="location = this.value;">
						<?php foreach ($sorts as $sorts) { ?>
						<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
						<option value="<?php echo $sorts['href']; ?>"
								selected="selected"><?php echo $sorts['text']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<div class="check-right"></div>
				</div>
			</div>
		</div>


		<?php foreach ($products as $product) { ?>
		<div class="product-grid col-xs-12 " data-product_id=<?php echo $product['product_id']; ?> >
				<div class="col-xs-12 border-gray">
					<div class="col-xs-4" style="padding: 0">
						<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"
																						  alt="<?php echo $product['name']; ?>"
																						  title="<?php echo $product['name']; ?>"
																						  class="img-responsive"/></a>
						</div>
					</div>
					<div class="col-xs-8">
						<p class="name-product font-size-16 font-type-verdana dark name"><?php echo $product['name']; ?></p>
						<?php if ($product['price']) { ?>
						<?php if (!$product['special']) { ?>
						<p class="price dark font-size-18 font-type-verdana font-bold font-italic"
						   style="text-align: left;"><?php echo trim($product['price']); ?></p>
						<?php } else { ?>
						<p class="price dark font-size-18 font-type-verdana font-bold font-italic" style="text-align: left;"><span
									class="price-new"><?php echo $product['special']; ?></span> <span
									class="price-old"><?php echo $product['price']; ?></span></p>
						<?php } ?>
						<?php } ?>

						<button type="button" class="btn pull-left button-style-1" onClick='location.href="<?php echo $product['href']; ?>"'>Заказать этот товар</button>
					</div>

				</div>
		</div>
	<?php } ?>

		<?php } ?>



	</div>

	<?php echo $content_bottom; ?>
</div>




<?php echo $footer; ?>