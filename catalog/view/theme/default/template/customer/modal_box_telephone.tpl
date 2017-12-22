<?php foreach($data as $key => $field) { ?>
	<?php if($key == 'two_modal') { ?>
		<input type="hidden" name="two_modal" value="0" />
		<?php continue; ?>
	<?php } ?>
	<?php if($key == 'telephone') { ?>
		<?php continue; ?>
	<?php } ?>
	<input type="hidden" name="<?php echo $key ?>" value="<?php echo $field ?>" />
<?php } ?>
<div class="text"><span>Введите свой номер телефона, и Наш оператор свяжется с вами, для уточнения данных заказа</span></div>
<div class="field"><input type="text" name="telephone" class="form-control"></div>
<span class="error" data-modal="1" hidden="hidden">Пожалуйста, введите телефон</span>
<div class="button"><input type="button" id="telephone_button"  class="btn btn-lg btn_calculator" value="Отправить"/></div>



<script type="text/javascript">



	$(document).ready(function () {
		$('#telephone_button').click(function () {
			var data = "";
			$('.modal_window_box input').each(function (index, value) {
				data += "&" + $(this).attr('name') + "=" + $(this).val();
			});
			var text = $(".modal_window_box [name='telephone']").val();
			if (text == '') {
				$('.modal_window_box .error').show();
				return false;
			} else {
				//alert('модальное окно не нужно');
				$('.modal_window_box .error').hide();
				ajaxClientCall(data);
			}
		});

	});
</script>