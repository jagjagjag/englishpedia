<?php

// require_once(ABSPATH . 'wp-admin/includes/media.php');

/*
 * setup custom metaboxes and fields with media uploader.
* author: Mizuho Ogino (http://web.contempo.jp/weblog)
* license: http://www.gnu.org/licenses/gpl.html GPL v2 or later
*/

/////////////////////// メタボックスの追加と保存 ///////////////////////

add_action("admin_init", "metaboxs_init");
function metaboxs_init(){ // 投稿編集画面にメタボックスを追加する
	add_meta_box( 'my_upload', 'マイアップロード画像', 'my_upload_postmeta', 'school', 'side','high' ); // ポジションはsideが推奨
	add_action('save_post', 'save_my_upload_postmeta');
}


/////////////////////// メタボックス（画像アップロード用） ///////////////////////

function my_upload_postmeta(){ //投稿ページに表示されるカスタムフィールド
	global $post;
	$post_id = $post->ID;
	$my_upload_li = '';
	$my_upload_images = get_post_meta( $post_id, 'my_upload_images', true );
	if ( $my_upload_images){
		foreach( $my_upload_images as $key => $img_id ){
			$thumb_src = wp_get_attachment_image_src ($img_id,'thumbnail');
			if ( empty ($thumb_src[0]) ){ //画像が存在しない空IDを強制的に取り除く
				delete_post_meta( $post_id, 'my_upload_images', $img_id );
			}
			else {
				$my_upload_li.=
				"\t".'<li class="img" id="img_'.$img_id.'">'."\n".
				"\t\t".'<span class="img_wrap">'."\n".
				"\t\t\t".'<a href="#" class="my_upload_images_remove" title="画像を削除する"></a>'."\n".
				"\t\t\t".'<img src="'.$thumb_src[0].'"/>'."\n".
				"\t\t\t".'<input type="hidden" name="my_upload_images[]" value="'.$img_id.'" />'."\n".
				"\t\t".'</span>'."\n".
				"\t".'</li>'."\n";
			}
		}
	}
	?>
<style type="text/css">
	#my_upload .inside { padding-top:8px; padding-bottom:13px; }
	#my_upload_images { display:block; margin:0; clear:both; list-style-type: none; }
	#my_upload_images:after { content:"."; display:block; height:0; clear:both; visibility:hidden; }
	#my_upload_images li { display:block; width:100%; margin:0; padding:5px 0; text-align:center; }
	#my_upload_images li span.img_wrap { display:inline-block; margin:0; height:auto; width:auto; padding:4px; position:relative; background:#ccc; }
	#my_upload_images li span img { margin:0; padding:0; max-height: 160px; width:auto; vertical-align:text-bottom; }
	#my_upload_images li span input { display:none; }
	#my_upload_images li span a.my_upload_images_remove { position:absolute; top:-8px; right:-8px; height:32px; width:32px; text-align:center; vertical-align:middle; background:#ccc; border-radius:50%; }
	#my_upload_images li span a.my_upload_images_remove:before { content:'×'; display:inline-block; text-decoration:none; width:1em; margin-right:.2em; text-align:center; font-size:20px; line-height:20px; padding:6px; color:#fff; font-weight:bold; }
	#my_upload_images li span a.my_upload_images_remove:hover { background:#aaa; }
	#my_upload_buttons a { padding:6px; height:32px; width:100%; line-height:20px; font-weight:bold; text-align:center; }
</style>
<div id="my_upload_buttons">
	<a id="my_upload_media" type="button" class="button" title="画像を追加・変更">アイテム画像の追加・削除</a>
	<p>ドラッグで好きな順に並べてください</p>
</div>
<ul id="my_upload_images">
	<?php echo $my_upload_li; ?>
</ul>
<input type="hidden" name="my_upload_postmeta_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
<script type="text/javascript">
jQuery( function(){
	var custom_uploader;
	jQuery('#my_upload_media').click(function(e) {
		e.preventDefault();
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		custom_uploader = wp.media({
			state : 'mystate',
			// title: _wpMediaViewsL10n.mediaLibraryTitle,
			title: 'アイテム画像',
			library: {
				type: 'image'
			},
			button: {
				text: '画像を選択'
			},
			multiple: true, // falseのとき画像選択は一つのみ可能
			frame: 'select', // select | post. selectは左のnavを取り除く指定
			editing:   false,
		});
		custom_uploader.states.add([
			new wp.media.controller.Library({
				id:		 'mystate',
				title: 'アイテム画像のアップロード',
				priority:   20,
				toolbar:	'select',
				filterable: 'uploaded',
				library:	wp.media.query( custom_uploader.options.library ),
				multiple:   custom_uploader.options.multiple ? 'reset' : false,
				editable:   true,
				displayUserSettings: false,
				displaySettings: true,
				allowLocalEdits: true
			}),
		]);
		custom_uploader.on('ready', function() {
			jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');//「この投稿への画像」をデフォルト表示　不要ならコメントアウト
			jQuery( '.media-frame-menu' ).remove(); // 左側のメニュー消去
			jQuery( '.media-frame-title, .media-frame-router, .media-frame-content, .media-frame-toolbar' ).css( 'left', 0 ); // その他のdivを左詰めする
		});
		custom_uploader.on('select', function() {
			var images = custom_uploader.state().get('selection'),
				ex_ul = jQuery('#my_upload_images'),
				ex_id = 0,
				array_ids = [];
			ex_ul.children('li').each( function( ){//すでに登録されている画像を配列に格納
				ex_id = Number(jQuery(this).attr( 'id' ).slice(4));
				array_ids.push( ex_id );
			});
			images.each(function( file ){
				new_id = file.toJSON().id;
				if ( jQuery.inArray( new_id, array_ids ) > -1 ){ //投稿編集画面のリストに重複している場合、削除
					ex_ul.find('li#img_'+ new_id).remove();
				}
				ex_ul.append('<li class="img" id="img_'+ new_id +'"></li>').find('li:last').append(
					'<span class="img_wrap">' +
					'<a href="#" class="my_upload_images_remove" title="画像を削除する"></a>' +
					'<img src="'+file.attributes.sizes.thumbnail.url+'" />' +
					'<input type="hidden" name="my_upload_images[]" value="'+ new_id +'" />' +
					'</span>'
				);
			});
		});
		custom_uploader.open();
	});
	jQuery( ".my_upload_images_remove" ).live( 'click', function( e ) {
		e.preventDefault();
		e.stopPropagation();
		img_obj = jQuery(this).parents('li.img').remove();
	});
	jQuery( "#my_upload_images" ).sortable({
		axis : 'y',
		cursor : "move",
		tolerance : "pointer",
		opacity: 0.6
	});
});
</script>
<?php }

/*データ更新時の保存*/
function save_my_upload_postmeta( $post_id ){
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
		return $post_id; // 自動保存ルーチンの時は何もしない
	}
	if (!wp_verify_nonce($_POST['my_upload_postmeta_nonce'], basename(__FILE__))){
		return $post_id; // wp-nonceチェック
	}
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ){ // パーミッションチェック
			return $post_id;
		}
	}
	else {
		if ( !current_user_can( 'edit_post', $post_id ) ){ // パーミッションチェック
			return $post_id;
		}
	}
	$new_images = isset($_POST['my_upload_images']) ? $_POST['my_upload_images']: null; //POSTされたデータ
	$ex_images = get_post_meta( $post_id, 'my_upload_images', true ); //DBのデータ
	if ( $ex_images !== $new_images ){
		if ( $new_images ){
			update_post_meta( $post_id, 'my_upload_images', $new_images ); // アップデート
		}
		else {
			delete_post_meta( $post_id, 'my_upload_images', $ex_images );
		}
	}
}

?>