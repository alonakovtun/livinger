<?php
/**
 * Information about WordPress config displayed in server configuration widget.
 *
 * @package WebP Converter for Media
 */

?>
<h4>WordPress</h4>
<table>
	<tbody>
	<tr>
		<td class="e">ABSPATH</td>
		<td class="v">
			<?php echo esc_html( ABSPATH ); ?>
		</td>
	</tr>
	<tr>
		<td class="e">wp_upload_dir <em>(basedir)</em></td>
		<td class="v">
			<?php echo esc_html( wp_upload_dir()['basedir'] ); ?>
		</td>
	</tr>
	</tbody>
</table>
