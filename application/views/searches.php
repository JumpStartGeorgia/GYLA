<div class="post_text" id="panel">
    <table>
	<tr>
		<th colspan='2'>შენახული ძებნის პარამეტრები<br /><br /></th>
	</tr>
<?php
    $num = count($searches) - 1;
    foreach($searches as $index => $search):
?>
	<tr<?php ($index == $num) AND print("  style='border: 0;'") ?>>
		<td width='100%' style='padding: 0; margin: 0;'>
			<a class='search_result' style='border: 0; margin: 0;' href='<?php echo URL::site('people/search/' . $search['code']); ?>'>
				<?php echo $search['name']; ?>
			</a>
		</td>
		<td align='right' style='padding: 0; margin: 0;'>
			<a class='search_result' style='border: 0; margin: 0; padding-right: 7px;'
			   href='<?php echo URL::site('people/searches/delete/' . $search['id']) ?>'>
				წაშლა
			</a>
		</td>
	</tr>

<?php
    endforeach;
?>
    </table>
</div>
